<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index()
    {
        $params = ['page_title' => 'Tutor Portal',];
        return view('tutor')->with($params);
    }
}
