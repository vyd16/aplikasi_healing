@extends('layouts.app')

@section('title', $location->name . ' – HealPoint')
@section('meta_description', Str::limit($location->description, 155))

@section('content')
<section class="py-4">
    <div class="row">
        {{-- Main Content --}}
        <div class="col-lg-8">
            {{-- Cover Image / Carousel --}}
            <div class="hp-detail-header mb-3">
                @if($location->media->count() > 0)
                    <div id="detailCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" style="border-radius:var(--radius-xl);overflow:hidden;">
                            @foreach($location->media as $i => $m)
                                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                    @if($m->type === 'photo')
                                        <img src="{{ $m->url }}" class="d-block w-100 detail-cover" alt="{{ $location->name }}">
                                    @else
                                        <video class="d-block w-100 detail-cover" controls>
                                            <source src="{{ $m->url }}" type="video/mp4">
                                        </video>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($location->media->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#detailCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#detailCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @else
                    <img src="https://picsum.photos/seed/detail{{ $location->id }}/800/400" class="detail-cover w-100" alt="{{ $location->name }}" style="border-radius:var(--radius-xl);">
                @endif
            </div>

            {{-- Location Info Card --}}
            <div class="hp-detail-info">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h1 style="font-size:1.6rem;font-weight:700;margin-bottom:0.25rem;">{{ $location->name }}</h1>
                        <p style="color:var(--text-muted);margin-bottom:0.25rem;">
                            <span class="material-symbols-outlined" style="font-size:18px;">location_on</span>
                            {{ $location->address }}
                        </p>
                        <p class="hp-distance-badge" data-lat="{{ $location->latitude }}" data-lng="{{ $location->longitude }}" style="display: none; align-items: center; gap: 4px; color: var(--color-accent); font-size: 0.9rem; font-weight: 600; margin-bottom: 0.5rem;">
                            <span class="material-symbols-outlined" style="font-size:18px;">near_me</span>
                            Jarak: <span class="distance-value">{{ __('messages.calculating') }}</span>
                        </p>
                    </div>
                    <div class="text-end">
                        <div class="rating-stars" style="font-size:1.1rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($location->rating))★@else☆@endif
                            @endfor
                        </div>
                        <small style="color:var(--text-muted);">{{ number_format($location->rating, 1) }} / 5 ({{ $location->reviews->count() }} ulasan)</small>
                    </div>
                </div>

                <span class="badge-{{ $location->status === 'approved' ? 'approved' : 'pending' }} mb-3 d-inline-block">{{ ucfirst($location->status) }}</span>

                {{-- Action Buttons --}}
                <div class="hp-detail-actions d-flex gap-2 mb-3 flex-wrap">
                    @auth
                        <form method="POST" action="{{ url('/favorites') }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="location_id" value="{{ $location->id }}">
                            <button class="btn btn-outline-accent" type="submit">
                                <span class="material-symbols-outlined" style="font-size:18px;">favorite</span> Simpan
                            </button>
                        </form>
                    @endauth
                    <button class="btn btn-outline-accent" onclick="navigator.share ? navigator.share({title:'{{ $location->name }}',url:window.location.href}) : navigator.clipboard.writeText(window.location.href)">
                        <span class="material-symbols-outlined" style="font-size:18px;">share</span> Bagikan
                    </button>
                    <a class="btn btn-outline-accent" href="https://www.google.com/maps/dir/?api=1&destination={{ $location->latitude }},{{ $location->longitude }}" target="_blank">
                        <span class="material-symbols-outlined" style="font-size:18px;">directions</span> Rute
                    </a>
                </div>

                {{-- Description --}}
                <h5 style="font-weight:600;">Deskripsi</h5>
                <p style="color:var(--text-secondary);line-height:1.7;">{{ $location->description }}</p>

                {{-- Facilities --}}
                <h5 style="font-weight:600;" class="mt-3">Fasilitas</h5>
                <div class="d-flex gap-3 flex-wrap mb-2">
                    @php
                        $facilityMap = [
                            'has_toilet'   => ['label' => 'Toilet',     'icon' => 'wc'],
                            'has_musholla' => ['label' => 'Musholla',   'icon' => 'mosque'],
                            'has_wifi'     => ['label' => 'WiFi',       'icon' => 'wifi'],
                            'has_camping'  => ['label' => 'Area Kemah', 'icon' => 'camping'],
                        ];
                        $hasFacility = false;
                    @endphp
                    @foreach($facilityMap as $key => $fac)
                        @if($location->$key)
                            @php $hasFacility = true; @endphp
                            <span class="badge" style="background:var(--surface-container-high);color:var(--text-primary);padding:0.5rem 0.8rem;border-radius:var(--radius-full);font-size:0.85rem;">
                                <span class="material-symbols-outlined" style="font-size:16px;">{{ $fac['icon'] }}</span> {{ $fac['label'] }}
                            </span>
                        @endif
                    @endforeach
                    @if(!$hasFacility)
                        <span style="color:var(--text-muted);font-size:0.9rem;">Belum ada informasi fasilitas.</span>
                    @endif
                </div>
            </div>

            {{-- Map --}}
            <div class="mt-4">
                <h5 style="font-weight:600;">Lokasi di Peta</h5>
                <div class="hp-map-container mt-2" id="detailMap" style="height:300px;"></div>
            </div>

            {{-- Reviews --}}
            <div class="mt-4">
                <h5 style="font-weight:600;">
                    <span class="material-symbols-outlined" style="font-size:20px;">rate_review</span>
                    Ulasan ({{ $location->reviews->count() }})
                </h5>

                @auth
                    {{-- Add Review Form --}}
                    <div class="hp-review-card mb-3" style="background:var(--color-accent-light);">
                        <form method="POST" action="{{ url('/location/' . $location->id . '/review') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label" style="font-weight:500;">Rating</label>
                                <select name="rating" class="form-select" style="max-width:120px;" required>
                                    <option value="5">★★★★★ (5)</option>
                                    <option value="4">★★★★☆ (4)</option>
                                    <option value="3">★★★☆☆ (3)</option>
                                    <option value="2">★★☆☆☆ (2)</option>
                                    <option value="1">★☆☆☆☆ (1)</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <textarea name="comment" class="form-control" rows="3" placeholder="Tulis ulasan kamu..."></textarea>
                            </div>
                            <div class="mb-2">
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                            <button class="btn btn-accent btn-sm" type="submit">
                                <span class="material-symbols-outlined" style="font-size:18px;">send</span> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                @else
                    <p style="color:var(--text-muted);">
                        <a href="{{ url('/login') }}">Masuk</a> untuk menulis ulasan.
                    </p>
                @endauth

                @forelse($location->reviews as $review)
                    <div class="hp-review-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="review-user">
                                    <span class="material-symbols-outlined" style="font-size:18px;">account_circle</span>
                                    {{ $review->user->name }}
                                </span>
                                <span class="review-date ms-2">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)★@else☆@endif
                                @endfor
                            </span>
                        </div>
                        @if($review->comment)
                            <p class="mt-2 mb-1" style="color:var(--text-secondary);">{{ $review->comment }}</p>
                        @endif
                        @if($review->photo_path)
                            <img src="{{ asset('storage/' . $review->photo_path) }}" class="img-fluid mt-2" style="max-height:200px;border-radius:var(--radius-md);" alt="Review photo">
                        @endif
                    </div>
                @empty
                    <p style="color:var(--text-muted);">Belum ada ulasan. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div style="position:sticky;top:90px;">
                <div class="hp-admin-stat mb-3">
                    <div class="stat-value">{{ number_format($location->rating, 1) }}</div>
                    <div class="stat-label">Rating Rata-rata</div>
                </div>
                <div class="hp-admin-stat mb-3">
                    <div class="stat-value">{{ $location->reviews->count() }}</div>
                    <div class="stat-label">Total Ulasan</div>
                </div>
                <div class="hp-admin-stat mb-3">
                    <div class="stat-value">{{ $location->favorites_count ?? 0 }}</div>
                    <div class="stat-label">Disimpan</div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const map = L.map('detailMap').setView([{{ $location->latitude }}, {{ $location->longitude }}], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);
    L.marker([{{ $location->latitude }}, {{ $location->longitude }}])
        .addTo(map)
        .bindPopup('<strong>{{ $location->name }}</strong>')
        .openPopup();
</script>
@endpush
@endsection
