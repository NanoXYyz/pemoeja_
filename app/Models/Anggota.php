<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Ambil opsi gender dari settings (category: anggota, sub_content: gender)
     */
    public static function getGenderOptions(): array
    {
        return Setting::getOptions('anggota', 'gender');
    }

    /**
     * Ambil opsi status dari settings (category: anggota, sub_content: status)
     */
    public static function getStatusOptions(): array
    {
        return Setting::getOptions('anggota', 'status');
    }

    /**
     * Ambil opsi jabatan dari settings (category: anggota, sub_content: jabatan)
     */
    public static function getJabatanOptions(): array
    {
        return Setting::getOptions('anggota', 'jabatan');
    }

    /**
     * Validasi rules dinamis berdasarkan settings
     */
    public static function validationRules(): array
    {
        $genderOptions  = implode(',', self::getGenderOptions());
        $statusOptions  = implode(',', self::getStatusOptions());
        $jabatanOptions = implode(',', self::getJabatanOptions());

        return [
            'nama'    => 'required|string|max:255',
            'gender'  => "required|in:{$genderOptions}",
            'status'  => "required|in:{$statusOptions}",
            'jabatan' => "required|in:{$jabatanOptions}",
        ];
    }
}