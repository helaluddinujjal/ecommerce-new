@php
    $pages=App\CmsPage::where(['status'=>1,'is_nav'=>0])->orderByRaw('ISNULL(priority),priority ASC')->get();
@endphp
  <!-- Footer -->
  <footer class="text-center text-white" style="background-color: #555">
    <!-- Grid container -->
    <div class="container">
      @if (!$pages->isEmpty())
      <section class="mt-5">
        <!-- Grid row-->
        <div class="row text-center d-flex justify-content-center pt-5">
          <!-- Grid column -->
          @foreach ($pages as $item)
          <div class="col-md-2">
            <h6 class="text-uppercase font-weight-bold">
              <a href="{{$item->url}}" class="text-white">{{$item->title}}</a>
            </h6>
          </div>
          @endforeach
          <!-- Grid column -->
        </div>
        <!-- Grid row-->
      </section>
      <!-- Section: Links -->

      
      @endif
      <!-- Section: Links -->
      <hr class="my-5" />

      <!-- Section: Text -->
      <section class="mb-5">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <h4 class="mb-3">Get the news</h4>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt
              distinctio earum repellat quaerat voluptatibus placeat nam,
              commodi optio pariatur est quia magnam eum harum corrupti
              dicta, aliquam sequi voluptate quas.
            </p>
            <form>
              <div class="input-group">
                <input type="text" class="form-control"><span class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary">Subscribe!</button></span>
              </div>
              <!-- /input-group-->
            </form>
          </div>
        </div>
      </section>
      <!-- Section: Text -->
    
      <!-- Section: Social -->
      <section class="text-center mb-5">
        <h4 class="mb-3">Stay in touch</h4>
        <a href="" class="text-white me-4">
          <i class="fa fa-facebook-f"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fa fa-twitter"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fa fa-google"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fa fa-instagram"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fa fa-linkedin"></i>
        </a>
        <a href="" class="text-white me-4">
          <i class="fa fa-github"></i>
        </a>
      </section>
      <!-- Section: Social -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
      © {{ date('Y') }} Copyright:
      <a class="text-white" href="/"
         >Ecommerce-new.com</a
        >
    </div>
   <!--Start of Tawk.to Script-->
<script type="text/javascript">
  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/634f7492daff0e1306d2be2a/1gfn5uo1b';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();
  </script>
  <!--End of Tawk.to Script-->
    <!-- Copyright -->
  </footer>
  <!-- Footer -->