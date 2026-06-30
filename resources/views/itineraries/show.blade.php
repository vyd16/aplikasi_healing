@extends('layouts.app')
@section('title', $itinerary->title . ' – HealPoint')

@section('content')
<section class="py-4">
    {{-- Back button --}}
    <a href="{{ route('itineraries') }}" class="d-inline-flex align-items-center gap-1 mb-3" style="color:var(--text-muted);font-size:0.85rem;text-decoration:none;">
        <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span> Kembali ke Trip Saya
    </a>

    {{-- Trip Header Card --}}
    <div class="hp-trip-header mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:0.25rem;color:var(--text-primary);">{{ $itinerary->title }}</h1>
                <p class="mb-0 d-flex align-items-center gap-2" style="color:var(--text-muted);font-size:0.9rem;">
                    <span class="material-symbols-outlined" style="font-size:16px;">calendar_today</span>
                    {{ \Carbon\Carbon::parse($itinerary->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($itinerary->end_date)->format('d M Y') }}
                    <span class="badge-approved ms-2">{{ $totalDays }} hari</span>
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                {{-- Share Button --}}
                <form method="POST" action="{{ route('itineraries.share', $itinerary->id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-accent btn-sm px-3 d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined" style="font-size:18px;">share</span> Bagikan
                    </button>
                </form>
                {{-- Add Destination Button --}}
                <button class="btn btn-accent btn-sm px-3 d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addDestination">
                    <span class="material-symbols-outlined" style="font-size:18px;">add_location</span> Tambah Destinasi
                </button>
            </div>
        </div>

        {{-- Share URL display --}}
        @if(session('share_url'))
            <div class="hp-share-box mt-3">
                <span class="material-symbols-outlined" style="font-size:18px;color:var(--color-success);">link</span>
                <input type="text" value="{{ session('share_url') }}" id="shareUrlInput" readonly>
                <button class="btn btn-accent btn-sm px-3" onclick="copyShareUrl()" id="copyBtn">
                    <span class="material-symbols-outlined" style="font-size:16px;">content_copy</span> Salin
                </button>
            </div>
        @endif
    </div>

    {{-- Trip Timeline per Day --}}
    @for($day = 1; $day <= $totalDays; $day++)
        <div class="hp-day-group" data-day="{{ $day }}">
            <span class="hp-day-label">
                <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">wb_sunny</span>
                Hari {{ $day }} · {{ \Carbon\Carbon::parse($itinerary->start_date)->addDays($day - 1)->isoFormat('dddd, D MMM') }}
            </span>

            <div class="day-items-container" data-day="{{ $day }}">
                @if(isset($itemsByDay[$day]))
                    @foreach($itemsByDay[$day] as $item)
                        <div class="hp-trip-item" draggable="true" data-item-id="{{ $item->id }}" data-day="{{ $day }}">
                            <span class="drag-handle material-symbols-outlined">drag_indicator</span>
                            <div class="item-info">
                                <div class="item-name">{{ $item->location->name }}</div>
                                <div class="item-meta">
                                    <span class="material-symbols-outlined" style="font-size:14px;vertical-align:middle;">location_on</span>
                                    {{ Str::limit($item->location->address, 40) }} · {{ $item->location->category }}
                                </div>
                            </div>
                            <a href="{{ route('location.show', $item->location->id) }}" class="btn btn-sm" style="color:var(--color-accent);flex-shrink:0;" title="Lihat Detail">
                                <span class="material-symbols-outlined" style="font-size:18px;">open_in_new</span>
                            </a>
                            <form method="POST" action="{{ route('itineraries.removeItem', $item->id) }}" class="d-inline" style="flex-shrink:0;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm" style="color:var(--color-danger);" title="Hapus" onclick="return confirm('Hapus destinasi ini?')">
                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>

            @if(!isset($itemsByDay[$day]) || $itemsByDay[$day]->isEmpty())
                <div class="text-center py-3" style="border:2px dashed var(--card-border);border-radius:var(--radius-md);color:var(--text-muted);font-size:0.85rem;">
                    <span class="material-symbols-outlined" style="font-size:20px;">add_circle_outline</span>
                    <br>Belum ada destinasi. Klik "Tambah Destinasi" untuk menambahkan.
                </div>
            @endif
        </div>
    @endfor
</section>

{{-- Add Destination Modal --}}
<div class="modal fade" id="addDestination" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background:var(--card-bg);color:var(--text-primary);border-radius:var(--radius-xl);border:1px solid var(--card-border);">
            <div class="modal-header border-0">
                <h5 class="modal-title" style="font-weight:700;">Tambah Destinasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('itineraries.addItem', $itinerary->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:500;">Pilih Hari</label>
                        <select name="day_number" class="form-select" required>
                            @for($d = 1; $d <= $totalDays; $d++)
                                <option value="{{ $d }}">Hari {{ $d }} – {{ \Carbon\Carbon::parse($itinerary->start_date)->addDays($d - 1)->isoFormat('dddd, D MMM') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:500;">Cari Lokasi</label>
                        <input type="text" id="searchLocation" class="form-control mb-2" placeholder="Ketik nama lokasi...">
                        <div id="locationList" style="max-height:300px;overflow-y:auto;">
                            @foreach($locations as $loc)
                                <label class="d-flex align-items-center gap-2 p-2 rounded location-option" style="cursor:pointer;border:1px solid transparent;transition:all 0.2s;" data-name="{{ strtolower($loc->name) }}">
                                    <input type="radio" name="location_id" value="{{ $loc->id }}" required style="accent-color:var(--color-accent);">
                                    <div>
                                        <span style="font-weight:600;font-size:0.9rem;">{{ $loc->name }}</span>
                                        <br><small style="color:var(--text-muted);">{{ $loc->category }} · {{ Str::limit($loc->address, 40) }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-accent" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-accent">
                        <span class="material-symbols-outlined" style="font-size:18px;">add_location</span> Tambahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // ===== Search filter for locations in modal =====
    const searchInput = document.getElementById('searchLocation');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('.location-option').forEach(opt => {
                const name = opt.getAttribute('data-name');
                opt.style.display = name.includes(q) ? '' : 'none';
            });
        });
    }

    // ===== Highlight selected location =====
    document.querySelectorAll('.location-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('.location-option').forEach(opt => {
                opt.style.borderColor = 'transparent';
                opt.style.background = 'transparent';
            });
            radio.closest('.location-option').style.borderColor = 'var(--color-accent)';
            radio.closest('.location-option').style.background = 'var(--color-accent-light)';
        });
    });

    // ===== Drag and Drop =====
    let draggedItem = null;

    document.querySelectorAll('.hp-trip-item').forEach(item => {
        item.addEventListener('dragstart', (e) => {
            draggedItem = item;
            item.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragend', () => {
            item.classList.remove('dragging');
            draggedItem = null;
            saveOrder();
        });
    });

    document.querySelectorAll('.day-items-container').forEach(container => {
        container.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const afterElement = getDragAfterElement(container, e.clientY);
            if (afterElement == null) {
                container.appendChild(draggedItem);
            } else {
                container.insertBefore(draggedItem, afterElement);
            }
        });
    });

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.hp-trip-item:not(.dragging)')];
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            }
            return closest;
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function saveOrder() {
        const items = [];
        document.querySelectorAll('.day-items-container').forEach(container => {
            const dayNum = parseInt(container.getAttribute('data-day'));
            container.querySelectorAll('.hp-trip-item').forEach((item, idx) => {
                items.push({
                    id: parseInt(item.getAttribute('data-item-id')),
                    day_number: dayNum,
                    order: idx + 1
                });
                item.setAttribute('data-day', dayNum);
            });
        });

        if (items.length === 0) return;

        fetch('{{ route("itineraries.reorder", $itinerary->id) }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: items })
        });
    }
});

// Copy share URL
function copyShareUrl() {
    const input = document.getElementById('shareUrlInput');
    if (input) {
        input.select();
        navigator.clipboard.writeText(input.value).then(() => {
            const btn = document.getElementById('copyBtn');
            btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:16px;">check</span> Tersalin!';
            setTimeout(() => {
                btn.innerHTML = '<span class="material-symbols-outlined" style="font-size:16px;">content_copy</span> Salin';
            }, 2000);
        });
    }
}
</script>
@endpush
@endsection
