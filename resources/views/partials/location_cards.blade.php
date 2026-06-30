@forelse($locations as $loc)
    <div class="col-6 col-md-4 col-lg-3">
        <a href="{{ route('location.show', $loc->id) }}" class="hp-location-card">
            <div class="card-img-wrapper">
                @if($loc->media && $loc->media->first())
                    <img src="{{ $loc->media->first()->url }}" class="card-img-top" alt="{{ $loc->name }}">
                @else
                    <img src="https://picsum.photos/seed/loc{{ $loc->id }}/400/300" class="card-img-top" alt="{{ $loc->name }}">
                @endif
                <span class="badge-category">{{ $loc->category }}</span>
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $loc->name }}</h5>
                <p class="card-text mb-1">
                    <span class="material-symbols-outlined" style="font-size:16px;">location_on</span>
                    {{ Str::limit($loc->address, 30) }}
                </p>
                <p class="card-text mb-2 hp-distance-badge text-accent" data-lat="{{ $loc->latitude }}" data-lng="{{ $loc->longitude }}" style="display: none; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 600; color: var(--color-accent);">
                    <span class="material-symbols-outlined" style="font-size:16px;">near_me</span>
                    <span class="distance-value">{{ __('messages.calculating') }}</span>
                </p>

                {{-- Facility Icons --}}
                @if($loc->has_toilet || $loc->has_musholla || $loc->has_wifi || $loc->has_camping)
                    <div class="d-flex gap-1 mb-2 flex-wrap">
                        @if($loc->has_toilet)
                            <span class="badge" style="background:var(--surface-container-high);color:var(--text-muted);font-size:0.7rem;padding:0.2rem 0.4rem;border-radius:var(--radius-full);" title="Toilet">
                                <span class="material-symbols-outlined" style="font-size:14px;">wc</span>
                            </span>
                        @endif
                        @if($loc->has_musholla)
                            <span class="badge" style="background:var(--surface-container-high);color:var(--text-muted);font-size:0.7rem;padding:0.2rem 0.4rem;border-radius:var(--radius-full);" title="Musholla">
                                <span class="material-symbols-outlined" style="font-size:14px;">mosque</span>
                            </span>
                        @endif
                        @if($loc->has_wifi)
                            <span class="badge" style="background:var(--surface-container-high);color:var(--text-muted);font-size:0.7rem;padding:0.2rem 0.4rem;border-radius:var(--radius-full);" title="WiFi">
                                <span class="material-symbols-outlined" style="font-size:14px;">wifi</span>
                            </span>
                        @endif
                        @if($loc->has_camping)
                            <span class="badge" style="background:var(--surface-container-high);color:var(--text-muted);font-size:0.7rem;padding:0.2rem 0.4rem;border-radius:var(--radius-full);" title="Area Kemah">
                                <span class="material-symbols-outlined" style="font-size:14px;">camping</span>
                            </span>
                        @endif
                    </div>
                @endif

                <div class="d-flex align-items-center justify-content-between">
                    <span class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($loc->rating))★@else☆@endif
                        @endfor
                    </span>
                    <small style="color:var(--text-muted)">{{ number_format($loc->rating,1) }}</small>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12 text-center py-5" id="noResultsPlaceholder">
        <span class="material-symbols-outlined" style="font-size:3rem;color:var(--text-muted);">search_off</span>
        <p class="mt-3" style="color:var(--text-muted);">Tidak ada lokasi ditemukan. Coba kata kunci lain.</p>
    </div>
@endforelse
