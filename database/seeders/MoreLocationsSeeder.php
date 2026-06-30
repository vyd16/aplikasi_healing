<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoreLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existing = DB::table('locations')->pluck('name')->map(fn($n) => strtolower(trim($n)))->toArray();

        $locations = [
            // === Wisata Alam & Air Terjun (Kuningan) ===
            [
                'name' => 'Curug Bangkong',
                'category' => 'Air Terjun',
                'address' => 'Kertawirama, Nusaherang, Kuningan',
                'description' => 'Air terjun indah dengan ketinggian 23 meter dan debit air yang besar. Suasana sekelilingnya rimbun dan sangat menyegarkan pikiran.',
                'latitude' => -6.9935, 'longitude' => 108.4350,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Curug Sidomba',
                'category' => 'Air Terjun',
                'address' => 'Peusing, Jalaksana, Kuningan',
                'description' => 'Kawasan wisata air terjun buatan yang asri, dilengkapi dengan area rekreasi keluarga, bumi perkemahan, dan domba bertanduk banyak.',
                'latitude' => -6.9380, 'longitude' => 108.4680,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Curug Ngelay',
                'category' => 'Air Terjun',
                'address' => 'Begawat, Selajambe, Kuningan',
                'description' => 'Air terjun tinggi tersembunyi dengan pesona alam liar yang eksotis. Sangat menenangkan untuk petualangan healing dari kebisingan kota.',
                'latitude' => -7.1120, 'longitude' => 108.4550,
                'has_toilet' => 0, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Curug Bebedahan',
                'category' => 'Air Terjun',
                'address' => 'Caimas, Kuningan',
                'description' => 'Air terjun dengan bebatuan berundak alami dan aliran air yang tenang, cocok untuk bersantai dan terapi alam.',
                'latitude' => -7.0250, 'longitude' => 108.4720,
                'has_toilet' => 0, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Curug Nyandung',
                'category' => 'Air Terjun',
                'address' => 'Cileuleuy, Cigugur, Kuningan',
                'description' => 'Tiga aliran air terjun berdampingan yang unik dan eksotis. Keasrian alam sekitarnya memberikan ketenangan jiwa yang luar biasa.',
                'latitude' => -6.9680, 'longitude' => 108.4230,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Mata Air Lembah Cibacang',
                'category' => 'Alam',
                'address' => 'Kuningan',
                'description' => 'Kolam mata air jernih alami di bawah lembah hijau yang teduh. Airnya yang dingin menyegarkan tubuh dan menjernihkan kepenatan.',
                'latitude' => -6.9550, 'longitude' => 108.4820,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Obyek Wisata Cibulan (Kolam Ikan Dewa)',
                'category' => 'Alam',
                'address' => 'Maniskidul, Jalaksana, Kuningan',
                'description' => 'Pemandian air dingin alami yang legendaris, dihuni oleh ikan kancra bodas (Ikan Dewa) yang dikeramatkan dan sangat ramah dengan pengunjung.',
                'latitude' => -6.9240, 'longitude' => 108.4870,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Woodland Kuningan',
                'category' => 'Alam',
                'address' => 'Setianegara, Cilimus, Kuningan',
                'description' => 'Destinasi wisata alam modern di tengah hutan pinus dengan wahana outbound, jembatan gantung estetik, dan spot foto instagramable.',
                'latitude' => -6.9080, 'longitude' => 108.4890,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 1
            ],
            [
                'name' => 'Varvara Hill',
                'category' => 'Alam',
                'address' => 'Cisantana, Cigugur, Kuningan',
                'description' => 'Bukit wisata dengan kafe bernuansa alam, menawarkan panorama alam hijau Kuningan dan udara pegunungan yang menyejukkan.',
                'latitude' => -6.8910, 'longitude' => 108.4410,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Bukit Alam Hejo',
                'category' => 'Alam',
                'address' => 'Pasawahan, Kuningan',
                'description' => 'Taman rekreasi keluarga bernuansa rindang dengan fasilitas kolam renang anak, area outbound, dan panorama alam pedesaan yang asri.',
                'latitude' => -6.8830, 'longitude' => 108.4350,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Banyu Panas Palimanan (Air Panas)',
                'category' => 'Alam',
                'address' => 'Palimanan Barat, Gempol, Cirebon',
                'description' => 'Pemandian air panas belerang alami yang berkhasiat menyembuhkan dan merelaksasi otot-otot yang tegang setelah penat beraktivitas.',
                'latitude' => -6.7080, 'longitude' => 108.4210,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Talaga Langit',
                'category' => 'Alam',
                'address' => 'Sinarancang, Mundu, Cirebon',
                'description' => 'Destinasi wisata bukit dengan kolam renang di atas awan, danau buatan, spot foto estetik, dan panorama alam Cirebon dari ketinggian.',
                'latitude' => -6.7820, 'longitude' => 108.5630,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Telaga Niren',
                'category' => 'Alam',
                'address' => 'Kaduela, Pasawahan, Kuningan',
                'description' => 'Telaga kecil dengan air super jernih kebiruan di samping Telaga Remis, memantulkan bayangan pepohonan rindang sekitarnya.',
                'latitude' => -6.8640, 'longitude' => 108.4110,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Curug Utang',
                'category' => 'Air Terjun',
                'address' => 'Kuningan',
                'description' => 'Air terjun alami dengan suasana rimba yang asri, menawarkan kesegaran air pegunungan yang sangat murni.',
                'latitude' => -6.8720, 'longitude' => 108.4280,
                'has_toilet' => 0, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 1
            ],
            // === Wisata Majalengka ===
            [
                'name' => 'Kebun Teh Cipasung',
                'category' => 'Alam',
                'address' => 'Cipasung, Lemahsugih, Majalengka',
                'description' => 'Hamparan hijau kebun teh yang luas dan berbukit-bukit di perbatasan Majalengka-Ciamis. Udara sejuk dan pemandangan hijau sejauh mata memandang.',
                'latitude' => -7.0250, 'longitude' => 108.2120,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Bukit Mercury Sayang Kaak',
                'category' => 'Gunung',
                'address' => 'Cibuluh, Argapura, Majalengka',
                'description' => 'Destinasi wisata dataran tinggi eksotis di lereng Gunung Ciremai, menawarkan gardu pandang terasering pertanian yang menakjubkan.',
                'latitude' => -6.8450, 'longitude' => 108.3810,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Situ Cipanten',
                'category' => 'Alam',
                'address' => 'Gunung Kuning, Sindang, Majalengka',
                'description' => 'Danau berair biru toska legendaris dengan ikan-ikan jinak. Dikelilingi hutan asri, menawarkan perahu kayuh dan jembatan penyeberangan estetik.',
                'latitude' => -6.8320, 'longitude' => 108.2880,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Museum Talaga Manggung',
                'category' => 'Alam',
                'address' => 'Talaga Wetan, Talaga, Majalengka',
                'description' => 'Museum peninggalan Kerajaan Talaga Manggung yang menyimpan kereta kencana kuno, gamelan sekaten, dan prasasti bersejarah yang magis.',
                'latitude' => -6.9740, 'longitude' => 108.2930,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Cikadongdong River Tubing',
                'category' => 'Alam',
                'address' => 'Payung, Rajagaluh, Majalengka',
                'description' => 'Arung jeram seru menyusuri sungai jernih Cikadongdong yang penuh bebatuan besar. Menguji adrenalin di tengah pesona pedesaan yang rindang.',
                'latitude' => -6.8180, 'longitude' => 108.3410,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Bukit Hejo (Majalengka)',
                'category' => 'Gunung',
                'address' => 'Sindangwangi, Majalengka',
                'description' => 'Bukit hijau yang asri dengan gardu pandang menghadap pedesaan dan sawah. Tempat favorit untuk menikmati angin sepoi-sepoi dan bersantai.',
                'latitude' => -6.8110, 'longitude' => 108.3750,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Telaga Biru / Nila Majalengka',
                'category' => 'Alam',
                'address' => 'Jerukleueut, Sindangwangi, Majalengka',
                'description' => 'Danau dengan air yang sangat biru transparan, memantulkan bayangan pohon rimbun di tepi telaga. Sangat hening dan menenangkan.',
                'latitude' => -6.8040, 'longitude' => 108.3880,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Desa Wisata Bantaragung',
                'category' => 'Alam',
                'address' => 'Bantaragung, Sindangwangi, Majalengka',
                'description' => 'Desa wisata berprestasi nasional di kaki Gunung Ciremai dengan pemandangan terasering sawah Ciboer, air terjun, dan kehidupan desa yang damai.',
                'latitude' => -6.8220, 'longitude' => 108.3610,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 1
            ],
            [
                'name' => 'Desa Wisata Sukasari Kaler',
                'category' => 'Alam',
                'address' => 'Sukasari Kaler, Argapura, Majalengka',
                'description' => 'Desa pertanian dataran tinggi berhawa sangat dingin. Menyajikan hamparan perkebunan bawang yang meliuk-liuk indah di lereng gunung.',
                'latitude' => -6.8650, 'longitude' => 108.3790,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            // === Wisata Indramayu (Pantai & Lainnya) ===
            [
                'name' => 'Pantai Tirtamaya',
                'category' => 'Pantai',
                'address' => 'Juntinyuat, Indramayu',
                'description' => 'Pantai pasir legendaris dengan deburan ombak khas laut utara dan kisah legenda Ki Buyut Tuban. Tempat favorit warga Indramayu untuk rekreasi keluarga.',
                'latitude' => -6.3420, 'longitude' => 108.4350,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Pantai Karangsong',
                'category' => 'Pantai',
                'address' => 'Karangsong, Indramayu',
                'description' => 'Pantai berpasir hitam eksotis yang bersebelahan dengan pelabuhan kapal nelayan tradisional dan kawasan konservasi mangrove.',
                'latitude' => -6.3050, 'longitude' => 108.3580,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Pantai Cemara Indah',
                'category' => 'Pantai',
                'address' => 'Cantigi, Indramayu',
                'description' => 'Pantai yang teduh karena ditumbuhi jajaran pohon cemara laut di sepanjang pesisir. Sangat cocok untuk piknik santai bersama keluarga.',
                'latitude' => -6.2840, 'longitude' => 108.2810,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Pantai Lemah Abang Eretan',
                'category' => 'Pantai',
                'address' => 'Eretan Wetan, Kandanghaur, Indramayu',
                'description' => 'Pantai tenang dengan bebatuan pemecah ombak di sepanjang bibir pantai. Menyajikan pemandangan kapal nelayan dan sunset laut Jawa yang indah.',
                'latitude' => -6.3020, 'longitude' => 108.0120,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Pantai Kesambi',
                'category' => 'Pantai',
                'address' => 'Balongan, Indramayu',
                'description' => 'Pantai berpasir yang asri dan tenang di wilayah Balongan, cocok untuk sekadar duduk santai mendengarkan deburan ombak.',
                'latitude' => -6.3310, 'longitude' => 108.3840,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Hutan Mangrove Karangsong',
                'category' => 'Alam',
                'address' => 'Karangsong, Indramayu',
                'description' => 'Kawasan konservasi bakau seluas puluhan hektar. Menyusuri hutan mangrove menggunakan perahu nelayan memberikan pengalaman healing hijau yang tak terlupakan.',
                'latitude' => -6.3010, 'longitude' => 108.3620,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Taman Cimanuk (Taman Tjimanoek)',
                'category' => 'Alam',
                'address' => 'Pekauman, Indramayu',
                'description' => 'Taman kota di tepian Sungai Cimanuk bersejarah. Lengkap dengan area bermain, jembatan estetik, dan lampion warna-warni saat malam hari.',
                'latitude' => -6.3260, 'longitude' => 108.3240,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Taman Rusa Bumi Patra',
                'category' => 'Alam',
                'address' => 'Karanganyar, Indramayu',
                'description' => 'Taman rekreasi hijau yang dihuni sekelompok rusa tutul jinak. Destinasi edukatif dan teduh di tengah perumahan Bumi Patra.',
                'latitude' => -6.3420, 'longitude' => 108.3180,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Jembatan Terusan Indramayu',
                'category' => 'Alam',
                'address' => 'Terusan, Sindang, Indramayu',
                'description' => 'Jembatan megah yang membentang di atas Sungai Cimanuk, menjadi ikon modern Indramayu dengan pemandangan sunset sungai yang menakjubkan.',
                'latitude' => -6.3380, 'longitude' => 108.2980,
                'has_toilet' => 0, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'The Nice Playland Indramayu',
                'category' => 'Alam',
                'address' => 'Indramayu',
                'description' => 'Kawasan bermain keluarga bernuansa modern luar ruangan dengan kebun binatang mini dan wahana rekreasi seru untuk refreshing anak-anak.',
                'latitude' => -6.3500, 'longitude' => 108.3250,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 1, 'has_camping' => 0
            ],
            [
                'name' => 'Agung Fantasi Waterpark Widasari',
                'category' => 'Alam',
                'address' => 'Kongsijaya, Widasari, Indramayu',
                'description' => 'Taman air dengan kolam ombak, seluncuran tinggi, dan ember tumpah raksasa. Menghilangkan rasa gerah pesisir utara.',
                'latitude' => -6.4420, 'longitude' => 108.2750,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 0
            ],
            [
                'name' => 'Situ Bolang',
                'category' => 'Alam',
                'address' => 'Jatisura, Cikedung, Indramayu',
                'description' => 'Danau buatan yang dikelilingi agrowisata perkebunan buah mangga gedong gincu dan taman bunga matahari yang cantik.',
                'latitude' => -6.4520, 'longitude' => 108.1750,
                'has_toilet' => 1, 'has_musholla' => 1, 'has_wifi' => 0, 'has_camping' => 1
            ],
            [
                'name' => 'Wisata Pohon Rangdu Gede',
                'category' => 'Alam',
                'address' => 'Bantarwaru, Gantar, Indramayu',
                'description' => 'Pohon randu alas raksasa purba berusia ratusan tahun yang berdiri kokoh. Menawarkan suasana teduh mistis dan ketenangan alam luar biasa.',
                'latitude' => -6.5350, 'longitude' => 107.9820,
                'has_toilet' => 1, 'has_musholla' => 0, 'has_wifi' => 0, 'has_camping' => 1
            ]
        ];

        $added = 0;
        foreach ($locations as $loc) {
            if (in_array(strtolower(trim($loc['name'])), $existing)) {
                continue;
            }
            DB::table('locations')->insert(array_merge($loc, [
                'rating' => round(rand(38, 49) / 10, 1),
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ]));
            $added++;
        }
    }
}
