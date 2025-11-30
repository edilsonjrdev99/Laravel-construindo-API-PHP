<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicSettingsColor extends Model
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
