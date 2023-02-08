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
                            <router-link to="/learn/admin_area/courses" class="nav-link"><i class="fa fa-book"></i> All Courses</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/learn/admin_area/exams" class="nav-link"><i class="fas fa-user-clock"></i> Exams</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/learn/admin_area/exam_results" class="nav-link"><i class="fas fa-user-cog"></i> Results </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/learn/admin_area/categories" class="nav-link"><i class="fas fa-cogs"></i> Categories </router-link>
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
@endsection