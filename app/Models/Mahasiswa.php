<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = "mahasiswa";
    protected $fillable = [
        'id',
        'nim',
        'email',
        'jurusan',
        'angkatan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status',
        'pembimbing_akademik_id',
    ];

    //Relasi dengan Dosen Wali / Pembimbing Akademik
    public function Dosenwali()
    {
        return $this->belongsTo(Dosenwali::class, 'pembimbing_akademik_id');
    }
}
