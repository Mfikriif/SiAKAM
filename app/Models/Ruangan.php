<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;



    protected $table = 'ruangan';
    protected $primaryKey = 'kode_ruangan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['kode_ruangan', 'kapasitas'];
}
