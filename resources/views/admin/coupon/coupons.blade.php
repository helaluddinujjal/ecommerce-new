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
          <h1>Coupons</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Coupons</li>
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
              <h3 class="card-title">Coupon List</h3>
              <a href="{{url('admin/add-edit-coupon')}}" class="btn btn-success float-right">Add Coupon</a>
              <div class="mt-5">
                @include('include.session_msg')
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Code</th>
                  <th>Coupon Type</th>
                  <th>Amount</th>
                  <th>Start Date</th>
                  <th>Expiry Date</th>
                  <th>Status</th>
                  <th>Action</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($coupons as $coupon)
                    <tr>
                      <td>{{$coupon->id}}</td>
                      <td>{{$coupon->coupon_code}} </td>
                      <td>{{$coupon->coupon_type}} </td>
                      <td>{{$coupon->amount}} {{$coupon->amount_type=="Percentage"?"%":"$"}} </td>
                      <td>{{$coupon->start_date}} </td>
                      <td>{{$coupon->expiry_date}} </td>
                      <td>
                         <a class="updateStatus" href="javascript:void(0)" id="coupon-{{$coupon->id}}" get_id="{{$coupon->id}}">
                          @if ($coupon->status==1)
                          <i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>
                          @else
                          <i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inctive"></i>
                          @endif
                        </a>
                         </td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a class="btn btn-sm btn-info" href="{{url('admin/add-edit-coupon/'.$coupon->id)}}">Edit</a>
                          <a class="btn btn-sm btn-danger confirm-delete" record="coupon" recorded="{{$coupon->id}}" href="javascript:void(0)">Delete</a>
                        </div>
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