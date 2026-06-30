@extends('layouts.app')
@section('title', $itinerary->title . ' – Trip Bersama HealPoint')

@section('content')
<section class="py-4">
    {{-- Shared Trip Header --}}
    <div class="hp-trip-header mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge rounded-pill px-3 py-2" style="background:var(--color-accent-light);color:var(--color-accent);font-weight:600;font-size:0.75rem;">
                <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">share</span> Trip Bersama
            </span>
        </div>
        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:0.25rem;color:var(--text-primary);">{{ $itinerary->title }}</h1>
        <p class="mb-2 d-flex align-items-center gap-2 flex-wrap" style="color:var(--text-muted);font-size:0.9rem;">
            <span class="material-symbols-outlined" style="font-size:16px;">calendar_today</span>
            {{ \Carbon\Carbon::parse($itinerary->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($itinerary->end_date)->format('d M Y') }}
            <span class="badge-approved">{{ $totalDays }} hari</span>
        </p>
        <p class="mb-0 d-flex align-items-center gap-1" style="color:var(--text-secondary);font-size:0.85rem;">
            <span class="material-symbols-outlined" style="font-size:16px;">account_circle</span>
            Dibuat oleh <strong>{{ $itinerary->user->name }}</strong>
        </p>
    </div>

    {{-- Trip Items by Day --}}
    @for($day = 1; $day <= $totalDays; $day++)
        <div class="hp-day-group">
            <span class="hp-day-label">
                <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">wb_sunny</span>
                Hari {{ $day }} · {{ \Carbon\Carbon::parse($itinerary->start_date)->addDays($day - 1)->isoFormat('dddd, D MMM') }}
            </span>

            @if(isset($itemsByDay[$day]))
                @foreach($itemsByDay[$day] as $item)
                    <div class="hp-trip-item" style="cursor:default;">
                        <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-accent);flex-shrink:0;">pin_drop</span>
                        <div class="item-info">
                            <div class="item-name">{{ $item->location->name }}</div>
                            <div class="item-meta">
                                <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">location_on</span>
                                {{ Str::limit($item->location->address, 50) }} · {{ $item->location->category }}
                            </div>
                        </div>
                        <a href="{{ route('location.show', $item->location->id) }}" class="btn btn-sm btn-outline-accent" style="flex-shrink:0;font-size:0.75rem;">
                            Lihat
                        </a>
                    </div>
                @endforeach
            @else
                <div class="text-center py-3" style="color:var(--text-muted);font-size:0.85rem;">
                    Tidak ada destinasi untuk hari ini.
                </div>
            @endif
        </div>
    @endfor

    {{-- CTA to explore --}}
    <div class="text-center mt-4 py-4">
        <p style="color:var(--text-muted);font-size:0.9rem;">Ingin merencanakan trip kamu sendiri?</p>
        <a href="{{ url('/') }}" class="btn btn-accent px-4">
            <span class="material-symbols-outlined" style="font-size:18px;">explore</span> Jelajahi HealPoint
        </a>
    </div>
</section>
@endsection
