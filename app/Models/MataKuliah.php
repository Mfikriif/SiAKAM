<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'mata_kuliah';
    protected $primaryKey = 'kode_mk';
    public $incrementing = false;
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'sifat'
    ];

    public function jadwals()
    {
        return $this->hasMany(JadwalMk::class, 'kode_mk', 'kode_mk');
    }

    public function pengambilanIrs()
    {
        return $this->hasMany(irs_detail::class,'kode_mk','kode_mk');
    }

}
