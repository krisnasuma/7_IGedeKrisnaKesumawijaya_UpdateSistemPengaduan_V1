@extends('layouts.app')

@section('title', 'Data Masyarakat Terhapus')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Data Masyarakat yang Dihapus</h2>
            <div>
                <a href="{{ route('admin.masyarakat') }}" class="btn btn-primary">
                    ← Kembali ke Data Masyarakat
                </a>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($masyarakat->count() > 0)
            <div class="alert alert-warning">
                <strong>Info:</strong> Data berikut telah dihapus (soft delete) dan dapat dipulihkan.
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
                            <th>Dihapus Pada</th>
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
                            <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.masyarakat.pulihkan', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" 
                                            onclick="return confirm('Pulihkan data masyarakat ini?')">
                                        🔄 Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('admin.masyarakat.hapus.permanen', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus permanen? Tindakan ini tidak dapat dibatalkan!')">
                                        🗑️ Hapus Permanen
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center py-4">
                <h5>📭 Tidak Ada Data Terhapus</h5>
                <p>Belum ada data masyarakat yang dihapus.</p>
                @if(session('error'))
                    <div class="mt-3">
                        <small class="text-muted">Pesan error: {{ session('error') }}</small>
                    </div>
                @endif
                <a href="{{ route('admin.masyarakat') }}" class="btn btn-primary mt-2">
                    Kembali ke Data Masyarakat
                </a>
            </div>
        @endif
    </div>
</div>
@endsection