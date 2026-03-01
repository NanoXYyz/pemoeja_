<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SettingOption extends Model {
    protected $fillable = ['setting_id', 'option_name'];

    protected function setOptionNameAttribute($value) {
        // Kecilkan huruf dan ganti spasi dengan strip
        $this->attributes['option_name'] = Str::lower(str_replace(' ', '-', $value));
    }
}