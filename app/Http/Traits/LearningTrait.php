<?php
namespace App\Http\Traits;

use App\Models\Lms\Course;
use App\Models\Lms\Exam;
use App\Models\Lms\Lesson;
use App\Models\Lms\Result;
use App\Models\Lms\UserCourse;
use App\Models\Lms\UserExam;
use App\Models\Lms\UserLesson;

trait LearningTrait{
    public function learn_complete_lesson($user, $id){
        $lesson = Lesson::find($id);
        $user_lesson = UserLesson::where('user_id', '=', $user->id)
                        ->where('lesson_id', '=', $id)->with('lesson.exam')->first();
        $user_course = UserCourse::where('user_id', '=', $user->id)
                        ->where('course_id', '=', $lesson->course_id)->with('course.lessons')->first();

        //If Lesson or Course are absent, stop completion process
        if (is_null($user_course) || is_null($user_lesson)){
            return ['message' => 'Error', 'course' => $user_course];
            }

        //If the lesson has an exam
        if (!is_null($user_lesson->lesson->exam)){ //Check if the exam has been passed by the user
            $user_exam = UserExam::where('user_id', '=', $user->id)->where('exam_id', '=', $lesson->exam->id)
                        //->where('start_date', '>=', date('Y-m-d'))->where('expiry_date', '<=', date('Y-m-d'))
                        ->first();
            //If not yet created, create one for User
            if (is_null($user_exam)){ 
                $user_exam = UserExam::create([
                    'user_id' => $user->id, 
                    'exam_id' => $lesson->exam->id, 
                    'course_id' => $lesson->course_id, 
                    'lesson_id' => $lesson->id, 
                    'assigned_date' => $user_lesson->assigned_date, 
                    'status' => 0,
                ]);

                $message = "You have not completed the exam for this lesson. You can't continue to next lesson";
                $icon = "warning";
                return ['icon'=> $icon, 'message' => $message, 'course' => $user_course];
                }
            else if ($user_exam->status == 3){ // If User has been passed exam
                $user_lesson->status = 3;
                $user_lesson->save();
                 
                if ($user_course->course->lessons[$user_course->level]->id == $lesson->id){
                    $user_course->level++;
                    $user_course->save();

                    $next_lesson = UserLesson::create([
                        'user_id' => $user->id,
                        'course_id' => $user_course->course->id,
                        'lesson_id' => $user_course->course->lessons[$user_course->level]->id,
                        'start_date' => date('Y-m-d'),
                        'status' => 3,
                    ]);
                }

                $message = "Exam has been passed. You can continue to next lesson";
                $icon = "success";
                return ['icon'=> $icon, 'message' => $message, 'course' => $user_course];
            } 
            else if ($user_exam->status == 6){ //If Exam was skipped
                if ($user_course->course->lessons[$user_course->level]->id == $lesson->id){
                    $user_course->level++;
                    $user_course->save();

                    $next_lesson = UserLesson::create([
                        'user_id' => $user->id,
                        'course_id'=>  $user_course->course->id,
                        'lesson_id' => $user_course->course->lessons[$user_course->level]->id,
                        'start_date' => date('Y-m-d'),
                        'status' => 3,
                    ]);
                }
                $message = "Exam has been skipped has you have failed multiple times. You can continue to next lesson";
                $icon = "success";
                return ['icon'=> $icon, 'message' => $message, 'course' => $user_course];
            }
            else{//Check number of trials
                $trials = Result::where('exam_id', '=', $lesson->exam->id)->where('user_id', '=', $user->id)->get();
                if ($trials->count() >= $user_lesson->lesson->exam->trials){
                    $user_exam->status = 6; 
                    $user_exam->save(); 
                    $user_lesson->status = 3; 
                    $user_lesson->user_finish_time = date('Y-m-d H:i:s'); //$user_lesson->exam_id = 0; 
                    $user_lesson->save(); 

                    //Update User Course to allow next level
                    
                    if ($user_course->course->lessons[$user_course->level]->id == $lesson->id){
                        $user_course->level++;
                        $user_course->save();
                        //Create a new UserLesson, so that the user can read the next lesson
                        $new_user_lesson = UserLesson::create([
                            'course_id' => $user_course->course->id,
                            'user_id' => $user->id,
                            'lesson_id' => $user_course->course->lessons[$user_course->level]->id,
                            $user_course->course->lessons[$user_course->level]->id
                        ]); 
                    }
                    return ['icon'=> 'success', 'message' => 'Done', 'course' => $user_course];
                }
                else{
                    return ['icon'=> 'error', 'message' => 'Error', 'course' => $user_course];
                }
            }
        }
        else{
            
            $user_lesson->status = 3;
            $user_lesson->user_finish_time = date('Y-m-d H:i:s');
            $user_lesson->save();
            
            //Check if the 
            if ($user_course->course->lessons[$user_course->level]->id == $lesson->id){
                $user_course->level++;
                $user_course->save();
                //Create a new UserLesson, so that the user can read the next lesson
                $new_user_lesson = UserLesson::create([
                    'course_id' => $user_course->course->id,
                    'user_id' => $user->id,
                    'lesson_id' => $user_course->course->lessons[$user_course->level]->id,
                    $user_course->course->lessons[$user_course->level]->id
                ]); 
            }
            return ['icon'=> 'success', 'message' => 'Done', 'course' => $user_course, 'trial_count' => 0];
        }
    }

    public function learn_exam_create_new($user_id, $exam_id){
        $exam = Exam::where('id', '=', $exam_id)->first();
        $user_course = UserCourse::where([['user_id', '=', $user_id], ['course_id', '=', $exam->course_id], ['status', '!=', 3]])->orderBy('expiry_date', 'DESC')->first();

        $user_exam = UserExam::create([
            'user_id'           => $user_id,
            'exam_id'           => $exam->id,
            'course_id'         => $exam->course_id,
            'lesson_id'         => $exam->lesson_id,
            'assigned_date'     => $user_course->assigned_date,
            'start_date'        => $user_course->start_date,
            'expiry_date'       => $user_course->expiry_date,
            'user_start_time'   => date('Y-m-d H:i:s'),
            'user_finish_time'  => NULL,
            'started'           => 2,
        ]);

        return $user_exam;
    }

    public function learn_get_lesson($id){
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

                return[
                    'message' => "Go on",
                    'lesson' => $lesson,
                ]);
            }
            else{
                return[
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
        return [
            'course'    =>  $lesson->course,
            'lesson'    =>  $lesson,
            'message'   =>  $message,
            'page_title' => 'Student Portal',
            'trials'    =>  $trials,
            'user_exam' =>  $user_exam,
            'trial_count' => 0,
        ];
    } 
}