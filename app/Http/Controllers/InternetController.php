<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternetController extends Controller
{
    public function index()
    {
        $params = [
            'page_title' => 'Network Checkers',
        ];
        return view('internet')->with($params);
    }
}
