@extends('layouts.learn')

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
                            <router-link to="/staff_month/winners" class="nav-link"><i class="fa fa-book"></i> All Winners</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/staff_month/vote" class="nav-link"><i class="fas fa-vote-yea"></i> Vote for this Month</router-link>
                        </li>
                        @if(Auth::user()->hasRole('Head of Department') || Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Chief Consultant') || Auth::user()->hasRole('Head Nurse') || Auth::user()->hasRole('Practice Manager'))
                        <li class="nav-item">
                            <router-link to="/staff_month/nominate" class="nav-link"><i class="fas fa-user-check"></i> Nominate</router-link>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('Human Resource') || Auth::user()->hasRole('Super Admin'))
                        <li class="nav-item">
                            <router-link to="/staff_month/close_vote" class="nav-link"><i class="fas fa-poll"></i> Close Voting</router-link>
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