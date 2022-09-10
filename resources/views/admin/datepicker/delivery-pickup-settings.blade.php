@extends('layouts.admin.layouts')
@push('style')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css"/>
<link rel="stylesheet" href="https://cdn.rawgit.com/dubrox/Multiple-Dates-Picker-for-jQuery-UI/master/jquery-ui.multidatespicker.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endpush
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Datepicker-Delivery Pickup</h1>
          <div class="mt-3"> 
            @include('include.session_msg')
          </div>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">Datepicker-Delivery Pickup</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form action="{{url('admin/datepicker/delivery-pickup')}}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Delivery Pickup Settings</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="display: block;">
              <div class="form-group">
                <label for="timezone">Timezone</label>
                <select name="timezone" id="timezone"  class="form-control">
                  <option value="">Select a timezone</option>
                  <option value="Asia/Dhaka" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Asia/Dhaka"?"selected":''}}>Bangladesh(Dhaka)</option>
                  <option value="Europe/Berlin" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Europe/Berlin"?"selected":''}}>Germany(Berlin)</option>
                  <option value="Europe/London" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Europe/London"?"selected":''}}>Uk(London)</option>
                  <option value="Europe/Paris" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Europe/Paris"?"selected":''}}>France(Paris)</option>
                  <option value="Europe/Rome" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Europe/Rome"?"selected":''}}>Itally(Rome)</option>
                  <option value="Europe/Amsterdam" {{!empty($datepickerSetting->timezone)&&$datepickerSetting->timezone=="Europe/Amsterdam"?"selected":''}}>Netherlands(Amsterdam)</option>
                </select>
              </div>
              <div class="form-group">
                <label for="holiday">Holiday</label>
                <input type="text" name="holiday" id="holiday" readonly="true" placeholder="yyyy-mm-dd" class="form-control" value="{{!empty($datepickerSetting->holiday)?$datepickerSetting->holiday:''}}">
              </div>
              <div class="form-group">
                <label for="weekend">Weekend</label>
                @php
                if (!empty($datepickerSetting) && !empty($datepickerSetting->weekend)) {
                  $weekend=explode(',',$datepickerSetting->weekend);
                }
                if (!empty($datepickerSetting) && $datepickerSetting->weekend==='0') {
                  $weekend=explode(',',$datepickerSetting->weekend);
                }
                @endphp
                <select class="select2 form-control" name="weekend[]" multiple="multiple" data-placeholder="Select Weeked" id="weekend">
                  <option value="0" {{!empty($weekend)&& in_array(0,$weekend)?"selected":''}}>Sunday</option>
                  <option value="1" {{!empty($weekend)&&in_array(1,$weekend)?"selected":''}}>Monday</option>
                  <option value="2" {{!empty($weekend)&&in_array(2,$weekend)?"selected":''}}>Tuesday</option>
                  <option value="3" {{!empty($weekend)&&in_array(3,$weekend)?"selected":''}}>Wednesday</option>
                  <option value="4" {{!empty($weekend)&&in_array(4,$weekend)?"selected":''}}>Thursday</option>
                  <option value="5" {{!empty($weekend)&&in_array(5,$weekend)?"selected":''}}>Friday</option>
                  <option value="6" {{!empty($weekend)&&in_array(6,$weekend)?"selected":''}}>Saturday</option>
                </select>
              </div>
              <div class="form-group">
                <label for="cutOffDay">Cut Off day </label>
                <select class="select2 form-control" name="cutOffDay" data-placeholder="Select Cut off Day" id="cutOffDay">
                  <option value="">Select cut off day</option>
                  <option value="0" {{!empty($datepickerSetting) &&((!empty($datepickerSetting->cutOffDay) ||$datepickerSetting->cutOffDay==='0')&&$datepickerSetting->cutOffDay==0)?"selected":''}}>Present Day</option>
                  <option value="1" {{!empty($datepickerSetting->cutOffDay)&&$datepickerSetting->cutOffDay==1?"selected":''}}>Next Day</option>
                </select>
              </div>
              <div class="form-group">
                <label for="timeFieldShow">Time Show/Hide</label>
                <select class="select2 form-control" name="timeFieldShow" data-placeholder="Select show or hide" id="timeFieldShow">
                  <option value="0">Hide</option>
                  <option value="1" {{!empty($datepickerSetting->timeFieldShow)&&$datepickerSetting->timeFieldShow==1?"selected":''}}>Show</option>
                </select>
              </div>
              <div class="form-check mt-3 mb-3">
                <input class="form-check-input" name="shopAlwaysOpen" type="checkbox" value="1" id="shopAlwaysOpen" {{!empty($datepickerSetting->shopOpenTime)&&!empty($datepickerSetting->shopCloseTime)?"":'checked'}}>
                <label class="form-check-label" for="shopAlwaysOpen">
                  Shop Always Open
                </label>
              </div>
              <div class="form-group shopAlwaysOpenField" style="display: none">
                <label for="shopOpenTime">Shop Open Hour</label>
                <input type="text" name="shopOpenTime" class="form-control" id="shopOpenTime" placeholder="Click for open time " readonly value="{{!empty($datepickerSetting->shopOpenTime)?$datepickerSetting->shopOpenTime:''}}">
              </div>
              <div class="form-group shopAlwaysOpenField" style="display: none">
                <label for="shopCloseTime">Shop Close Hour</label>
                <input type="text" name="shopCloseTime" class="form-control" id="shopCloseTime" placeholder="Click for Close time " readonly value="{{!empty($datepickerSetting->shopCloseTime)?$datepickerSetting->shopCloseTime:''}}">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <input type="submit" value="Save" class="btn btn-info btn-lg w-50 mb-3">
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
@endsection

@push('script')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-multidatespicker/1.6.6/jquery-ui.multidatespicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
  $('#holiday').multiDatesPicker({
    dateFormat: 'yy-mm-dd'
  });


  $('#shopOpenTime,#shopCloseTime,#shopBreakTimeStart,#shopBreakTimeEnd').timepicker({
      timeFormat: 'HH:mm',
      interval: 60,
      dynamic: true,
      dropdown: true,
      scrollbar: true
  });

  if ($('#shopAlwaysOpen').prop('checked')) {
    $(".shopAlwaysOpenField").hide();
  }else{
    $(".shopAlwaysOpenField").show();
  }
  $('#shopAlwaysOpen').click(function(){
    if ($('#shopAlwaysOpen').prop('checked')) {
    $(".shopAlwaysOpenField").slideUp();
    }else{
      $(".shopAlwaysOpenField").slideDown();
    }
  })
</script>
@endpush