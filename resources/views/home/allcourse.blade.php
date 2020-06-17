<!DOCTYPE html>
<html lang="en">
<head>
@include('home.top')
 
</head>

<body id="body">

@include('home.topbar')

<header id="header">
  @include('home.header')
</header>


  <main id="main">


  <div class="container">
  @yield('content')
  </div>


  </main>

 
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Online School</strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by <a href="{{ url('/home') }}">Online School</a>
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- JavaScript Libraries -->
  <style>
.count{
    background:#d9534f;
    padding:2px;
    color:white;
    border-radius: 100%;
    }
</style>

  <script href="{{ asset('home/lib/jquery/jquery.min.js') }}"></script>
  <script href="{{ asset('home/lib/jquery/jquery-migrate.min.js') }}"></script>
  <script href="{{ asset('home/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script href="{{ asset('home/lib/easing/easing.min.js') }}"></script>
  <script href="{{ asset('home/lib/superfish/hoverIntent.js') }}"></script>
  <script href="{{ asset('home/lib/superfish/superfish.min.js') }}"></script>
  <script href="{{ asset('home/lib/wow/wow.min.js') }}"></script>
  <script href="{{ asset('home/lib/owlcarousel/owl.carousel.min.js') }}"></script>
  <script href="{{ asset('home/lib/magnific-popup/magnific-popup.min.js') }}"></script>
  <script href="{{ asset('home/lib/sticky/sticky.js') }}"></script>



  <script href="{{ asset('home/contactform/contactform.js') }}"></script>
  <script href="{{ asset('home/js/main.js') }}"></script>


</body>
</html>

