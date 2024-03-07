<?php

namespace App\Http\Controllers\Learn;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\LearningTrait;

class StudentController extends Controller
{
    use LearningTrait;

    public function complete_lesson($id)
    {
        $params = $this->learn_complete_lesson(Auth::user(), $id);
        print_r($params['course']->course_id);
        return redirect('/learn/student_area/course/'.$params['course']->course_id);

    }

    public function index()
    {
        $params = ['page_title' => 'Student Portal',];
        return view('learn.student')->with($params);
    }

    public function show($id){
       $params = $this->learn_get_lesson($id);
       return view('learn.student_reader')->with($params);
    }
}
