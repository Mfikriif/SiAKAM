<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivitasAkademik extends Model
{
    use HasFactory;

    protected $table = 'civitas_akademik'; // Specify the table name

    // Define fillable fields if needed
    protected $fillable = [
        'nama',
        'nip',
        'email',
        'jurusan',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status',
    ];

    // Define any relationships if necessary
}
