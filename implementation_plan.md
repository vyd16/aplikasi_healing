# Rencana Migrasi & Seeding Data di Vercel

Rencana ini dibuat untuk mengintegrasikan dan mengeksekusi data lokasi tambahan yang saat ini belum terunggah ke database production di Vercel/Aiven MySQL.

## Analisis Penyebab Masalah

Setelah dianalisis, database di Vercel hanya memuat **15 lokasi** awal karena:
1. `DatabaseSeeder.php` hanya memanggil `LocationSeeder::class`.
2. Data lokasi tambahan yang banyak (sekitar 100+ lokasi baru) tersimpan secara terpisah dalam file PHP mentah (raw scripts) di folder `database/seeders`:
   - `seed_new_locations.php` (berisi 52 lokasi baru)
   - `seed_more_locations.php` (berisi ~50 lokasi baru lainnya)
   - `seed_facilities.php` (berisi fasilitas lokasi)
3. File-file tersebut bukan merupakan kelas Seeder resmi Laravel, tidak terpanggil oleh `DatabaseSeeder`, dan belum pernah dijalankan di lingkungan *production* Vercel.

---

## Solusi yang Diusulkan

Kami akan merestrukturisasi berkas *seeding* agar menjadi kelas Laravel Seeder yang standar dan dapat dieksekusi secara otomatis, serta menyediakan *endpoint* aman untuk memicu proses *seeding* di Vercel.

### 1. Refaktorisasi File Seeder Mentah menjadi Laravel Seeder Class
* Membuat kelas seeder baru:
  - `database/seeders/NewLocationsSeeder.php` (dari isi `seed_new_locations.php`)
  - `database/seeders/MoreLocationsSeeder.php` (dari isi `seed_more_locations.php`)
  - `database/seeders/FacilitiesSeeder.php` (dari isi `seed_facilities.php`)
* Mendaftarkan kelas-kelas seeder tersebut di dalam `DatabaseSeeder.php` agar dapat dipanggil secara otomatis melalui `php artisan db:seed`.

### 2. Menyediakan Route Pemicu (Trigger) di Vercel
Karena Vercel berjalan di lingkungan *serverless* tanpa akses konsol SSH persisten untuk menjalankan `php artisan db:seed`, kita akan membuat *route* web sementara yang aman (dilindungi dengan token rahasia) untuk menjalankan seeder melalui kode:
- Endpoint: `GET /run-seeding-prod?key=healpoint_secure_token_123`
- Route ini akan memanggil `Artisan::call('db:seed')` secara terprogram.

---

## Rincian Perubahan Berkas (Proposed Changes)

### [Component: Database Seeders]

#### [MODIFY] [DatabaseSeeder.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/DatabaseSeeder.php)
Menambahkan pemanggilan untuk kelas seeder baru:
```php
public function run(): void
{
    $this->call([
        LocationSeeder::class,
        NewLocationsSeeder::class,
        MoreLocationsSeeder::class,
        FacilitiesSeeder::class,
    ]);
}
```

#### [NEW] [NewLocationsSeeder.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/NewLocationsSeeder.php)
Mengonversi `seed_new_locations.php` menjadi struktur kelas seeder Laravel standar:
```php
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewLocationsSeeder extends Seeder {
    public function run(): void {
        // Logika insert data lokasi baru
    }
}
```

#### [NEW] [MoreLocationsSeeder.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/MoreLocationsSeeder.php)
Mengonversi `seed_more_locations.php` menjadi struktur kelas seeder Laravel standar:
```php
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoreLocationsSeeder extends Seeder {
    public function run(): void {
        // Logika insert data lokasi tambahan lainnya
    }
}
```

#### [NEW] [FacilitiesSeeder.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/FacilitiesSeeder.php)
Mengonversi `seed_facilities.php` menjadi struktur kelas seeder Laravel standar.

#### [DELETE] [seed_new_locations.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/seed_new_locations.php)
Menghapus file mentah lama setelah berhasil diimpor ke seeder class baru.

#### [DELETE] [seed_more_locations.php](file:///c:/xampp/htdocs/aplikasi_healing/database/seeders/seed_more_locations.php)
Menghapus file mentah lama setelah berhasil diimpor ke seeder class baru.

---

### [Component: Routing]

#### [MODIFY] [web.php](file:///c:/xampp/htdocs/aplikasi_healing/routes/web.php)
Menambahkan route aman untuk memicu seeder pada production:
```php
Route::get('/run-seeding-prod', function () {
    if (request('key') !== 'healpoint_secure_token_123') {
        abort(403);
    }
    
    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});
```

---

## Rencana Verifikasi

### Pengujian Lokal
1. Menjalankan `php artisan db:seed` secara lokal untuk memastikan semua seeder baru berjalan tanpa error dan data terisi lengkap di database lokal.

### Pengujian Production (Vercel)
1. Setelah kode di-push dan di-deploy ke Vercel, buka URL:
   `https://aplikasi-healing-three.vercel.app/run-seeding-prod?key=healpoint_secure_token_123`
2. Pastikan responnya menunjukkan `"status": "success"`.
3. Buka halaman utama aplikasi untuk memastikan semua lokasi tambahan (100+ spot) tampil dengan benar.
4. Hapus route `/run-seeding-prod` setelah seeding selesai untuk menjaga keamanan sistem.
