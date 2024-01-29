<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">


  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
 

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
        <main class="py-4">
<div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4 ">
              <a href="index.html" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
              </a>
            </div>
            <!-- End Logo -->
    
    

            <div class="card mb-3">

              <div class="card-body login-form">
                <div id="login_alert"></div>
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <p class="text-center small">Enter your username & password to login</p>
                </div>
           {{-- Login Message --}}
           @if(session()->has('LoginError'))
           <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        <strong>{{ session('LoginError') }}</strong> try again
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
           @endif
           {{-- end Message --}}
                <form method="POST" action="{{ url('/login') }}" class="row g-3" id="loginForm" >
                  @csrf
                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Username</label>
                    <div class="input-group ">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-fill"></i></span>
                      <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="username" >
                      @error('username')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <div class="input-group ">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-person-fill-lock"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password" >
                    <span class="input-group-text" id="password_see">
                        <i class="bi bi-lock-fill" id="show_password"></i>
                        <i class="bi bi-unlock-fill d-none" id="hide_password"></i>
                      </span>
                      @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" id="btn-login" type="submit">Login</button>
                  </div>
                </form>

              </div>
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              Designed by <a href="#">SEDD   </a>  <label style="color: black;">With</label>   <i style="color: red;" class="bi bi-heart-fill"></i>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main>

<!-- Jquery -->
<script src="{{ asset('assets/js/scripts/jquery-3.7.1.min.js') }}"></script>

<!-- Vendor JS Files -->

<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/auth/login.js') }}"></script>
</body>
</html>

