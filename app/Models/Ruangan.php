<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Ruangan extends Model
{
    use HasFactory;
    protected $table = "ruangan";
    protected $fillable = [
        'id',
        'kapasitas',
        'jurusan',
        'kode_ruangan',
        'status',
    ];
}
