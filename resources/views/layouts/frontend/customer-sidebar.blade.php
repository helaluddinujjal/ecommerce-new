<div class="col-lg-3">
    <!--
    *** CUSTOMER MENU ***
    _________________________________________________________
    -->
    <div class="card sidebar-menu">
        <div class="card-header">
        <h3 class="h4 card-title">Customer section</h3>
        </div>
        <div class="card-body">
        <ul class="nav nav-pills flex-column"><a href="{{url('/orders')}}" class="nav-link {{ (request()->is('orders*')) ? 'active' : '' }}"><i class="fa fa-list"></i> My orders</a><a href="{{url('orders')}}" class="nav-link"><i class="fa fa-heart"></i> My wishlist</a><a href="{{url('my-account')}}" class="nav-link {{ (request()->is('my-account')) ? 'active' : '' }}"><i class="fa fa-user"></i> My account</a><a href="i{{url('my-account')}}" class="nav-link"><i class="fa fa-sign-out"></i> Logout</a></ul>
        </div>
    </div>
    <!-- /.col-lg-3-->
    <!-- *** CUSTOMER MENU END ***-->
</div>