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
          <h1>Products</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
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
              <h3 class="card-title">Products List</h3>
              <a href="{{url('admin/add-edit-product')}}" class="btn btn-success float-right">Add Product</a>
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
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Category</th>
                  <th>Section</th>
                  <th>Image</th>
                  <th>Status</th>
                  <th>Action</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($products as $product)
                   
                    <tr>
                      <td>{{$product->id}}</td>
                      <td>{{$product->product_name}}</td>
                      <td>{{$product->product_code}}</td>
                      <td>{{$product->product_color}}</td>
                      <td>{{$product->category->category_name}}</td>
                      <td>{{$product->section->name}}</td>
                      <td>
                        @php
                            $image_path=public_path('images/product/small/'.$product->main_image);
                        @endphp
                        @if (!empty($product->main_image)&&file_exists($image_path))
                            <img width="100" src="{{asset('images/product/small/'.$product->main_image)}}" alt="{{$product->product_name}}">
                        @else
                            <img width="100" src="{{asset('images/demo/demo-small.jpeg')}}" alt="{{$product->product_name}}">
                        @endif
                      </td>
                      <td>
                        <a class="updateStatus" href="javascript:void(0)" id="product-{{$product->id}}" name="product" get_id="{{$product->id}}">
                          @if ($product->status==1)
                          <i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>
                          @else
                          <i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inctive"></i>
                          @endif  
                        </a></td>
                      <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                          <a title="Add/Edit Attribute" class="btn btn-sm btn-success" href="{{url('admin/add-attribute/'.$product->id)}}"><i class="fas fa-plus-square"></i></a>
                          <a title="Add/Edit Image" class="btn btn-sm btn-warning" href="{{url('admin/add-image/'.$product->id)}}"><i class="fas fa-image"></i></a>
                          <a title="Edit Product" class="btn btn-sm btn-info" href="{{url('admin/add-edit-product/'.$product->id)}}"><i class="fas fa-edit"></i></a>
                          <a title="Delete Product" class="btn btn-sm btn-danger confirm-delete" record="product" recorded="{{$product->id}}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
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