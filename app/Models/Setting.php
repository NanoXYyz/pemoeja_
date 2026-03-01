<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'sub_content', 'type_data', 'keterangan', 'default_value'];

    // Relasi ke tabel options (asumsi nama model SettingOption)
    public function options()
    {
        return $this->hasMany(SettingOption::class);
    }
}