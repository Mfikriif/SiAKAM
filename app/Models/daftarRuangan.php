<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daftarRuangan extends Model
{
    use HasFactory;

    protected $table = 'daftar_ruangan';

    public $timestamps = false;

    protected $fillable = 
    [
        'id',
        'kode_ruangan',
        'keterangan',
    ];
}
