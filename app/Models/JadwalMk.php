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
        'hari',
        'jam_mulai',
        'jam_selesai',
        'koordinator_mk',
        'pengampu_1',
        'pengampu_2',
        'pengampu_3',
        'reason_for_rejection'
    ];
    
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'kode_mk', 'kode_mk');
    }
}
