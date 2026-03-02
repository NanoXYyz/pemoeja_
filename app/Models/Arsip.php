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
     * tahun: integer (hanya tahun, bukan full date)
     */
    public static function validationRules(): array
    {
        $keteranganOptions = self::getKeteranganOptions();
        $currentYear = (int) date('Y');

        return [
            'tahun'      => "required|integer|min:2000|max:{$currentYear}",
            'keterangan' => !empty($keteranganOptions)
                ? 'required|in:' . implode(',', $keteranganOptions)
                : 'required|string|max:255',
            'link'       => 'required|url|max:2048',
        ];
    }
}