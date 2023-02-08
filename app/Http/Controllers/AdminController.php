<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $params = [
            'page_title' => 'Administrator ',
        ];
        return view('admin')->with($params);
    }
}
