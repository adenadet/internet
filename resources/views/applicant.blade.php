@extends('layouts.ext')

@section('content')
<section class="content">
    <div class="row">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
    </div>
</section>
@endsection