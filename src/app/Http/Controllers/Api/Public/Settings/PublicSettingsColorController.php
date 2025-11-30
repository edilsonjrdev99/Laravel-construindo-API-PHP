<?php

namespace App\Http\Controllers\Api\Public\Settings;

use App\Http\Controllers\Controller;
use App\Models\PublicSettingsColor;

class PublicSettingsColorController extends Controller
{
    public function index() {
        $data = PublicSettingsColor::all();

        return response()->json($data);
    }
}
