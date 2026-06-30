@extends('layouts.app')
@section('title', 'Notifikasi – HealPoint')

@section('content')
<section class="py-4">
    <div class="mb-4">
        <h1 class="hp-section-title">
            <span class="material-symbols-outlined me-2" style="font-size:24px;">notifications</span>Notifikasi
        </h1>
        <p style="color:var(--text-secondary);">
            Dapatkan pembaruan langsung tentang status persetujuan lokasi, ulasan baru, dan info lainnya di sini.
        </p>
    </div>

    <div class="row g-4">
        {{-- Left Column: Notifications List --}}
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="small text-muted font-weight-bold">
                    Menampilkan {{ $notifications->count() }} notifikasi terbaru
                </span>
                @if($notifications->where('read_at', null)->count() > 0)
                    <form method="POST" action="{{ route('notifications.readAll') }}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-accent btn-sm py-1 px-3" style="font-size: 0.8rem; border-radius: var(--radius-full);">
                            <span class="material-symbols-outlined" style="font-size:16px;">done_all</span> Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            @forelse($notifications as $notif)
                <div class="hp-review-card d-flex align-items-start gap-3 p-3 mb-3" style="{{ !$notif->read_at ? 'background:var(--color-accent-light); border-left:4px solid var(--color-accent);' : '' }}">
                    <div class="flex-shrink-0 mt-1">
                        @if(($notif->data['icon'] ?? '') === 'check_circle')
                            <span class="material-symbols-outlined" style="font-size:28px;color:var(--color-success);font-variation-settings:'FILL' 1;">check_circle</span>
                        @elseif(($notif->data['icon'] ?? '') === 'rate_review')
                            <span class="material-symbols-outlined" style="font-size:28px;color:var(--color-accent);font-variation-settings:'FILL' 1;">rate_review</span>
                        @else
                            <span class="material-symbols-outlined" style="font-size:28px;color:var(--text-muted);">notifications</span>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <p class="mb-1 text-primary" style="font-weight:500; font-size:0.95rem; line-height: 1.4;">{{ $notif->data['message'] ?? 'Notifikasi baru' }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <small style="color:var(--text-muted);">{{ $notif->created_at->diffForHumans() }}</small>
                            @if(isset($notif->data['location_id']))
                                <a href="{{ route('location.show', $notif->data['location_id']) }}" class="small" style="font-weight: 600;">Lihat Lokasi <span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span></a>
                            @endif
                        </div>
                    </div>
                    @if(!$notif->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="flex-shrink-0 ms-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-outline-secondary p-1 border-0" style="border-radius:50%; width:28px; height:28px; display:flex; align-items:center; justify-content:center;" title="Tandai dibaca">
                                <span class="material-symbols-outlined" style="font-size:18px;">check</span>
                            </button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="hp-auth-card text-center py-5">
                    <span class="material-symbols-outlined" style="font-size:4rem;color:var(--text-muted); opacity: 0.5;">notifications_off</span>
                    <h5 class="mt-3 font-weight-bold" style="color:var(--text-secondary);">Tidak ada notifikasi</h5>
                    <p class="text-muted small">Semua pemberitahuan baru akan muncul di bagian ini.</p>
                </div>
            @endforelse

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $notifications->links() }}
            </div>
        </div>

        {{-- Right Column: Information & Settings Tips --}}
        <div class="col-lg-4">
            {{-- Notification Stats Card --}}
            <div class="hp-auth-card mb-4" style="background: linear-gradient(135deg, var(--card-bg) 0%, var(--surface-container-high) 100%);">
                <h5 class="mb-3" style="font-weight:700;">Ringkasan</h5>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2" style="border-bottom: 1px solid var(--card-border);">
                    <span style="color: var(--text-secondary); font-size:0.9rem;">Belum Dibaca</span>
                    <span class="badge rounded-pill bg-danger py-1 px-3" style="font-size: 0.8rem; font-weight:700;">
                        {{ $notifications->where('read_at', null)->count() }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span style="color: var(--text-secondary); font-size:0.9rem;">Total Pemberitahuan</span>
                    <span class="font-weight-bold text-primary" style="font-size: 0.9rem;">
                        {{ $notifications->total() }}
                    </span>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="hp-auth-card" style="border-left: 4px solid var(--color-success);">
                <h5 class="mb-3" style="font-weight:700;">Info Notifikasi</h5>
                <p class="small text-muted" style="line-height: 1.6;">
                    Notifikasi membantu kamu melacak status ulasan yang kamu tulis atau lokasi healing baru yang kamu ajukan. Kamu juga akan menerima notifikasi jika admin menyetujui pengajuan konten kreatormu.
                </p>
                <div class="mt-3 p-3 bg-light rounded-lg" style="border-radius: var(--radius-md);">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="material-symbols-outlined text-success" style="font-size: 18px;">security</span>
                        <span class="small font-weight-bold" style="color:var(--text-secondary);">Keamanan Data</span>
                    </div>
                    <p class="small text-muted mb-0 mt-1" style="font-size:0.75rem;">Kami tidak akan pernah mengirimkan notifikasi spam atau membagikan datamu ke pihak ketiga.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
