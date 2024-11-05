<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class irs_detail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'irs_detail';

    protected $fillable = [
        'irs_id',
        'kode_mk'
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
