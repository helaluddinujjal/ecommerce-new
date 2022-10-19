@extends('layouts.frontend.layouts')
@push('style')
    <!-- Leaflet CSS - For the map-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.css">
@endpush
@section('content')
<div id="all">
    <div id="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <!-- breadcrumb-->
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li aria-current="page" class="breadcrumb-item active">Contact</li>
              </ol>
            </nav>
          </div>
          {{-- sidebar --}}
          @include('layouts.frontend.sidebar')
          <div class="col-lg-9">
            <div id="contact" class="box">
              <h1>Contact</h1>
              <p class="lead">Are you curious about something? Do you have some kind of problem with our products?</p>
              <p>Please feel free to contact us, our customer service center is working for you 24/7.</p>
              <hr>
              <div class="row">
                <div class="col-md-4">
                  <h3><i class="fa fa-map-marker"></i>Address</h3>
                  <p>13/25 New Avenue<br>New Heaven<br>45Y 73J<br>England<br><strong>Great Britain</strong></p>
                </div>
                <!-- /.col-sm-4-->
                <div class="col-md-4">
                  <h3><i class="fa fa-phone"></i> Call center</h3>
                  <p class="text-muted">This number is toll free if calling from Great Britain otherwise we advise you to use the electronic form of communication.</p>
                  <p><strong>+33 555 444 333</strong></p>
                </div>
                <!-- /.col-sm-4-->
                <div class="col-md-4">
                  <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                  <p class="text-muted">Please feel free to write an email to us or to use our electronic ticketing system.</p>
                  <ul>
                    <li><strong><a href="mailto:">info@fakeemail.com</a></strong></li>
                    <li><strong><a href="#">Ticketio</a></strong> - our ticketing support platform</li>
                  </ul>
                </div>
                <!-- /.col-sm-4-->
              </div>
              <!-- /.row-->
              <hr>
              <div id="map" class="leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom" style="position: relative;" tabindex="0"><div class="leaflet-pane leaflet-map-pane" style="transform: translate3d(0px, 0px, 0px);"><div class="leaflet-pane leaflet-tile-pane"><div class="leaflet-layer " style="z-index: 1; opacity: 1;"><div class="leaflet-tile-container leaflet-zoom-animated" style="z-index: 20; transform: translate3d(0px, 0px, 0px) scale(1);"><img alt="" role="presentation" src="https://stamen-tiles-b.a.ssl.fastly.net/toner-lite/13/4282/2663.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(113px, 134px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-c.a.ssl.fastly.net/toner-lite/13/4283/2663.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(369px, 134px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-a.a.ssl.fastly.net/toner-lite/13/4282/2662.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(113px, -122px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-b.a.ssl.fastly.net/toner-lite/13/4283/2662.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(369px, -122px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-c.a.ssl.fastly.net/toner-lite/13/4282/2664.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(113px, 390px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-d.a.ssl.fastly.net/toner-lite/13/4283/2664.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(369px, 390px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-a.a.ssl.fastly.net/toner-lite/13/4281/2663.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-143px, 134px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-d.a.ssl.fastly.net/toner-lite/13/4284/2663.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(625px, 134px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-d.a.ssl.fastly.net/toner-lite/13/4281/2662.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-143px, -122px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-c.a.ssl.fastly.net/toner-lite/13/4284/2662.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(625px, -122px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-b.a.ssl.fastly.net/toner-lite/13/4281/2664.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(-143px, 390px, 0px); opacity: 1;"><img alt="" role="presentation" src="https://stamen-tiles-a.a.ssl.fastly.net/toner-lite/13/4284/2664.png" class="leaflet-tile leaflet-tile-loaded" style="width: 256px; height: 256px; transform: translate3d(625px, 390px, 0px); opacity: 1;"></div></div></div><div class="leaflet-pane leaflet-shadow-pane"></div><div class="leaflet-pane leaflet-overlay-pane"></div><div class="leaflet-pane leaflet-marker-pane"><img src="img/marker.png" class="leaflet-marker-icon leaflet-zoom-animated leaflet-interactive" style="margin-left: -12.5px; margin-top: -18.75px; width: 25px; height: 37.5px; transform: translate3d(382px, 200px, 0px); z-index: 200;" alt="" tabindex="0"></div><div class="leaflet-pane leaflet-tooltip-pane"></div><div class="leaflet-pane leaflet-popup-pane"></div><div class="leaflet-proxy leaflet-zoom-animated"></div></div><div class="leaflet-control-container"><div class="leaflet-top leaflet-left"><div class="leaflet-control-zoom leaflet-bar leaflet-control"><a class="leaflet-control-zoom-in" href="#" title="Zoom in" role="button" aria-label="Zoom in">+</a><a class="leaflet-control-zoom-out" href="#" title="Zoom out" role="button" aria-label="Zoom out">−</a></div></div><div class="leaflet-top leaflet-right"></div><div class="leaflet-bottom leaflet-left"></div><div class="leaflet-bottom leaflet-right"><div class="leaflet-control-attribution leaflet-control"><a href="http://leafletjs.com" title="A JS library for interactive maps">Leaflet</a> | Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> — Map data © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors</div></div></div></div>
              <hr>
              <h2>Contact form</h2>
              <form method="POST" action="{{url('contact')}}"  >
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="firstname">Firstname</label>
                      <input id="firstname" name="firstname" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastname">Lastname</label>
                      <input id="lastname" name="lastname" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input id="email" name="email" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <input id="subject" name="subject" type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea id="message" name="message" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send message</button>
                  </div>
                </div>
                <!-- /.row-->
              </form>
            </div>
          </div>
          <!-- /.col-lg-9-->
        </div>
      </div>
    </div>
  </div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js"> </script>
<script src="https://d19m59y37dris4.cloudfront.net/obaju/2-1-1/js/map.js"></script>
@endpush