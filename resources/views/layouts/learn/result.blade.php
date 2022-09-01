@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Test Result
                    <div class="card-tools">
                        @if ($exam->pass_mark <= $result->total_points)
                        Passed
                        @else
                        Failed <a href="/student_area/exam/{{$exam->id}}"><button type="button" class="btn btn-sm btn-primary" title="Repeat">Retry</button></a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status'))
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row invoice-info">
                        <div class="col-sm-6 invoice-col">
                        Exam:<address><strong><h2>{{$exam->name}}</h2></strong></address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <address>
                                <strong>Pass Mark:</strong>
                                <h3>{{$exam->pass_mark}} of {{$exam->question}}</h3>
                            </address>
                        </div>
                        <div class="col-sm-3 invoice-col">
                            <address>
                                <strong>Result Mark:</strong>
                                <h3>{{$result->total_points}} of {{$exam->question}}</h3>
                            </address>
                        </div>
                    </div>
                    <?php $s_n = 1; ?>
                    <table class="table">
                        <thead>
                            <tr><th style="width: 10%;">#</th><th style="width: 40%;">Question</th><th style="width: 40%;">Answer</th><th style="width: 10%;">Score</th></tr>
                        </thead>
                        <tbody>
                        @foreach($exams as $question)
                            <tr>
                                <td>{{$s_n++}}.</td>
                                <td>{{$question->question}}</td>
                                <td>{{$question->option_text}}</td>
                                <td><span class="badge {{($question['points'] > 0)? 'bg-success' : 'bg-danger'}}">{{$question->points}}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table> 
                </div>
                <div class="card-footer">
                    @if($exam->pass_mark <= $result->total_points)
                    <p>Congratulations, you may <a href="/learn/student_area/exams">See other Exams</a> or <a href="/learn/student_area/courses">Return to Courses</a>.</p>
                    @else
                    <p>You failed this stage, you would need to repeat it, <a href="/learn/student_area/exam/{{$exam->id}}">click here</a> to retake exam
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection