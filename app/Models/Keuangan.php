<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'keterangan',
        'input',
        'saldo',
        'bukti'
    ];

    // Scope untuk mempermudah filter
    public function scopePemasukan($query)
    {
        return $query->where('input', 'pemasukan');
    }

    public function scopePengeluaran($query)
    {
        return $query->where('input', 'pengeluaran');
    }
}