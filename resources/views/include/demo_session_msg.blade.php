@if (Session::has('error_msg'))
<div class="alert alert-danger alert-dismissible fade show" role="alert" style="clear:both">
  <strong>Hey!!!</strong> {{Session::get('error_msg')}}.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if (Session::has('success_msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert" style="clear:both">
  <strong>Hey!!!</strong> {{Session::get('success_msg')}}.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if ($errors->any())
<ul class="list-group mb-2" style="clear:both">
  @foreach ($errors->all() as $error)
    <li class="alert alert-danger alert-dismissible fade show mb-1" role="alert">{{$error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button></li>
  @endforeach
</ul> 
@endif
