@extends('layouts.app')
@section('title', 'Masuk – HealPoint')

@section('content')
<div class="hp-auth-container">
    <div class="hp-auth-card">
        <div class="text-center mb-3">
            <span class="material-symbols-outlined" style="font-size:3rem;color:var(--color-accent);font-variation-settings:'FILL' 1;">spa</span>
        </div>
        <h2>Masuk</h2>
        <p class="auth-subtitle">Selamat datang kembali! Silakan masuk ke akunmu.</p>

        @if($errors->any())
            <div class="alert alert-danger hp-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember" style="color:var(--text-secondary);">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-accent w-100 mb-3">Masuk</button>
        </form>
        <p class="text-center" style="color:var(--text-muted);">
            Belum punya akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
        </p>
    </div>
</div>
@endsection
