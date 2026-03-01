<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    // Tambahkan baris ini
    protected $fillable = [
        'tanggal',
        'title',
        'tempat',
        'mc',
        'pf',
    ];
}