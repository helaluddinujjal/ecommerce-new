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
          <h1>Product Attributes</h1>
          <div class="mt-3">
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/products')}}">Product</a></li>
            <li class="breadcrumb-item active">Products Attributes</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/add-attribute',$productData->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Attribute</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-md-8">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Product Name</b> <a class="float-right">{{$productData->product_name}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Code</b> <a class="float-right">{{$productData->product_code}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Color</b> <a class="float-right">{{$productData->product_color}}</a>
                    </li>
                    <li class="list-group-item">
                      <b>Product Price</b> <a class="float-right">{{settings('site_currency')}}{{$productData->product_price}}</a>
                    </li>
                  </ul>
                    <div class="field_wrapper">
                      <input type="hidden" id="productData" value="{{$productData->id}}">
                      <div class="attribute">
                        <input title="Input Product Attribute Size" class="attr_size"  type="text" id="size" name="size[]" placeholder="Size" required/>
                        <input title="Input Product Attribute SKU" class="attr_sku" type="text" id="sku" name="sku[]" placeholder="SKU" required/>
                        <input title="Input Product Attribute Price" type="number" id="price" name="price[]" placeholder="Price({{settings('site_currency')}})" step="any" min=".1" required/>
                        <input title="Input Product Attribute Stock" type="number" id="stock" name="stock[]" placeholder="Stock" required min="0"/>
                        <input title="Input Product Attribute Weight in (gram)" type="number" id="weight" name="weight[]" placeholder="Weight(g)" required step="any" min=".1"/>
                          <a href="javascript:void(0);" class="add_button" title="Add field"><img src="{{asset('images/icon/add-icon.png')}}"/></a>
                        </div>
                      </div>
                      <p id="result"></p>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    @if (!empty($productData->main_image))
                    <div class="form-group mt-2 text-center"> 
                      <img width="200" src="{{asset('images/product/small/'.$productData->main_image)}}" alt="{{$productData->product_name}}"> 
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="Create product Attribute" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Products Attribute List</h3>
          <div class="mt-5">
            @include('include.session_msg')
          </div>
        </div>
        <!-- /.card-header -->
        <form action="{{url('admin/edit-attribute',$productData->id)}}" method="post">
          @csrf
          <div class="card-body">
            <table id="datatable" class="table table-bordered table-striped display responsive nowrap">
              <thead>
              <tr>
                <th>ID</th>
                <th>Size</th>
                <th>SKU</th>
                <th>Price({{settings('site_currency')}})</th>
                <th>Stock</th>
                <th>Weight(g)</th>
                <th>Status</th>
                <th>Action</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
                @foreach ($productData->attributes as $attribute)
                
                  <tr>
                    <td>{{$attribute->id}} <input type="hidden" name="attrId[]" value="{{$attribute->id}}"></td>
                    <td>{{$attribute->size}}</td>
                    <td>{{$attribute->sku}}</td>
                    <td><input class="form-control" type="number" type="any" name="price[]" value="{{$attribute->price}}" required step="any" min=".1"></td>
                    <td><input class="form-control" type="number" name="stock[]" value="{{$attribute->stock}}" required min="0"></td>
                    <td><input class="form-control" type="number" name="weight[]" value="{{$attribute->weight}}" required step="any" min=".1"></td>
                    <td>
                      <a class="updateStatus" href="javascript:void(0)" id="attribute-{{$attribute->id}}" name="attribute" get_id="{{$attribute->id}}">
                        @if ($attribute->status==1)
                        <i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>
                        @else
                        <i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inctive"></i>
                        @endif  
                      </a> 
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <a title="Delete Attribute" class="btn btn-sm btn-danger confirm-delete" record="attribute" recorded="{{$attribute->id}}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                    <td></td>
                  </tr>  
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-center">
            <input type="submit" value="Update product Attribute" class="btn btn-success btn-lg w-50 mb-3">
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
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