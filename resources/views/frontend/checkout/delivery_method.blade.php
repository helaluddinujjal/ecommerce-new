<div class="content py-3" id="delivery-address" style="display:none ">
    <div class="row">
      <div class="col-md-6">
        <div class="box shipping-method">
          <h4>Local Pickup</h4>
          <p>You will collect product from shop.In local pickup charge will 0.</p>
          <div class="box-footer text-center">
            <input type="radio" autocomplete="off" class="delivery_method" name="delivery_method" value="Local Pickup">
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box shipping-method">
          <h4>Delivery(Flat Rate)</h4>
          <p>You will get product at your home.Charge applicable according to your location.</p>
          <div class="box-footer text-center">
            <input type="radio" autocomplete="off" class="delivery_method" name="delivery_method" value="Flat Rate">
          </div>
        </div>
      </div>
    </div>
    {{-- local pickup date time  --}}
    <div class="row" id="local_pick_date" style="display:none">
        <div class="col-md-12">
            <div class="form-group">
            <label for="delivery_first_name">Date and Time Select</label> <br>
            <input id="local_pickup_date_time" name="delivery_pickup_dateTime" type="text" class="form-control" placeholder="Select date and time for pickup" value="" readonly>
            </div>
        </div>
    </div>
    <div id="delivery_method_content" style="display: none">
      <div class="row">
        <div class="col-md-12">
          <div class="form-check">
            <input class="form-check-input" autocomplete="off" type="checkbox" id="check_to_different_address" name="check_to_different_address">
            <label class="form-check-label" for="check_to_different_address">
              Ship to a different address
            </label>
          </div>
        </div>
      </div>
      <div id="diff_address_fields" style="display: none">
            <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                            <tbody>
                                <tr><td colspan="5"><h4>Your previous delivery addresses:</h4></td></tr>
                                @foreach ($deliveryAddDetails as $addDetails)
                                <tr>
                                    <td><input type="radio" onClick="deliveryCharges('{{$addDetails->country}}');" autocomplete="off" name="deliveryAdd" data="{{$addDetails->id}}" class="deliveryAdd"></td>
                                    <td>
                                    <label><strong> Name:</strong><span>{{$addDetails->first_name}}</span></label>
                                    <label><strong>Last Name:</strong><span>{{$addDetails->last_name}}</span> </label>
                                    <label><strong>Address 1:</strong><span>{{$addDetails->address_1}}</span> </label>
                                    <label><strong>Address 2:</strong><span>{{$addDetails->address_2}}</span> </label>
                                    <label><strong>Country:</strong><span>{{$addDetails->country}}</span> </label>
                                    <label><strong>State:</strong><span>{{$addDetails->state}}</span> </label>
                                    <label><strong>City:</strong><span>{{$addDetails->city}}</span> </label>
                                    <label><strong>Pincode:</strong><span>{{$addDetails->pincode}}</span> </label>
                                    <label><strong>Mobile:</strong><span>{{$addDetails->mobile}}</span> </label>
                                    </td>
                                    <td>
                                    <a href="javascript:void(0)" class="deleteDeliveryAddress" data="{{$addDetails->id}}"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div id="ajax_del_add_field_data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="delivery_first_name">Firstname</label>
                        <input id="delivery_first_name" name="delivery_first_name" type="text" class="form-control" placeholder="Input your first name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="delivery_last_name">Lastname</label>
                        <input id="delivery_last_name" name="delivery_last_name" type="text" class="form-control" placeholder="Input your last name">
                        </div>
                    </div>
                </div>
                <!-- /.row-->
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_address_1">Address 1</label>
                                <input id="delivery_address_1" name="delivery_address_1" type="text" class="form-control" placeholder="Input your Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_address_2">Address 2</label>
                                <input id="delivery_address_2" name="delivery_address_2" type="text" class="form-control" placeholder="Input your address 2">
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
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" id="stateSection">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select id="state" name="delivery_state" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" id="citySection">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select id="city" name="delivery_city" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3" id="pincodeSection">
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input id="pincode" placeholder="Input your pincode" name="delivery_pincode" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="delivery_mobile">Telephone</label>
                                <div class="input-group">
                                    <div class="input-group-addon" id="countryEmoji">
                                    
                                    </div>
                                    <input id="delivery_mobile" name="delivery_mobile" placeholder="Input your mobile" type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    <!-- /.row-->
                </div>
            </div>
        </div>
    </div>
</div>