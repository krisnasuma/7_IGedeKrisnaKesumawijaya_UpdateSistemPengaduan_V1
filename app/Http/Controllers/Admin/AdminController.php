<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_pengajuan' => Pengajuan::count(),
            'pengajuan_menunggu' => Pengajuan::where('status', 'menunggu')->count(),
            'pengajuan_diproses' => Pengajuan::where('status', 'diproses')->count(),
            'total_masyarakat' => Masyarakat::count(),
            'masyarakat_belum_verifikasi' => Masyarakat::where('terverifikasi', false)->count(),
            'masyarakat_terverifikasi' => Masyarakat::where('terverifikasi', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function pengajuan()
    {
        $pengajuan = Pengajuan::with(['masyarakat', 'admin'])->get();
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    public function updatePengajuan(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'keterangan' => 'nullable|string'
        ]);

        $validated['admin_id'] = auth()->id();

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->update($validated);

        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    public function dataMasyarakat()
    {
        $masyarakat = Masyarakat::with('pengajuan')->get();
        return view('admin.masyarakat.index', compact('masyarakat'));
    }

    public function verifikasiMasyarakat($id)
    {
        DB::transaction(function () use ($id) {
            $masyarakat = Masyarakat::findOrFail($id);
            $masyarakat->update([
                'terverifikasi' => true,
                'verified_at' => now(),
                'verified_by' => auth()->id()
            ]);
        });

        return back()->with('success', 'Masyarakat berhasil diverifikasi!');
    }

    public function batalkanVerifikasiMasyarakat($id)
    {
        DB::transaction(function () use ($id) {
            $masyarakat = Masyarakat::findOrFail($id);
            $masyarakat->update([
                'terverifikasi' => false,
                'verified_at' => null,
                'verified_by' => null
            ]);
        });

        return back()->with('success', 'Verifikasi masyarakat dibatalkan!');
    }

    public function detailMasyarakat($id)
    {
        $masyarakat = Masyarakat::with(['pengajuan' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.masyarakat.detail', compact('masyarakat'));
    }

    public function masyarakatBelumVerifikasi()
    {
        $masyarakat = Masyarakat::belumTerverifikasi()->get();
        return view('admin.masyarakat.belum-verifikasi', compact('masyarakat'));
    }


    /////////////////////////////////////////////////////
    public function hapusMasyarakat($id)
    {
        DB::transaction(function () use ($id) {
            $masyarakat = Masyarakat::findOrFail($id);
        
            // Hapus semua pengajuan terkait terlebih dahulu (optional)
            $masyarakat->pengajuan()->delete();
        
            // Hapus data masyarakat
            $masyarakat->delete();
        });

        return redirect()->route('admin.masyarakat')
            ->with('success', 'Data masyarakat berhasil dihapus!');
    }

    // Method untuk soft delete (recommended)
    public function nonaktifkanMasyarakat($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        $masyarakat->update(['status_aktif' => false]);

        return back()->with('success', 'Masyarakat berhasil dinonaktifkan!');
    }

    // Method untuk restore (jika pakai soft delete)
    public function aktifkanMasyarakat($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        $masyarakat->update(['status_aktif' => true]);

        return back()->with('success', 'Masyarakat berhasil diaktifkan kembali!');
    }

    /////////////////////////////////////////////////////
    
    /**
    * Menampilkan data masyarakat yang sudah dihapus (soft delete)
    */
    public function masyarakatTerhapus()
    {
        $masyarakat = Masyarakat::onlyTrashed()->get();
        return view('admin.masyarakat.terhapus', compact('masyarakat'));
    }

    /**
    * Memulihkan data masyarakat yang dihapus
    */
    public function pulihkanMasyarakat($id)
    {
        $masyarakat = Masyarakat::onlyTrashed()->findOrFail($id);
        $masyarakat->restore();

        return redirect()->route('admin.masyarakat')
            ->with('success', 'Data masyarakat berhasil dipulihkan!');
    }

    
    /**
    * Hapus permanen data masyarakat (true delete)
    */
    public function hapusPermanenMasyarakat($id)
    {
        DB::transaction(function () use ($id) {
            $masyarakat = Masyarakat::onlyTrashed()->findOrFail($id);
        
            // Hapus semua pengajuan terkait terlebih dahulu
            $masyarakat->pengajuan()->forceDelete();
        
            // Hapus permanen masyarakat
            $masyarakat->forceDelete();
        });

        return redirect()->route('admin.masyarakat.terhapus')
            ->with('success', 'Data masyarakat berhasil dihapus permanen!');
    }

}