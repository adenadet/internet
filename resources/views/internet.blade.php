@extends('layouts.learn')

@section('extra_content')
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>
<!--
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
                            <router-link to="/student_area/courses" class="nav-link"><i class="fas fa-users-class"></i> My Courses</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/student_area/exams" class="nav-link"><i class="fas fa-file-certificate"></i> My Exams</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/student_area/results" class="nav-link"><i class="fas fa-user-cog"></i> My Results </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</section>
-->
@endsection