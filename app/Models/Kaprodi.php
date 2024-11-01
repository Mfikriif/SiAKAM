<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaprodi extends Model
{
    use HasFactory;

    // Nama tabel dalam database
    protected $table = 'kaprodi';

    // Kolom yang dapat diisi
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

    public function user()
    {
        return $this->hasOne(User::class, 'kaprodi_id');
    }
}