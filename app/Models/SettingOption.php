<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SettingOption extends Model
{
    protected $fillable = ['setting_id', 'option_name', 'label', 'urutan'];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Setting
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

    /**
     * Mutator: lowercase dan ganti spasi dengan strip
     */
    protected function setOptionNameAttribute($value)
    {
        $this->attributes['option_name'] = Str::lower(str_replace(' ', '-', $value));
    }

    /**
     * Scope: urutkan berdasarkan kolom urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('option_name');
    }
}