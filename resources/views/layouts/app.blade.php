<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HealPoint – Temukan Tempat Healing Terbaik')</title>
    <meta name="description" content="@yield('meta_description', 'HealPoint - Platform direktori lokasi wisata penenang pikiran di Cirebon, Majalengka, dan Kuningan.')">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body data-distance-unit="{{ session('distance_unit', 'km') }}">

    @auth
    {{-- ===== Sidebar (Authenticated Users) ===== --}}
    <aside class="hp-sidebar no-transition" id="hpSidebar">
        {{-- Inline script to apply collapsed class immediately, preventing flicker on page load --}}
        <script>
            if (localStorage.getItem('hp-sidebar-collapsed') === 'true') {
                document.getElementById('hpSidebar').classList.add('collapsed');
            }
        </script>

        {{-- Collapse Toggle --}}
        <button class="sidebar-collapse-btn" id="sidebarToggle" aria-label="Toggle sidebar">
            <span class="material-symbols-outlined" style="font-size:16px;">chevron_left</span>
        </button>

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <span class="material-symbols-outlined" style="font-size:1.1rem;font-variation-settings:'FILL' 1;">spa</span>
            </div>
            <div class="sidebar-brand-text">
                <h1>HealPoint</h1>
                <p>Temukan kedamaianmu</p>
            </div>
        </div>

        {{-- Main Navigation --}}
        <nav class="sidebar-nav">
            <a href="{{ url('/') }}" class="sidebar-nav-item {{ request()->is('/') ? 'active' : '' }}">
                <span class="material-symbols-outlined">home</span>
                <span class="sidebar-label">{{ __('messages.home') }}</span>
            </a>
            <a href="{{ url('/explore') }}" class="sidebar-nav-item {{ request()->is('explore*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">explore</span>
                <span class="sidebar-label">{{ __('messages.explore') }}</span>
            </a>
            <a href="{{ url('/map') }}" class="sidebar-nav-item {{ request()->is('map*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">map</span>
                <span class="sidebar-label">{{ __('messages.map') }}</span>
            </a>

            @if(Auth::user()->canPostLocation())
            <a href="{{ route('location.create') }}" class="sidebar-nav-item {{ request()->is('location/create*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">add_location_alt</span>
                <span class="sidebar-label">{{ __('messages.add_location') }}</span>
            </a>
            @else
            <a href="{{ route('creator.apply') }}" class="sidebar-nav-item {{ request()->is('creator*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">verified</span>
                <span class="sidebar-label">Jadi Kreator</span>
            </a>
            @endif

            <a href="{{ url('/itineraries') }}" class="sidebar-nav-item {{ request()->is('itineraries*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">calendar_month</span>
                <span class="sidebar-label">{{ __('messages.trip') }}</span>
            </a>
            <a href="{{ url('/favorites') }}" class="sidebar-nav-item {{ request()->is('favorites*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">favorite</span>
                <span class="sidebar-label">{{ __('messages.favorites') }}</span>
            </a>

            @php
                $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->whereNull('read_at')->count();
            @endphp
            <a href="{{ route('notifications') }}" class="sidebar-nav-item {{ request()->is('notifications*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">notifications</span>
                <span class="sidebar-label">Notifikasi</span>
                @if($unreadCount > 0)
                    <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                @endif
            </a>

            <a href="{{ url('/faq') }}" class="sidebar-nav-item {{ request()->is('faq*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">help</span>
                <span class="sidebar-label">FAQ</span>
            </a>

            @if(Auth::user()->isAdmin())
            <a href="{{ url('/admin') }}" class="sidebar-nav-item {{ request()->is('admin*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">admin_panel_settings</span>
                <span class="sidebar-label">Admin</span>
            </a>
            @endif
        </nav>

        {{-- Footer Section --}}
        <div class="sidebar-footer">
            {{-- Theme Toggle --}}
            <button onclick="toggleTheme()" class="sidebar-nav-item border-0 bg-transparent text-start w-100" id="themeToggleBtn" title="Ubah Tema" style="cursor: pointer;">
                <span class="material-symbols-outlined" id="themeToggleIcon">dark_mode</span>
                <span class="sidebar-label sidebar-footer-label" id="themeToggleLabel">Mode Gelap</span>
            </button>

            {{-- Profile --}}
            <a href="{{ route('profile') }}" class="sidebar-nav-item {{ request()->is('profile*') ? 'active' : '' }}">
                <span class="material-symbols-outlined">account_circle</span>
                <span class="sidebar-footer-label">
                    {{ Auth::user()->name }}
                    @if(Auth::user()->isCreator())
                        <small style="color:var(--color-accent);font-size:0.65rem;">● Kreator</small>
                    @elseif(Auth::user()->isAdmin())
                        <small style="color:var(--color-danger);font-size:0.65rem;">● Admin</small>
                    @endif
                </span>
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button type="submit" class="sidebar-nav-item logout-item" style="width:100%;border:none;background:transparent;cursor:pointer;">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="sidebar-footer-label">{{ __('messages.logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== Mobile Bottom Nav ===== --}}
    <div class="hp-bottom-nav d-flex d-md-none">
        <a href="{{ url('/') }}" class="bottom-nav-item {{ request()->is('/') ? 'active' : '' }}">
            <span class="material-symbols-outlined">home</span>
            <span class="bottom-nav-label">Beranda</span>
        </a>
        <a href="{{ url('/explore') }}" class="bottom-nav-item {{ request()->is('explore*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">explore</span>
            <span class="bottom-nav-label">Eksplor</span>
        </a>
        <a href="{{ url('/map') }}" class="bottom-nav-item {{ request()->is('map*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">map</span>
            <span class="bottom-nav-label">Peta</span>
        </a>
        <a href="{{ url('/itineraries') }}" class="bottom-nav-item {{ request()->is('itineraries*') ? 'active' : '' }}">
            <span class="material-symbols-outlined">calendar_month</span>
            <span class="bottom-nav-label">Rencana</span>
        </a>
        <button class="bottom-nav-item border-0 bg-transparent" id="mobileMenuBtn">
            <span class="material-symbols-outlined">menu</span>
            <span class="bottom-nav-label">Menu</span>
        </button>
    </div>
    <div class="hp-sidebar-backdrop" id="sidebarBackdrop"></div>
    @endauth

    {{-- ===== Main Content ===== --}}
    <main class="hp-main-content @guest no-sidebar @endguest">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success hp-alert alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger hp-alert alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @guest
        {{-- Guest Top Bar (simple) --}}
        <div class="d-flex justify-content-between align-items-center mb-4 px-2" style="max-width:500px;margin:0 auto;">
            <a href="{{ url('/') }}" style="display:flex;align-items:center;gap:0.5rem;text-decoration:none;color:var(--text-primary);font-weight:700;font-size:1.25rem;">
                <span class="material-symbols-outlined" style="font-size:1.1rem;font-variation-settings:'FILL' 1;background:var(--primary-container);color:#fff;padding:8px;border-radius:50%;">spa</span>
                HealPoint
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ url('/login') }}" class="btn btn-outline-accent btn-sm">{{ __('messages.login') }}</a>
                <a href="{{ url('/register') }}" class="btn btn-accent btn-sm">{{ __('messages.register') }}</a>
            </div>
        </div>
        @endguest

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // ===== Theme Management =====
        const html = document.documentElement;
        function setTheme(theme) {
            html.dataset.theme = theme;
            localStorage.setItem('hp-theme', theme);
            updateThemeUI(theme);
        }
        function updateThemeUI(theme) {
            const themeIcon = document.getElementById('themeToggleIcon');
            const themeLabel = document.getElementById('themeToggleLabel');
            if (themeIcon) {
                themeIcon.textContent = theme === 'dark' ? 'light_mode' : 'dark_mode';
            }
            if (themeLabel) {
                themeLabel.textContent = theme === 'dark' ? 'Mode Terang' : 'Mode Gelap';
            }
        }
        function toggleTheme() {
            const currentTheme = html.dataset.theme || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        }
        const savedTheme = localStorage.getItem('hp-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        setTheme(savedTheme);

        // ===== Sidebar Collapse =====
        const sidebar = document.getElementById('hpSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebar && sidebarToggle) {
            const sidebarState = localStorage.getItem('hp-sidebar-collapsed');
            if (sidebarState === 'true') sidebar.classList.add('collapsed');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                localStorage.setItem('hp-sidebar-collapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // ===== Mobile Sidebar Drawer Toggle =====
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        if (mobileMenuBtn && sidebar && sidebarBackdrop) {
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.add('show-mobile');
                sidebarBackdrop.classList.add('show');
            });
            sidebarBackdrop.addEventListener('click', () => {
                sidebar.classList.remove('show-mobile');
                sidebarBackdrop.classList.remove('show');
            });
        }

        // ===== Dynamic Distance Calculation =====
        window.userCoords = null;
        window.calculateDistances = function(elements) {
            const distanceUnit = document.body.dataset.distanceUnit || 'km';
            const distanceBadges = elements || document.querySelectorAll('.hp-distance-badge');

            if (distanceBadges.length > 0) {
                const runCalculation = (lat, lng) => {
                    const toRad = (x) => x * Math.PI / 180;
                    distanceBadges.forEach((badge) => {
                        const destLat = parseFloat(badge.dataset.lat);
                        const destLng = parseFloat(badge.dataset.lng);
                        if (isNaN(destLat) || isNaN(destLng)) return;

                        const R = distanceUnit === 'mil' ? 3958.8 : 6371;
                        const dLat = toRad(destLat - lat);
                        const dLng = toRad(destLng - lng);
                        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                                  Math.cos(toRad(lat)) * Math.cos(toRad(destLat)) *
                                  Math.sin(dLng / 2) * Math.sin(dLng / 2);
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        const distance = R * c;

                        const valueSpan = badge.querySelector('.distance-value');
                        if (valueSpan) {
                            const unitLabel = distanceUnit === 'mil' ? ' mi' : ' km';
                            valueSpan.textContent = distance.toFixed(1) + unitLabel;
                        }
                        badge.style.display = 'inline-flex';
                    });
                };

                if (window.userCoords) {
                    runCalculation(window.userCoords.latitude, window.userCoords.longitude);
                } else if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        window.userCoords = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };
                        runCalculation(window.userCoords.latitude, window.userCoords.longitude);
                    }, (error) => {
                        console.log('Geolocation error or permission denied:', error);
                        distanceBadges.forEach(badge => badge.style.display = 'none');
                    });
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            window.calculateDistances();

            // Smooth transition enable after load
            const sidebarEl = document.getElementById('hpSidebar');
            if (sidebarEl) {
                setTimeout(() => {
                    sidebarEl.classList.remove('no-transition');
                }, 100);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
