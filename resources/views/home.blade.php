@extends('layouts.app')

@section('title', 'HealPoint – Temukan Tempat Healing Terbaik')

@section('content')
{{-- Header Area: Title & Subtitle + Search --}}
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <h1 class="hp-section-title mb-1" style="font-size: 1.8rem; font-weight: 800; letter-spacing: -0.5px;">Temukan Tempat Healing Terbaik di Sekitarmu</h1>
        <p class="mb-0" style="font-size: 0.9rem; color: var(--text-secondary);">Jelajahi ratusan lokasi wisata penenang pikiran di Cirebon, Majalengka, dan Kuningan.</p>
    </div>
    <div class="hp-search flex-shrink-0" style="width: 100%; max-width: 340px;">
        <form method="GET" action="{{ url('/explore') }}">
            <div class="input-group" style="height: 48px; border-radius: var(--radius-full); overflow: hidden; border: 1px solid var(--outline-variant); background: var(--surface-container-high);">
                <span class="input-group-text border-0 bg-transparent ps-3">
                    <span class="material-symbols-outlined text-muted" style="font-size: 20px;">search</span>
                </span>
                <input type="text" name="q" class="form-control border-0 bg-transparent" placeholder="Cari cafe, taman, atau tempat..." style="font-size: 0.85rem; box-shadow: none;">
            </div>
        </form>
    </div>
</div>

@php
    // Get first 7 popular locations, and fill with static data if database has less than 7
    $featuredList = $popularLocations->take(7);
    $fallbacks = [
        [
            'id' => 991,
            'name' => 'Zenergy Retreat: Kembali ke Alam',
            'description' => 'Pengalaman meditasi mendalam di tengah hutan pinus dengan fasilitas spa alami dan bimbingan praktisi profesional.',
            'category' => 'Alam',
            'image' => 'https://picsum.photos/seed/featured1/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 992,
            'name' => 'Tepi Langit Camp & Cafe',
            'description' => 'Menikmati kopi hangat di atas ketinggian awan dengan pemandangan langsung ke Gunung Ciremai yang memukau.',
            'category' => 'Gunung',
            'image' => 'https://picsum.photos/seed/featured2/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 993,
            'name' => 'Pantai Kejawanan Sunset Point',
            'description' => 'Destinasi terbaik untuk menikmati keindahan matahari terbenam dengan hembusan angin laut yang menenangkan jiwa.',
            'category' => 'Pantai',
            'image' => 'https://picsum.photos/seed/featured3/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 994,
            'name' => 'Curug Muara Jaya Oasis',
            'description' => 'Gemercik air terjun bertingkat yang menyegarkan di lereng gunung, tempat sempurna menjernihkan pikiran.',
            'category' => 'Air Terjun',
            'image' => 'https://picsum.photos/seed/featured4/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 995,
            'name' => 'Taman Ketenangan Balong Dalem',
            'description' => 'Telaga air jernih alami dikelilingi pepohonan rindang purba, sangat cocok untuk refleksi diri.',
            'category' => 'Alam',
            'image' => 'https://picsum.photos/seed/featured5/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 996,
            'name' => 'Bukit Lambosir Greenery',
            'description' => 'Padang rumput hijau luas berlatar belakang tebing batu Megalitikum yang eksotis dan damai.',
            'category' => 'Gunung',
            'image' => 'https://picsum.photos/seed/featured6/1200/600',
            'url' => url('/explore')
        ],
        [
            'id' => 997,
            'name' => 'Hutan Kota Sumber Silir',
            'description' => 'Kawasan konservasi hutan bambu rimbun di tengah kota yang menawarkan keteduhan instan bagi jiwa penat.',
            'category' => 'Alam',
            'image' => 'https://picsum.photos/seed/featured7/1200/600',
            'url' => url('/explore')
        ]
    ];
    
    $slides = [];
    foreach($featuredList as $loc) {
        $slides[] = [
            'id' => $loc->id,
            'name' => $loc->name,
            'description' => $loc->description,
            'category' => $loc->category,
            'image' => $loc->media->first() ? $loc->media->first()->url : 'https://picsum.photos/seed/loc' . $loc->id . '/1200/600',
            'url' => route('location.show', $loc->id)
        ];
    }
    
    $idx = 0;
    while(count($slides) < 7 && $idx < count($fallbacks)) {
        $slides[] = $fallbacks[$idx];
        $idx++;
    }
