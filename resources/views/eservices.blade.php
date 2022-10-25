@extends('layouts.lte')

@section('extra_content')
<section class="content">
    <div class="row">
        <div class="col-md-3">
            @if($page_title == 'E-Services | Front Office') @include('partials.eservices.front')
            @elseif($page_title == 'E-Services | Medical Officer') @include('partials.eservices.doctor')
            @endif
        </div>
        <div class="col-md-9">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
    </div>
</section>
@endsection