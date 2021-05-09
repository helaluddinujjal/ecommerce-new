@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Site Settings</h1>
          @include('include.session_msg')
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Site Settings</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/site-settings')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-2">

          <div class="mt-3 mb-3">
            @include('include.session_msg')
          </div>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Site Settings</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-md-10 offset-1">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <h5 class="text-center"><b>Currency Settings</b></h5> 
                    </li>
                  </ul>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Select Site Currency</b> 
                    </li>
                  </ul>
                  <div class="form-group">
                          <select name="site_currency" id="site_currency" class="form-control">
                            <option value="$" {{settings('site_currency')=="$"?'selected':''}}>USD($)</option>
                            <option value="€" {{settings('site_currency')=="€"?'selected':''}}>Euro(€)</option>
                            <option value="¢" {{settings('site_currency')=="¢"?'selected':''}}>Cent(¢)</option>
                            <option value="£" {{settings('site_currency')=="£"?'selected':''}}>Pound(£)</option>
                            <option value="৳" {{settings('site_currency')=="৳"?'selected':''}}>Taka(৳)</option>
                            <option value="₹" {{settings('site_currency')=="₹"?'selected':''}}>Rupee(₹)</option>
                          </select>
                  </div>
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-10 offset-1">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <h5 class="text-center"><b>Delivery Charge Settings</b></h5> 
                    </li>
                  </ul>
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Delivery Charge Type</b> 
                    </li>
                  </ul>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input delivery_charge_country" type="radio" value="Country" name="delivery_charge_type" {{settings('delivery_charge_type')=="Country"?'checked':''}}>
                      <label class="form-check-label">Delivery Charge Applicable by Country</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input delivery_charge_country_weight" type="radio" value="Weight" name="delivery_charge_type" {{settings('delivery_charge_type')=="Weight"?'checked':''}}>
                      <label class="form-check-label">Delivery Charge Applicable by Product Weight</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-10 offset-1">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Weight Measurement</b> 
                    </li>
                  </ul>
                  <div class="form-group">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="g" name="weight_measurement" {{settings('weight_measurement')=="g"?'checked':''}}>
                      <label class="form-check-label">Gram(g)</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="kg" name="weight_measurement" {{settings('weight_measurement')=="kg"?'checked':''}}>
                      <label class="form-check-label">Kilo Gram (kg)</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <!-- /.card-body -->
        </div>
          <!-- /.card -->
        <div class="row">
          <div class="col-8 offset-2  text-center">
            <input type="submit" value="Saved" class="btn btn-info btn-lg w-100 mb-3">
          </div>
        </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection