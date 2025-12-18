<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';

    public $timestamps = false;

    // Tambahkan semua field yang bisa diisi mass assignment
    protected $fillable = [
        'path',
        'judul',
        'deskripsi',
        'created_at',
        'tanggal_berakhir',
    ];

    protected $attributes = [
        'created_at' => null,
        'judul' => null,
        'deskripsi' => null,
        'tanggal_berakhir' => null,
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'tanggal_berakhir' => 'datetime',
    ];
}
