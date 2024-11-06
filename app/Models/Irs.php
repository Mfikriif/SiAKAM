<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irs extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'irs';

    protected $primaryKey = 'irs_id';

    protected $fillable = [
        'irs_id',
        'mahasiswa_id',
        'nama',
        'program_studi',
        'semester',
        'tahun_akademik',
        'kode_mk',
        'nama_mk',
        'sks',
        'tota_sks',
        'status',
        'tanggal_pengajuan',
        'tanggal_persetujuan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'id');
    }

    public function khs()
    {
        return $this->hasMany(khs::class,'irs_id');
    }
}
