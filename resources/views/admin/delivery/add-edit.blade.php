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
          <h1>Edit Delivery Chargees</h1>
          <div class="mt-3">
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/view-delivery-charges')}}">Delivery Charges List</a></li>
            <li class="breadcrumb-item active">Edit Delivery Charges</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/edit-delivery-charge',$deliveryChargesData->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Delivery Charges Settings</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="countryName">Country Name</label>
                <input type="text" readonly id="countryName" class="form-control" @if (!empty($deliveryChargesData->country))
                  value="{{$deliveryChargesData->country}}"  
                @endif>
              </div>
              <div class="form-group">
                <label for="deliveryCharges">Delivery Charges</label>
                <input type="text" id="deliveryCharges" name="delivery_charges" class="form-control" @if (!empty($deliveryChargesData->delivery_charges))
                  value="{{$deliveryChargesData->delivery_charges}}"  
                  @else
                  {{old('delivery_charges')}}
                @endif>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-md-8 offset-md-2 text-center">
          <input type="submit" value="Saved" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection

@push('script')

@endpush