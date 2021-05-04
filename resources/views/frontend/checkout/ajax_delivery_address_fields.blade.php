
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label for="delivery_first_name">Firstname</label>
            <input id="delivery_first_name" name="delivery_first_name" type="text" class="form-control" placeholder="Input your first name" @if (!empty($delAddDetails->first_name))
                value="{{$delAddDetails->first_name}}"
            @endif>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="delivery_last_name">Lastname</label>
            <input id="delivery_last_name" name="delivery_last_name" type="text" class="form-control" placeholder="Input your last name" @if (!empty($delAddDetails->last_name))
            value="{{$delAddDetails->last_name}}"
        @endif>
            </div>
        </div>
    </div>
    <!-- /.row-->
    <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="delivery_address_1">Address 1</label>
                    <input id="delivery_address_1" name="delivery_address_1" type="text" class="form-control" placeholder="Input your Address" @if (!empty($delAddDetails->address_1))
                    value="{{$delAddDetails->address_1}}"
                @endif>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="delivery_address_2">Address 2</label>
                    <input id="delivery_address_2" name="delivery_address_2" type="text" class="form-control" placeholder="Input your address 2" @if (!empty($delAddDetails->address_2))
                    value="{{$delAddDetails->address_2}}"
                @endif>
                </div>
            </div>
    </div>
  <!-- /.row-->
  <div class="row">
            <div class="col-md-6 col-lg-3" id="countrySection">
                <div class="form-group">
                    <label for="country">Country</label>
                    <select id="country" autocomplete="off" name="delivery_country"  class="form-control deliveryCountry">
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" @if (isset($selectCountry->id)&&!empty($selectCountry->id)&&$selectCountry->id==$country->id)
                                selected="selected"
                            @endif>{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" id="stateSection">
                <div class="form-group">
                    <label for="state">State</label>
                    @if (isset($selectState->id)&&!empty($selectState->id))
                    
                        <select id="state" autocomplete="off" name="delivery_state" class="form-control">
                            @foreach (App\Country::getStates($selectCountry->id) as $state)
                                <option @if ($state->id==$selectState->id)
                                    selected="selected"
                                @endif value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="state" name="delivery_state" value="{{$delAddDetails->state}}"  type="text" class="form-control">
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-3" id="citySection">
                <div class="form-group">
                    <label for="city">City</label>
                    @if (!empty($selectCity))
                        <select id="city" autocomplete="off" name="delivery_city" class="form-control">
                            @foreach (App\Country::getcities($selectState->id) as $city)
                                <option @if ($city->id==$selectCity->id)
                                    selected="selected"
                                @endif value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="city" name="delivery_city" value="{{$delAddDetails->city}}"  type="text" class="form-control">
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-3" id="pincodeSection">
                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input id="pincode" placeholder="Input your pincode" name="delivery_pincode" type="text" class="form-control" @if (!empty($delAddDetails->pincode))
                    value="{{$delAddDetails->pincode}}"
                @endif>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="delivery_mobile">Telephone</label>
                    <div class="input-group">
                        <div class="input-group-addon" id="countryEmoji">
                            @if (!empty($selectCountry->id))
                            @php
                                $flag=App\Country::flag($selectCountry->id);
                            @endphp
                                <i>{{ $flag->emoji}}
                                </i>
                            @endif
                        </div>
                        <input id="delivery_mobile" name="delivery_mobile" placeholder="Input your mobile" type="text" class="form-control" @if (!empty($delAddDetails->mobile))
                        value="{{$delAddDetails->mobile}}"
                    @endif>
                    </div>
                </div>
            </div>
        <!-- /.row-->
    </div>