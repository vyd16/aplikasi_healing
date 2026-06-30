@extends('layouts.app')
@section('title', 'Trip Saya – HealPoint')

@section('content')
<section class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h1 class="hp-section-title mb-0">
            <span class="material-symbols-outlined me-2" style="font-size:24px;">calendar_month</span>Trip Saya
        </h1>
        <button class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#createTrip">
            <span class="material-symbols-outlined" style="font-size:20px;">add</span> Buat Trip Baru
        </button>
    </div>

    <div class="row g-4">
        @forelse($itineraries as $trip)
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/itineraries/' . $trip->id) }}" class="hp-location-card" style="cursor:pointer;">
                    <div class="card-body" style="padding:1.5rem;">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0" style="height:auto;">{{ $trip->title }}</h5>
                            <span class="badge-approved">{{ $trip->items_count ?? 0 }} destinasi</span>
                        </div>
                        <p class="card-text d-flex align-items-center gap-1" style="font-size:0.85rem;">
                            <span class="material-symbols-outlined" style="font-size:16px;">calendar_today</span>
                            {{ \Carbon\Carbon::parse($trip->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($trip->end_date)->format('d M Y') }}
                        </p>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <span class="material-symbols-outlined" style="font-size:16px;color:var(--color-accent);">arrow_forward</span>
                            <small style="color:var(--color-accent);font-weight:600;">Lihat Detail</small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            {{-- Beautiful Empty State --}}
            <div class="col-12">
                <div class="hp-empty-state">
                    <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="max-width:160px;">
                        <circle cx="100" cy="100" r="90" fill="var(--color-accent-light)" opacity="0.5"/>
                        <circle cx="100" cy="100" r="60" fill="var(--color-accent-light)"/>
                        {{-- Map/Route icon --}}
                        <rect x="65" y="60" width="70" height="80" rx="8" fill="var(--card-bg)" stroke="var(--color-accent)" stroke-width="2"/>
                        <line x1="80" y1="80" x2="120" y2="80" stroke="var(--color-accent)" stroke-width="2" opacity="0.5"/>
                        <line x1="80" y1="95" x2="110" y2="95" stroke="var(--color-accent)" stroke-width="2" opacity="0.3"/>
                        <line x1="80" y1="110" x2="115" y2="110" stroke="var(--color-accent)" stroke-width="2" opacity="0.3"/>
                        <circle cx="90" cy="125" r="4" fill="var(--color-accent)">
                            <animate attributeName="r" values="3;5;3" dur="1.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="105" cy="125" r="4" fill="var(--color-accent)" opacity="0.5">
                            <animate attributeName="r" values="3;5;3" dur="1.5s" begin="0.5s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="120" cy="125" r="4" fill="var(--color-accent)" opacity="0.3">
                            <animate attributeName="r" values="3;5;3" dur="1.5s" begin="1s" repeatCount="indefinite"/>
                        </circle>
                    </svg>
                    <h3>Belum Ada Rencana Perjalanan</h3>
                    <p>Susun rencana healing kamu agar liburan lebih terorganisir dan menyenangkan! Klik tombol di bawah untuk membuat trip pertama.</p>
                    <button class="btn btn-accent px-4" data-bs-toggle="modal" data-bs-target="#createTrip">
                        <span class="material-symbols-outlined" style="font-size:18px;">add_circle</span> Buat Trip Pertama
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</section>

{{-- Create Trip Modal --}}
<div class="modal fade" id="createTrip" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background:var(--card-bg);color:var(--text-primary);border-radius:var(--radius-xl);border:1px solid var(--card-border);">
            <div class="modal-header border-0">
                <h5 class="modal-title" style="font-weight:700;">Buat Trip Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ url('/itineraries') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:500;">Nama Trip</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Weekend Healing Kuningan" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" style="font-weight:500;">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label" style="font-weight:500;">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-accent" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-accent">
                        <span class="material-symbols-outlined" style="font-size:18px;">check</span> Buat Trip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
