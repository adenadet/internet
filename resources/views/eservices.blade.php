@extends('layouts.lte')

@section('extra_content')
<section class="content">
    <div class="row">
        @if (($page_title == 'E-Services | Front Admin') || ($page_title == 'E-Services | Front Office') || ($page_title == 'E-Services | Medical Officer') || ($page_title == 'E-Services | Radiologist'))
        <div class="col-md-3">
            @if($page_title == 'E-Services | Front Office') @include('partials.eservices.front')
            @elseif($page_title == 'E-Services | Medical Officer') @include('partials.eservices.doctor')
            @elseif($page_title == 'E-Services | Radiologist') @include('partials.eservices.radiologist')
            @elseif($page_title == 'E-Services | Front Admin') @include('partials.eservices.front_admin')
            @endif
        </div>
        <div class="col-md-9">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        @else
        <div class="col-md-12">
            <router-view></router-view>
            <vue-progress-bar></vue-progress-bar>
        </div>
        @endif
    </div>
</section>
@endsection