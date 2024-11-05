<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irs extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'irs';

    protected $primaryKey = 'irs_id';

    protected $fillable = [
        'irs_id',
        'id',
        'semester',
        'status',
        'tanggal_pengajuan',
        'tanggal_persetujuan'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class,'id');
    }

    public function irsDetail()
    {
        return $this->hasMany(irs_detail::class,'irs_id');
    }
}
