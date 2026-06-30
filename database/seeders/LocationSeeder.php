<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        if (!User::where('email', 'admin@healpoint.id')->exists()) {
            User::create([
                'name' => 'Admin HealPoint',
                'email' => 'admin@healpoint.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]);
        }

        // Create demo user
        if (!User::where('email', 'demo@healpoint.id')->exists()) {
            User::create([
                'name' => 'Pengguna Demo',
                'email' => 'demo@healpoint.id',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
        }

        $existing = \Illuminate\Support\Facades\DB::table('locations')->pluck('name')->map(fn($n) => strtolower(trim($n)))->toArray();

        $spots = [
            // === CIREBON ===
            [
                'name' => 'Taman Sari Gua Sunyaragi',
                'category' => 'Alam',
                'latitude' => -6.7362,
                'longitude' => 108.5513,
                'address' => 'Sunyaragi, Kesambi, Kota Cirebon',
                'description' => 'Taman bersejarah dengan gua-gua buatan dan taman yang asri, cocok untuk meditasi dan menenangkan pikiran. Dibangun pada abad ke-14 sebagai tempat peristirahatan sultan.',
                'rating' => 4.3,
                'status' => 'approved',
            ],
            [
                'name' => 'Pantai Kejawanan',
                'category' => 'Pantai',
                'latitude' => -6.6977,
                'longitude' => 108.5584,
                'address' => 'Pegambiran, Lemahwungkuk, Kota Cirebon',
                'description' => 'Pantai yang tenang dengan pemandangan laut Jawa, sempurna untuk menikmati sunset sambil melepas penat. Terdapat area duduk dan warung seafood segar.',
                'rating' => 4.0,
                'status' => 'approved',
            ],
            [
                'name' => 'Situ Sedong',
                'category' => 'Alam',
                'latitude' => -6.8120,
                'longitude' => 108.4830,
                'address' => 'Sedong, Kabupaten Cirebon',
                'description' => 'Danau buatan yang dikelilingi pepohonan hijau, ideal untuk memancing, piknik, atau sekadar duduk menikmati ketenangan alam.',
                'rating' => 4.1,
                'status' => 'approved',
            ],
            [
                'name' => 'Taman Wisata Gronggong',
                'category' => 'Alam',
                'latitude' => -6.7890,
                'longitude' => 108.5120,
                'address' => 'Gronggong, Kapetakan, Kabupaten Cirebon',
                'description' => 'Kawasan wisata alam dengan view kota Cirebon dari ketinggian. Udara sejuk dan banyak warung makan khas Cirebon. Ideal untuk healing sore hari.',
                'rating' => 4.4,
                'status' => 'approved',
            ],

            // === MAJALENGKA ===
            [
                'name' => 'Tebing Gunung Hawu',
                'category' => 'Gunung',
                'latitude' => -6.8530,
                'longitude' => 108.2720,
                'address' => 'Argamukti, Argapura, Majalengka',
                'description' => 'Tebing batu dengan pemandangan alam spektakuler dan udara pegunungan yang segar. Cocok untuk pendaki pemula yang ingin menikmati ketenangan di ketinggian.',
                'rating' => 4.6,
                'status' => 'approved',
            ],
            [
                'name' => 'Curug Muara Jaya',
                'category' => 'Air Terjun',
                'latitude' => -6.8910,
                'longitude' => 108.2350,
                'address' => 'Argamukti, Argapura, Majalengka',
                'description' => 'Air terjun setinggi 75 meter yang tersembunyi di tengah hutan. Suara gemuruh air dan udara sejuk menciptakan suasana healing yang sempurna.',
                'rating' => 4.7,
                'status' => 'approved',
            ],
            [
                'name' => 'Situ Sangiang',
                'category' => 'Alam',
                'latitude' => -6.8350,
                'longitude' => 108.3460,
                'address' => 'Sangiang, Banjaran, Majalengka',
                'description' => 'Danau alami yang tenang dikelilingi perbukitan hijau. Tempat ini cocok untuk camping, piknik keluarga, atau sekadar menikmati udara segar.',
                'rating' => 4.2,
                'status' => 'approved',
            ],
            [
                'name' => 'Puncak Batu Tilu',
                'category' => 'Gunung',
                'latitude' => -6.8780,
                'longitude' => 108.2580,
                'address' => 'Leuwimunding, Majalengka',
                'description' => 'Puncak dengan tiga batu besar yang menawarkan panorama alam luas. Spot favorit untuk sunrise sekaligus tempat meditasi alam terbuka.',
                'rating' => 4.5,
                'status' => 'approved',
            ],

            // === KUNINGAN ===
            [
                'name' => 'Telaga Remis',
                'category' => 'Alam',
                'latitude' => -6.9495,
                'longitude' => 108.3845,
                'address' => 'Kaduela, Pasawahan, Kuningan',
                'description' => 'Danau alami di kaki Gunung Ciremai dengan air jernih kebiruan. Dikelilingi hutan pinus yang sejuk, sempurna untuk healing dan foto estetik.',
                'rating' => 4.8,
                'status' => 'approved',
            ],
            [
                'name' => 'Curug Landung',
                'category' => 'Air Terjun',
                'latitude' => -6.9670,
                'longitude' => 108.3590,
                'address' => 'Pasawahan, Kuningan',
                'description' => 'Air terjun bertingkat dengan kolam alami yang cocok untuk berendam. Suasananya sangat tenang karena tersembunyi di dalam hutan lindung Gunung Ciremai.',
                'rating' => 4.5,
                'status' => 'approved',
            ],
            [
                'name' => 'Taman Nasional Gunung Ciremai',
                'category' => 'Gunung',
                'latitude' => -6.8920,
                'longitude' => 108.3050,
                'address' => 'Linggarjati, Cilimus, Kuningan',
                'description' => 'Taman nasional yang melindungi gunung tertinggi di Jawa Barat. Terdapat jalur trekking, camping ground, dan mata air alami yang menyejukkan.',
                'rating' => 4.9,
                'status' => 'approved',
            ],
            [
                'name' => 'Waduk Darma',
                'category' => 'Alam',
                'latitude' => -6.8700,
                'longitude' => 108.4690,
                'address' => 'Darma, Kuningan',
                'description' => 'Waduk besar dengan pemandangan Gunung Ciremai sebagai latar belakang. Tersedia perahu, area memancing, dan gazebo untuk bersantai.',
                'rating' => 4.3,
                'status' => 'approved',
            ],
            [
                'name' => 'Buper Palutungan',
                'category' => 'Alam',
                'latitude' => -6.9150,
                'longitude' => 108.3500,
                'address' => 'Cisantana, Cigugur, Kuningan',
                'description' => 'Bumi perkemahan di lereng Gunung Ciremai dengan udara sangat sejuk. Dilengkapi fasilitas camping, toilet, dan musholla. Ideal untuk healing bersama keluarga.',
                'rating' => 4.6,
                'status' => 'approved',
            ],
            [
                'name' => 'Kolam Renang Sangkanurip',
                'category' => 'Alam',
                'latitude' => -6.8580,
                'longitude' => 108.4280,
                'address' => 'Sangkanurip, Kuningan',
                'description' => 'Kolam renang alami dengan air dari mata air pegunungan yang segar dan jernih. Tempat ini populer untuk relaksasi dan berenang santai.',
                'rating' => 4.1,
                'status' => 'approved',
            ],
            [
                'name' => 'Curug Putri',
                'category' => 'Air Terjun',
                'latitude' => -6.9430,
                'longitude' => 108.3680,
                'address' => 'Pasawahan, Kuningan',
                'description' => 'Air terjun cantik yang konon menjadi tempat mandi putri kerajaan. Air terjun ini relatif mudah dijangkau dan sangat fotogenik.',
                'rating' => 4.4,
                'status' => 'approved',
            ],
        ];

        foreach ($spots as $data) {
            if (in_array(strtolower(trim($data['name'])), $existing)) {
                continue;
            }
            Location::create($data);
        }
    }
}
