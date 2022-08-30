@extends('layouts.ext')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-9">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</section>
@endsection