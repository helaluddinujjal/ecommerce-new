@extends('layouts.admin.layouts')
@push('style-link')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Catalogues</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Orders</li>
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
              <h3 class="card-title">Order List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped display responsive nowrap">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Order Date</th>
                  <th>Customer Name</th>
                  <th>Customer Email</th>
                  <th>Orderd Products</th>
                  <th>Order Amount</th>
                  <th>Order Status</th>
                  <th>Delivery Method</th>
                  <th>Delivery/Pickup Date</th>
                  <th>Payment Method</th>
                  <th>Action</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>
                        <td>{{date('d-m-Y',strtotime($order->created_at))}}</td>
                        <td>{{$order->user->first_name}} {{$order->user->last_name}}</td>
                        <td>{{$order->user->email}}</td>
                        <td>
                            @if (!empty($order->order_products))
                            @foreach ($order->order_products as $product)
                            {{$product->product_code}} <br>
                            @endforeach  
                        @endif    
                        </td>
                        <td> {{$order->currency.$order->total}}</td>
                        <td><span class="badge badge-info">{{$order->order_status}}</span></td>
                        <td> {{$order->delivery_method}}</td>
                        <td>
                          @if ($order->delivery_method=="Local Pickup")
                          {{date('d-m-Y h:i A',strtotime($order->delivery_pickup_dateTime))}} 
                          @else
                             {{date('d-m-Y',strtotime($order->delivery_pickup_dateTime))}} 
                          @endif  
                        </td>
                        <td> {{$order->payment_method}}</td>
                        <td>
                          <a href="{{url('admin/orders/'.$order->id)}}" title="View" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                          @if ($order->order_status=="Shipped"||$order->order_status=="Delivered")
                            <a href="{{url('admin/order-invoice/'.$order->id)}}" title="Click to invoice" class="btn btn-info btn-sm"><i class="fas fa-file-invoice"></i></a>
                          @endif
                        </td>
                        <td></td>
                    </tr>  
                  @endforeach
                </tbody>
              </table>
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
    <!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
{{-- <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> --}}
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>

<script>
  $(function () {
    $("#datatable").DataTable({
      "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"],
      responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   -1
        } ],
        order: [ 1, 'asc' ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  
  });

</script>
@endpush