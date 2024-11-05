<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\CivitasAkademik;


class Mahasiswa extends Model
{
    use HasFactory;
    
    protected $table = "mahasiswa";

    protected $primaryKey = "mahasiswa_id";

    protected $fillable = [
        'mahasiswa_id',
        'nim',
        'email',
        'semester',
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
        return $this->belongsTo(CivitasAkademik::class, 'pembimbing_akademik_id');
    }

    public function irs()
    {
        return $this->hasMany(Irs::class,'mahasiswa_id');
    }
}
