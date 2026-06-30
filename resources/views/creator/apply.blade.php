@extends('layouts.app')
@section('title', 'Jadi Konten Kreator – HealPoint')

@section('content')
<section class="py-4">
    <div class="mb-4">
        <h1 class="hp-section-title">
            <span class="material-symbols-outlined me-2" style="font-variation-settings:'FILL' 1; color: var(--color-accent);">verified</span>Jadi Konten Kreator
        </h1>
        <p style="color:var(--text-secondary);">
            Upgrade akunmu untuk bisa mendaftarkan lokasi healing baru dan menjadi bagian dari komunitas kreator HealPoint.
        </p>
    </div>

    <div class="row g-4">
        {{-- Left Column: Main Status or Application Form --}}
        <div class="col-lg-7">
            {{-- If user is already a creator --}}
            @if(Auth::user()->canPostLocation())
                <div class="hp-auth-card text-center py-5">
                    <span class="material-symbols-outlined" style="font-size:4rem;color:var(--color-success);">check_circle</span>
                    <h4 class="mt-3" style="font-weight:700;">Kamu sudah menjadi Konten Kreator! 🎉</h4>
                    <p style="color:var(--text-secondary);">Mulai tambahkan lokasi healing baru sekarang.</p>
                    <a href="{{ route('location.create') }}" class="btn btn-accent mt-2">
                        <span class="material-symbols-outlined" style="font-size:18px;">add_location_alt</span> Tambah Lokasi
                    </a>
                </div>

            {{-- If has pending application --}}
            @elseif($application && $application->isPending())
                <div class="hp-auth-card text-center py-5">
                    <span class="material-symbols-outlined" style="font-size:4rem;color:var(--color-warning);">hourglass_top</span>
                    <h4 class="mt-3" style="font-weight:700;">Pengajuan Sedang Ditinjau</h4>
                    <p style="color:var(--text-secondary);">
                        Pengajuanmu sudah dikirim pada <strong>{{ $application->created_at->format('d M Y') }}</strong>.
                        Tim kami akan meninjau dalam 1-3 hari kerja. Kamu akan mendapat notifikasi setelah hasilnya keluar.
                    </p>
                    <div class="mt-4 p-3 text-start" style="background:var(--surface-container-high);border-radius:var(--radius-lg);">
                        <small style="color:var(--text-muted); font-weight: 600;">Detail pengajuan:</small>
                        <div class="mt-2">
                            @if($application->instagram_url)
                                <div class="mb-1"><strong>Instagram:</strong> <a href="{{ $application->instagram_url }}" target="_blank" style="word-break: break-all;">{{ $application->instagram_url }}</a></div>
                            @endif
                            @if($application->tiktok_url)
                                <div class="mb-1"><strong>TikTok:</strong> <a href="{{ $application->tiktok_url }}" target="_blank" style="word-break: break-all;">{{ $application->tiktok_url }}</a></div>
                            @endif
                            <div><strong>Followers:</strong> {{ number_format($application->followers_count) }}</div>
                        </div>
                    </div>
                </div>

            {{-- If rejected, allow re-apply --}}
            @elseif($application && $application->isRejected())
                <div class="alert alert-danger hp-alert mb-4">
                    <h6 class="alert-heading font-weight-bold d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined">error</span> Pengajuan sebelumnya ditolak
                    </h6>
                    <p class="mb-0 mt-1">Alasan: {{ $application->admin_notes ?? 'Tidak memenuhi persyaratan.' }}</p>
                    <hr>
                    <p class="mb-0 small">Kamu bisa mencoba mengajukan kembali di bawah ini.</p>
                </div>
                @include('creator._form')

            {{-- Fresh application --}}
            @else
                @include('creator._form')
            @endif
        </div>

        {{-- Right Column: Information, Perks & Requirements --}}
        <div class="col-lg-5">
            {{-- Requirements Card --}}
            <div class="hp-auth-card mb-4" style="border-left: 4px solid var(--color-accent);">
                <h5 class="mb-3" style="font-weight:700;">
                    <span class="material-symbols-outlined" style="font-size:22px;color:var(--color-accent);">checklist</span>
                    Persyaratan
                </h5>
                <ul class="mb-0 ps-3" style="color:var(--text-secondary);line-height:2.2;">
                    <li>Memiliki akun <strong>Instagram</strong> atau <strong>TikTok</strong> yang aktif.</li>
                    <li>Minimal memiliki <strong>3.000 followers</strong> di salah satu platform tersebut.</li>
                    <li>Bersedia mempromosikan lokasi-lokasi healing yang terdaftar secara positif.</li>
                    <li>Konten bersifat positif, kreatif, original, dan tidak mengandung unsur SARA.</li>
                </ul>
            </div>

            {{-- Creator Benefits Card --}}
            <div class="hp-auth-card" style="background: linear-gradient(135deg, var(--card-bg) 0%, var(--surface-container-high) 100%);">
                <h5 class="mb-3" style="font-weight:700;">
                    <span class="material-symbols-outlined" style="font-size:22px;color:var(--color-success);">stars</span>
                    Keuntungan Kreator
                </h5>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-2">
                        <span class="material-symbols-outlined text-accent" style="font-size:20px;">add_location</span>
                        <div>
                            <strong style="color:var(--text-primary); font-size:0.9rem;">Mendaftarkan Lokasi Baru</strong>
                            <p class="small text-muted mb-0">Rekomendasikan spot-spot healing tersembunyi andalanmu ke ribuan pengguna lain.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="material-symbols-outlined text-accent" style="font-size:20px;">workspace_premium</span>
                        <div>
                            <strong style="color:var(--text-primary); font-size:0.9rem;">Badge Kreator Premium</strong>
                            <p class="small text-muted mb-0">Dapatkan badge khusus di profilmu agar ulasan dan postinganmu lebih dipercaya.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <span class="material-symbols-outlined text-accent" style="font-size:20px;">group</span>
                        <div>
                            <strong style="color:var(--text-primary); font-size:0.9rem;">Komunitas Eksklusif</strong>
                            <p class="small text-muted mb-0">Bergabung dengan grup jejaring sesama kreator untuk kolaborasi dan sharing info event.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
