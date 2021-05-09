<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="{{asset('images/admin/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

    <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">

        @if (!empty(Auth::guard('admin')->user()->image))
          <img src="{{asset('images/admin/profile/'.Auth::guard('admin')->user()->image)}}" class="img-circle elevation-2" alt="User Image">        
        @else
          <img src="{{asset('images/admin/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">              
        @endif
      </div>
      <div class="info">
        <a href="#" class="d-block">{{Auth::guard('admin')->user()->name}}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>
    <!-- Sidebar Menu -->

    {{-- dashboard --}}
    @php
        if (Session::get('page')=='dashboard') {
          $active='active';
        } else {
          $active='';
        }
    @endphp
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{url('admin/dashboard')}}" class="nav-link {{$active}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        {{-- settings --}}
        @php
          if (Session::get('page')=='admin-account-settings' ||Session::get('page')=='admin-site-settings') {
            $active='menu-is-opening menu-open';
          } else {
            $active='';
          }
        @endphp
        <li class="nav-item has-treeview {{$active}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Settings
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          @php
            if (Session::get('page')=='admin-account-settings') {
              $active='active';
            } else {
              $active='';
            }
          @endphp
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('admin/account-settings')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Profile Settings</p>
              </a>
            </li>
            {{-- site settings --}}
            @php  
            if (Session::get('page')=='admin-site-settings') {
                $active='active';
              } else {
                $active='';
              }
          @endphp
          <li class="nav-item">
            <a href="{{url('admin/site-settings')}}" class="nav-link {{$active}}">
              <i class="far fa-circle nav-icon"></i>
              <p>Site Settings </p>
            </a>
          </li>
          </ul>
        </li>
          {{-- Catalogues --}}
          @php
          if (Session::get('page')=='admin-section' ||Session::get('page')=='admin-category'||Session::get('page')=='admin-brand'||Session::get('page')=='admin-filter'||Session::get('page')=='admin-coupon'||Session::get('page')=='admin-order'||Session::get('page')=='admin-order-status') {
            $active='menu-is-opening menu-open';
          } else {
            $active='';
          }
          @endphp
        <li class="nav-item has-treeview {{$active}}">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-columns"></i>
            <p>
              Catalogues
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          @php
            if (Session::get('page')=='admin-section') {
              $active='active';
            } else {
              $active='';
            }
          @endphp
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('admin/sections')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Sections</p>
              </a>
            </li>
            @php
              if(Session::get('page')=='admin-brand') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/brands')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Brands</p>
              </a>
            </li>
            @php  
              if (Session::get('page')=='admin-category') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/categories')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            @php  
              if (Session::get('page')=='admin-filter') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/product-filters')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Product Filters</p>
              </a>
            </li>
            @php  
              if (Session::get('page')=='admin-coupon') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/coupons')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Coupons</p>
              </a>
            </li>
            @php  
              if (Session::get('page')=='admin-order') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/orders')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Orders</p>
              </a>
            </li>
            @php  
              if (Session::get('page')=='admin-order-status') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/order-statuses')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Order Statuses</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Product Menu -->
        @php
        if (Session::get('page')=='admin-product') {
          $active='active';
        } else {
          $active='';
        }
        @endphp
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{url('admin/products')}}" class="nav-link {{$active}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Products
            </p>
          </a>
        </li>
        <!-- Banner Menu -->
        @php
          if (Session::get('page')=='admin-banner') {
            $active='active';
          } else {
            $active='';
          }
        @endphp
        <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{url('admin/banners')}}" class="nav-link {{$active}}">
            <i class="nav-icon fas fa-images"></i>
            <p>
              Banners
            </p>
          </a>
        </li>
          {{-- Datepicker --}}
          @php
          if (Session::get('page')=='admin-datepicker-localpickup' ||Session::get('page')=='admin-datepicker-delivery-pickup') {
            $active='menu-is-opening menu-open';
          } else {
            $active='';
          }
        @endphp
        <li class="nav-item has-treeview {{$active}}">
          <a href="#" class="nav-link">
            <i class="far fa-calendar-alt"></i>
            <p>
              Datepickers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
              @php  
              if (Session::get('page')=='admin-datepicker-localpickup') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/datepicker/localpickup')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Local Pickup Settings </p>
              </a>
            </li>
              @php  
              if (Session::get('page')=='admin-datepicker-delivery-pickup') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/datepicker/delivery-pickup')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Pickup Settings </p>
              </a>
            </li>
          </ul>
        </li>
          {{-- Delivery Charges --}}
          @php
          if (Session::get('page')=='admin-delivery-charges' ||Session::get('page')=='admin-delivery-charges-by-weight') {
            $active='menu-is-opening menu-open';
          } else {
            $active='';
          }
        @endphp
        <li class="nav-item has-treeview {{$active}}">
          <a href="#" class="nav-link">
            <i class="fas fa-shipping-fast"></i>
            <p>
              Delivery Charges
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
              @php  
              if (Session::get('page')=='admin-delivery-charges') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/view-delivery-charges')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Charges By Country </p>
              </a>
            </li>
              @php  
              if (Session::get('page')=='admin-delivery-charges-by-weight') {
                  $active='active';
                } else {
                  $active='';
                }
            @endphp
            <li class="nav-item">
              <a href="{{url('admin/view-delivery-charges-by-weight')}}" class="nav-link {{$active}}">
                <i class="far fa-circle nav-icon"></i>
                <p>Delivery Charges By Weight </p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-circle nav-icon"></i>
            <p>Level 1</p>
          </a>
        </li>
        <li class="nav-header">LABELS</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-circle text-danger"></i>
            <p class="text">Important</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-circle text-warning"></i>
            <p>Warning</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
    <!-- /.sidebar -->
</aside>