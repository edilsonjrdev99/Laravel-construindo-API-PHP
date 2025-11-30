<?php

namespace App\Models\Public\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicSettingsColorModel extends Model
{
    use HasFactory;

    protected $table = 'public_settings_colors';

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'string'
    ];
}
