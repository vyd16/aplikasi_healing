### Dokumen Kebutuhan Produk (PRD)
**Nama Produk:** HealPoint (Aplikasi Direktori Tempat Healing)
**Platform:** Aplikasi Web Responsif Seluler (Mobile-First Web App)
**1. Ringkasan Eksekutif**
HealPoint merupakan platform direktori lokasi wisata penenang pikiran. Sistem membantu pengguna menemukan tempat terbaik untuk menyegarkan jiwa. Pengguna mencari lokasi, membaca ulasan, menyusun rencana perjalanan, dan membagikan rekomendasi tempat baru.
**2. Arsitektur Sistem**
Tim pengembang wajib menerapkan teknologi berikut untuk mendukung antarmuka seluler pada desain:
 * **Frontend:** Bootstrap 5 dengan desain khusus seluler (Mobile-First).
 * **Backend:** Framework Laravel (PHP) untuk penyediaan API dan logika bisnis.
 * **Database:** MySQL untuk menyimpan entitas master dan transaksi.
 * **Integrasi Eksternal:** Sistem memanggil API Google Maps atau Mapbox untuk merender peta dan menghitung rute.
**3. Rincian Fitur Utama**
Sistem membagi fitur aplikasi ke dalam enam modul utama berdasarkan referensi desain antarmuka.
**A. Modul Pengenalan dan Autentikasi**
 * **Layar Splash & Onboarding:** Sistem menampilkan logo HealPoint dan tiga halaman perkenalan fitur aplikasi.
 * **Autentikasi Pengguna:** Pengguna mendaftar dan masuk menggunakan akun Google atau alamat Email.
**B. Modul Dasbor dan Pencarian**
 * **Beranda Utama:** Sistem menampilkan sapaan pengguna, kotak pencarian, pintasan kategori ruang terbuka (Alam, Pantai, Gunung, Air Terjun), serta daftar rekomendasi lokasi populer.
 * **Pencarian Lanjutan:** Pengguna mengetik kata kunci lokasi. Sistem menyimpan riwayat pencarian terakhir.
 * **Filter Suasana:** Pengguna menyaring lokasi berdasarkan parameter kategori, radius jarak, ketersediaan fasilitas (Toilet, Musholla, WiFi, Area Kemah), dan batas minimum rating bintang.
 * **Peta Eksplorasi:** Sistem memetakan lokasi di sekitar pengguna menggunakan ikon pin interaktif.
**C. Modul Detail Lokasi dan Interaksi**
 * **Halaman Detail:** Sistem menyajikan foto sampul, nama tempat, jarak, tombol aksi (Simpan, Bagikan, Rute), deskripsi teks, dan ikon fasilitas pendukung.
 * **Galeri Media:** Pengguna melihat foto dan video dari pengelola dan pengunjung lain melalui sistem *tab*.
 * **Sistem Ulasan:** Sistem menghitung rata-rata rating. Pengguna menulis komentar, memberikan rating bintang, dan mengunggah foto bukti kunjungan.
 * **Kontribusi Tempat Baru:** Pengguna mengisi formulir untuk mendaftarkan lokasi baru yang belum ada di dalam pangkalan data.
**D. Modul Perencanaan Perjalanan (Rencana Trip)**
 * **Manajemen Jadwal:** Pengguna membuat rencana perjalanan baru.
 * **Penyusunan Itinerary:** Pengguna memasukkan jadwal harian, catatan khusus, dan rencana anggaran pengeluaran.
 * **Navigasi Rute:** Sistem membaca titik lokasi pengguna saat ini dan menampilkan opsi rute tercepat menuju tempat tujuan beserta estimasi waktu tempuh.
**E. Modul Profil dan Manajemen Akun**
 * **Daftar Favorit:** Sistem menyimpan dan menampilkan daftar tempat yang pengguna tandai.
 * **Pusat Notifikasi:** Sistem mengirimkan pemberitahuan mengenai interaksi ulasan atau pembaruan sistem.
 * **Pengaturan Aplikasi:** Pengguna mengubah opsi bahasa, mengaktifkan mode gelap (Dark Mode), mengatur satuan jarak (Kilometer/Mil), dan membersihkan data singgahan (Cache).
**F. Kebutuhan Non-Fungsional (Sistem)**
 * **Peringatan Mode Luring (Offline):** Sistem mendeteksi pemutusan koneksi internet dan menampilkan halaman peringatan.
 * **Pusat Bantuan:** Sistem menyediakan daftar pertanyaan umum (FAQ) dan tombol kontak dukungan teknis.
**4. Hak Akses Pengguna Terintegrasi**
 * **Pengguna Biasa:** Memiliki akses ke fitur pencarian, penyusunan rencana perjalanan, penulisan ulasan, dan penyimpanan lokasi favorit.
 * **Konten Kreator / Pendaftar Lokasi:** Memiliki akses formulir penambahan tempat baru untuk memperkaya direktori lokasi.
 * **Administrator (Backend):** Memvalidasi pendaftaran lokasi baru dan mengawasi kualitas ulasan melalui dasbor.

1. Platform & Tech Stack  Bootstrap 5 + Laravel + MySQL + React Native (Expo)
2. Autentikasi:
a. Login Email/Password (JWT custom auth)
b. Login Google (Emergent-managed Google Auth)
3. Peta: gunakan leafletjs
4. Fitur opsional (untuk MVP awal)
a. Dark mode + pengaturan bahasa
b. Mode offline detection
c. Push notifications (Emergent-managed, hanya bisa dites di real device setelah deploy)
d. Semua fitur di PRD (full scope)
5. Konten awal:
seed data tempat tempat healing yang populer di wilayah cirebon, majalengka, kuningan