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
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li aria-current="page" class="breadcrumb-item active">My account</li>
              </ol>
            </nav>
          </div>
          @include('layouts.frontend.customer-sidebar')
          <div class="col-lg-9">
            <div class="box">
              <h1>My account</h1>
              <p class="lead">Change your personal details or your password here.</p>
              <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
              <h3>Change password</h3>
              <form action="{{url('update-password')}}" method="POST" id="userPassword">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password_old">Old password</label>
                      <input id="password_old" name="password_old" type="password" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password_new">New password</label>
                      <input id="password_new" name="password_new" type="password" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password_confirm">Retype new password</label>
                      <input id="password_confirm" name="password_confirm" type="password" class="form-control">
                    </div>
                  </div>
                </div>
                <!-- /.row-->
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                </div>
              </form>
              <h3 class="mt-5">Personal details</h3>
              <form action="{{url('my-account')}}" method="POST" id="userAccount">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input id="first_name" name="first_name" value="{{!empty($userDetails->first_name)?$userDetails->first_name:''}}" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input id="last_name" name="last_name" value="{{!empty($userDetails->last_name)?$userDetails->last_name:''}}" type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <!-- /.row-->
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address_1">Address 1</label>
                      <input id="address_1" name="address_1" value="{{!empty($userDetails->address_1)?$userDetails->address_1:''}}" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="address_2">Address 2</label>
                      <input id="address_2" name="address_2" value="{{!empty($userDetails->address_2)?$userDetails->address_2:''}}" type="text" class="form-control">
                    </div>
                  </div>
                </div>
                <!-- /.row-->
                <div class="row">
                    <div class="col-md-6 col-lg-3" id="countrySection">
                        <div class="form-group">
                          <label for="country">Country</label>
                            <select id="country" autocomplete="off" name="country" value="{{!empty($userDetails->country)?$userDetails->country:''}}" class="form-control">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option @if (!empty($userDetails->country)&&$country->id==$userDetails->country)
                                        selected="selected"
                                    @endif value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3" id="stateSection">
                    <div class="form-group">
                      <label for="state">State</label>
                      @if (!empty($userDetails->state))
                        @if (!is_numeric($userDetails->state))
                            <input id="state" name="state" value="{{$userDetails->state}}"  type="text" class="form-control">
                        @else
                            <select id="state" autocomplete="off" name="state" class="form-control">
                                @foreach (App\Country::getStates($userDetails->country) as $state)
                                    <option @if ($state->id==$userDetails->state)
                                        selected="selected"
                                    @endif value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            </select>
                        @endif
                      @else
                        <select id="state" name="state" class="form-control"></select>
                      @endif
                    </div>
                  </div>
                    <div class="col-md-6 col-lg-3" id="citySection">
                        <div class="form-group">
                            <label for="city">City</label>
                            @if (!empty($userDetails->city))
                                @if (!is_numeric($userDetails->city))
                                    <input id="city" name="city" value="{{$userDetails->city}}"  type="text" class="form-control">
                                @else
                                    <select id="city" autocomplete="off" name="city" class="form-control">
                                        @foreach (App\Country::getcities($userDetails->state) as $city)
                                            <option @if ($city->id==$userDetails->city)
                                                selected="selected"
                                            @endif value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @else
                                <select id="city" name="city" class="form-control"></select>
                            @endif
                        </div>
                    </div>
                  <div class="col-md-6 col-lg-3" id="pincodeSection">
                    <div class="form-group">
                      <label for="pincode">Pincode</label>
                      <input id="pincode" name="pincode" value="{{!empty($userDetails->pincode)?$userDetails->pincode:''}}"  type="text" class="form-control">
                    </div>
                  </div>
                 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Telephone</label>
                      <div class="input-group">
                        <div class="input-group-addon" id="countryEmoji">
                          @if (!empty($userDetails->country))
                          @php
                              $flag=App\Country::flag($userDetails->country);
                          @endphp
                              <i>{{ $flag->emoji}}
                              </i>
                          @endif
                        </div>
                        <input id="phone" name="mobile" value="{{!empty($userDetails->mobile)?$userDetails->mobile:''}}"  type="text" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" disabled="disabled" value="{{$userDetails->email}}" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script src="{{asset('js/frontend/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/frontend/custom.jquery.validate.js')}}"></script>
@endpush