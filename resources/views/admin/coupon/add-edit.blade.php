@extends('layouts.admin.layouts')
@push('style')
<link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
@endpush
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 text-center">
          <h1>{{$title}}</h1>
          <div class="mt-3">
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/coupons')}}">Coupons</a></li>
            <li class="breadcrumb-item active">{{$title}}</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form @if (!empty($couponData->id))
      action="{{url('admin/add-edit-coupon',$couponData->id)}}"
    @else
    action="{{url('admin/add-edit-coupon')}}"  
    @endif method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Coupon Settings</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="coupon_option">Coupon Option</label>
                <br>
                <span>
                  <input type="radio" id="manual_coupon" value="Manual"   name="coupon_option"  @if (!empty($couponData->coupon_option) && $couponData->coupon_option=="Manual")
                   checked="checked"
                @endif> <label for="manual_coupon">Manual</label></span> 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                <span>
                  <input type="radio" id="automatic_coupon" name="coupon_option" value="Automatic"  @if (!empty($couponData->coupon_option) && $couponData->coupon_option=="Automatic")
                  checked="checked" 
                @endif> <label for="automatic_coupon">Automatic</label>
                </span>
              </div>
              <div class="form-group" @if (!empty($couponData->coupon_option) && $couponData->coupon_option=="Manual")
                style="display: block" 
              @else
              style="display: none" 
              @endif  id="coupon_code_field">
                <label for="coupon_code">Coupon Code</label>
                <input type="text" id="coupon_code" class="form-control" name="coupon_code" placeholder="Enter Coupon Code" @if (!empty($couponData->coupon_code))
                  value="{{$couponData->coupon_code}}"  
                @else
                value="{{old('coupon_code')}}"  
                @endif>
              </div>
              <div class="form-group">
                <label for="coupon_type">Coupon Type</label>
                <br>
                <span>
                  <input type="radio" id="single_coupon" value="Single"   name="coupon_type"  @if (!empty($couponData->coupon_type) && $couponData->coupon_type=="Single")
                   checked="checked" 
                @endif> <label for="single_coupon">Single Time</label></span> 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                <span>
                  <input type="radio" id="multiple_coupon" name="coupon_type" value="Multiple"  @if (!empty($couponData->coupon_type) && $couponData->coupon_type=="Multiple")
                  checked="checked"  
                @endif> <label for="multiple_coupon">Multiple Time</label>
                </span>
              </div>
              <div class="form-group">
                <label for="amount_type">Amount Type</label>
                <br>
                <span>
                  <input type="radio" id="percentage" value="Percentage"   name="amount_type"  @if (!empty($couponData->amount_type) && $couponData->amount_type=="Percentage")
                   checked="checked" 
                @endif> <label for="percentage">Percentage(%)</label></span> 	&nbsp;	&nbsp;	&nbsp;	&nbsp;
                <span>
                  <input type="radio" id="usd" name="amount_type" value="USD"  @if (!empty($couponData->amount_type) && $couponData->amount_type=="USD")
                  checked="checked"  
                @endif> <label for="usd">USD ($)</label>
                </span>
              </div>
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" min="0" id="amount" class="form-control" name="amount" placeholder="Enter Amount" @if (!empty($couponData->amount))
                  value="{{$couponData->amount}}"  
                @else
                value="{{old('amount')}}"  
                @endif>
              </div>
              <div class="form-group">
                <label>Select Categories</label>
                <select class="select2" name="categories[]" multiple="multiple" data-placeholder="Select Categories" style="width: 100%;">
                  @foreach ($categories as $section)
                    <optgroup label="{{$section->name}}""></optgroup>
                      @foreach ($section->categories as $parentCat)
                        <option title="{{$section->name}}"
                        value="{{$parentCat->id}}"
                        @if (collect(old('categories'))->contains($parentCat->id))
                          selected=""
                          @elseif(in_array($parentCat->id,$selCat))selected=""
                        @endif>&#10146;&#10146;{{$parentCat->category_name}}</option>
                        @foreach ($parentCat->childcategories as $childCat)
                          <option title="{{$section->name}} &#10146; {{$parentCat->category_name}}" value="{{$childCat->id}}""
                            @if (collect(old('categories'))->contains($childCat->id))
                          selected=""
                          @elseif(in_array($childCat->id,$selCat)) selected=""
                        @endif
                            >&emsp;&emsp;&#10551; {{$childCat->category_name}}</option>
                        @endforeach
                      @endforeach
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Select Users</label>
                <select class="select2" name="users[]" multiple="multiple" data-placeholder="Select Users" style="width: 100%;">
                  @foreach ($users as $user)
                        <option
                        value="{{$user->email}}"
                        @if (collect(old('users'))->contains($user->email))
                          selected=""
                          @elseif(in_array($user->email,$selUsers))selected=""
                        @endif>{{$user->email}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Date range:</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="far fa-calendar-alt"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control float-right" name="expiry_date" id="expiry_date" @if (!empty($couponData->start_date)&& !empty($couponData->expiry_date))
                  value="{{$couponData->start_date}} to {{$couponData->expiry_date}}"
                  @else
                  value="{{old('expiry_date')}}"
                  @endif>
                </div>
                <!-- /.input group -->
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
          <input type="submit" value="{{$title}}" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection

@push('script')
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script>
      //Date range picker
      $('#expiry_date').daterangepicker({
        autoUpdateInput: false,
        locale: {
                format: 'YYYY-MM-DD',
                separator: " to ",
                cancelLabel: 'Clear'
            },  
      })

  $('#expiry_date').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('#expiry_date').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
    </script>
@endpush