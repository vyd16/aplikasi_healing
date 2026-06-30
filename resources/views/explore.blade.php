@extends('layouts.app')

@section('title', 'Jelajahi Tempat Healing – HealPoint')

@section('content')
<section class="py-4">
    <h1 class="hp-section-title mb-4">Jelajahi Tempat Healing</h1>

    {{-- Search & Filter Bar --}}
    <form method="GET" action="{{ url('/explore') }}" id="exploreForm">
        <div class="row mb-3">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <div class="input-group">
                    <span class="input-group-text" style="background:var(--input-bg);border-color:var(--input-border);border-radius:var(--radius-md) 0 0 var(--radius-md);">
                        <span class="material-symbols-outlined" style="font-size:20px;color:var(--text-muted);">search</span>
                    </span>
                    <input type="text" name="q" id="searchInput" class="form-control" placeholder="Cari lokasi..." value="{{ request('q') }}"
                           style="border-radius:0;" autocomplete="off">
                    <button class="btn btn-accent" type="submit" style="border-radius:0 var(--radius-md) var(--radius-md) 0;">
                        <span class="material-symbols-outlined" style="font-size:20px;">search</span>
                    </button>
                </div>

                {{-- Search History Dropdown --}}
                <div id="searchHistory" class="position-relative" style="display:none;">
                    <div class="list-group position-absolute w-100 shadow-sm" style="z-index:1050;border-radius:var(--radius-md);overflow:hidden;margin-top:2px;">
                        {{-- populated by JS --}}
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
                <div class="dropdown hp-custom-dropdown">
                    <button class="btn dropdown-toggle w-100" type="button" id="categoryDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">category</span>
                            <span class="selected-label">
                                @if(request('category'))
                                    @php
                                        $catIcons = ['Alam' => '🌳', 'Pantai' => '🏖️', 'Gunung' => '⛰️', 'Air Terjun' => '💧'];
                                    @endphp
                                    {{ $catIcons[request('category')] ?? '' }} {{ request('category') }}
                                @else
                                    Semua Kategori
                                @endif
                            </span>
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100 shadow" aria-labelledby="categoryDropdownBtn">
                        <li>
                            <button class="dropdown-item d-flex align-items-center gap-2 {{ request('category') == '' ? 'active' : '' }}" type="button" data-value="">
                                <span class="material-symbols-outlined" style="font-size: 18px;">grid_view</span> Semua Kategori
                            </button>
                        </li>
                        @foreach(['Alam' => '🌳', 'Pantai' => '🏖️', 'Gunung' => '⛰️', 'Air Terjun' => '💧'] as $cat => $emoji)
                            <li>
                                <button class="dropdown-item d-flex align-items-center gap-2 {{ request('category') == $cat ? 'active' : '' }}" type="button" data-value="{{ $cat }}">
                                    <span style="font-size: 18px;">{{ $emoji }}</span> {{ $cat }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <input type="hidden" name="rating" id="ratingInput" value="{{ request('rating') }}">
                <div class="dropdown hp-custom-dropdown">
                    <button class="btn dropdown-toggle w-100" type="button" id="ratingDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="d-flex align-items-center gap-2">
                            <span class="material-symbols-outlined" style="font-size: 20px;">star</span>
                            <span class="selected-label">
                                @if(request('rating'))
                                    {{ request('rating') }}+ ★
                                @else
                                    Rating
                                @endif
                            </span>
                        </span>
                    </button>
                    <ul class="dropdown-menu w-100 shadow" aria-labelledby="ratingDropdownBtn">
                        <li>
                            <button class="dropdown-item d-flex align-items-center gap-2 {{ request('rating') == '' ? 'active' : '' }}" type="button" data-value="">
                                <span class="material-symbols-outlined" style="font-size: 18px;">star_half</span> Semua Rating
                            </button>
                        </li>
                        @for($r = 4; $r >= 1; $r--)
                            <li>
                                <button class="dropdown-item d-flex align-items-center gap-2 {{ request('rating') == $r ? 'active' : '' }}" type="button" data-value="{{ $r }}">
                                    <span style="color: var(--color-warning); font-size: 14px; letter-spacing: -2px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $r)★@else☆@endif
                                        @endfor
                                    </span>
                                    <span style="margin-left: 4px;">{{ $r }}+ ★</span>
                                </button>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>

        </div>

        {{-- Facility Filters --}}
        <div class="d-flex gap-3 flex-wrap align-items-center mb-4 p-3" style="background:var(--surface-container);border-radius:var(--radius-lg);">
            <span style="font-weight:600;font-size:0.9rem;color:var(--text-secondary);">
                <span class="material-symbols-outlined" style="font-size:18px;vertical-align:middle;">filter_list</span> Fasilitas:
            </span>
            @php
                $facilities = [
                    'has_toilet'   => ['label' => 'Toilet',     'icon' => 'wc'],
                    'has_musholla' => ['label' => 'Musholla',   'icon' => 'mosque'],
                    'has_wifi'     => ['label' => 'WiFi',       'icon' => 'wifi'],
                    'has_camping'  => ['label' => 'Area Kemah', 'icon' => 'camping'],
                ];
            @endphp
            @foreach($facilities as $key => $fac)
                <label class="hp-facility-check" style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;padding:0.35rem 0.75rem;border-radius:var(--radius-full);background:{{ request($key) ? 'var(--color-accent)' : 'var(--surface-container-high)' }};color:{{ request($key) ? '#fff' : 'var(--text-secondary)' }};font-size:0.85rem;font-weight:500;transition:all 0.2s ease;">
                    <input type="checkbox" name="{{ $key }}" value="1" {{ request($key) ? 'checked' : '' }}
                           onchange="this.form.submit()" style="display:none;">
                    <span class="material-symbols-outlined" style="font-size:18px;">{{ $fac['icon'] }}</span>
                    {{ $fac['label'] }}
                </label>
            @endforeach
        </div>
    </form>

    {{-- Results Count --}}
    <div class="mb-3">
        <small style="color:var(--text-muted);">{{ $locations->total() }} lokasi ditemukan</small>
    </div>

    {{-- Results Grid --}}
    <div class="row g-4" id="locationsGrid">
        @include('partials.location_cards')
    </div>

    {{-- Load More --}}
    <div class="text-center mt-5 mb-4 d-none" id="loadMoreContainer">
        <button type="button" class="btn btn-accent px-5 py-3" id="loadMoreBtn" style="font-size:0.95rem;border-radius:var(--radius-lg);display:inline-flex;align-items:center;gap:8px;">
            <span class="material-symbols-outlined spin-icon" id="loadMoreSpinner" style="display:none;font-size:20px;">sync</span>
            <span class="material-symbols-outlined" id="loadMoreIcon" style="font-size:20px;">expand_more</span>
            <span id="loadMoreText">Muat Lebih Banyak</span>
        </button>
    </div>
</section>

@push('scripts')
<script>
(function() {
    const STORAGE_KEY = 'hp_search_history';
    const MAX_HISTORY = 5;
    const searchInput = document.getElementById('searchInput');
    const historyContainer = document.getElementById('searchHistory');
    const historyList = historyContainer?.querySelector('.list-group');
    const form = document.getElementById('exploreForm');

    // --- Custom Dropdowns handling ---
    document.querySelectorAll('.hp-custom-dropdown').forEach(dropdown => {
        const hiddenInput = dropdown.closest('.col-6').querySelector('input[type="hidden"]');
        const items = dropdown.querySelectorAll('.dropdown-item');
        
        items.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                hiddenInput.value = item.getAttribute('data-value');
                form.submit();
            });
        });
    });


    // Load history from localStorage
    function getHistory() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
        } catch (e) {
            return [];
        }
    }

    // Save a search term
    function saveSearch(term) {
        if (!term || term.trim().length < 2) return;
        let history = getHistory();
        // Remove duplicate
        history = history.filter(h => h.toLowerCase() !== term.toLowerCase());
        // Add to front
        history.unshift(term.trim());
        // Limit
        if (history.length > MAX_HISTORY) history = history.slice(0, MAX_HISTORY);
        localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
    }

    // Render history dropdown
    function renderHistory() {
        const history = getHistory();
        if (!historyList || history.length === 0) {
            historyContainer.style.display = 'none';
            return;
        }

        historyList.innerHTML = '<div class="list-group-item d-flex justify-content-between align-items-center" style="background:var(--surface-container);border:none;padding:0.4rem 0.8rem;">'
            + '<small style="color:var(--text-muted);font-weight:600;"><span class="material-symbols-outlined" style="font-size:16px;vertical-align:middle;">history</span> Riwayat Pencarian</small>'
            + '<button type="button" class="btn btn-sm p-0" id="clearHistoryBtn" style="color:var(--color-danger);font-size:0.75rem;border:none;background:none;">Hapus</button>'
            + '</div>';

        history.forEach(term => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action d-flex align-items-center gap-2';
            item.style.cssText = 'background:var(--card-bg);color:var(--text-primary);border:none;border-top:1px solid var(--surface-container-high);padding:0.5rem 0.8rem;font-size:0.9rem;';
            item.innerHTML = '<span class="material-symbols-outlined" style="font-size:16px;color:var(--text-muted);">schedule</span>' + term;
            item.addEventListener('click', () => {
                searchInput.value = term;
                historyContainer.style.display = 'none';
                form.submit();
            });
            historyList.appendChild(item);
        });

        historyContainer.style.display = 'block';

        // Clear history button
        document.getElementById('clearHistoryBtn')?.addEventListener('click', (e) => {
            e.stopPropagation();
            localStorage.removeItem(STORAGE_KEY);
            historyContainer.style.display = 'none';
        });
    }

    // Show history on focus when input is empty or matches
    searchInput?.addEventListener('focus', () => {
        renderHistory();
    });

    // Hide history when clicking outside
    document.addEventListener('click', (e) => {
        if (!searchInput?.contains(e.target) && !historyContainer?.contains(e.target)) {
            historyContainer.style.display = 'none';
        }
    });

    // Save search on form submit
    form?.addEventListener('submit', () => {
        saveSearch(searchInput?.value);
    });

    // If page loaded with a search query, save it
    const currentQuery = searchInput?.value;
    if (currentQuery && currentQuery.trim().length >= 2) {
        saveSearch(currentQuery);
    }

    // --- Load More Feature ---
    let nextPage = {{ $locations->currentPage() + 1 }};
    let hasMore = {{ $locations->hasMorePages() ? 'true' : 'false' }};
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadMoreSpinner = document.getElementById('loadMoreSpinner');
    const loadMoreIcon = document.getElementById('loadMoreIcon');
    const loadMoreText = document.getElementById('loadMoreText');
    const locationsGrid = document.getElementById('locationsGrid');

    if (hasMore && loadMoreContainer) {
        loadMoreContainer.classList.remove('d-none');
    }

    loadMoreBtn?.addEventListener('click', () => {
        if (!hasMore) return;

        // UI Feedback
        loadMoreBtn.disabled = true;
        loadMoreSpinner.style.display = 'inline-block';
        loadMoreIcon.style.display = 'none';
        loadMoreText.textContent = 'Memuat...';

        // Prepare URL with current query parameters
        const url = new URL(window.location.href);
        url.searchParams.set('page', nextPage);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Append new cards
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.html;
            
            const newBadges = tempDiv.querySelectorAll('.hp-distance-badge');
            locationsGrid.appendChild(tempDiv);
            
            // Re-flatten grid to avoid nesting divs if needed, or simply append child nodes
            while (tempDiv.firstChild) {
                locationsGrid.appendChild(tempDiv.firstChild);
            }
            tempDiv.remove();

            // Calculate distance for the new cards
            if (window.calculateDistances) {
                window.calculateDistances(newBadges);
            }

            // Update page state
            hasMore = data.hasMore;
            nextPage++;

            if (!hasMore) {
                loadMoreContainer.style.display = 'none';
            } else {
                loadMoreBtn.disabled = false;
                loadMoreSpinner.style.display = 'none';
                loadMoreIcon.style.display = 'inline-block';
                loadMoreText.textContent = 'Muat Lebih Banyak';
            }
        })
        .catch(err => {
            console.error('Error loading more locations:', err);
            loadMoreBtn.disabled = false;
            loadMoreSpinner.style.display = 'none';
            loadMoreIcon.style.display = 'inline-block';
            loadMoreText.textContent = 'Muat Lebih Banyak';
        });
    });
})();
</script>
@endpush
@endsection
