<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Send message to Google Gemini API
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
            'history.*.role' => 'required_with:history|in:user,model',
            'history.*.text' => 'required_with:history|string',
        ]);

        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Google Gemini API Key belum dikonfigurasi di file .env server.',
            ], 500);
        }

        // 1. Dapatkan konteks ringkasan tempat wisata dari database (cached 1 jam)
        $locationsContext = Cache::remember('healpoint_bot_locations_summary', 3600, function () {
            $locations = Location::where('status', 'approved')
                ->select('id', 'name', 'category', 'address', 'rating', 'description', 'has_toilet', 'has_musholla', 'has_wifi', 'has_camping')
                ->orderBy('rating', 'desc')
                ->limit(45)
                ->get();

            $list = [];
            foreach ($locations as $loc) {
                $facilities = [];
                if ($loc->has_toilet) $facilities[] = 'Toilet';
                if ($loc->has_musholla) $facilities[] = 'Musholla';
                if ($loc->has_wifi) $facilities[] = 'WiFi';
                if ($loc->has_camping) $facilities[] = 'Camping';
                $facStr = !empty($facilities) ? implode(', ', $facilities) : 'Standar';

                $cleanDesc = Str::limit(strip_tags($loc->description ?? ''), 120);
                $list[] = "- [ID: {$loc->id}] {$loc->name} (Kategori: {$loc->category}, Rating: {$loc->rating}/5, Lokasi: {$loc->address}, Fasilitas: {$facStr}). Deskripsi singkat: {$cleanDesc}";
            }

            return implode("\n", $list);
        });

        // 2. Bangun System Prompt yang ramah & berorientasi healing
        $systemPrompt = "Kamu adalah HealBot, asisten virtual ramah, hangat, dan menenangkan dari platform 'HealPoint' (Platform direktori dan rekomendasi tempat healing, relaksasi pikiran, wisata alam, curug, dan spot santai di wilayah Cirebon, Majalengka, Kuningan, dan sekitarnya).

Kepribadian & Gaya Bicara:
1. Bersikaplah ramah, santun, hangat, empatik, dan solutif. Bayangkan kamu sedang mengobrol dengan seorang teman yang ingin melepas penat dari kesibukan kerja/kuliah.
2. Gunakan Bahasa Indonesia yang mengalir, natural, dan menyenangkan.
3. Utamakan merekomendasikan tempat-tempat wisata yang ada di katalog HealPoint di bawah ini.

--- DAFTAR TEMPAT HEALING DI HEALPOINT ---
{$locationsContext}
--- AKHIR DAFTAR TEMPAT ---

Panduan Rekomendasi:
1. Ketika merekomendasikan tempat yang ada di katalog di atas, SELALU sertakan tautan detail tempat dalam format link Markdown: [Nama Tempat](/location/{id}).
   Contoh penulisan: \"Kamu bisa mengunjungi [Curug Putri Palutungan](/location/5) yang suasananya sangat asri dan sejuk.\"
2. Berikan informasi yang relevan seperti suasana tempat, keindahan alam, dan fasilitas yang ada (misal toilet, musholla, camping ground).
3. Jika pengguna menanyakan rekomendasi rute / itinerary santai, buatkan susunan rencana kegiatan yang menyenangkan berdasarkan tempat-tempat di atas.
4. Jika pengguna bertanya hal umum di luar healing atau wisata, jawab dengan sopan dan singkat, lalu arahkan kembali ke topik relaksasi atau ajak menjelajahi destinasi di HealPoint.
5. Gunakan format Markdown rapi: gunakan bullet point, tebalkan kata penting (**bold**), dan buat paragraf yang nyaman dibaca.";

        // 3. Susun isi riwayat percakapan (conversation history)
        $contents = [];
        if ($request->has('history') && is_array($request->history)) {
            // Ambil maksimal 6 percakapan terakhir agar tetap cepat dan tidak melebihi konteks
            $recentHistory = array_slice($request->history, -6);
            foreach ($recentHistory as $item) {
                if (!empty($item['text'])) {
                    $contents[] = [
                        'role' => $item['role'] === 'user' ? 'user' : 'model',
                        'parts' => [
                            ['text' => (string) $item['text']]
                        ]
                    ];
                }
            }
        }

        // Tambahkan pesan pengguna saat ini
        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $request->message]
            ]
        ];

        // 4. Panggil Gemini API dengan fallback model jika terjadi 503 (high demand)
        $configuredModel = config('services.gemini.model', 'gemini-3.5-flash-lite');
        $modelsToTry = array_unique([$configuredModel, 'gemini-3.5-flash-lite', 'gemini-3.8-flash', 'gemini-flash-latest']);

        $lastError = null;
        foreach ($modelsToTry as $modelName) {
            try {
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";

                $response = Http::timeout(25)->post($endpoint, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemPrompt]
                        ]
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 800,
                    ]
                ]);

                if ($response->successful()) {
                    $reply = $response->json('candidates.0.content.parts.0.text');
                    if (!empty($reply)) {
                        return response()->json([
                            'success' => true,
                            'reply' => $reply,
                            'model_used' => $modelName,
                        ]);
                    }
                }

                $lastError = "Model {$modelName} gagal: HTTP " . $response->status() . " - " . Str::limit($response->body(), 200);
                Log::warning("Gemini API try error: " . $lastError);

            } catch (\Exception $e) {
                $lastError = "Exception pada {$modelName}: " . $e->getMessage();
                Log::warning($lastError);
            }
        }

        // Jika semua model gagal
        return response()->json([
            'success' => false,
            'message' => 'Maaf, server AI HealBot sedang sibuk saat ini. Silakan coba kirim pesan lagi dalam beberapa saat.',
            'debug' => config('app.debug') ? $lastError : null,
        ], 503);
    }
}
