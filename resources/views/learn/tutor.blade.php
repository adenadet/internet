@extends('layouts.lte')

@section('extra_content')
<section class="content">
    <div class="row">
        @if($page != 'Lesson Details')
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sub Menus</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active"><router-link to="/learn/tutor_area/courses" class="nav-link"><i class="fas fa-book-open"></i> My Courses</router-link></li>
                        <li class="nav-item"><router-link to="/learn/tutor_area/exams" class="nav-link"><i class="fas fa-user-cog"></i> My Exams</router-link></li>
                        <li class="nav-item"><router-link to="/learn/tutor_area/results" class="nav-link"><i class="fa fa-bar-chart"></i> Results</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
        @elseif($page == 'Lesson Details')
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sub Menus</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active"><a href="/learn/tutor_area/courses" class="nav-link"><i class="fas fa-book-open"></i> My Courses</a></li>
                        <li class="nav-item"><a href="/learn/tutor_area/exams" class="nav-link"><i class="fas fa-user-cog"></i> My Exams</a></li>
                        <li class="nav-item"><a href="/learn/tutor_area/results" class="nav-link"><i class="fa fa-bar-chart"></i> Results</a></li>
                    </ul>
                </div>
            </div>
        </div>
        @endif 
        @if($page != 'Lesson Details')
        <div class="col-md-9">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        @elseif($page == 'Lesson Details')
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{$lesson->name}}</h3></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <iframe src="{{ asset($lesson->file) }}" class="col-12" style="min-height: 1000px"></iframe>
                        </div>
                        <div class="col-md-4">
                            <router-view></router-view>
                            <vue-progress-bar></vue-progress-bar>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection