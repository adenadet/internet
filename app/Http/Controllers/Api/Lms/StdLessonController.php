<?php

namespace App\Http\Controllers\Api\Lms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lms\Course;
use App\Models\Lms\Lesson;
use App\Models\Lms\Result;
use App\Models\Lms\UserCourse;
use App\Models\Lms\UserExam;
use App\Models\Lms\UserLesson;

class StdLessonController extends Controller
{
    public function complete($id){
        $this->learn_complete_lesson(auth('api')->user(), $id);
    }
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $lesson = Lesson::where('id', '=', $id)->with('course')->with('exam')->first();
        $trials = 0;
        $message = '';
        $user_exam = '';

        //check if this user is supposed to be doing this course
        $user_course = UserCourse::where('course_id', '=', $lesson->course_id)
            ->where('user_id', '=', auth('api')->id())
            ->where('status', '<=', 2)->first();
            //->where('start_date', '>=', date('Y-m-d')) //Must have started
            //->where('expiry_date', '<=', date('Y-m-d')) //Must have not expired
            
        $user_lesson = UserLesson::where('lesson_id', '=', $id)
            ->where('user_id', '=', auth('api')->id())
            //->where('status', '<=', 3)
            ->with('lesson.exam')
            ->first();

        
        
        //Checks for Exam Done by User
        if (!is_null($lesson->exam)){
            //Check to see the User Exam
            $user_exam = UserExam::where('user_id', '=', auth('api')->id())->where('exam_id', '=', $lesson->exam->id)->first();
            //->where('start_date', '>=', date('Y-m-d')) //Must have started
            //->where('expiry_date', '<=', date('Y-m-d')) //Must have not expired

            //Check how many times 
            $trials = Result::where('user_id', '=',  auth('api')->id())->where('exam_id', '=', $lesson->exam->id)->count();
        }
        else{}
        /*
        if (is_null($user_course)){
            if (is_null($user_lesson) && ($user_course->level == 0)){
                //Check if the course is a new course
                $user_lesson = UserLesson::create([
                    'course_id' => $user_course->course->id,
                    'user_id' => auth('api')->id(),
                    'lesson_id' => $lesson->id,
                    'assigned_date' => date('Y-m-d H:i:s'),
                ]);

                return response()->json([
                    'message' => "Go on",
                    'lesson' => $lesson,
                ]);
            }
            else{
                return response()->json([
                    'message' => "Don't go",
                    'lesson' => $lesson,
                ]);
            }
        }

        else if ((!is_null($user_course)) && (!is_null($user_lesson))){
            $lesson = Lesson::where('id', '=', $id)->with('course')->with('exam')->first(); //get the correct lesson
            if (!is_null($lesson->exam)){ //check if the lesson has a quiz,
                //-- Step 1: Check that the user has been assigned the exam --
                $user_exams = UserExam::where('user_id', '=', auth('api')->id())->where('exam_id', '=', $lesson->exam->id)->get();
                //->where('expiry_date', '>=', date('Y-m-d'))
                            
                //*-- Step 1b: If the User had not been previously assigned the exam, assign the exam to the user --*
                if (is_null($user_exams)){
                    $user_exam = UserExam::Create(
                    [
                        'assigned_date' => date('Y-m-d H:i:s'), 
                        'course_id' => $lesson->course_id,
                        'exam_id' => $lesson->exam->id, 
                        'expiry_date' => $lesson->course->expiry_date, 
                        'lesson_id' => $lesson->id,
                        'start_date' => $lesson->course->start_date,
                        'status' => 0,
                        'user_id' => auth('api')->id(),
                    ]);
                }
                //*--Step 2: Get the number of trials available trials left --*
                $trials = Result::where('exam_id', '=', $user_lesson->lesson->exam->id)->where('user_id', '=', auth('api')->id())->count();
            }
            $message = "Go On";
            }
        else{
            $message = "Don't go on";
            }
        */
        return response()->json([
            'course'    =>  $lesson->course,
            'lesson'    =>  $lesson,
            'message'   =>  $message,
            'trials'    =>  $trials,
            'user_exam' =>  $user_exam,
        ]);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
