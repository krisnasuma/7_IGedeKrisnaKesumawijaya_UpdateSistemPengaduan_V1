@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Ganti Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('masyarakat.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Saat Ini *</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru *</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                               id="new_password" name="new_password" required>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru *</label>
                        <input type="password" class="form-control" 
                               id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('masyarakat.profil') }}" class="btn btn-secondary">
                            ← Kembali
                        </a>
                        <button type="submit" class="btn btn-warning">
                            🔒 Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6>Tips Password Aman:</h6>
                <ul class="small text-muted mb-0">
                    <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                    <li>Minimal 8 karakter</li>
                    <li>Jangan gunakan informasi pribadi yang mudah ditebak</li>
                    <li>Gunakan password yang berbeda dari akun lainnya</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection