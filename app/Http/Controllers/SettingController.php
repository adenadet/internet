<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $params = [
            'page_title' => 'Settings',
        ];
        return view('settings')->with($params);
    }
}