@endphp

{{-- 7 Recommendations Slideshow/Carousel with zoom transitions --}}
<section class="mb-5">
    <div class="hp-featured-carousel" id="featuredCarousel">
        @foreach($slides as $slideIdx => $slide)
            <div class="carousel-slide {{ $slideIdx === 0 ? 'active' : '' }}" data-index="{{ $slideIdx }}" style="background: url('{{ $slide['image'] }}') no-repeat center center;">
                <div class="carousel-overlay"></div>
                <div class="carousel-content">
                    <span class="badge mb-3 px-3 py-2 text-uppercase" style="background: var(--color-accent); color: #fff; font-weight: 700; font-size: 0.7rem; border-radius: var(--radius-full); letter-spacing: 0.5px;">Rekomendasi Minggu Ini</span>
                    <h2 class="fw-bold mb-2 text-white" style="letter-spacing: -0.5px; font-size: 2.2rem; text-shadow: 0 2px 4px rgba(0,0,0,0.4);">{{ $slide['name'] }}</h2>
                    <p class="text-white-50 mb-4" style="font-size: 0.95rem; line-height: 1.5; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">{{ Str::limit($slide['description'], 160) }}</p>
                    <a href="{{ $slide['url'] }}" class="btn btn-accent px-4 py-2 d-flex align-items-center gap-2" style="border-radius: var(--radius-full); font-weight: 600; font-size: 0.85rem; box-shadow: 0 4px 14px rgba(154, 68, 23, 0.3); width: fit-content;">
                        Lihat Selengkapnya <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                    </a>
                </div>
            </div>
        @endforeach

        {{-- Next & Prev Buttons --}}
        <button class="carousel-nav-btn prev-btn" id="prevSlide" aria-label="Previous slide">
            <span class="material-symbols-outlined">chevron_left</span>
        </button>
        <button class="carousel-nav-btn next-btn" id="nextSlide" aria-label="Next slide">
            <span class="material-symbols-outlined">chevron_right</span>
        </button>

        {{-- Indicators --}}
        <ul class="carousel-indicators" id="carouselIndicators">
            @foreach($slides as $slideIdx => $slide)
                <li class="carousel-indicator-dot {{ $slideIdx === 0 ? 'active' : '' }}" data-go-to="{{ $slideIdx }}"></li>
            @endforeach
        </ul>
    </div>
</section>



{{-- Categories --}}
<section class="mb-5 hp-categories">
    <h2 class="hp-section-title">Kategori</h2>
    <div class="row g-3 mt-2">
        <div class="col-6 col-md-3 anim-slide-up anim-delay-1">
            <a href="{{ url('/explore?category=Alam') }}" class="hp-category-card cat-alam">
                <span class="cat-name">Alam</span>
            </a>
        </div>
        <div class="col-6 col-md-3 anim-slide-up anim-delay-2">
            <a href="{{ url('/explore?category=Pantai') }}" class="hp-category-card cat-pantai">
                <span class="cat-name">Pantai</span>
            </a>
        </div>
        <div class="col-6 col-md-3 anim-slide-up anim-delay-3">
            <a href="{{ url('/explore?category=Gunung') }}" class="hp-category-card cat-gunung">
                <span class="cat-name">Gunung</span>
            </a>
        </div>
        <div class="col-6 col-md-3 anim-slide-up anim-delay-4">
            <a href="{{ url('/explore?category=Air Terjun') }}" class="hp-category-card cat-airterjun">
                <span class="cat-name">Air Terjun</span>
            </a>
        </div>
    </div>
</section>

