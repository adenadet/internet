@extends('layouts.lte')

@section('content')

<div class="content">
    <router-view></router-view>
    <vue-progress-bar></vue-progress-bar>
</div>
@endsection