@extends('layouts.app')

@section('title', 'Data Masyarakat Terdaftar')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Masyarakat Terdaftar</h2>
            <div>
                <a href="{{ route('admin.masyarakat.belum-verifikasi') }}" class="btn btn-warning">
                    📋 Masyarakat Belum Diverifikasi
                </a>
                <!-- Tambahkan link ke data terhapus -->
                <a href="{{ route('admin.masyarakat.terhapus') }}" class="btn btn-secondary ms-2">
                    🗑️ Data Terhapus
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $masyarakat->count() }}</h5>
                        <p class="card-text">Total Masyarakat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $masyarakat->where('terverifikasi', true)->count() }}</h5>
                        <p class="card-text">Terverifikasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $masyarakat->where('terverifikasi', false)->count() }}</h5>
                        <p class="card-text">Belum Diverifikasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $masyarakat->sum('pengajuan.count') }}</h5>
                        <p class="card-text">Total Pengajuan</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Terdaftar</th>
                        <th>Status</th>
                        <th>Pengajuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($masyarakat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>
                            <a href="{{ route('admin.masyarakat.detail', $item->id) }}" class="text-decoration-none">
                                {{ $item->nama }}
                            </a>
                        </td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($item->terverifikasi)
                                <span class="badge bg-success">
                                    ✅ Terverifikasi
                                    @if($item->verified_at)
                                        <br><small>{{ $item->verified_at->format('d/m/Y') }}</small>
                                    @endif
                                </span>
                            @else
                                <span class="badge bg-warning">⏳ Belum Diverifikasi</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $item->pengajuan->count() }} pengajuan</span>
                        </td>
                        <td>
                            @if(!$item->terverifikasi)
                                <form action="{{ route('admin.masyarakat.verifikasi', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" 
                                            onclick="return confirm('Verifikasi masyarakat ini?')">
                                        ✅ Verifikasi
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.masyarakat.batalkan-verifikasi', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" 
                                            onclick="return confirm('Batalkan verifikasi masyarakat ini?')">
                                        ❌ Batalkan
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.masyarakat.detail', $item->id) }}" class="btn btn-info btn-sm">
                                👁️ Detail
                            </a>

                            <!-- Tombol Hapus dengan Konfirmasi -->
                            <button type="button" class="btn btn-danger btn-sm" 
                                data-bs-toggle="modal" data-bs-target="#hapusModal{{ $item->id }}">
                                🗑️ Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus - PASTIKAN DI DALAM SECTION -->
@foreach($masyarakat as $item)
<div class="modal fade" id="hapusModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data masyarakat berikut?</p>
                <ul>
                    <li><strong>NIK:</strong> {{ $item->nik }}</li>
                    <li><strong>Nama:</strong> {{ $item->nama }}</li>
                    <li><strong>Email:</strong> {{ $item->email }}</li>
                </ul>
                <div class="alert alert-warning">
                    <strong>Peringatan:</strong> 
                    @if($item->pengajuan->count() > 0)
                        Data ini memiliki {{ $item->pengajuan->count() }} pengajuan yang juga akan dihapus!
                    @else
                        Tindakan ini tidak dapat dibatalkan!
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('admin.masyarakat.hapus', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection