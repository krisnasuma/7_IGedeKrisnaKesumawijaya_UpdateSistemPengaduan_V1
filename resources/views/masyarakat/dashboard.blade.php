@extends('layouts.app')

@section('title', 'Dashboard Masyarakat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard Masyarakat</h2>
        <p>Selamat datang, <strong>{{ Auth::guard('masyarakat')->user()->nama }}</strong></p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Buat Pengajuan Baru</h5>
                <p class="card-text">Ajukan permohonan</p>
                <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">Buat Pengajuan</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Lihat Pengajuan</h5>
                <p class="card-text">Lihat status pengajuan Anda</p>
                <a href="{{ route('pengajuan.index') }}" class="btn btn-success">Daftar Pengajuan</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Profil Saya</h5>
                <p class="card-text">Kelola informasi akun Anda</p>
                <a href="{{ route('masyarakat.profil') }}" class="btn btn-info">Kelola Profil</a>
            </div>
        </div>
    </div>
    
</div>

<!-- Pengajuan Terbaru -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pengajuan Terbaru</h5>
            </div>
            <div class="card-body">
                @php
                    $pengajuanTerbaru = Auth::guard('masyarakat')->user()->pengajuan()->latest()->take(3)->get();
                @endphp
                
                @if($pengajuanTerbaru->count() > 0)
                    <div class="row">
                        @foreach($pengajuanTerbaru as $pengajuan)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $pengajuan->judul }}</h6>
                                    <p class="card-text small">{{ Str::limit($pengajuan->deskripsi, 80) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $pengajuan->status == 'selesai' ? 'success' : ($pengajuan->status == 'diproses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                        <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    </div>
                                </div>
                                <div class="card-footer small text-muted">
                                    {{ $pengajuan->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-muted">Belum ada pengajuan.</p>
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary">Buat Pengajuan Pertama</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection