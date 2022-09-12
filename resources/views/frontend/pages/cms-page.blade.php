@extends('layouts.frontend.layouts')
@section('content')
<div id="all">
    <div id="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <!-- breadcrumb-->
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li aria-current="page" class="breadcrumb-item active">{{$cmsPage->title}}</li>
              </ol>
            </nav>
          </div>
          {{-- sidebar --}}
          @include('layouts.frontend.sidebar')
          <div class="col-lg-9">
            <div class="box">
                <h1>{{$cmsPage->title}}</h1>
            </div>
            <div id="text-page" class="box">
                {!! $cmsPage->description !!}
            </div>
          </div>
          <!-- /.col-lg-9-->
        </div>
      </div>
    </div>
  </div>
@endsection
