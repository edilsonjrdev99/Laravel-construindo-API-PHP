<?php

namespace App\Http\Controllers\Api\Public\Settings;

use App\Http\Controllers\Controller;
use App\Models\Public\Settings\PublicSettingsMenuModel;

class PublicSettingsMenuController extends Controller
{
    public function index() {
        $menus = PublicSettingsMenuModel::whereNull('parent_id')
            ->with('submenus')
            ->get();

        return response()->json($menus);
    }
}
