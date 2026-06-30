@extends('layouts.app')
@section('title', 'Admin Dashboard – HealPoint')

@section('content')
{{-- Admin Welcome Header --}}
<div class="hp-admin-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="mb-1" style="font-size:1.6rem;font-weight:800;color:#fff;">Selamat Datang, Admin 👋</h1>
            <p class="mb-0" style="opacity:0.85;font-size:0.9rem;">Panel kontrol untuk mengelola seluruh ekosistem HealPoint.</p>
        </div>
        <div class="text-end" style="opacity:0.7;font-size:0.8rem;">
            <span class="material-symbols-outlined" style="font-size:16px;">schedule</span>
            {{ now()->isoFormat('dddd, D MMMM Y · HH:mm') }}
        </div>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="hp-admin-stat">
            <div class="stat-icon" style="background:rgba(154,68,23,0.1);color:var(--color-accent);">
                <span class="material-symbols-outlined" style="font-size:24px;">location_on</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalLocations }}</div>
                <div class="stat-label">Total Lokasi</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="hp-admin-stat">
            <div class="stat-icon" style="background:rgba(245,158,11,0.1);color:var(--color-warning);">
                <span class="material-symbols-outlined" style="font-size:24px;">pending_actions</span>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color:var(--color-warning);">{{ $pendingLocations->count() }}</div>
                <div class="stat-label">Menunggu Persetujuan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="hp-admin-stat">
            <div class="stat-icon" style="background:rgba(86,98,74,0.1);color:var(--color-success);">
                <span class="material-symbols-outlined" style="font-size:24px;">rate_review</span>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color:var(--color-success);">{{ $totalReviews }}</div>
                <div class="stat-label">Total Ulasan</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="hp-admin-stat">
            <div class="stat-icon" style="background:rgba(154,68,23,0.1);color:var(--color-accent);">
                <span class="material-symbols-outlined" style="font-size:24px;">group</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalUsers }}</div>
                <div class="stat-label">Pengguna</div>
            </div>
        </div>
    </div>
</div>

