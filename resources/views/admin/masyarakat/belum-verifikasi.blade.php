@extends('layouts.app')

@section('title', 'Masyarakat Belum Diverifikasi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Masyarakat Belum Diverifikasi</h2>
            <div>
                <a href="{{ route('admin.masyarakat') }}" class="btn btn-primary">
                    ← Kembali ke Data Masyarakat
                </a>
            </div>
        </div>

        @if($masyarakat->count() > 0)
            <div class="alert alert-info">
                <strong>Info:</strong> Terdapat {{ $masyarakat->count() }} masyarakat yang belum diverifikasi.
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
                            <th>Alamat</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masyarakat as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->telepon }}</td>
                            <td>{{ Str::limit($item->alamat, 50) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.masyarakat.verifikasi', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" 
                                            onclick="return confirm('Verifikasi masyarakat ini?')">
                                        ✅ Verifikasi
                                    </button>
                                </form>
                                <a href="{{ route('admin.masyarakat.detail', $item->id) }}" class="btn btn-info btn-sm">
                                    👁️ Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-success text-center">
                <h5>🎉 Selamat!</h5>
                <p>Tidak ada masyarakat yang belum diverifikasi. Semua data masyarakat sudah terverifikasi.</p>
                <a href="{{ route('admin.masyarakat') }}" class="btn btn-primary">
                    Lihat Data Masyarakat
                </a>
            </div>
        @endif
    </div>
</div>
@endsection