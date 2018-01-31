<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Keller Williams FrontDoor">
    <meta name="author" content="Keller Williams">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <title>KW FrontDoor
        @hasSection('title')
        - @yield('title')
        @endif
    </title>
    <link href="{{ asset('assets/css/all.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
    @yield('css')

            <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    @yield('top_scripts')


</head>

<body>
@yield('content')
<script src="{{ asset('assets/js/dependencies.js') }}"></script>
@yield('bottom_scripts')
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>
</html>