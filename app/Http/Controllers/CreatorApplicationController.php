<?php

namespace App\Http\Controllers;

use App\Models\CreatorApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreatorApplicationController extends Controller
{
    // Show the creator application page
    public function showForm()
    {
        $user = Auth::user();

        // If already a creator or admin, redirect
        if ($user->canPostLocation()) {
            return redirect('/')->with('success', 'Kamu sudah menjadi Konten Kreator!');
        }

        // Check existing application
        $application = $user->creatorApplication;

        return view('creator.apply', compact('application'));
    }

    // Submit a creator application
    public function apply(Request $request)
    {
        $user = Auth::user();

        // Prevent if already creator/admin
        if ($user->canPostLocation()) {
            return redirect('/')->with('success', 'Kamu sudah menjadi Konten Kreator!');
        }

        // Prevent duplicate pending application
        $existing = CreatorApplication::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah memiliki pengajuan yang sedang ditinjau. Mohon tunggu.');
        }

        $validated = $request->validate([
            'instagram_url'   => 'nullable|url|max:500',
            'tiktok_url'      => 'nullable|url|max:500',
            'followers_count' => 'required|integer|min:0',
            'reason'          => 'required|string|min:20|max:2000',
        ], [
            'reason.min' => 'Alasan harus minimal 20 karakter.',
            'followers_count.required' => 'Jumlah followers wajib diisi.',
        ]);

        // At least one social media link required
        if (empty($validated['instagram_url']) && empty($validated['tiktok_url'])) {
            return back()->withErrors(['social' => 'Minimal satu link media sosial (Instagram atau TikTok) harus diisi.'])->withInput();
        }

        CreatorApplication::create([
            'user_id'         => $user->id,
            'instagram_url'   => $validated['instagram_url'],
            'tiktok_url'      => $validated['tiktok_url'],
            'followers_count' => $validated['followers_count'],
            'reason'          => $validated['reason'],
            'status'          => 'pending',
        ]);

        return redirect()->route('creator.apply')->with('success', 'Pengajuan berhasil dikirim! Tim kami akan meninjau dalam 1-3 hari kerja.');
    }
}
