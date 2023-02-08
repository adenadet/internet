<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $params = [
            'page_title' => 'Policies',
        ];
        return view('policies')->with($params);
    }
}
