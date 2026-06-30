@extends('layouts.app')
@section('title', 'FAQ – HealPoint')

@section('content')
<section class="py-4">
    <div class="mb-4">
        <h1 class="hp-section-title">Pertanyaan Umum (FAQ)</h1>
        <p style="color:var(--text-secondary);">
            Temukan jawaban cepat untuk pertanyaan-pertanyaan yang sering ditanyakan seputar penggunaan HealPoint.
        </p>
    </div>

    <div class="row g-4">
        {{-- Left Column: Info & Contact --}}
        <div class="col-lg-4">
            <div class="hp-auth-card mb-4" style="background: linear-gradient(135deg, var(--card-bg) 0%, var(--surface-container-high) 100%);">
                <h5 class="mb-3" style="font-weight:700;">Butuh Bantuan Lain?</h5>
                <p class="small text-muted" style="line-height: 1.6;">
                    Jika kamu tidak menemukan jawaban yang kamu cari di daftar FAQ ini, tim dukungan kami selalu siap membantumu kapan saja.
                </p>
                <div class="mt-4 p-3 text-center" style="background:var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--card-border);">
                    <span class="material-symbols-outlined text-accent" style="font-size:3rem;">mail</span>
                    <h6 class="mt-2 font-weight-bold" style="font-size:0.95rem;">Hubungi Kami</h6>
                    <p class="small text-muted mb-3">Kirimkan pertanyaanmu ke email dukungan kami.</p>
                    <a href="mailto:support@healpoint.id" class="btn btn-accent btn-sm w-100" style="font-size: 0.8rem; border-radius: var(--radius-full);">
                        support@healpoint.id
                    </a>
                </div>
            </div>

            <div class="hp-auth-card" style="border-left: 4px solid var(--color-accent);">
                <h6 class="font-weight-bold mb-2">Panduan Pengguna</h6>
                <p class="small text-muted mb-0" style="line-height: 1.6;">
                    Pastikan untuk membaca panduan privasi dan keamanan sebelum menulis ulasan atau mengunggah lokasi baru. Semua data yang diunggah akan melalui proses verifikasi oleh tim admin kami.
                </p>
            </div>
        </div>

        {{-- Right Column: FAQ Accordion --}}
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                @php
                $faqs = [
                    ['Apa itu HealPoint?', 'HealPoint adalah platform direktori lokasi wisata penenang pikiran di wilayah Cirebon, Majalengka, dan Kuningan. Anda bisa mencari tempat healing, membaca ulasan, dan merencanakan perjalanan.'],
                    ['Apakah HealPoint gratis?', 'Ya! HealPoint sepenuhnya gratis untuk digunakan. Anda bisa menjelajahi lokasi, membaca ulasan, dan merencanakan trip tanpa biaya.'],
                    ['Bagaimana cara menambahkan tempat baru?', 'Anda perlu mendaftar dan mengajukan status sebagai Konten Kreator terlebih dahulu. Setelah disetujui, tombol "Tambah Lokasi" akan muncul di menu sidebar Anda.'],
                    ['Apakah data lokasi akurat?', 'Kami berusaha menyajikan data selengkap mungkin. Koordinat peta didapatkan dari sumber terpercaya, namun kami menyarankan untuk selalu mengecek kondisi terkini sebelum berkunjung.'],
                    ['Bagaimana cara menulis ulasan?', 'Anda perlu mendaftar dan masuk terlebih dahulu. Setelah itu, kunjungi halaman detail lokasi dan scroll ke bagian ulasan untuk menulis review.'],
                    ['Apakah ada fitur offline?', 'Saat ini HealPoint membutuhkan koneksi internet untuk digunakan. Fitur mode offline sedang dalam perencanaan untuk update mendatang.'],
                ];
                @endphp

                @foreach($faqs as $i => $faq)
                <div class="accordion-item" style="background:var(--card-bg); border-color:var(--card-border); margin-bottom:0.75rem; border-radius:var(--radius-lg); overflow:hidden;">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}"
                                style="background:var(--card-bg); color:var(--text-primary); font-weight:600; font-family:'Plus Jakarta Sans',sans-serif; border-radius:var(--radius-lg); box-shadow:none; padding:1.1rem 1.25rem;">
                            <span class="material-symbols-outlined me-2" style="font-size:20px;color:var(--color-accent);">help</span>
                            {{ $faq[0] }}
                        </button>
                    </h2>
                    <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body" style="color:var(--text-secondary); background: var(--bg-primary); line-height: 1.7; padding: 1.25rem;">
                            {{ $faq[1] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
