<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use Illuminate\Pagination\Paginator;
use App\Product;
use App\Category;
use App\City;
use App\Country;
use App\Coupon;
use App\DatepickerSetting;
use App\DeliveryAddress;
use App\DeliveryCharge;
use App\DeliveyChargeByWeight;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrdersProduct;
use App\PincodeCod;
use App\PincodePrepaid;
use App\ProductAttribute;
use App\ProductView;
use App\SiteSetting;
use App\State;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{


    //listing
    public function listing(Request $request)
    {
        Session::put('filter_velue', 'true');
        Paginator::useBootstrap();
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;

            if (isset($data['sec']) && !empty($data['sec'])) {
                $sec = $data['sec'];
            } else {
                $sec = "";
            }
            if (isset($data['cat']) && !empty($data['cat'])) {
                $cat = $data['cat'];
                $countData = Category::where(['url' => $cat, 'status' => 1])->count();
                $categoryDetails = Category::categoryDetails($sec, $cat);
                $productDetails = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
            } else {
                $cat = '';
                $categoryDetails = '';
                $countData = Section::where(['url' => $sec, 'status' => 1])->count();
                $sectionDetails = Section::where(['url' => $sec, 'status' => 1])->first();
                $productDetails = Product::with('brand')->where('section_id', $sectionDetails->id)->where('status', 1);
            }
            if ($countData) {
                if (isset($data['fabric_filter']) && !empty($data['fabric_filter'])) {
                    $productDetails->whereIn('products.fabric', $data['fabric_filter']);
                }
                if (isset($data['sleeve_filter']) && !empty($data['sleeve_filter'])) {
                    $productDetails->whereIn('products.sleeve', $data['sleeve_filter']);
                }
                if (isset($data['pattern_filter']) && !empty($data['pattern_filter'])) {
                    $productDetails->whereIn('products.pattern', $data['pattern_filter']);
                }
                if (isset($data['fit_filter']) && !empty($data['fit_filter'])) {
                    $productDetails->whereIn('products.fit', $data['fit_filter']);
                }
                if (isset($data['occation_filter']) && !empty($data['occation_filter'])) {
                    $productDetails->whereIn('products.occation', $data['occation_filter']);
                }
                if (isset($data['brand_filter']) && !empty($data['brand_filter'])) {
                    $productDetails->whereIn('products.brand_id', $data['brand_filter']);
                }
                // sorting products
                //echo "<pre>";print_r($productDetails);die;
                // print_r($sort_by);die;
                $sort_by = '';
                if (isset($data['sort_by']) && !empty($data['sort_by'])) {
                    $sort_by = $data['sort_by'];
                    $sort_by_arr = explode("__", $sort_by);
                    $name = $sort_by_arr[0];
                    $value = $sort_by_arr[1];
                    $productDetails = $productDetails->orderBy($name, $value);
                }
                $productDetails = $productDetails->paginate(2);
                return view('frontend/product/ajax_listing')->with(compact('categoryDetails', 'productDetails', 'sec', 'cat', 'sort_by'));
            }
        }
        $getUrl = Route::getFacadeRoot()->current()->uri();
        $getUrl = explode('/', $getUrl);
        $countUrl = count($getUrl);
        $sec = $getUrl[0];
        if ($countUrl > 1) {
            $cat = $getUrl[1];

            $countCategory = Category::where(['url' => $cat, 'status' => 1])->count();
            $categoryDetails = Category::categoryDetails($sec, $cat);
            $productDetails = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
            $productDetails = $productDetails->paginate(2);
            return view('frontend/product/listing')->with(compact('categoryDetails', 'productDetails', 'sec', 'cat'));
        } elseif ($countUrl == 1) {
            $cat = '';
            $categoryDetails = '';
            $sectionDetails = Section::where(['url' => $sec, 'status' => 1])->first();
            $productDetails = Product::with('brand')->where('section_id', $sectionDetails->id)->where('status', 1)->paginate(20);
            return view('frontend/product/listing')->with(compact('sectionDetails', 'categoryDetails', 'productDetails', 'sec', 'cat'));
        } else {
            abort(404);
        }
    }


    //single product page
    public function productDetails($url)
    {
        $productDetails = Product::with(['category', 'section', 'brand', 'attributes' => function ($query) {
            $query->where('status', 1);
        }, 'images'])->where('url', $url)->first();
        //product views
        if ($productDetails->showProduct()) {
            ProductView::createProductViewLog($productDetails);
        } else {
            $productDetails->increment('views');
            ProductView::createProductViewLog($productDetails);
        }
        $lastProductViews = ProductView::select('product_id', 'url')->where('user_id', Auth::id())->orWhere('ip', \Request::getClientIp())->orWhere('session_id', \Request::getSession()->getId())->orderBy('updated_at', 'Desc')->limit(3)->get();
        $relatedProducts = Product::where(['category_id' => $productDetails->category_id, 'section_id' => $productDetails->section_id])->where('id', '!=', $productDetails->id)->inRandomOrder()->limit(3)->get();
        $totalStock = ProductAttribute::where('product_id', $productDetails->id)->sum('stock');
        Session::put('filter_velue', 'false');
        return view('frontend.product.detail')->with(compact('productDetails', 'totalStock', 'relatedProducts', 'lastProductViews'));
    }
    public function getAttrPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $productData = Product::getAttrDiscountPrice($data['productId'], $data['proSize']);
            $currency = settings('site_currency');
            //return $productData;
            return response()->json([
                'productData' => $productData,
                'currency' => $currency,
            ]);
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rule = [
                'size' => 'required',
                'quantity' => 'required|numeric|min:1',
            ];
            $customMsg = [
                'size.required' => "Please select product size",
                'quantity' => "Quantity is required",
                'quantity.numeric' => "Quantity must be numeric",
                'quantity.min' => "Quantity value must be 1 or more",
            ];
            $this->validate($request, $rule, $customMsg);

            $productAttr = ProductAttribute::where(['product_id' => $data['product_id'], 'size' => $data['size']])->first();
            //echo "<pre>"; print_r($productAttr);die;
            if ($productAttr->stock < $data['quantity']) {
                Session::flash('error_msg', 'Required quantity is not available');
                return redirect()->back();
            } else {
                $session_id = Session::get('session_id');
                if (empty($session_id)) {
                    $session_id = request()->getSession()->getId();
                    Session::put('session_id', $session_id);
                }
                if (Auth::check()) {
                    $countCart = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size']])->where(function ($query) use ($session_id) {
                        $query->where('user_id', Auth::user()->id);
                        $query->orWhere('session_id', $session_id);
                    })->count();
                } else {
                    $countCart = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => $session_id])->count();
                }
                if ($countCart > 0) {
                    Session::flash('error_msg', 'Product already exist in cart');
                    return redirect()->back();
                }
                $cart = new Cart();
                $cart->session_id = $session_id;
                $cart->product_id = $data['product_id'];
                $cart->user_id = Auth::check() ? Auth::user()->id : 0;
                $cart->size = $data['size'];
                $cart->weight = $productAttr->weight;
                $cart->quantity = $data['quantity'];
                $cart->save();
                return redirect('/cart');
            }
        }
    }

    public function cart()
    {
        $cartDatas = Cart::userCartItem();
        $relatedProducts = Cart::getCartRelatedProduct($cartDatas);
        return view('frontend.product.cart')->with(compact('cartDatas', 'relatedProducts'));
    }
    public function cartQtyUpdated(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $cartData = Cart::where('id', $data['cartId'])->first();
            $availableStock = ProductAttribute::select('stock')->where(['product_id' => $cartData->product_id, 'size' => $cartData->size])->first();
            if ($availableStock->stock < $data['value']) {
                $cartDatas = Cart::userCartItem();
                return response()->json([
                    'status' => false,
                    'msg' => "Product stock is not available.",
                    'view' => (string)View::make('frontend.product.ajax_cart_table')->with(compact('cartDatas')),
                    'order_summery' => (string)View::make('frontend.product.ajax_order_summery')
                ]);
            }
            $availableSize = ProductAttribute::select('id')->where(['product_id' => $cartData->product_id, 'size' => $cartData->size, 'status' => 1])->count();
            if ($availableSize < 1) {
                Cart::where('id', $data['cartId'])->update(['quantity' => 0]);
                $cartDatas = Cart::userCartItem();
                return response()->json([
                    'status' => false,
                    'msg' => "Opps!!!Product size is not available now.Please delete the item from the cart.",
                    'view' => (string)View::make('frontend.product.ajax_cart_table')->with(compact('cartDatas')),
                    'order_summery' => (string)View::make('frontend.product.ajax_order_summery')
                ]);
            }
            $cart = Cart::where('id', $data['cartId'])->update(['quantity' => $data['value']]);
            $cartDatas = Cart::userCartItem();
            $totalCartItems = totalCartItem();
            return response()->json(['status' => true, 'view' => (string)View::make('frontend.product.ajax_cart_table')->with(compact('cartDatas')), 'totalCartItems' => $totalCartItems, 'order_summery' => (string)View::make('frontend.product.ajax_order_summery')]);
        }
    }
    public function cartItemDeleted(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            Cart::where('id', $data['cartId'])->delete();
            $cartDatas = Cart::userCartItem();
            return response()->json(['msg' => "Cart Item has been deleted.", 'status' => true, 'view' => (string)View::make('frontend.product.ajax_cart_table')->with(compact('cartDatas')), 'order_summery' => (string)View::make('frontend.product.ajax_order_summery')]);
        }
    }

    public function applyCoupon(Request $request)
    {
        if ($request->ajax()) {
            Session::put('coupon_amount', 0);
            Session::put('coupon_code', '');
            $request->coupon_code;
            $checkCoupon = Coupon::where('coupon_code', $request->coupon_code)->count();
            $cartDatas = Cart::userCartItem();
            $totalCartItems = totalCartItem();

            //check coupon code valid or invaalid
            if ($checkCoupon < 1) {
                return response()->json([
                    'status' => 'false',
                    'msg' => "This coupon code is not valid",
                    'totalCartItems' => $totalCartItems,
                    'couponAmount' => 0,
                    'view' => (string)view('frontend.product.ajax_cart_table', compact('cartDatas')),
                    'order_summery' => (string)View::make('frontend.product.ajax_order_summery')
                ]);
            } else {
                //check coupon code start date
                $couponData = Coupon::where('coupon_code', $request->coupon_code)->first();
                $todayDate = date("Y-m-d");
                if (strtotime($todayDate) < strtotime($couponData->start_date)) {
                    $msg = "This coupon code will activate from " . $couponData->start_date;
                }
                //check coupon code expired date
                if (strtotime($todayDate) > strtotime($couponData->expiry_date)) {
                    $msg = "This coupon code is expired.";
                }

                //check coupon code single or multiple time uses
                if ($couponData->coupon_type == "Single") {
                    $orderCount = Order::where(['coupon_code' => $request->coupon_code, 'user_id' => Auth::user()->id])->count();
                    if ($orderCount >= 1) {
                        $msg = "This coupon code is already availed by you.";
                    }
                }
                $userCartDatas = Cart::userCartItem();
                //get categories where coupon code allow
                if (!empty($couponData->categories)) {
                    $catIds = explode(',', $couponData->categories);
                }
                //get users include  for coupon code
                if (!empty($couponData->users)) {
                    $catEmails = explode(',', $couponData->users);
                    foreach ($catEmails as $email) {
                        $getUserId = User::select('id')->where('email', $email)->first();
                        if (!empty($getUserId)) {
                            $userIds[] = $getUserId->id;
                        } else {
                            $userIds[] = [];
                        }
                    }
                }

                $totalAmount = 0;
                //check alowable category to product
                foreach ($userCartDatas as  $item) {
                    if (!empty($couponData->categories)) {
                        if (!in_array($item->product->category_id, $catIds)) {
                            $msg = "This coupon code is not for one of the selected products";
                        }
                    }
                    //check user are alowable to coupon
                    if (!empty($couponData->users)) {
                        if (!in_array($item->user_id, $userIds)) {
                            $msg = "This coupon code is not for you";
                        }
                    }
                    $attrPrice = Cart::getProductAttrPrice($item->product_id, $item->size);
                    $totalAmount = $totalAmount + ($attrPrice * $item->quantity);
                }
                if (isset($msg)) {
                    return response()->json([
                        'status' => 'false',
                        'msg' => $msg,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => 0,
                        'view' => (string)view('frontend.product.ajax_cart_table', compact('cartDatas')),
                        'order_summery' => (string)View::make('frontend.product.ajax_order_summery')
                    ]);
                } else {
                    //coupon code successfully apply
                    if ($couponData->amount_type == "Percentage") {
                        $couponAmount = $totalAmount * ($couponData->amount / 100);
                    } else {
                        $couponAmount = $couponData->amount;
                    }
                    Session::put('coupon_amount', $couponAmount);
                    Session::put('coupon_code', $request->coupon_code);
                    $msg = "Coupon code successfully applied. You are availing discount.";
                    return response()->json([
                        'status' => 'true',
                        'msg' => $msg,
                        'totalCartItems' => $totalCartItems,
                        'couponAmount' => $couponAmount,
                        'view' => (string)view('frontend.product.ajax_cart_table', compact('cartDatas')),
                        'order_summery' => (string)View::make('frontend.product.ajax_order_summery')
                    ]);
                }
            }
        }
    }

    public function checkout(Request $request)
    {
        $userDetails = User::where('id', Auth::user()->id)->first();
        if ($request->isMethod('post')) {

            //website secuirity

            $cartItems = Cart::userCartItem();
            foreach ($cartItems as $key => $cart) {
                //product status check and remove from cart
                $getProductStatus=Product::getProductStatus($cart->product_id);
                if($getProductStatus==0){
                   // Product::deleteCartProduct($cart->product_id);
                    Session::flash('error_msg', $cart->product->product_name.' Product is not available.So remove from cart and try again');
                    return redirect("/cart");
                }

                //product stock check and remove from cart
                $getProductStock=Product::getProductStock($cart->product_id,$cart->size);
                if($getProductStock==0){
                   // Product::deleteCartProduct($cart->product_id);

                  Session::flash('error_msg', $cart->product->product_name.' Product is out of stock.So remove from cart and try again');
                    return redirect("/cart");
                }

                //product attribute stock check and remove from cart
                $getAttributeStock=Product::getAttributeCount($cart->product_id,$cart->size);
                if($getAttributeStock==0){
                   // Product::deleteCartProduct($cart->product_id);
                    Session::flash('error_msg', $cart->product->product_name.' Product attribute is out of stock.So remove from cart and try again');
                    return redirect("/cart");
                }
                //prevemt disable category product to checkout
                $getCategoryStatus=Product::getCategoryStatus($cart->product->category_id);
                if($getCategoryStatus==0){
                   // Product::deleteCartProduct($cart->product_id);
                    Session::flash('error_msg', $cart->product->product_name.' Product category is disable.So remove from cart and try again');
                    return redirect("/cart");
                }
                //prevent disable brand product to checkout
                $getBrandStatus=Product::getBrandStatus($cart->product->brand_id);
                if($getBrandStatus==0){
                   // Product::deleteCartProduct($cart->product_id);
                    Session::flash('error_msg', $cart->product->product_name.' Product brand is disable.So remove from cart and try again');
                    return redirect("/cart");
                }
            }
            $rules = [
                "billing_first_name" => "required",
                "billing_last_name" => "required",
                "billing_address_1" => "required",
                "billing_country" => "required",
                "billing_state" => "required",
                "billing_city" => "required",
                "billing_pincode" => "required",
                "billing_mobile" => "required",
                "billing_email" => "required",
                "delivery_method" => "required|in:Flat Rate,Local Pickup",
                "payment_gatway" => "required|in:Paypal,Payumoney,COD",
            ];
            if ($request->check_to_different_address) {
                $rules['delivery_first_name'] = 'required';
                $rules['delivery_last_name'] = 'required';
                $rules['delivery_address_1'] = 'required';
                $rules['delivery_country'] = 'required';
                $rules['delivery_state'] = 'required';
                $rules['delivery_city'] = 'required';
                $rules['delivery_pincode'] = 'required';
                $rules['delivery_mobile'] = 'required';
                $rules['delivery_pickup_dateTime'] = 'required';
            }
            $this->validate($request, $rules);
            $data = $request->all();
            $ch_country = null;
            $ch_pincode = null;
            if ($request->check_to_different_address) {
                $ch_country = $data['delivery_country'];
                $ch_pincode = $data['delivery_pincode'];
                //get country name
                $deliveryCountryName = getCountryName($data['delivery_country']);
                if ($deliveryCountryName == false) {
                    toast('Invalid Delivery Country', 'error');
                    return redirect()->back();
                } else {
                    $data['delivery_country'] = $deliveryCountryName;
                }
                $deliveryStateName = getStateName($data['delivery_state']);
                if ($deliveryStateName == false) {
                    toast('Invalid Delivery State Name', 'error');
                    return redirect()->back();
                } else {
                    $data['delivery_state'] = $deliveryStateName;
                }
                $deliveryCityName = getCityName($data['delivery_city']);
                if ($deliveryCityName == false) {
                    toast('Invalid Delivery City Name', 'error');
                    return redirect()->back();
                } else {
                    $data['delivery_city'] = $deliveryCityName;
                }
            }else{
                $ch_country = $data['billing_country'];
                $ch_pincode = $data['billing_pincode'];
            }
            $billingCountryName = getCountryName($data['billing_country']);
            if ($billingCountryName == false) {
                toast('Invalid Billing Country', 'error');
                return redirect()->back();
            } else {
                $data['billing_country'] = $billingCountryName;
            }
            //get state name

            $billingStateName = getStateName($data['billing_state']);
            if ($billingStateName == false) {
                toast('Invalid Billing State Name', 'error');
                return redirect()->back();
            } else {
                $data['billing_state'] = $billingStateName;
            }
            //get city name

            $billingCityName = getCityName($data['billing_city']);
            if ($billingCityName == false) {
                toast('Invalid Billing City Name', 'error');
                return redirect()->back();
            } else {
                $data['billing_city'] = $billingStateName;
            }
            //check payment get way
            if ($data['payment_gatway'] == "COD") {
                $paymentMethod = "COD";
                $orderStatus = 'New';
            } else {
                $paymentMethod = "Prepaid";
                $orderStatus = 'Pending';
            }

            //check delivery or pickup date time
            //check holiday
            if ($data["delivery_method"] == "Local Pickup") {
                $datepickerSettings = DatepickerSetting::find(1);
                $title = "Local pickup";
            } else {
                $datepickerSettings = DatepickerSetting::find(2);
                $title = "Delivery";
            }
            if (!empty($datepickerSettings->timezone)) {
                date_default_timezone_set($datepickerSettings->timezone);
            } else {
                date_default_timezone_set('Europe/Berlin');
            }

            $today = date('Y-m-d');
            $delivery_localpickupDate = date('Y-m-d', strtotime($data['delivery_pickup_dateTime']));

            //check time
            if (!empty($datepickerSettings->timeFieldShow) && $datepickerSettings->timeFieldShow == 1) {
                if (!empty($datepickerSettings->cutOffDay) && $datepickerSettings->cutOffDay == 1) {
                    $next_date = date('Y-m-d', strtotime($today . ' +1 day'));
                    if ($next_date == $delivery_localpickupDate) {
                        $delivery_time = date('H:i', strtotime($data['delivery_pickup_dateTime']));
                        $nowHour = date('H:i');
                        if ($delivery_time < $nowHour) {
                            toast('Please change the ' . $title . ' time.your selected time is over', 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    if ($today == $delivery_localpickupDate) {
                        $delivery_time = date('H:i', strtotime($data['delivery_pickup_dateTime']));
                        $nowHour = date('H:i');
                        if ($delivery_time < $nowHour) {
                            toast('Please change the ' . $title . ' time.your selected time is over', 'error');
                            return redirect()->back();
                        }
                    }
                }
            }

            //if date become previous day

            if ($today > $delivery_localpickupDate) {
                toast('Please do not select previous date from datepicker.Please change the ' . $title . ' date.', 'error');
                return redirect()->back();
            }
            //chaking select time is before open shop time
            if (!empty($datepickerSettings->shopOpenTime) && $datepickerSettings->timeFieldShow == 1) {
                $shopOpen = $datepickerSettings->shopOpenTime;
                $selectTime = date('H:i', strtotime($data['delivery_pickup_dateTime']));
                if ($selectTime < $shopOpen) {
                    toast('Shop Opening hour is' . $shopOpen . '.Please change the ' . $title . ' Time.', 'error');
                    return redirect()->back();
                }
            }
            //chaking closing shop time
            if (!empty($datepickerSettings->shopCloseTime)) {
                $nowHour = date('H:i');
                $date = date('Y-m-d');
                $shopClose = $datepickerSettings->shopCloseTime;

                //check select time is after closing time
                if ($datepickerSettings->timeFieldShow == 1) {
                    $selectTime = date('H:i', strtotime($data['delivery_pickup_dateTime']));
                    if ($selectTime > $shopClose) {
                        toast('It is shop closing hour.Please change the ' . $title . ' Time.', 'error');
                        return redirect()->back();
                    }
                }
                //chaking closing shop time
                if (!empty($datepickerSettings->cutOffDay) && $datepickerSettings->cutOffDay == 1) {
                    if ($nowHour > $shopClose) {
                        $deliveryDate = date('Y-m-d', strtotime($data['delivery_pickup_dateTime']));
                        $next_date = date('Y-m-d', strtotime($date . ' +2 day'));
                        if ($deliveryDate < $next_date) {
                            toast('Shop is closed.Please change the ' . $title . ' date.', 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    if ($nowHour > $shopClose) {
                        $deliveryDate = date('Y-m-d', strtotime($data['delivery_pickup_dateTime']));
                        $next_date = date('Y-m-d', strtotime($date . ' +1 day'));
                        if ($deliveryDate < $next_date) {
                            toast('Shop is closed.Please change the ' . $title . ' date.', 'error');
                            return redirect()->back();
                        }
                    }
                }
            }
            //if date become weekend
            if (!empty($datepickerSettings->weekend) || $datepickerSettings->weekend === "0") {

                $delivery_pickupDay = date('N', strtotime($data['delivery_pickup_dateTime']));

                if (strpos($datepickerSettings->weekend, $delivery_pickupDay) !== false) {
                    toast('It is Weekend Time.Please change the ' . $title . ' date.', 'error');
                    return redirect()->back();
                }
            }
            //if date become holiday
            if (!empty($datepickerSettings->holiday)) {

                $delivery_pickupDate = date('Y-m-d', strtotime($data['delivery_pickup_dateTime']));
                if (strpos($datepickerSettings->holiday, $delivery_pickupDate) !== false) {
                    toast('It is holiday Time.Please change the ' . $title . ' date.', 'error');
                    return redirect()->back();
                }
            }

            //final time input in database
            if ($datepickerSettings->timeFieldShow == 1) {
                $inputDateTime = date('d-m-Y h:i A', strtotime($data['delivery_pickup_dateTime']));
            } else {
                $inputDateTime = date('d-m-Y', strtotime($data['delivery_pickup_dateTime']));
            }

            //deliveryCharges
            if ($data["delivery_method"] == "Flat Rate") {
                if ($request->check_to_different_address) {
                    $deliveryCharge = DeliveryCharge::deliveryCharges($data['delivery_country']);
                } else {
                    $deliveryCharge = DeliveryCharge::deliveryCharges($data['billing_country']);
                }
                if ($deliveryCharge === false) {
                    $msg = "Delivery is not available in your country.";
                    toast($msg, 'error');
                    return redirect()->back();
                } else {
                    $deliveryCharges = $deliveryCharge['delivery_charges'];
                }


                 // pincode check for prepaid
            if ($data['payment_gatway'] == "Paypal"||$data['payment_gatway'] == "Payumoney") {
                $checkPrepaidPin = PincodePrepaid::where(['country_id' => $ch_country, "status" => 1])->first();
                if (!empty($checkPrepaidPin)) {
                    if (!empty($checkPrepaidPin->pincode)) {
                        $pincode = explode(",", $checkPrepaidPin->pincode);
                        if (!in_array($ch_pincode, $pincode)) {
                            $msg = "Prepaid Delivery is not available in your pincode.";
                            toast($msg, 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    $msg = "Prepaid Delivery is not available in your pincode.";
                    toast($msg, 'error');
                    return redirect()->back();
                }
            }
               // pincode check for prepaid
               if ($data['payment_gatway'] == "COD") {
           // return $ch_country;
             $checkPrepaidPin = PincodeCod::where(['country_id' => $ch_country, "status" => 1])->first();
                if (!empty($checkPrepaidPin)) {
                    if (!empty($checkPrepaidPin->pincode)) {
                        $pincode = explode(",", $checkPrepaidPin->pincode);
                        if (!in_array($ch_pincode, $pincode)) {
                            $msg = "Cash on Delivery is not available in your pincode.";
                            toast($msg, 'error');
                            return redirect()->back();
                        }
                    }
                } else {
                    $msg = "Cash on Delivery is not available in your pincode.";
                    toast($msg, 'error');
                    return redirect()->back();
                }
            }
            } else {
                $deliveryCharges = 0;
            }

            Session::put("payTatal", (Session::get('grandTotal') + $deliveryCharges));
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = Auth::user()->id;
            $order->billing_first_name = $data['billing_first_name'];
            $order->billing_last_name = $data['billing_last_name'];
            $order->billing_address_1 = $data['billing_address_1'];
            $order->billing_address_2 = $data['billing_address_2'];
            $order->billing_country = $data['billing_country'];
            $order->billing_state = $data['billing_state'];
            $order->billing_city = $data['billing_city'];
            $order->billing_pincode = $data['billing_pincode'];
            $order->billing_mobile = $data['billing_mobile'];
            $order->billing_email = $data['billing_email'];
            $order->delivery_method = $data["delivery_method"];
            $order->delivery_charges = $deliveryCharges;
            $order->coupon_code = Session::get('coupon_code');
            $order->coupon_amount = Session::get('coupon_amount');
            $order->order_status = $orderStatus;
            $order->payment_method = $paymentMethod;
            $order->payment_gateway = $data['payment_gatway'];
            $order->delivery_pickup_dateTime = $inputDateTime;
            $order->currency = settings('site_currency');
            $order->total = !empty($deliveryCharges) ? Session::get('grandTotal') + $deliveryCharges : Session::get('grandTotal');
            if ($data["delivery_method"] == "Flat Rate") {
                if ($request->check_to_different_address) {
                    $order->delivery_first_name = $data['delivery_first_name'];
                    $order->delivery_last_name = $data['delivery_last_name'];
                    $order->delivery_address_1 = $data['delivery_address_1'];
                    $order->delivery_address_2 = $data['delivery_address_2'];
                    $order->delivery_country = $data['delivery_country'];
                    $order->delivery_state = $data['delivery_state'];
                    $order->delivery_city = $data['delivery_city'];
                    $order->delivery_pincode = $data['delivery_pincode'];
                    $order->delivery_mobile = $data['delivery_mobile'];
                } else {
                    $order->delivery_first_name = $data['billing_first_name'];
                    $order->delivery_last_name = $data['billing_last_name'];
                    $order->delivery_address_1 = $data['billing_address_1'];
                    $order->delivery_address_2 = $data['billing_address_2'];
                    $order->delivery_country = $data['billing_country'];
                    $order->delivery_state = $data['billing_state'];
                    $order->delivery_city = $data['billing_city'];
                    $order->delivery_pincode = $data['billing_pincode'];
                    $order->delivery_mobile = $data['billing_mobile'];
                }
            } else {
                $order->delivery_first_name = '';
                $order->delivery_last_name = '';
                $order->delivery_address_1 = '';
                $order->delivery_address_2 = '';
                $order->delivery_country = '';
                $order->delivery_state = '';
                $order->delivery_city = '';
                $order->delivery_pincode = '';
                $order->delivery_mobile = '';
            }
            $order->save();
            $orderId = DB::getPdo()->lastInsertId();
            $orderId = $order->id;
            if ($order->delivery_first_name != '') {
                $delivery = DeliveryAddress::updateOrCreate(['first_name' => $order->delivery_first_name, 'address_1' => $order->delivery_address_1, 'mobile' => $order->delivery_mobile], [
                    'user_id' => Auth::user()->id,
                    'first_name' => $order->delivery_first_name,
                    'last_name' => $order->delivery_last_name,
                    'address_1' => $order->delivery_address_1,
                    'address_2' => $order->delivery_address_2,
                    'country' => $order->delivery_country,
                    'state' => $order->delivery_state,
                    'city' => $order->delivery_city,
                    'pincode' => $order->delivery_pincode,
                    'mobile' => $order->delivery_mobile,
                ]);
            }
            $cartDatas = Cart::where('user_id', Auth::user()->id)->get();
            foreach ($cartDatas as  $cart) {
                $orderPro = new OrdersProduct();
                $orderPro->order_id = $orderId;
                $orderPro->user_id = Auth::user()->id;
                $orderPro->product_id = $cart->product_id;
                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $cart->product_id)->first();
                $orderPro->product_name = $getProductDetails->product_name;
                $orderPro->product_code = $getProductDetails->product_code;
                $orderPro->product_color = $getProductDetails->product_color;
                $orderPro->product_size = $cart->size;
                $getAttrDiscountPrice = Product::getAttrDiscountPrice($cart->product_id, $cart->size);
                $orderPro->product_unit_price = $getAttrDiscountPrice['attr_price'];
                $orderPro->product_discount_price = $getAttrDiscountPrice['final_price'];
                $orderPro->product_qty = $cart->quantity;
                $orderPro->save();

                //update stock
                if ($data['payment_gatway'] == "COD") {
                    Product::reduceStock($cart->product_id, $cart->size, $cart->quantity);
                }
            }
            Session::put('orderId', $orderId);
            DB::commit();
            if ($data['payment_gatway'] == "COD") {

                $msg = "Your order [order_id] has been successfully placed with Laravel Project.We will intimate you once your order is shipped";
                $msg = str_replace("[order_id]", $orderId, $msg);
                $email = Auth::user()->email;
                $name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
                $orderDetails = Order::with('order_products')->where('id', $orderId)->first();
                $msgData = [
                    'msg' => $msg,
                    'name' => $name,
                    'order_id' => $orderId,
                    'orderDetails' => $orderDetails,
                ];
                $subject = "Order Placed-" . config('app.name');;
                Mail::send('mail.order', $msgData, function ($message) use ($email, $subject, $name) {
                    $message->to($email, $name)->subject($subject);
                });
                toast("Order has been completed !!", 'success');
                return redirect('thanks');
            } else if ($data['payment_gatway'] == "Paypal") {
                return redirect('paypal/payment/' . $orderId);
            } else if ($data['payment_gatway'] == "Payumoney") {
                return redirect('payumoney');
            }
        }
        $localPickupSettings = DatepickerSetting::find(1);
        $deliveryPickupSettings = DatepickerSetting::find(2);
        $deliveryAddDetails = DeliveryAddress::where('user_id', Auth::user()->id)->get();
        //check delivery charge type
        if (settings('delivery_charge_type') == "Country") {
            $deliveryChargesCountry = DeliveryCharge::select('country')->where('status', 1)->get()->toArray();
        } else {
            $deliveryChargesCountry = DeliveyChargeByWeight::select('country')->where('status', 1)->get()->toArray();
        }

        $deliveryCountries = Country::select('id', 'name')->whereIn('name', $deliveryChargesCountry)->get();
        $countries = Country::select('id', 'name')->get();
        $cartDatas = Cart::userCartItem();
        return view('frontend.checkout.checkouts')->with(compact('userDetails', 'deliveryCountries', 'countries', 'deliveryAddDetails', 'cartDatas', 'localPickupSettings', 'deliveryPickupSettings'));
    }

    public function thanks()
    {
        if (!empty(Session::get('orderId'))) {
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('frontend.checkout.thanks');
        } else {
            return redirect('cart');
        }
    }
    public function deliveryAddressDeleted($id)
    {
        $check = DeliveryAddress::where(["user_id" => Auth::user()->id, 'id' => $id])->count();
        //return $check;

        if ($check == 1) {
            DeliveryAddress::where(["user_id" => Auth::user()->id, 'id' => $id])->delete();
            $msg = "item has been deleted";
            toast($msg, "success");
        } else {
            $msg = "Something wrong!! Please try later. ";
            toast($msg, "error");
        }

        return redirect()->back();
    }
    public function deliveryAddressFields(Request $request)
    {
        if ($request->ajax()) {
            $check = DeliveryAddress::where(["user_id" => Auth::user()->id, 'id' => $request->del_add_id])->count();
            //return $check;

            if ($check == 1) {
                $delAddDetails = DeliveryAddress::where(["user_id" => Auth::user()->id, 'id' => $request->del_add_id])->first();
                $selectCountry = Country::select('id')->where('name', $delAddDetails->country)->first();


                if (isset($selectCountry->id) && !empty($selectCountry->id)) {
                    $selectState = State::select('id')->where(['country_id' => $selectCountry->id, 'name' => $delAddDetails->state])->first();
                } else {
                    $selectState = "";
                }
                if (isset($selectState->id) && !empty($selectState->id)) {
                    $selectCity = City::select('id')->where(['state_id' => $selectState->id, 'name' => $delAddDetails->city])->first();
                } else {
                    $selectCity = "";
                }
                $status = "true";
            } else {
                $delAddDetails = "";
                $status = "false";
                $selectCountry = "";
                $selectState = "";
                $selectCity = "";
            }
            $deliveryChargesCountry = DeliveryCharge::select('country')->where('status', 1)->get()->toArray();
            $deliveryCountries = Country::select('id', 'name')->whereIn('name', $deliveryChargesCountry)->get();
            $countries = Country::select('id', 'name')->get();
            return response()->json(['status' => $status, "view" => (string)view('frontend.checkout.ajax_delivery_address_fields')->with(compact('delAddDetails', 'deliveryCountries', 'selectCountry', 'selectState', 'selectCity'))]);
        }
    }

    //delivery charges
    public function getDeliveryCharges(Request $request)
    {
        if ($request->ajax()) {
            $deliveryCharge = DeliveryCharge::deliveryCharges($request->country);
            if ($deliveryCharge === false) {
                $msg = "Delivery is not available in your country.";
                return response()->json(['msg' => $msg, "view" => (string)view('frontend.product.ajax_order_summery')->with(compact('msg',))]);
            } else if ($deliveryCharge == "empty") {
                return response()->json(["view" => (string)view('frontend.product.ajax_order_summery')]);
            } else {
                return response()->json(["view" => (string)view('frontend.product.ajax_order_summery')->with(compact('deliveryCharge',))]);
            }
        }
    }

    //delivery charges
    public function getDeliveryPaymentMethodbyPincode(Request $request)
    {
        if ($request->ajax()) {
            $deliveryCharge = DeliveryCharge::deliveryCharges($request->country);
            if ($deliveryCharge === false) {
                $msg = "Delivery is not available in your country.";
                return response()->json(['msg' => $msg, "view" => (string)view('frontend.product.ajax_order_summery')->with(compact('msg',))]);
            } else if ($deliveryCharge == "empty") {
                return response()->json(["view" => (string)view('frontend.product.ajax_order_summery')]);
            } else {
                return response()->json(["view" => (string)view('frontend.product.ajax_order_summery')->with(compact('deliveryCharge',))]);
            }
        }
    }
    //getCountryByPincode
    public function getCountryByPincode(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if (!empty($data['country']) && !empty($data['pincode']) && !empty($data['ch_pin'])) {
                if ($data['ch_pin'] == "ch_cod") {
                    $checkCodPin = PincodeCod::where(['country_id' => $data['country'], "status" => 1])->first();
                    if (!empty($checkCodPin)) {
                        if (!empty($checkCodPin->pincode)) {
                            $pincode = explode(",", $checkCodPin->pincode);
                            if (in_array($data['pincode'], $pincode)) {
                                $status = true;
                                $msg = "Pincode is available in your country for cash on delivary.";
                            } else {
                                $status = false;
                                $msg = "Pincode is not available in your country for cash on delivary";
                            }
                        }
                    } else {
                        $status = false;
                        $msg = "Delivery is not available in your pincode.";
                    }
                    return response()->json([
                        'status' => $status,
                        'msg' => $msg,
                    ]);
                } else {
                    $checkPrepaidPin = PincodePrepaid::where(['country_id' => $data['country'], "status" => 1])->first();
                    if (!empty($checkPrepaidPin)) {
                        if (!empty($checkPrepaidPin->pincode)) {
                            $pincode = explode(",", $checkPrepaidPin->pincode);
                            if (in_array($data['pincode'], $pincode)) {
                                $status = true;
                                $msg = "Pincode is available in your country for prepaid delivary.";
                            } else {
                                $status = false;
                                $msg = "Pincode is not available in your country for prepaid delivary";
                            }
                        }
                    } else {
                        $status = false;
                        $msg = "Delivery is not available in your pincode.";
                    }
                    return response()->json([
                        'status' => $status,
                        'msg' => $msg,
                    ]);
                }
            } else {
                $settings = SiteSetting::first();
                if (isset($settings->delivery_charge_type) && $settings->delivery_charge_type == "Country") {
                    $deliveryCharge = DeliveryCharge::where(["id" => $data['country'], "status" => 1])->count();
                    if ($deliveryCharge > 0) {
                        $status = true;
                        $msg = "Delivery is available in your country.";
                    } else {
                        $status = false;
                        $msg = "Delivery is not available in your country.";
                    }
                    return response()->json([
                        'status' => $status,
                        'msg' => $msg,
                    ]);
                } else {
                    $deliveryCharge = DeliveyChargeByWeight::where(["id" => $data['country'], "status" => 1])->count();
                    if ($deliveryCharge > 0) {
                        $status = true;
                        $msg = "Delivery is available in your country.";
                    } else {
                        $status = false;
                        $msg = "Delivery is not available in your country.";
                    }
                    return response()->json([
                        'status' => $status,
                        'msg' => $msg,
                    ]);
                }
            }
        }
    }
}