{{-- Two Column Layout: Left = Pending Locations + Kreator | Right = Reviews --}}
<div class="row g-4">
    {{-- Left Column --}}
    <div class="col-lg-7">
        {{-- Pending Locations --}}
        <div class="mb-4">
            <h3 class="hp-admin-section-title">
                <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-warning);">pending_actions</span>
                Lokasi Menunggu Persetujuan
                @if($pendingLocations->count() > 0)
                    <span class="badge rounded-pill" style="background:var(--color-warning);color:#000;font-size:0.7rem;">{{ $pendingLocations->count() }}</span>
                @endif
            </h3>

            @if($pendingLocations->isEmpty())
                <div class="hp-review-card text-center py-4" style="color:var(--text-muted);">
                    <span class="material-symbols-outlined" style="font-size:2.5rem;color:var(--color-success);">check_circle</span>
                    <p class="mt-2 mb-0">Semua lokasi sudah disetujui! 🎉</p>
                </div>
            @else
                <div class="hp-table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lokasi</th>
                                <th>Kategori</th>
                                <th>Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingLocations as $loc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('location.show', $loc->id) }}" style="font-weight:600;">{{ Str::limit($loc->name, 25) }}</a>
                                    <br><small style="color:var(--text-muted);">{{ $loc->created_at->format('d M Y') }}</small>
                                </td>
                                <td><span class="badge-pending">{{ $loc->category }}</span></td>
                                <td style="font-size:0.85rem;">{{ $loc->user ? $loc->user->name : '-' }}</td>
                                <td>
                                    <form method="POST" action="{{ url('/admin/locations/' . $loc->id . '/approve') }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-accent btn-sm px-3">
                                            <span class="material-symbols-outlined" style="font-size:16px;">check</span> Setujui
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Creator Applications --}}
        <div>
            <h3 class="hp-admin-section-title">
                <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-accent);">verified</span>
                Pengajuan Konten Kreator
                @if($pendingCreators->count() > 0)
                    <span class="badge rounded-pill" style="background:var(--color-accent);color:#fff;font-size:0.7rem;">{{ $pendingCreators->count() }}</span>
                @endif
            </h3>

            @if($pendingCreators->isEmpty())
                <div class="hp-review-card text-center py-4" style="color:var(--text-muted);">
                    <span class="material-symbols-outlined" style="font-size:2.5rem;color:var(--color-success);">check_circle</span>
                    <p class="mt-2 mb-0">Tidak ada pengajuan kreator yang menunggu.</p>
                </div>
            @else
                @foreach($pendingCreators as $app)
                    <div class="hp-creator-card">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h6 class="mb-0 fw-bold" style="font-size:0.95rem;">
                                    <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;color:var(--color-accent);">account_circle</span>
                                    {{ $app->user->name }}
                                </h6>
                                <small style="color:var(--text-muted);">{{ $app->user->email }} · {{ $app->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="badge-pending">Pending</span>
                        </div>

                        <div class="d-flex flex-wrap gap-3 mt-2" style="font-size:0.85rem;">
                            @if($app->instagram_url)
                                <a href="{{ $app->instagram_url }}" target="_blank" class="d-flex align-items-center gap-1" style="color:var(--text-secondary);">
                                    <span class="material-symbols-outlined" style="font-size:16px;">photo_camera</span> Instagram
                                </a>
                            @endif
                            @if($app->tiktok_url)
                                <a href="{{ $app->tiktok_url }}" target="_blank" class="d-flex align-items-center gap-1" style="color:var(--text-secondary);">
                                    <span class="material-symbols-outlined" style="font-size:16px;">play_circle</span> TikTok
                                </a>
                            @endif
                            <span class="d-flex align-items-center gap-1" style="color:var(--text-secondary);">
                                <span class="material-symbols-outlined" style="font-size:16px;">group</span>
                                <strong>{{ number_format($app->followers_count) }}</strong> followers
                                @if($app->followers_count >= 3000)
                                    <span class="material-symbols-outlined" style="font-size:14px;color:var(--color-success);">check_circle</span>
                                @else
                                    <span class="material-symbols-outlined" style="font-size:14px;color:var(--color-danger);">warning</span>
                                @endif
                            </span>
                        </div>

                        @if($app->reason)
                            <p class="mt-2 mb-0" style="font-size:0.85rem;color:var(--text-secondary);">
                                <em>"{{ Str::limit($app->reason, 120) }}"</em>
                            </p>
                        @endif

                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            <form method="POST" action="{{ route('admin.creator.approve', $app->id) }}">
                                @csrf @method('PUT')
                                <button class="btn btn-accent btn-sm px-3">
                                    <span class="material-symbols-outlined" style="font-size:16px;">check</span> Terima
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.creator.reject', $app->id) }}" class="d-flex gap-2 align-items-center">
                                @csrf @method('PUT')
                                <input type="text" name="admin_notes" class="form-control form-control-sm" placeholder="Alasan penolakan..." style="max-width:200px;font-size:0.8rem;">
                                <button class="btn btn-sm" style="color:var(--color-danger);border:1px solid var(--color-danger);border-radius:var(--radius-full);font-size:0.8rem;">
                                    <span class="material-symbols-outlined" style="font-size:16px;">close</span> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    {{-- Right Column: Recent Reviews --}}
    <div class="col-lg-5">
        <h3 class="hp-admin-section-title">
            <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-accent);">rate_review</span>
            Ulasan Terbaru
        </h3>

        <div class="hp-review-card" style="padding:1.25rem;">
            @forelse($recentReviews as $rev)
                <div class="hp-timeline-review">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                        <div>
                            <span style="font-weight:600;font-size:0.9rem;color:var(--text-primary);">
                                <span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle;">account_circle</span>
                                {{ $rev->user->name }}
                            </span>
                            <span style="color:var(--text-muted);font-size:0.8rem;"> → </span>
                            <a href="{{ route('location.show', $rev->location->id) }}" style="font-size:0.85rem;">{{ Str::limit($rev->location->name, 20) }}</a>
                        </div>
                        <span class="rating-stars" style="font-size:0.75rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rev->rating)★@else☆@endif
                            @endfor
                        </span>
                    </div>
                    @if($rev->comment)
                        <p class="mb-0 mt-1" style="font-size:0.8rem;color:var(--text-secondary);">{{ Str::limit($rev->comment, 80) }}</p>
                    @endif
                    <small style="color:var(--text-muted);font-size:0.7rem;">{{ $rev->created_at->diffForHumans() }}</small>
                </div>
            @empty
                <p class="text-center mb-0" style="color:var(--text-muted);font-size:0.9rem;">Belum ada ulasan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
