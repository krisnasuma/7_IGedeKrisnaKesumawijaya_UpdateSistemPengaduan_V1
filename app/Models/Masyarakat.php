<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'masyarakat';
    protected $guard = 'masyarakat';

    protected $fillable = [
        'nik', 'nama', 'email', 'password', 'telepon', 'alamat', 'terverifikasi'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Tambahkan dates untuk soft delete
    protected $dates = ['deleted_at'];

    // Scope untuk mudah query
    public function scopeTerverifikasi($query)
    {
        return $query->where('terverifikasi', true);
    }

    public function scopeBelumTerverifikasi($query)
    {
        return $query->where('terverifikasi', false);
    }

    public function scopeAktif($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeNonAktif($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    public function pengajuan()
    {
        return $this->hasMany(Pengajuan::class, 'masyarakat_id');
    }

    // Method untuk verifikasi
    public function verifikasi()
    {
        $this->update(['terverifikasi' => true]);
    }

    public function batalkanVerifikasi()
    {
        $this->update(['terverifikasi' => false]);
    }
}