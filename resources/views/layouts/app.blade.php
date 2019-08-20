<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Bootstrap-ecommerce by Vosidiy">

<title>@yield('title', 'Shoper') </title>

<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">

<!-- jQuery -->
<script src="{{ asset('js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

<!-- Bootstrap4 files-->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">

<!-- plugin: owl carousel  -->
<link href="{{ asset('plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
<script src="{{ asset('plugins/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- custom style -->
<link href="{{ asset('css/ui.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

<!-- custom javascript -->
<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

</head>
<body>
    @yield('content')
</body>
</html>
