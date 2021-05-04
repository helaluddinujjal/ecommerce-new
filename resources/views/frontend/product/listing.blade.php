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
                
                @if (!empty($categoryDetails))
                  @php
                     echo $categoryDetails['breadcumbs'];
                   @endphp
                @else
                <li aria-current="page" class="breadcrumb-item active">{{$sectionDetails->name}}</li>
                    
                @endif
              </ol>
            </nav>
          </div>
          {{-- sidebar --}}
          @include('layouts.frontend.sidebar')
          <div class="col-lg-9">
            <div class="box">
              @if (!empty($categoryDetails))
                <h1>{{$categoryDetails['categoryDetails']['category_name']}}</h1>
                <p>{{$categoryDetails['categoryDetails']['description']}}</p>
                @else
                  <h1>{{$sectionDetails->name}}</h1>
                @endif
              
            </div>
            
            <div class="show_product">
              @include('frontend.product.ajax_listing')
            </div>
          </div>
          <!-- /.col-lg-9-->
        </div>
      </div>
    </div>
  </div>
@endsection