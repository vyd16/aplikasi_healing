@extends('layouts.app')
@section('title', 'Lokasi Favorit – HealPoint')

@section('content')
<section class="py-4">
    <h1 class="hp-section-title mb-4">
        <span class="material-symbols-outlined me-2" style="font-variation-settings:'FILL' 1;color:var(--color-accent);">favorite</span>Lokasi Favorit Saya
    </h1>

    <div class="row g-4">
        @forelse($favorites as $fav)
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('location.show', $fav->location->id) }}" class="hp-location-card">
                    <div class="card-img-wrapper">
                        @if($fav->location->media && $fav->location->media->first())
                            <img src="{{ $fav->location->media->first()->url }}" class="card-img-top" alt="{{ $fav->location->name }}" loading="lazy">
                        @else
                            <img src="https://picsum.photos/seed/loc{{ $fav->location->id }}/400/300" class="card-img-top" alt="{{ $fav->location->name }}" loading="lazy">
                        @endif
                        <span class="badge-category">{{ $fav->location->category }}</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $fav->location->name }}</h5>
                        <p class="card-text">
                            <span class="material-symbols-outlined" style="font-size:16px;">location_on</span>
                            {{ Str::limit($fav->location->address, 30) }}
                        </p>
                        <div class="card-footer-info">
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($fav->location->rating))★@else☆@endif
                                @endfor
                            </span>
                            <span class="rating-value">{{ number_format($fav->location->rating, 1) }}</span>
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
                        <path d="M100 145 L65 110 C55 100 55 82 65 72 C75 62 93 62 100 75 C107 62 125 62 135 72 C145 82 145 100 135 110 Z" fill="var(--color-accent)" opacity="0.7">
                            <animate attributeName="opacity" values="0.7;1;0.7" dur="2s" repeatCount="indefinite"/>
                        </path>
                        <path d="M100 140 L70 112 C62 104 62 90 70 82 C78 74 92 74 100 84 C108 74 122 74 130 82 C138 90 138 104 130 112 Z" fill="var(--color-accent)">
                            <animateTransform attributeName="transform" type="scale" values="1;1.05;1" dur="2s" repeatCount="indefinite" additive="sum" origin="100 110"/>
                        </path>
                    </svg>
                    <h3>Belum Ada Lokasi Favorit</h3>
                    <p>Temukan tempat healing yang kamu suka dan tandai sebagai favorit agar mudah ditemukan kembali nanti.</p>
                    <a href="{{ url('/explore') }}" class="btn btn-accent px-4">
                        <span class="material-symbols-outlined" style="font-size:18px;">explore</span> Mulai Jelajahi
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</section>
@endsection
