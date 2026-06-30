{{-- Creator Application Form Partial --}}
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
    <h5 style="font-weight:700;">
        <span class="material-symbols-outlined" style="font-size:20px;color:var(--color-accent);">edit_note</span>
        Formulir Pendaftaran
    </h5>

    <form method="POST" action="{{ route('creator.submit') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Link Instagram <small style="color:var(--text-muted);">(opsional jika ada TikTok)</small></label>
            <div class="input-group">
                <span class="input-group-text" style="background:var(--input-bg);border-color:var(--input-border);">
                    <span class="material-symbols-outlined" style="font-size:18px;">photo_camera</span>
                </span>
                <input type="url" name="instagram_url" class="form-control" placeholder="https://instagram.com/username" value="{{ old('instagram_url') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Link TikTok <small style="color:var(--text-muted);">(opsional jika ada Instagram)</small></label>
            <div class="input-group">
                <span class="input-group-text" style="background:var(--input-bg);border-color:var(--input-border);">
                    <span class="material-symbols-outlined" style="font-size:18px;">music_note</span>
                </span>
                <input type="url" name="tiktok_url" class="form-control" placeholder="https://tiktok.com/@username" value="{{ old('tiktok_url') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Followers (gabungan) <span style="color:var(--color-danger);">*</span></label>
            <input type="number" name="followers_count" class="form-control" placeholder="e.g. 5000" value="{{ old('followers_count') }}" required min="0">
            <small style="color:var(--text-muted);">Masukkan total followers dari semua platform yang kamu daftarkan.</small>
        </div>

        <div class="mb-4">
            <label class="form-label">Alasan Ingin Menjadi Kreator <span style="color:var(--color-danger);">*</span></label>
            <textarea name="reason" class="form-control" rows="4" placeholder="Ceritakan mengapa kamu ingin menjadi Konten Kreator di HealPoint dan bagaimana kamu akan mempromosikan lokasi healing... (min. 20 karakter)" required>{{ old('reason') }}</textarea>
        </div>

        <button type="submit" class="btn btn-accent w-100">
            <span class="material-symbols-outlined" style="font-size:20px;">send</span> Kirim Pengajuan
        </button>
    </form>
</div>
