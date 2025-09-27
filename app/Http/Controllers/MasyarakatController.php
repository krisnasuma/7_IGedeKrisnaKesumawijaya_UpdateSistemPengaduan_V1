<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{
    public function showProfil()
    {
        $user = Auth::guard('masyarakat')->user();
        $stats = [
            'total_pengajuan' => $user->pengajuan()->count(),
            'pengajuan_selesai' => $user->pengajuan()->where('status', 'selesai')->count(),
            'pengajuan_diproses' => $user->pengajuan()->where('status', 'diproses')->count(),
        ];
        
        return view('masyarakat.profil.show', compact('user', 'stats'));
    }

    public function editProfil()
    {
        $user = Auth::guard('masyarakat')->user();
        return view('masyarakat.profil.edit', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::guard('masyarakat')->user();
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('masyarakat.profil')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function showChangePassword()
    {
        return view('masyarakat.profil.change-password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::guard('masyarakat')->user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password saat ini salah!');
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('masyarakat.profil')
            ->with('success', 'Password berhasil diubah!');
    }
}