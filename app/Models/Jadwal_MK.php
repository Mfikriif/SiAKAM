<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal_MK extends Model
{
    use HasFactory;

    protected $table = "jadwal_mk";
    protected $fillable = [
        'kode_mk',
        'hari',
        'jam',
        'kode_ruangan',
        'nama_mk',
        'sks',
        'sifat',
        'pengampu',
        'kelas',
        'semester',
    ];

    public function Matkul()
    {
        return $this->belongsTo(Matkul::class, 'kode_mk');
    }
    public function Ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kode_ruangan');
    }
}