{{-- Galeri Visual Estetik (Standardized Card Heights Grid - aligned perfectly "Rata") --}}
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="hp-section-title mb-0">Galeri Visual Estetik</h2>
        <a href="{{ url('/explore') }}" class="small fw-bold text-accent" style="text-decoration:none; font-size: 0.85rem; display:flex; align-items:center; gap:4px;">
            Lihat Semua <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
        </a>
    </div>
    <div class="row g-4">
        @forelse($popularLocations as $loc)
            <div class="col-6 col-md-4 col-lg-3 anim-slide-up">
                <a href="{{ route('location.show', $loc->id) }}" class="hp-location-card">
                    <div class="card-img-wrapper">
                        @if($loc->media->first())
                            <img src="{{ $loc->media->first()->url }}" class="card-img-top" alt="{{ $loc->name }}">
                        @else
                            <img src="https://picsum.photos/seed/{{ $loc->id }}/400/300" class="card-img-top" alt="{{ $loc->name }}">
                        @endif
                        <span class="badge-category">{{ $loc->category }}</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $loc->name }}</h5>
                        <p class="card-text mb-1">
                            <span class="material-symbols-outlined" style="font-size:16px; vertical-align: middle;">location_on</span>
                            {{ $loc->address }}
                        </p>
                        <p class="card-text mb-2 hp-distance-badge text-accent" data-lat="{{ $loc->latitude }}" data-lng="{{ $loc->longitude }}" style="display: none; align-items: center; gap: 4px; font-size: 0.8rem; font-weight: 600; color: var(--color-accent);">
                            <span class="material-symbols-outlined" style="font-size:15px; vertical-align: middle;">near_me</span>
                            <span class="distance-value">Menghitung...</span>
                        </p>
                        
                        <div class="card-footer-info">
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($loc->rating))★@else☆@endif
                                @endfor
                            </span>
                            <span class="rating-value">{{ number_format($loc->rating, 1) }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <span class="material-symbols-outlined" style="font-size:3rem;color:var(--text-muted);">explore_off</span>
                <p class="mt-2" style="color:var(--text-muted);">Belum ada lokasi tersedia. Jadilah yang pertama menambahkan!</p>
            </div>
        @endforelse
    </div>
</section>

{{-- Map Explorer --}}
<section class="mb-5">
    <h2 class="hp-section-title">Peta Eksplorasi</h2>
    <div class="hp-map-container mt-3" id="homeMap" style="height: 400px; border-radius: var(--radius-lg); overflow: hidden;"></div>
</section>

@push('scripts')
<script>
    // ===== Leaflet Map initialization =====
    const map = L.map('homeMap').setView([-6.85, 108.35], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add markers for locations
    const locations = @json($mapLocations);
    locations.forEach(loc => {
        L.marker([loc.latitude, loc.longitude])
            .addTo(map)
            .bindPopup(`<strong>${loc.name}</strong><br>${loc.category}<br>⭐ ${Number(loc.rating).toFixed(1)}`);
    });



    // ===== 7 Recommendations Carousel Slide System =====
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('#featuredCarousel .carousel-slide');
        const dots = document.querySelectorAll('#carouselIndicators .carousel-indicator-dot');
        const nextBtn = document.getElementById('nextSlide');
        const prevBtn = document.getElementById('prevSlide');
        
        let currentSlide = 0;
        let slideInterval = setInterval(nextSlideAction, 5000);

        function showSlide(index) {
            slides[currentSlide].classList.remove('active');
            dots[currentSlide].classList.remove('active');
            
            currentSlide = (index + slides.length) % slides.length;
            
            slides[currentSlide].classList.add('active');
            dots[currentSlide].classList.add('active');
        }

        function nextSlideAction() {
            showSlide(currentSlide + 1);
        }

        function prevSlideAction() {
            showSlide(currentSlide - 1);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                clearInterval(slideInterval);
                nextSlideAction();
                slideInterval = setInterval(nextSlideAction, 5000);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                clearInterval(slideInterval);
                prevSlideAction();
                slideInterval = setInterval(nextSlideAction, 5000);
            });
        }

        dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                clearInterval(slideInterval);
                const targetIdx = parseInt(e.target.getAttribute('data-go-to'));
                showSlide(targetIdx);
                slideInterval = setInterval(nextSlideAction, 5000);
            });
        });
    });
</script>
@endpush
@endsection
