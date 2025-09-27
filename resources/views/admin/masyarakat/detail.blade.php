@extends('layouts.app')

@section('title', 'Detail Masyarakat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Masyarakat: {{ $masyarakat->nama }}</h2>
            <div>
                <a href="{{ route('admin.masyarakat') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">NIK</th>
                                <td>{{ $masyarakat->nik }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $masyarakat->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $masyarakat->email }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>{{ $masyarakat->telepon }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $masyarakat->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Terdaftar</th>
                                <td>{{ $masyarakat->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($masyarakat->terverifikasi)
                                        <span class="badge bg-success">✅ Terverifikasi</span>
                                        @if($masyarakat->verified_at)
                                            <br><small>Pada: {{ $masyarakat->verified_at->format('d F Y H:i') }}</small>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">⏳ Belum Diverifikasi</span>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <div class="mt-3">
                            @if(!$masyarakat->terverifikasi)
                                <form action="{{ route('admin.masyarakat.verifikasi', $masyarakat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        ✅ Verifikasi Masyarakat Ini
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.masyarakat.batalkan-verifikasi', $masyarakat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" 
                                            onclick="return confirm('Batalkan verifikasi masyarakat ini?')">
                                        ❌ Batalkan Verifikasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Riwayat Pengajuan ({{ $masyarakat->pengajuan->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @if($masyarakat->pengajuan->count() > 0)
                            <div class="list-group">
                                @foreach($masyarakat->pengajuan as $pengajuan)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $pengajuan->judul }}</h6>
                                        <span class="badge bg-{{ $pengajuan->status == 'selesai' ? 'success' : ($pengajuan->status == 'diproses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1 small">{{ Str::limit($pengajuan->deskripsi, 100) }}</p>
                                    <small class="text-muted">
                                        {{ $pengajuan->created_at->format('d/m/Y') }} • {{ ucfirst($pengajuan->jenis) }}
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center">Belum ada pengajuan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection