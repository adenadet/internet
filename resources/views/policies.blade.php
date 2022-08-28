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
                            <router-link to="/policies/department" class="nav-link"><i class="fa fa-file"></i> My Departmental Policies</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/policies/general" class="nav-link"><i class="fas fa-file-alt"></i> General Policies</router-link>
                        </li>
                        @if(Auth::user()->hasRole('Policy Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('policy_administer')) 
                        <li class="nav-item">
                            <router-link to="/policies/admin" class="nav-link"><i class="fas fa-cog"></i> Administrator</router-link>
                        </li>
                        @endif
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