@extends('layouts.admin.layouts')
@push('style-link')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush
@php
    foreach ($usersCountry as $key => $value) {
      $dataPoints[$key]['label']=getCountryName($usersCountry[$key]['country']);
      $dataPoints[$key]['y']=$usersCountry[$key]['total'];
    }
    
@endphp
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users Chart</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Users Chart</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User Country List</h3>
              <div class="mt-5">
                @include('include.session_msg')
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection
@push('script')
<script>
window.onload = function() {
 
 
 var chart = new CanvasJS.Chart("chartContainer", {
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
     dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
   }]
 });
 chart.render();
  
 }
</script>
<script src="{{asset('js/admin/canvas-chart.js')}}"></script>
// <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endpush
