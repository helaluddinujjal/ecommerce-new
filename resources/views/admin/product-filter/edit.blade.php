@extends('layouts.admin.layouts')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Product Filters</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/product-filters')}}">Product Filters</a></li>
            <li class="breadcrumb-item active">{{ucwords($productFilterData->name)}} Filters</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/edit-filter',$productFilterData->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-2">

          <div class="mt-3 mb-3">
            @include('include.session_msg')
          </div>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Product Filters</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="row">
                <div class="col-md-10 offset-1">
                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                      <b>Filter Name</b> <a class="float-right">{{ucwords($productFilterData->name)}}</a>
                    </li>
                  </ul>
                  <div class="form-group">
                    <label for="productName">Filter Heading (frontend sidebar)</label>
                    <input type="text" id="productName" class="form-control w-75" name="filter_title" placeholder="Enter Filter Title" @if (!empty($productFilterData->title))
                      value="{{$productFilterData->title}}"  
                    @else
                    value="{{old('filter_title')}}"  
                    @endif>
                  </div>
                  <div class="form-group">
                      <label for="productName">Filter Value</label>
                      <div class="field_wrapper">
                        <input type="hidden" id="productFilter" value="{{$productFilterData->id}}">
                        <div class="value">
                          <input class="filter_value w-75"  type="text" id="filter_value" name="filter_value[]" placeholder="Value"/>
                            <a href="javascript:void(0);" class="add_button" title="Add field"><img src="{{asset('images/icon/add-icon.png')}}"/></a>
                        </div>
                      </div>
                      <p id="result"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="row">
          <div class="col-8 offset-2  text-center">
            <input type="submit" value="Saved" class="btn btn-info btn-lg w-100 mb-3">
          </div>
        </div>
      </form>
  </section>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ucwords($productFilterData->name)}} Filter Values</h3>
          <div class="mt-5">
            @include('include.session_msg')
          </div>
        </div>
        <!-- /.card-header -->
        <form action="{{url('admin/edit-filter',$productFilterData->id)}}" method="post">
          @csrf
          <div class="card-body">
            <table id="product" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>SL</th>
                <th>Value</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @php
                    $filterValues=json_decode($productFilterData->value);
                @endphp
                @foreach ($filterValues as $key=>$value)
                 
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>
                      <a class="updateStatus" href="javascript:void(0)" id="filter_value-{{$key}}" name="value" get_id="{{$productFilterData->id}}-{{$key}}">
                        @if ($value->status==1)
                        <i title="Click to inactive" class="fa fa-toggle-on fa-2x" aria-hidden="true" status="Active"></i>
                        @else
                        <i title="Click to active" class="fa fa-toggle-off fa-2x" aria-hidden="true" status="Inctive"></i>
                        @endif  
                      </a>  
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="Basic example">
                        <a title="Delete Value" class="btn btn-sm btn-danger confirm-delete" record="filter-value" recorded="{{$productFilterData->id}}-{{$key}}" href="javascript:void(0)"><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>  
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.content -->
</div>
@endsection