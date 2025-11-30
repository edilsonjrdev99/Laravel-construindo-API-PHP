<?php

namespace App\Http\Controllers\Api\Public\Settings;

use App\Http\Controllers\Controller;
use App\Models\Public\Settings\PublicSettingsColorModel;

class PublicSettingsColorController extends Controller
{
    public function index() {
        $data = PublicSettingsColorModel::all();

        return response()->json($data);
    }
}
