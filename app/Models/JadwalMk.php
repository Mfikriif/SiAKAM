<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMk extends Model
{
    use HasFactory;

    protected $table = 'jadwal_mk';

    protected $fillable = [
        'id',
        'kode_mk',
        'nama',
        'semester',
        'sks',
        'sifat',
        'kelas',
        'ruangan',
        'kuota_kelas',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'koordinator_mk',
        'pengampu_1',
        'pengampu_2',
        'pengampu_3',
        'reason_for_rejection',
        'tahun_ajaran_id'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jadwalMK) {
            // Cari tahun ajaran aktif
            $tahunAjaranAktif = TahunAjaran::where('is_active', true)->first();

            if ($tahunAjaranAktif) {
                $jadwalMK->tahun_ajaran_id = $tahunAjaranAktif->id;
            } else {
                throw new \Exception('Tidak ada tahun ajaran yang aktif.');
            }
        });
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }

    // Relasi ke tabel tahun_ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }
}
