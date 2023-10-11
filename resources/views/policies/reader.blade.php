@extends('layouts.lte')

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Sub Menus</h3></div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="/policies/department" class="nav-link"><i class="fa fa-file"></i> My Departmental Policies</a>
                        </li>
                        <li class="nav-item">
                            <a href="/policies/general" class="nav-link"><i class="fas fa-file-alt"></i> General Policies</a>
                        </li>
                        @if(Auth::user()->hasRole('Policy Admin') || Auth::user()->hasRole('Super Admin') || Auth::user()->can('policy_administer')) 
                        <li class="nav-item">
                            <a href="/policies/admin" class="nav-link"><i class="fas fa-cog"></i> Administrator</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{$policy->name}}</h3></div>
                <div class="card-body">
                    <iframe src="{{ asset($policy->file) }}" class="col-12" style="min-height: 1000px"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection