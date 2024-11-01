<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    protected $table = "mata_kuliah";
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
    ];
}
