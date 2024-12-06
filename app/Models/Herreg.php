<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herreg extends Model
{
    use HasFactory;

    /**
     * Table name.
     */
    protected $table = 'herreg';

    /**
     * Primary key.
     */
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * Fillable fields.
     * These fields can be mass-assigned.
     */
    protected $fillable = [
        'nim',
        'tahun_ajaran',
        'status',
    ];

    /**
     * Relationship with Mahasiswa model.
     * This sets the foreign key relationship with the mahasiswa table.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

}