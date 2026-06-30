@extends('layouts.app')
@section('title', 'Peta Eksplorasi – HealPoint')

@section('content')
<section class="py-3">
    <h1 class="hp-section-title mb-3">
        <span class="material-symbols-outlined me-2" style="font-size:24px;">map</span>Peta Eksplorasi
    </h1>
    <div class="hp-map-container" id="fullMap" style="height: calc(100vh - 200px); min-height: 500px;"></div>
</section>

@push('scripts')
<script>
    const map = L.map('fullMap').setView([-6.85, 108.35], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    const locations = @json($locations);
    locations.forEach(loc => {
        const marker = L.marker([loc.latitude, loc.longitude]).addTo(map);
        const stars = '★'.repeat(Math.round(loc.rating)) + '☆'.repeat(5 - Math.round(loc.rating));
        marker.bindPopup(`
            <div style="min-width:180px;">
                <strong>${loc.name}</strong><br>
                <small>${loc.category}</small><br>
                <span style="color:#9a4417;">${stars}</span> ${Number(loc.rating).toFixed(1)}<br>
                <a href="{{ url('/location') }}/${loc.id}" class="btn btn-sm btn-accent mt-1" style="font-size:0.75rem;padding:0.3rem 0.8rem;">Lihat Detail</a>
            </div>
        `);
    });

    // Try to get user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const userLatLng = [pos.coords.latitude, pos.coords.longitude];
            L.marker(userLatLng, {
                icon: L.divIcon({
                    html: '<div style="background:#9a4417;width:14px;height:14px;border-radius:50%;border:3px solid #fff;box-shadow:0 0 8px rgba(154,68,23,0.5);"></div>',
                    iconSize: [14, 14],
                    className: ''
                })
            }).addTo(map).bindPopup('Lokasi Anda');
        });
    }
</script>
@endpush
@endsection
