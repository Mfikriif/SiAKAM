<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajaran';
    // Kolom yang bisa diisi (fillable)
    protected $fillable = [
        'tahun',
        'semester',
        'is_active',
    ];

    // Relasi ke tabel jadwal_mk
    public function jadwalMk()
    {
        return $this->hasMany(JadwalMk::class, 'tahun_ajaran_id');
    }
}