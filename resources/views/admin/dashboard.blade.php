@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard Administrator</h2>
        <p>Selamat datang, <strong>{{ Auth::guard('admin')->user()->nama }}</strong></p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $stats['total_pengajuan'] }}</h5>
                <p class="card-text">Total Pengajuan</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $stats['pengajuan_menunggu'] }}</h5>
                <p class="card-text">Menunggu</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $stats['pengajuan_diproses'] }}</h5>
                <p class="card-text">Diproses</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $stats['total_masyarakat'] }}</h5>
                <p class="card-text">Masyarakat</p>
            </div>
        </div>
    </div>

    <!-- Tambahkan di bagian stats cards -->
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $stats['masyarakat_belum_verifikasi'] }}</h5>
                <p class="card-text">Belum Diverifikasi</p>
                <a href="{{ route('admin.masyarakat.belum-verifikasi') }}" class="btn btn-warning btn-sm">Kelola</a>
            </div>
        </div>
    </div>
    
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.pengajuan') }}" class="btn btn-primary">Kelola Pengajuan</a>
                    <a href="{{ route('admin.masyarakat') }}" class="btn btn-success">Data Masyarakat</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Statistik Terbaru</h5>
            </div>
            <div class="card-body">
                <p>Pengajuan hari ini: <strong>0</strong></p>
                <p>Pengajuan bulan ini: <strong>0</strong></p>
                <p>Masyarakat terdaftar: <strong>{{ $stats['total_masyarakat'] }}</strong></p>
            </div>
        </div>
    </div>

</div>
@endsection