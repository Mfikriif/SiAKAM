<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khs extends Model
{
    use HasFactory;

    protected $table = "khs";

    public $timestamps = false;

    protected $fillable = [
        'id_khs',
        'nim',
        'nama',
        'program_studi',
        'semester',
        'kode_mk',
        'nama_mk',
        'sks',
        'nilai_angka',
        'nilai_huruf',
        'ip_semester',
        'ip_kumulatif',
    ];

    public function matakuliah()
    {
        return $this->belongsTo(MataKuliah::class,'kode_mk','kode_mk');
    }

    public function irs()
    {
        return $this->belongsTo(Irs::class,'irs_id','irs_id');
    }
}
