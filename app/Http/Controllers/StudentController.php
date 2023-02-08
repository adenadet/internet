<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $params = ['page_title' => 'Student Portal',];
        return view('student')->with($params);
    }
}
