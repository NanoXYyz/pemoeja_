<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'sub_content', 'type_data', 'keterangan', 'default_value'];

    /**
     * Relasi ke SettingOption
     */
    public function options()
    {
        return $this->hasMany(SettingOption::class);
    }

    /**
     * Ambil semua opsi untuk category + sub_content tertentu
     * Contoh: Setting::getOptions('anggota', 'jabatan')
     */
    public static function getOptions(string $category, string $subContent): array
    {
        $setting = self::where('category', $category)
            ->where('sub_content', $subContent)
            ->first();

        if (!$setting) return [];

        return $setting->options()->pluck('option_name')->toArray();
    }

    /**
     * Ambil default value untuk category + sub_content tertentu
     */
    public static function getDefault(string $category, string $subContent): ?string
    {
        return self::where('category', $category)
            ->where('sub_content', $subContent)
            ->value('default_value');
    }

    /**
     * Ambil semua settings berdasarkan category (untuk form builder)
     */
    public static function getByCategory(string $category)
    {
        return self::where('category', $category)
            ->with('options')
            ->get();
    }
}