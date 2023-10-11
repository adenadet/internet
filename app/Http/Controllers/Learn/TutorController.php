<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lms\Lesson;

class TutorController extends Controller
{
    public function index()
    {
        $params = ['page_title' => 'Tutor Portal', 'page' => 'Dashboard'];
        return view('learn.tutor')->with($params);
    }


    public function lesson_show($id)
    {
        $params = [
            'page_title' => 'Tutor Portal',
            'page' => 'Lesson Details',
            'lesson' => Lesson::where('id', '=', $id)->first(),
        ];

        return view('learn.tutor')->with($params);
    }
}
