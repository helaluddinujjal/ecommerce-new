    @if (Session::has('error_msg'))
       
       <ul id="error_msg_show" class="list-group mb-2 d-none note-style" style="clear:both">
          <br>
          <p> {{Session::get('error_msg')}}</p>
          </ul>
    @endif
    @if (Session::has('success_msg'))
        <ul id="success_msg_show" class="list-group mb-2 d-none note-style" style="clear:both">
          <br>
          <p> {{Session::get('success_msg')}}</p>
          </ul>
    @endif
    @if (Session::has('warning_msg'))
        <ul id="warning_msg_show" class="list-group mb-2 d-none note-style" style="clear:both">
          <br>
          <p> {{Session::get('warning_msg')}}</p>
          </ul>
    @endif
    @if (Session::has('confirm_msg'))
        <ul id="confirm_msg_show" class="list-group mb-2 d-none note-style" style="clear:both">
          <br>
          <p> {{Session::get('confirm_msg')}}</p>
          </ul>
    @endif
    @if ($errors->any())
        <ul id="errors_msg_show" class="list-group mb-2 d-none note-style" style="clear:both">
          @foreach ($errors->all() as $error)
            <li class="list-group-item">{{$error}}</li>
          @endforeach
        </ul> 
    @endif

    @push('script')
        <script>
           //display laravel error
          $(document).ready(function(){
            var has_errors={{$errors->count()>0?'true':'false'}}
          if (has_errors) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              showConfirmButton: true,
              html:jQuery('#errors_msg_show').html(),
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              },
            }) 
          }
            var has_success={{Session::has('success_msg')?'true':'false'}}
          if (has_success) {
            Swal.fire({
              icon: 'success',
              showConfirmButton: true,
              html:jQuery('#success_msg_show').html(),
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              },
            }) 
          }
            var has_warning={{Session::has('warning_msg')?'true':'false'}}
          if (has_warning) {
            Swal.fire({
              icon: 'warning',
              showConfirmButton: true,
              html:jQuery('#warning_msg_show').html(),
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              },
            }) 
          }
            var has_error={{Session::has('error_msg')?'true':'false'}}
          if (has_error) {
            Swal.fire({
              icon: 'error',
              showConfirmButton: true,
              html:jQuery('#error_msg_show').html(),
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              },
            }) 
          }
            var has_confirm={{Session::has('confirm_msg')?'true':'false'}}
          if (has_confirm) {
            Swal.fire({
              icon: 'success',
              showConfirmButton: true,
              html:jQuery('#confirm_msg_show').html(),
              showClass: {
                popup: 'animate__animated animate__fadeInDown'
              },
              hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
              },
            }) 
          }
        })
      </script>
    @endpush