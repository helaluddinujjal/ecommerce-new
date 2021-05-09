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
            <li class="breadcrumb-item"><a href="{{url('/admin/view-delivery-charges')}}">Delivery Charge List</a></li>
            <li class="breadcrumb-item active">Edit Delivery Charges By Weight</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/edit-delivery-charge-by-weight',$deliveryChargesData->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Delivery Charges by Weight Settings</h3>

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
              <div class="table-responsive">
                <table class="table">
                  <tr><th colspan="4">Condition</th></tr>
                  <tr>
                    <th class="align-middle h-100"><span>Weight</span></th>
                    <td>
                      <div class="form-group">
                        <label for="from">is From ({{settings('weight_measurement')}})</label>
                        <input type="number" step="any" id="from" class="form-control" name="from" placeholder="Weight From" min="0">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <label for="from">to ({{settings('weight_measurement')}})</label>
                        <input type="number" step="any" id="to" class="form-control" name="to" placeholder="Weight To">
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <label for="delivery_charges">Delivery Charges({{settings('site_currency')}})</label>
                        <input type="number" id="delivery_charges" class="form-control" name="delivery_charges" placeholder="Delivery Charges" step="0.01" min="0">
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th colspan="2"></th>
                    <th colspan="2">*** -1=Bellow and +1=Above for to field</th>
                  </tr>
                </table>
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
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card card-green">
        <div class="card-header">
          <h3 class="card-title">Weight Charges List</h3>
        </div>
        <div class="mt-5">
          @include('include.session_msg')
        </div>
        <!-- /.card-header -->
        <form action="{{url('edit-delivery-charge-by-weight-data',$deliveryChargesData->id)}}" method="post">
          @csrf
          <div class="card-body table-responsive">
            <table id="product" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>SL</th>
                <th>Weight From</th>
                <th>Weight To</th>
                <th>Delivery Charges</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @if (!empty($deliveryChargesData['delivery_charges_by_weight']))
                  @foreach ($deliveryChargesData['delivery_charges_by_weight'] as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$value['from']}}{{settings('weight_measurement')}}</td>
                      <td>
                        @if ($value['to']==='-1')
                            Bellow
                         @elseif($value['to']==='+1')
                            Above
                        @else
                            {{$value['to']}}{{settings('weight_measurement')}}
                        @endif
                      </td>
                      <td>{{settings('site_currency')}}{{$value['delivery_charges']}}</td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a title="Delete Value" class="btn btn-sm btn-danger confirm-delete" record="delivery-weight-value" recorded="{{$deliveryChargesData->id}}-{{$key}}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>  
                  @endforeach
                @else
                    <tr>
                      <td colspan="5"><h3 class="text-center text-danger">Data is empty</h3></td>
                    </tr>
                @endif
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.content -->
</div>
@endsection

@push('script')

@endpush