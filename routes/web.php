<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Section;
use App\Category;
//Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

/*
***********admin
*/
Route::prefix('/admin')->namespace('Admin')->group(function(){
    Route::group(['middleware'=>['admin']],function(){

        Route::get('/dashboard', 'AdminController@dashboard');
        Route::get('/logout', 'AdminController@logout');

        /*
        ************Settings
        */
        Route::post('/check-password', 'AdminController@checkPass');
        Route::post('/update-password', 'AdminController@updatePass');
        Route::match(['get','post'],'/account-settings', 'AdminController@accountSettings');
        Route::match(['get','post'],'/site-settings', 'SettingsController@siteSettings');

        /*
        ************section
        */
        Route::get('/sections', 'SectionController@sections');
        Route::post('/update-status-section', 'SectionController@updateSectionStatus');

        /*
        ************categories
        */
        Route::get('categories','CategoryController@categories');
        Route::post('/update-status-category', 'CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'/category-add-edit/{id?}', 'CategoryController@categoryAddEdit');
        Route::post('/append-category-level', 'CategoryController@appendCategoryStatus');
        Route::post('/check-category-url', 'CategoryController@checkCategoryUrl');
        //Delete category+image
        Route::get('/delete-category-image/{id}','CategoryController@deleteCategoryImage');
        Route::get('/delete-category/{id}','CategoryController@deleteCategory');


        /*
        ************products
        */
        Route::get('products','ProductController@products');
        Route::post('/update-status-product', 'ProductController@updateStatusProduct');
        Route::match(['get','post'],'/add-edit-product/{id?}', 'ProductController@addEditProduct');
        Route::post('/append-product-level', 'ProductController@appendProductStatus');

        //check data
        Route::post('/check-product-url', 'ProductController@checkProductUrl');
        Route::post('/check-product-code', 'ProductController@checkProductCode');
        Route::post('/check-attribute-code', 'ProductController@checkAttributeCode');
        //Delete product+image
        Route::get('/delete-product-image/{id}','ProductController@deleteProductImage');
        Route::get('/delete-product-video/{id}','ProductController@deleteProductVideo');
        Route::get('/delete-product/{id}','ProductController@deleteProduct');

        //Product Attribute
        Route::match(['get','post'],'/add-attribute/{id}', 'ProductController@addAttribute');
        Route::post('/edit-attribute/{id}', 'ProductController@editAttribute');
        Route::post('/update-status-attribute', 'ProductController@updateStatusAttribute');
        Route::get('/delete-attribute/{id}','ProductController@deleteAttribute');
        //Product image
        Route::match(['get','post'],'/add-image/{id}', 'ProductController@addImage');
        Route::post('/update-status-image', 'ProductController@updateStatusImage');
        Route::get('/delete-image/{id}','ProductController@deleteImage');

        /*
        *******BRANDs
        */
        Route::get('brands','BrandController@brands');
        Route::post('/update-status-brand', 'BrandController@updateBrandStatus');
        Route::match(['get','post'],'/add-edit-brand/{id?}', 'BrandController@brandAddEdit');
        Route::get('/delete-brand/{id}', 'BrandController@deleteBrand');
        Route::post('/check-brand-url', 'BrandController@checkBrandUrl');

        /*
        *******Product filters
        */
        Route::get('product-filters','ProductFilterController@productFilters');
        Route::post('/update-status-filter', 'ProductFilterController@updateFilterStatus');
        Route::post('/update-status-filter_value', 'ProductFilterController@updateFilterStatusValue');
        Route::match(['get','post'],'/edit-filter/{id?}', 'ProductFilterController@editFilter');
        Route::get('/delete-filter-value/{id}', 'ProductFilterController@deleteFilterValue');
        Route::post('/check-filter-value', 'ProductFilterController@checkFilterValue');

         /*
        *******Coupns
        */
        Route::get('coupons','CouponController@coupons');
        Route::post('/update-status-coupon', 'CouponController@updateCouponStatus');
        Route::match(['get','post'],'/add-edit-coupon/{id?}', 'CouponController@couponAddEdit');
        Route::get('/delete-coupon/{id}', 'CouponController@deletecoupon');

        /*
        *******Banners
        */
        Route::get('banners','BannerController@banners');
        Route::post('/update-status-banner', 'BannerController@updateBannerStatus');
        Route::match(['get','post'],'/add-edit-banner/{id?}', 'BannerController@bannerAddEdit');
        Route::get('/delete-banner/{id}', 'BannerController@deleteBanner');
        /*
        *******Orders
        */
        Route::get('orders','OrderController@orders');
        Route::get('orders/{id}','OrderController@orderDetails');
        Route::post('/order-status-update', 'OrderController@updateOrderStatus');
        Route::get('/order-invoice/{id}', 'OrderController@orderInvoice');
        Route::get('/order-pdf/{id}', 'OrderController@orderPdf');
        /*
        *******Orders Status
        */
        Route::get('order-statuses','OrderStatusController@orderStatuses');
        Route::post('/update-status-orderstatus','OrderStatusController@updateStatusOrderstatus');
        Route::match(['get','post'],'/add-edit-order-status/{id?}', 'OrderStatusController@addEditOrderStatus');
        Route::get('/delete-order-status/{id}', 'OrderStatusController@deleteorderStatus');

        /*
        *******Delivery
        */
        //delivery charge by country
        Route::get('view-delivery-charges','DeliveryController@viewDeliveryCharges');
        Route::post('/update-status-delivery_charge','DeliveryController@updateStatusDeliveryCharge');
        Route::match(['get','post'],'edit-delivery-charge/{id}','DeliveryController@editDeliveryCharges');
        //delivery charge by weight
        Route::get('view-delivery-charges-by-weight','DeliveryController@viewDeliveryChargesByWeight');
        Route::post('/update-status-delivery_charge_by_weight','DeliveryController@updateStatusDeliveryChargeByWeight');
        Route::match(['get','post'],'edit-delivery-charge-by-weight/{id}','DeliveryController@editDeliveryChargesByWeight');
        Route::get('delete-delivery-weight-value/{id}','DeliveryController@deliveryWeightValueDeleted');
        /*
        *******Datepicker
        */
        Route::match(['get','post'],'datepicker/localpickup','DatepickerSettingsController@localpickupSettings');
        Route::match(['get','post'],'datepicker/delivery-pickup','DatepickerSettingsController@deliverypickupSettings');

        /*
        *******Pincode
        */
        //cod
        Route::get('pincode/cod','PincodeController@pincodeCod');
        Route::post('update-status-pincode_cod','PincodeController@updatePincodeCodStatus');
        Route::match(['get','post'],'pincode/add-edit-cod/{id?}','PincodeController@addEditCod');
        Route::get('delete-pincode-cod/{id}','PincodeController@pincodeCodDeleted');

        //prepaid
        Route::get('pincode/prepaid','PincodeController@pincodePrepaid');
        Route::match(['get','post'],'pincode/add-edit-prepaid/{id?}','PincodeController@addEditPrepaid');
        Route::get('pincode/prepaid','PincodeController@pincodePrepaid');
        Route::post('update-status-pincode_prepaid','PincodeController@updatePincodePrepaidStatus');
        Route::match(['get','post'],'pincode/add-edit-prepaid/{id?}','PincodeController@addEditPrepaid');
        Route::get('delete-pincode-prepaid/{id}','PincodeController@pincodePrepaidDeleted');


         //get state & city date using ajax
        Route::match(['get','post'],'/get-state','PincodeController@getState');
        Route::match(['get','post'],'/get-cities','PincodeController@getCities');
    });
    Route::match(['get','post'],'/', 'AdminController@login');
});

/*
***********frontend
*/

Route::namespace('Frontend')->group(function(){
    Route::get('/','IndexController@index');
    // listing
    $sections=Section::select('url','id')->where('status',1)->get();
    foreach ($sections as $section) {
        Route::match(['get','post'],'/'.$section->url,'ProductController@listing');
        //section
        $catUrls=Category::select('url')->where(['status'=>1,'section_id'=>$section->id])->get()->pluck('url')->toArray();
        foreach ($catUrls as $catUrl) {
            //category
            Route::match(['get','post'],'/'.$section->url.'/'.$catUrl,'ProductController@listing');
        }
    }
    //single product page
    //Route::get('/{section}/{category}/product/{url}', 'ProductController@productDetails')->name('custom_product');
    //  Route::get('/{section}/{category}/product/{url}',['uses'=>'ProductController@productDetails','as'=>'product-details']);
    Route::get('/product/{url}','ProductController@productDetails');
     Route::post('/get-attr-price','ProductController@getAttrPrice');

     //cart
     Route::post('/add-to-cart','ProductController@addToCart');
     Route::get('/cart','ProductController@cart');
     Route::post('/cart-qty-updated','ProductController@cartQtyUpdated');
     Route::post('/cart-item-deleted','ProductController@cartItemDeleted');

     //user registration
     Route::match(['get','post'],'/login','UserController@Login')->name('login');
     Route::match(['get','post'],'/register','UserController@registration');
     Route::get('/logout','UserController@logout');
     Route::match(['get','post'],'/check-user-email','UserController@checkUserEmail');
     Route::match(['get','post'],'/confirm/{code}','UserController@userConfirmEmail');
     Route::match(['get','post'],'/forget-password','UserController@forgetPassword');
     Route::group(['middleware'=>'auth'],function () {
         Route::match(['get','post'],'/my-account','UserController@myAccount');
         Route::match(['get','post'],'/check-password','UserController@checkPassword');
         Route::post('/update-password','UserController@updatePassword');

         //coupon apply
         Route::post('/apply-coupon','ProductController@applyCoupon');

        //checkout
        Route::match(['get','post'],'/checkout','ProductController@checkout');
        Route::get('/delivery-address-deleted/{id}','ProductController@deliveryAddressDeleted');
        Route::post('/get-delivery-charges','ProductController@getDeliveryCharges');
        Route::post('/get-delivery-payment-method-by-pincode','ProductController@getDeliveryPaymentMethodbyPincode');
        Route::post('/delivery-address','ProductController@deliveryAddressFields');
        Route::get('/thanks','ProductController@thanks');

        //paypal
        Route::get('paypal/payment/{id}', 'PaypalController@payment')->name('paypal.checkout');
        Route::get('paypal/cancel/{id}', 'PaypalController@cancel')->name('paypal.cancel');
        Route::get('paypal/success/{id}', 'PaypalController@success')->name('paypal.success');

        //payumoney
        Route::get('payumoney', 'PayUMoneyController@payumoney');
        Route::post('payumoney/response', 'PayUMoneyController@payumoneyResponse');

        //orders
        Route::get('/orders','OrderController@orders');
        Route::get('/orders/{id}','OrderController@orderDetails');

     });

     //get country date using ajax
     Route::match(['get','post'],'/get-state','UserController@getState');
     Route::match(['get','post'],'/get-cities','UserController@getCities');

     //get country by pincode
     Route::post('/get-country-pincode','ProductController@getCountryByPincode');

     //varify payumoney payment by corn job
     Route::get('payumoney/verify/{id?}', 'PayUMoneyController@payumoneyVerify');
});
