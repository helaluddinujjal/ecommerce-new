@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$data['totalOrder']}}</h3>

                <p>Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$data['totalEarn']}}<sup style="font-size: 20px">{{get_currency_code()}}</sup></h3>

                <p>Total Earn</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$data['totalUser']}}</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{url('admin/users')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$data['totalPendingOrder']}}</h3>

                <p>Pending Order</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
       <div class="row mt-5">
        <div class="col-lg-12">
          <div id="regUser" style="height: 370px; width: 100%;"></div>
        </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@php
    foreach ($data['usersCountry'] as $key => $value) {
      $regUserdata[$key]['label']=getCountryName($data['usersCountry'][$key]['country']);
      $regUserdata[$key]['y']=$data['usersCountry'][$key]['total'];
    }
    
@endphp
@push('script')
<script>
window.onload = function() {
 
 
 var regUser = new CanvasJS.Chart("regUser", {
   animationEnabled: true,
   title: {
     text: "Register Users"
   },
   subtitles: [{
     text: new Date()
   }],
   data: [{
     type: "pie",
     yValueFormatString: "#,##0\" User\"",
     indexLabel: "{label} ({y})",
     dataPoints: <?php echo json_encode($regUserdata, JSON_NUMERIC_CHECK); ?>
   }]
 });
 regUser.render();
  
 }
</script>
<script src="{{asset('js/admin/canvas-chart.js')}}"></script>
// <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endpush