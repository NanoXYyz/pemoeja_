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
        'bukti',
    ];

    /**
     * Ambil opsi jenis transaksi dari settings
     * (category: keuangan, sub_content: input)
     */
    public static function getInputOptions(): array
    {
        return Setting::getOptions('keuangan', 'input');
    }

    /**
     * Validasi rules dinamis berdasarkan settings
     */
    public static function validationRules(): array
    {
        $inputOptions = implode(',', self::getInputOptions());

        return [
            'date'        => 'required|date',
            'keterangan'  => 'required|string|max:255',
            'input'       => "required|in:{$inputOptions}",
            'saldo'       => 'required|integer',
            'bukti'       => 'nullable|image|max:2048',
        ];
    }

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