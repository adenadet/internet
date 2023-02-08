<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $params = [
            'page_title' => 'Profile',
        ];
        return view('profile')->with($params);
    }
}
