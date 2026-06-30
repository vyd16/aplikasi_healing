@extends('layouts.app')
@section('title', __('messages.profile') . ' – HealPoint')

@section('content')
    <section class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="hp-section-title mb-0">
                <span class="material-symbols-outlined me-2"
                    style="font-size:28px;vertical-align:middle;">manage_accounts</span>{{ __('messages.profile') }}
            </h1>
        </div>

        @if($errors->any())
            <div class="alert alert-danger hp-alert mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            {{-- Left Column: Edit Profile details --}}
            <div class="col-lg-7">
                <div class="hp-auth-card">
                    <h4 class="mb-3" style="font-weight:700;color:var(--color-accent);">
                        <span class="material-symbols-outlined me-2"
                            style="font-size:22px;vertical-align:middle;">person</span>Data Diri
                    </h4>
                    <hr class="mb-4" style="border-color:rgba(0,0,0,0.1);">

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                                required>
                        </div>

                        <div class="p-3 mb-3" style="background:var(--color-accent-light);border-radius:var(--radius-lg);">
                            <h6 style="font-weight:700;margin-bottom:0.5rem;color:var(--color-accent);">Ubah Password <span
                                    style="font-weight:400;font-size:0.8rem;color:var(--text-muted);">(Biarkan kosong jika
                                    tidak ingin mengubah)</span></h6>

                            <div class="mb-2">
                                <label class="form-label" style="font-size:0.85rem;">Password Lama</label>
                                <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size:0.85rem;">Password Baru</label>
                                    <input type="password" name="new_password" class="form-control"
                                        placeholder="Min. 8 karakter">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size:0.85rem;">Konfirmasi Password Baru</label>
                                    <input type="password" name="new_password_confirmation" class="form-control"
                                        placeholder="Konfirmasi password baru">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-accent w-100">
                            <span class="material-symbols-outlined"
                                style="font-size:20px;vertical-align:middle;">save</span> Simpan Perubahan Profil
                        </button>
                    </form>
                </div>
            </div>

            {{-- Right Column: Application Settings --}}
            <div class="col-lg-5">
                <div class="hp-auth-card">
                    <h4 class="mb-3" style="font-weight:700;color:var(--color-accent);">
                        <span class="material-symbols-outlined me-2"
                            style="font-size:22px;vertical-align:middle;">settings</span>Pengaturan Aplikasi
                    </h4>
                    <hr class="mb-4" style="border-color:rgba(0,0,0,0.1);">

                    <form method="POST" action="{{ route('profile.settings') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">
                                <span class="material-symbols-outlined me-1"
                                    style="font-size:18px;vertical-align:middle;">language</span>Pilihan Bahasa (Language)
                            </label>
                            <input type="hidden" name="locale" id="localeInput" value="{{ session('locale', 'id') }}">
                            <div class="dropdown hp-custom-dropdown">
                                <button class="btn dropdown-toggle w-100" type="button" id="localeDropdownBtn"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="d-flex align-items-center gap-2">
                                        <span class="selected-label">
                                            @if(session('locale') === 'en')
                                                <span></span> English
                                            @else
                                                <span></span> Bahasa Indonesia
                                            @endif
                                        </span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow" aria-labelledby="localeDropdownBtn">
                                    <li>
                                        <button
                                            class="dropdown-item d-flex align-items-center gap-2 {{ session('locale', 'id') === 'id' ? 'active' : '' }}"
                                            type="button" data-value="id">
                                            <span></span> Bahasa Indonesia
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item d-flex align-items-center gap-2 {{ session('locale') === 'en' ? 'active' : '' }}"
                                            type="button" data-value="en">
                                            <span></span> English
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <span class="material-symbols-outlined me-1"
                                    style="font-size:18px;vertical-align:middle;">straighten</span>Satuan Jarak (Distance
                                Unit)
                            </label>
                            <input type="hidden" name="distance_unit" id="distanceUnitInput"
                                value="{{ session('distance_unit', 'km') }}">
                            <div class="dropdown hp-custom-dropdown">
                                <button class="btn dropdown-toggle w-100" type="button" id="distanceUnitDropdownBtn"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="d-flex align-items-center gap-2">
                                        <span class="selected-label">
                                            @if(session('distance_unit') === 'mil')
                                                <span></span> Mil (Miles)
                                            @else
                                                <span></span> Kilometer (KM)
                                            @endif
                                        </span>
                                    </span>
                                </button>
                                <ul class="dropdown-menu w-100 shadow" aria-labelledby="distanceUnitDropdownBtn">
                                    <li>
                                        <button
                                            class="dropdown-item d-flex align-items-center gap-2 {{ session('distance_unit', 'km') === 'km' ? 'active' : '' }}"
                                            type="button" data-value="km">
                                            <span>📏</span> Kilometer (KM)
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            class="dropdown-item d-flex align-items-center gap-2 {{ session('distance_unit') === 'mil' ? 'active' : '' }}"
                                            type="button" data-value="mil">
                                            <span>📏</span> Mil (Miles)
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-accent w-100 mb-3">
                            Simpan Pengaturan
                        </button>

                    </form>

                    {{-- Client-Side Clear Cache Option --}}
                    <div class="mt-4 p-3" style="background:rgba(0,0,0,0.03);border-radius:var(--radius-lg);">
                        <h6 style="font-weight:700;">Bersihkan Data Singgahan (Cache)</h6>
                        <p class="small text-muted mb-2">Hapus data lokal, cookie, dan preferensi untuk memuat ulang
                            aplikasi ke kondisi awal.</p>
                        <button class="btn btn-outline-accent w-100 btn-sm" id="clearCacheBtn"
                            style="color:var(--color-danger);border-color:var(--color-danger);">
                            <span class="material-symbols-outlined"
                                style="font-size:18px;vertical-align:middle;">delete_sweep</span> Hapus Cache Aplikasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Custom settings dropdowns handling
            document.querySelectorAll('.hp-custom-dropdown').forEach(dropdown => {
                const container = dropdown.closest('.mb-3, .mb-4');
                if (!container) return;
                const hiddenInput = container.querySelector('input[type="hidden"]');
                const btnLabel = dropdown.querySelector('.selected-label');
                const items = dropdown.querySelectorAll('.dropdown-item');

                items.forEach(item => {
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        const val = item.getAttribute('data-value');
                        hiddenInput.value = val;

                        // Update active class
                        items.forEach(i => i.classList.remove('active'));
                        item.classList.add('active');

                        // Update dropdown button label content
                        if (btnLabel) {
                            btnLabel.innerHTML = item.innerHTML;
                        }
                    });
                });
            });

            document.getElementById('clearCacheBtn').addEventListener('click', function () {
                if (confirm('Apakah Anda yakin ingin menghapus data singgahan aplikasi? Tindakan ini akan menghapus preferensi tersimpan Anda.')) {
                    // Clear local storage and session storage
                    localStorage.clear();
                    sessionStorage.clear();

                    // Delete all cookies
                    const cookies = document.cookie.split(";");
                    for (let i = 0; i < cookies.length; i++) {
                        const cookie = cookies[i];
                        const eqPos = cookie.indexOf("=");
                        const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                    }

                    alert('Cache aplikasi berhasil dibersihkan! Halaman akan dimuat ulang.');
                    window.location.reload();
                }
            });
        </script>
    @endpush
@endsection