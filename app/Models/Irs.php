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
        'nim',
        'nama',
        'program_studi',
        'semester',
        'tahun_akademik',
        'kode_mk',
        'nama_mk',
        'kelas',
        'sks',
        'tota_sks',
        'status',
        'tanggal_pengajuan',
        'tanggal_persetujuan'
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id');
    }

    public function jadwal()
    {
        return $this->hasOne(JadwalMk::class, 'kode_mk', 'kode_mk');
    }

    public function khs()
    {
        return $this->hasMany(khs::class,'irs_id');
    }

    public function jadwalMk()
    {
        return $this->belongsTo(JadwalMk::class, 'kode_mk', 'kode_mk');
    }
}
