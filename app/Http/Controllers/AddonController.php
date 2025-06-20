<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $data['available'] = miniCollection(json_decode(file_get_contents("Modules/Addons/available_addons.json"), true));
        return view('admin.addon.view',$data);
    }
}
