<div class="content py-3" id="billing-address">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="billing_first_name">Firstname</label>
          <input id="billing_first_name" name="billing_first_name" type="text" class="form-control" value="{{!empty($userDetails->first_name)?$userDetails->first_name:''}}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="billing_last_name">Lastname</label>
          <input id="billing_last_name" name="billing_last_name" type="text" class="form-control" value="{{!empty($userDetails->last_name)?$userDetails->last_name:''}}">
        </div>
      </div>
    </div>
    <!-- /.row-->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="billing_address_1">Address 1</label>
          <input id="billing_address_1" name="billing_address_1" type="text" class="form-control" value="{{!empty($userDetails->address_1)?$userDetails->address_1:''}}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="billing_address_2">Address 2</label>
          <input id="billing_address_2" name="billing_address_2" type="text" class="form-control" value="{{!empty($userDetails->address_2)?$userDetails->address_2:''}}">
        </div>
      </div>
    </div>
    <!-- /.row-->
    <div class="row">
        <div class="col-md-6 col-lg-3" id="countrySection">
          <div class="form-group">
            <label for="country">Country</label>
              <select id="country" autocomplete="off" name="billing_country" value="{{!empty($userDetails->country)?$userDetails->country:''}}" class="form-control billingCountry">
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
                  <input id="state" name="billing_state" value="{{$userDetails->state}}"  type="text" class="form-control">
              @else
                  <select id="state" autocomplete="off" name="billing_state" class="form-control deliveryCity">
                      @foreach (App\Country::getStates($userDetails->country) as $state)
                          <option @if ($state->id==$userDetails->state)
                              selected="selected"
                          @endif value="{{$state->id}}">{{$state->name}}</option>
                      @endforeach
                  </select>
              @endif
            @else
              <select id="state" name="billing_state" class="form-control deliveryCity"></select>
            @endif
          </div>
        </div>
        <div class="col-md-6 col-lg-3" id="citySection">
            <div class="form-group">
                <label for="city">City</label>
                @if (!empty($userDetails->city))
                    @if (!is_numeric($userDetails->city))
                        <input id="city" name="billing_city" value="{{$userDetails->city}}"  type="text" class="form-control">
                    @else
                        <select id="city" autocomplete="off" name="billing_city" class="form-control deliveryCity">
                            @foreach (App\Country::getcities($userDetails->state) as $city)
                                <option @if ($city->id==$userDetails->city)
                                    selected="selected"
                                @endif value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    @endif
                @else
                    <select id="city" name="billing_city" class="form-control deliveryCity"></select>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-lg-3" id="pincodeSection">
          <div class="form-group">
            <label for="pincode">Pincode</label>
            <input id="pincode" name="billing_pincode" value="{{!empty($userDetails->pincode)?$userDetails->pincode:''}}"  type="text" class="form-control billingPincode">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="billing_mobile">Telephone</label>
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
              <input id="billing_mobile" name="billing_mobile" value="{{!empty($userDetails->mobile)?$userDetails->mobile:''}}"  type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="billing_email">Email</label>
            <input id="billing_email" name="billing_email" type="text" class="form-control" value="{{$userDetails->email}}">
          </div>
        </div>
    </div>
    <!-- /.row-->
  </div>
