@extends('layouts.app')
@section('title', 'Daftar – HealPoint')

@section('content')
<div class="hp-auth-container">
    <div class="hp-auth-card">
        <div class="text-center mb-3">
            <span class="material-symbols-outlined" style="font-size:3rem;color:var(--color-accent);font-variation-settings:'FILL' 1;">spa</span>
        </div>
        <h2>Daftar Akun</h2>
        <p class="auth-subtitle">Buat akun untuk menyimpan lokasi favorit dan menulis ulasan.</p>

        @if($errors->any())
            <div class="alert alert-danger hp-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama kamu" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button type="submit" class="btn btn-accent w-100 mb-3">Daftar</button>
        </form>
        <p class="text-center" style="color:var(--text-muted);">
            Sudah punya akun? <a href="{{ url('/login') }}">Masuk</a>
        </p>
    </div>
</div>
@endsection
