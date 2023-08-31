
<!doctype html>
<html lang="en">
    <base href="{{ url('/', ["/"]) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css?v=2">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" type="text/css" href="{{ url('css', ['style.css']) }}">
    @livewireStyles
    

    <title>BIO PETSHOP Tanjungpinang</title>
  </head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

      <a class="navbar-brand" href="#">
        <img
              src="images/ps.png"
              alt=""
              width="30"
              height="24"
              class="d-inline-block align-text-top">
              BIO
              <strong>PETSHOP</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item @yield('aberanda')">
            <a class="nav-link" href="{{ url('beranda', []) }}">Beranda <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('akeranjang')" href="{{ url('keranjang', []) }}">Keranjang Belanja
              @if (!(empty(Auth::user()->id)))
                        <small class="badge badge-danger">
                          @php
                              $idku = Auth::user()->id;
                              $keranjangku = DB::table("keranjang")->where("iduser", $idku)->count();
                          @endphp
                          {{ $keranjangku }}
                        </small>
                            
                        @endif
            </a>
          </li>
  
          <li class="nav-item">
            <a class="nav-link @yield('anotifikasi')" href="{{ url('notifikasi', []) }}">Notifikasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @yield('adiskusi')" href="{{ url('diskusi', []) }}">Diskusi</a>
          </li>
          
          <li class="nav-item">
            @if (empty(Auth::user()))
              
              <a href="{{ url('login', []) }}" class="btn btn-outline-success my-2 my-sm-0">LOGIN</a >
            @else
            <form action="{{ route('logout', []) }}" method="post">
              @csrf
              <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
            @endif
          </li>
          
        </ul>
          
      </div>
    </div>
  </nav>


  <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
    <div class="container">

      <a class="navbar-brand" href="#">
        <img
              src="images/coin.webp"
              alt=""
              width="30"
              height="30"
              class="d-inline-block align-text-top">
              POINTKU : 
              <strong>
                @php
                    $point = 0;
                    if (!empty(Auth::user())) {
                      # code...
                      $pointku = DB::table("point")->where("iduser", $idku);
                      if($pointku->count() == 1) {
                        $point = $pointku->first()->point;
                      }
                    }

                    
                @endphp
                Rp{{ number_format($point,0,",",'.') }}
              </strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      
    </div>
  </nav>
  


<div class="container py-3">
    @yield('content')
</div>


<section id="footer">
  <div class="footer1">
      <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-4 kolom-footer">
                <h6 class="text-uppercase fw-bold mb-4">
                    <i class="fas fa-gem me-0 text-grayish"></i>ABOUT US
                </h6>
                <p>
                    BIO PETSHOP adalah sebuah klinik hewan yang menyediakan pelayanan kesehatan dan menjual berbagai produk untuk memenuhi kebutuhan hewan peliharaan.
                </p>
                </div>
                <div class="col-4 kolom-footer">
                <h6 class="text-uppercase fw-bold mb-4">
                     Produk & Pelayanan
                 </h6>
                 <p>
                     Dry Food
                 </p>
                 <p>
                    Wet Food
                </p>
                <p> 
                    Aksesoris
                </p>
                <p>
                    Perawatan
                 </p>
                 <p>
                    Konsultasi
                 </p>
                </div>
                <div class="col-4 kolom-footer">
                <h6 class="text-uppercase fw-bold mb-4">
                    Kontak
                </h6>
                <p><i class="fas fa-home me-3 text-grayish">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                      <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                    </svg>
                </i>

                    WF5G+289, Jl. Damai, Sei Jang, Kec. Bukit Bestari,</p>
                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
</svg><i class="fas fa-phone me-3 text-grayish"></i> +62 822-6866-3400</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
  <footer class="text-center text-white" style="background-color: #0a4275;">
    <!-- Grid container -->
    <div class="container p-2 pb-0">
      <!-- Section: CTA -->
      <section class="">
        <p class="d-flex justify-content-center align-items-center">
          <span class="me-3">Belum punya akun?</span>
          <a class="btn btn-outline-light btn-rounded" href="{{ url('register', []) }}">
            Daftar Disini!
          </a>
        </p>
      </section>
      <!-- Section: CTA -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-1" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-white" href="https://localhost/petshop2022/">BIO PETSHOP Tanjungpinang</a>
    </div>
    <!-- Copyright -->
  </footer>
</section>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
@include('sweetalert::alert')
@yield('script')
@livewireScripts

</body>
</html>
   
 
