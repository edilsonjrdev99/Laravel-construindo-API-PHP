<?php

namespace App\Http\Controllers\Api\Public\Settings;

use App\Http\Controllers\Controller;
use App\Models\Public\Settings\PublicSettingsMenuModel;

class PublicSettingsMenuController extends Controller
{
    public function index() {
        $menus = PublicSettingsMenuModel::all();

        return response()->json($menus);
    }
}
