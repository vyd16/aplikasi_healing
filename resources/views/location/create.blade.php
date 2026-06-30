@extends('layouts.app')
@section('title', 'Tambah Lokasi Baru – HealPoint')

@section('content')
<section class="py-4" style="max-width:800px;">
    <h1 class="hp-section-title mb-4">
        <span class="material-symbols-outlined me-2" style="font-size:24px;">add_location_alt</span>Ajukan Tempat Baru
    </h1>
    <p style="color:var(--text-secondary);margin-bottom:2rem;">
        Punya rekomendasi tempat healing yang belum terdaftar? Isi formulir di bawah ini. Setelah dikirim, tim kami akan meninjau dan menyetujuinya.
    </p>

    @if($errors->any())
        <div class="alert alert-danger hp-alert mb-3">
            <strong>Mohon periksa kembali:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="hp-auth-card">
        <form method="POST" action="{{ route('location.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nama Tempat --}}
            <div class="mb-3">
                <label class="form-label">Nama Tempat <span style="color:var(--color-danger);">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Curug Landung" value="{{ old('name') }}" required>
            </div>

            {{-- Kategori --}}
            <div class="mb-3">
                <label class="form-label">Kategori <span style="color:var(--color-danger);">*</span></label>
                <select name="category" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach(['Alam','Pantai','Gunung','Air Terjun','Kafe','Taman','Seni','Yoga'] as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
                <label class="form-label">Alamat Lengkap <span style="color:var(--color-danger);">*</span></label>
                <input type="text" name="address" class="form-control" placeholder="e.g. Jl. Raya Kuningan, Desa Cigugur" value="{{ old('address') }}" required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label">Deskripsi <span style="color:var(--color-danger);">*</span></label>
                <textarea name="description" class="form-control" rows="4" placeholder="Ceritakan suasana dan keunikan tempat ini (min. 20 karakter)..." required>{{ old('description') }}</textarea>
            </div>

            {{-- Koordinat --}}
            <div class="mb-3">
                <label class="form-label">Titik Lokasi di Peta <span style="color:var(--color-danger);">*</span></label>
                <p class="small" style="color:var(--text-muted);">Klik pada peta untuk menandai titik lokasi, atau isi koordinat secara manual.</p>
                <div class="hp-map-container mb-2" id="pickMap" style="height:300px;"></div>
                <div class="row g-2">
                    <div class="col-6">
                        <input type="number" step="any" name="latitude" id="latInput" class="form-control" placeholder="Latitude" value="{{ old('latitude', '-6.85') }}" required>
                    </div>
                    <div class="col-6">
                        <input type="number" step="any" name="longitude" id="lngInput" class="form-control" placeholder="Longitude" value="{{ old('longitude', '108.35') }}" required>
                    </div>
                </div>
            </div>

            {{-- Fasilitas --}}
            <div class="mb-3">
                <label class="form-label">Fasilitas Tersedia</label>
                <div class="d-flex gap-3 flex-wrap">
                    @php
                        $facilityOptions = [
                            'has_toilet'   => ['label' => 'Toilet',     'icon' => 'wc'],
                            'has_musholla' => ['label' => 'Musholla',   'icon' => 'mosque'],
                            'has_wifi'     => ['label' => 'WiFi',       'icon' => 'wifi'],
                            'has_camping'  => ['label' => 'Area Kemah', 'icon' => 'camping'],
                        ];
                    @endphp
                    @foreach($facilityOptions as $key => $fac)
                        <label class="hp-facility-check" style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;padding:0.45rem 0.85rem;border-radius:var(--radius-full);background:var(--surface-container-high);color:var(--text-secondary);font-size:0.9rem;font-weight:500;transition:all 0.2s ease;">
                            <input type="checkbox" name="{{ $key }}" value="1" {{ old($key) ? 'checked' : '' }}
                                   onchange="this.parentElement.style.background = this.checked ? 'var(--color-accent)' : 'var(--surface-container-high)'; this.parentElement.style.color = this.checked ? '#fff' : 'var(--text-secondary)';">
                            <span class="material-symbols-outlined" style="font-size:18px;">{{ $fac['icon'] }}</span>
                            {{ $fac['label'] }}
                        </label>
                    @endforeach
                </div>
                <small style="color:var(--text-muted);">Centang fasilitas yang tersedia di lokasi ini.</small>
            </div>

            {{-- Foto --}}
            <div class="mb-4">
                <label class="form-label">Foto Tempat <small style="color:var(--text-muted);">(opsional, maks 5MB)</small></label>
                <input type="file" name="photo" class="form-control" accept="image/*">
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-accent w-100">
                <span class="material-symbols-outlined" style="font-size:20px;">send</span> Kirim Pengajuan
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script>
    const lat = parseFloat(document.getElementById('latInput').value) || -6.85;
    const lng = parseFloat(document.getElementById('lngInput').value) || 108.35;

    const map = L.map('pickMap').setView([lat, lng], 11);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    function updateInputs(latlng) {
        document.getElementById('latInput').value = latlng.lat.toFixed(6);
        document.getElementById('lngInput').value = latlng.lng.toFixed(6);
    }

    // Click on map to place marker
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateInputs(e.latlng);
    });

    // Drag marker
    marker.on('dragend', function(e) {
        updateInputs(marker.getLatLng());
    });

    // Sync inputs to marker
    document.getElementById('latInput').addEventListener('change', function() {
        const newLat = parseFloat(this.value);
        const newLng = parseFloat(document.getElementById('lngInput').value);
        if (!isNaN(newLat) && !isNaN(newLng)) {
            marker.setLatLng([newLat, newLng]);
            map.panTo([newLat, newLng]);
        }
    });
    document.getElementById('lngInput').addEventListener('change', function() {
        const newLat = parseFloat(document.getElementById('latInput').value);
        const newLng = parseFloat(this.value);
        if (!isNaN(newLat) && !isNaN(newLng)) {
            marker.setLatLng([newLat, newLng]);
            map.panTo([newLat, newLng]);
        }
    });
</script>
@endpush
@endsection
