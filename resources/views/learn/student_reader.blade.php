@extends('layouts.lte')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sub Menus</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a to="/learn/student_area/courses" class="nav-link"><i class="fa fa-book"></i> My Courses</a>
                        </li>
                        <li class="nav-item">
                            <a to="/learn/student_area/exams" class="nav-link"><i class="fas fa-user-clock"></i> My Exams</a>
                        </li>
                        <li class="nav-item">
                            <a to="/learn/student_area/results" class="nav-link"><i class="fas fa-portrait"></i> My Results </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-dark"><h3 class="card-title">{{$lesson->name}}</h3>
                    <div class="card-tools">
                    @if(!is_null($lesson->exam))
                        @if(is_null($user_exam))<a href="/learn/student_area/exam/{{$lesson->exam->id}}"><button type="button" class="btn btn-sm btn-success">Go To Exam</button></a>
                        @elseif ($user_exam->status >= 3) <a href="/learn/student_area/exam/{{$lesson->exam->id}}"><button type="button" class="btn btn-sm btn-success">Redo Exam</button></a>
                        @elseif((($lesson->exam->trials != null ? $lesson->exam->trials : 10000000) - $trial_count > 0) && ($user_exam->status < 3))<a href="/learn/student_area/exam/{{$lesson.exam.id}}"><button type="button" class="btn btn-sm btn-success">Go To Exam</button></a> 
                        @endif 
                        @if((($lesson->exam->trials != null ? $lesson->exam->trials : 10000000) - $trial_count > 0) && ((is_null($user_exam)) || ($user_exam->status >= 3)))<button type="button" class="btn btn-sm btn-default">Next >></button>
                        @else <button type="button" class="btn btn-sm btn-default">Skip >></button>
                        @endif
                    @else
                    <a href="/learn/student_area/lesson/complete/{{$lesson->id}}" class="btn btn-xs btn-success">Complete</a>
                    @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(!(is_null($lesson->file)))<iframe src="{{ asset($lesson->file) }}" class="col-12" style="min-height: 1000px"></iframe>@endif
                    @if(!(is_null($lesson->video)))<router-view></router-view>@endif
                    <div class="row">
                        {{$lesson->content}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection