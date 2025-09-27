@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    <div class="col-md-4">
        <!-- Card Profil -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Profil Saya</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px;">
                        <span class="text-white fw-bold" style="font-size: 2rem;">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </span>
                    </div>
                </div>
                
                <h5>{{ $user->nama }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                
                <div class="d-grid gap-2">
                    <a href="{{ route('masyarakat.profil.edit') }}" class="btn btn-outline-primary btn-sm">
                        ✏️ Edit Profil
                    </a>
                    <a href="{{ route('masyarakat.password.edit') }}" class="btn btn-outline-secondary btn-sm">
                        🔒 Ganti Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistik -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Statistik Pengajuan</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <h5 class="mb-0 text-primary">{{ $stats['total_pengajuan'] }}</h5>
                            <small>Total</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <h5 class="mb-0 text-success">{{ $stats['pengajuan_selesai'] }}</h5>
                            <small>Selesai</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border rounded p-2">
                            <h5 class="mb-0 text-warning">{{ $stats['pengajuan_diproses'] }}</h5>
                            <small>Proses</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Detail Informasi -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Detail Informasi</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">NIK:</div>
                    <div class="col-md-8">{{ $user->nik }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Lengkap:</div>
                    <div class="col-md-8">{{ $user->nama }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Email:</div>
                    <div class="col-md-8">{{ $user->email }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Telepon:</div>
                    <div class="col-md-8">{{ $user->telepon }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Alamat:</div>
                    <div class="col-md-8">{{ $user->alamat }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Terdaftar Sejak:</div>
                    <div class="col-md-8">{{ $user->created_at->format('d F Y') }}</div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 fw-bold">Status Verifikasi:</div>
                    <div class="col-md-8">
                        @if($user->terverifikasi)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning">Belum Diverifikasi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Terbaru -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Pengajuan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($user->pengajuan->count() > 0)
                    <div class="list-group">
                        @foreach($user->pengajuan->take(5) as $pengajuan)
                        <a href="{{ route('pengajuan.show', $pengajuan->id) }}" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $pengajuan->judul }}</h6>
                                <small class="text-muted">{{ $pengajuan->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($pengajuan->deskripsi, 100) }}</p>
                            <small>
                                <span class="badge bg-{{ $pengajuan->status == 'selesai' ? 'success' : ($pengajuan->status == 'diproses' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                                • {{ ucfirst($pengajuan->jenis) }}
                            </small>
                        </a>
                        @endforeach
                    </div>
                    @if($user->pengajuan->count() > 5)
                        <div class="text-center mt-2">
                            <a href="{{ route('pengajuan.index') }}" class="btn btn-sm btn-outline-primary">
                                Lihat Semua Pengajuan
                            </a>
                        </div>
                    @endif
                @else
                    <p class="text-muted text-center">Belum ada pengajuan.</p>
                    <div class="text-center">
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-primary btn-sm">
                            Buat Pengajuan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection