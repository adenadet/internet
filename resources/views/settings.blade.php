@extends('layouts.learn')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Sub Menus</h3></div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <router-link to="/settings/departments" class="nav-link"><i class="fas fa-boxes"></i> Departments</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/settings/branches" class="nav-link"><i class="fas fa-building"></i> Branches</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/student_area/results" class="nav-link"><i class="fas fa-user-cog"></i> Results</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/student_area/results" class="nav-link"><i class="fas fa-user-cog"></i> Results</router-link>
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