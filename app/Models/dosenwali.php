<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dosenwali extends Model
{
    use HasFactory;

    protected $table = "pembimbing_akademik" ;

    protected $fillable = [
        'id',
        'nama',
        'nip',
        'email',
        'jurusan',
        'id_mahasiswa_perwalian',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
    ];
}
