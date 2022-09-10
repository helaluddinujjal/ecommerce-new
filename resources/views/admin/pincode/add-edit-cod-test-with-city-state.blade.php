@extends('layouts.admin.layouts')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                        <div class="mt-3">
                            @include('include.session_msg')
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/admin/pincode/cod') }}">Pincode</a></li>
                            <li class="breadcrumb-item active">{{ $title }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <form
                @if (!empty($pincodeData->id)) action="{{ url('admin/pincode/add-edit-cod', $pincodeData->id) }}"
    @else
    action="{{ url('admin/pincode/add-edit-cod') }}" @endif
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">COD Pincode Section</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4" id="countrySection">
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <select id="country" autocomplete="off" name="delivery_country"
                                                class="form-control deliveryCountry">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" @if (!empty($pincodeData->country_id) && $pincodeData->country_id==$country->id)
                                                        selected
                                                     @endif>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4" id="stateSection">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><input type="checkbox" name="delivery_state_status" id="stateCheck" class="form-check" value="true" title="chacked for state" @if (!empty($pincodeData->state_id_status) && $pincodeData->state_id_status==true)
                                                    checked="checked"
                                                 @endif
                                                    autocomplete="off">
                                                  </div>
                                                </div>
                                                <select id="state" name="delivery_state" class="form-control" @if (empty($states))
                                                style="display: none"
                                                @endif >

                                                    @if (!empty($states))
                                                    @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" @if (!empty($pincodeData->state_id) && $pincodeData->state_id==$state->id)
                                                        selected
                                                     @endif>{{ $state->name }}</option>
                                                @endforeach
                                                    @endif

                                                </select>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4" id="citySection">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                  <div class="input-group-text"><input type="checkbox" id="cityCheck" name="delivery_city_status" class="form-check" value="true" title="chacked for state" autocomplete="off" @if (!empty($pincodeData->city_id_status) && $pincodeData->city_id_status==true)
                                                    checked="checked"
                                                 @endif></div>
                                                </div>
                                                <select id="city" name="delivery_city" class="form-control" @if (empty($cities))
                                                style="display: none"
                                                @endif>
                                                    @if (!empty($cities))
                                                    @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" @if (!empty($pincodeData->city_id) && $pincodeData->city_id==$city->id)
                                                        selected
                                                     @endif>{{ $city->name }}</option>
                                                @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 mb-1" >
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="pincode_status" id="is_accept" value="true" @if (!empty($pincodeData->pincode_status) && $pincodeData->pincode_status==true)
                                            checked="checked"
                                         @endif autocomplete="off">
                                            <label class="form-check-label" for="is_accept">Check for accecptable pincode</label>
                                          </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12" id="acceptablePincodeSection">
                                        <div class="form-group">
                                            <label for="acceptable_pincode">Unacceptable Pincode (seperate by coma(,). ex: 4334,5554)</label>
                                            <textarea name="pincode" id="pincode" class="form-control" cols="30" rows="10">@if (!empty($pincodeData->pincode))
                                                {{$pincodeData->pincode}}
                                             @endif</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <input type="submit" value="{{ $title }}" class="btn btn-info btn-lg w-50 mb-3">
                    </div>
                </div>
            </form>
        </section>
        <!-- /.content -->
    </div>
@endsection
