@extends('layouts.learn')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Sub Menus</h3></div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><router-link to="/ticketing" class="nav-link"><i class="fas fa-user-tag"></i> My Tickets</router-link></li>
                        <li class="nav-item"><router-link to="/ticketing/department" class="nav-link"><i class="fas fa-tags"></i> Departmental Tickets</router-link></li>
                        @if(Auth::user()->hasRole('Ticket Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('ticket_setting')) 
                        <li class="nav-item"><router-link to="/ticketing/settings" class="nav-link"><i class="fas fa-cogs"></i> Settings</router-link></li>
                        @endif
                        @if(Auth::user()->hasRole('Ticket Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('ticket_administer')) 
                        <li class="nav-item"><router-link to="/ticketing/admin" class="nav-link"><i class="fas fa-user-cog"></i> Admin</router-link></li>
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