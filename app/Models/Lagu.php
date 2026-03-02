<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lagu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'key',
        'lirik',
        'reff',
    ];

    /**
     * Ambil opsi key/nada dari settings
     * (category: lagu, sub_content: key)
     */
    public static function getKeyOptions(): array
    {
        $options = Setting::getOptions('lagu', 'key');

        // Fallback ke default chromatic scale jika settings belum diisi
        if (empty($options)) {
            return ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];
        }

        return $options;
    }

    /**
     * Validasi rules dinamis berdasarkan settings
     */
    public static function validationRules(): array
    {
        $keyOptions = implode(',', self::getKeyOptions());

        return [
            'title' => 'required|string|max:255',
            'key'   => "required|in:{$keyOptions}",
            'lirik' => 'required|string',
            'reff'  => 'nullable|string',
        ];
    }
}