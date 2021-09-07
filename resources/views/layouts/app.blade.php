<!DOCTYPE html>
<html lang="de">
<head>
  <title>i4vision</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{ asset('plugins/frontend/bootstrap.min.css') }}">
  <script type="text/javascript" src="{{ asset('plugins/frontend/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('plugins/frontend/bootstrap.min.js') }}"></script>

  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
    /*width: 70%;*/
    margin: auto;
  }

    @media only screen and (max-width: 1000px) {
      #image-title {
        padding-top: 5px;
        font-size: 20px;
      }
    }

    @media only screen and (max-width: 767px) {
      #image-title {
        padding-top: 5px;
        font-size: 15px;
      }
    }
  </style>

  @stack('styles')
</head>
<body>

<div>

    @yield('content')
</div>
</body>
<script type="text/javascript">
  $(".carousel-control").find(".glyphicon").hide();
  $(".carousel-control").mouseleave(function() {
    $(this).find(".glyphicon").hide( 200 );
  });

  $(".carousel-control").mouseenter(function() {
    $(this).find(".glyphicon").show( 200 );
  });


  </script>
</html>