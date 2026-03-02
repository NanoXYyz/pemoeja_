<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'title',
        'tempat',
        'mc',
        'pf',
    ];

    /**
     * Ambil opsi tempat dari settings
     * (category: jadwal, sub_content: tempat)
     */
    public static function getTempatOptions(): array
    {
        return Setting::getOptions('jadwal', 'tempat');
    }

    /**
     * Ambil opsi title/jenis acara dari settings
     * (category: jadwal, sub_content: title)
     */
    public static function getTitleOptions(): array
    {
        return Setting::getOptions('jadwal', 'title');
    }

    /**
     * Validasi rules dinamis berdasarkan settings
     */
    public static function validationRules(): array
    {
        $tempatOptions = self::getTempatOptions();
        $titleOptions  = self::getTitleOptions();

        $rules = [
            'tanggal' => 'required|date',
            'mc'      => 'required|string|max:255',
            'pf'      => 'required|string|max:255',
        ];

        // Jika ada opsi dari settings, pakai validasi in:
        $rules['tempat'] = !empty($tempatOptions)
            ? 'required|in:' . implode(',', $tempatOptions)
            : 'required|string|max:255';

        $rules['title'] = !empty($titleOptions)
            ? 'required|in:' . implode(',', $titleOptions)
            : 'required|string|max:255';

        return $rules;
    }
}