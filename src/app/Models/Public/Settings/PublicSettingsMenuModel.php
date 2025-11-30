<?php

namespace App\Models\Public\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicSettingsMenuModel extends Model {
    use HasFactory;

    protected $table = 'public_settings_menu';

    protected $fillable = [
        'name',
        'title',
        'link',
        'path'
    ];

    protected $casts = [
        'name'  => 'string',
        'title' => 'string',
        'link'  => 'string',
        'path'  => 'string'
    ];

    public function parent() {
        return $this->belongsTo(PublicSettingsMenuModel::class, 'parent_id');
    }

    public function submenus() {
        return $this->hasMany(PublicSettingsMenuModel::class, 'parent_id');
    }
}
