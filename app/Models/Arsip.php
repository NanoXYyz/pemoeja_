<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Ambil opsi kategori arsip dari settings
     * (category: arsip, sub_content: keterangan)
     */
    public static function getKeteranganOptions(): array
    {
        return Setting::getOptions('arsip', 'keterangan');
    }

    /**
     * Validasi rules dinamis berdasarkan settings
     */
    public static function validationRules(): array
    {
        $keteranganOptions = self::getKeteranganOptions();

        return [
            'tahun'      => 'required|date',
            'keterangan' => !empty($keteranganOptions)
                ? 'required|in:' . implode(',', $keteranganOptions)
                : 'required|string|max:255',
            'link'       => 'required|string',
        ];
    }
}