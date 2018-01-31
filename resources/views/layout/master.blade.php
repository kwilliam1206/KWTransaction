<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Keller Williams FrontDoor">
    <meta name="author" content="Keller Williams">
    <meta name="_token" content="{{ csrf_token() }}"/>

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

    <!-- DataTables -->
    <link href="{{ asset('assets/css/datatables.css') }}" rel="stylesheet" type="text/css"/>

    <!--forms-->
    <link href="{{ asset('assets/css/forms.css') }}" rel="stylesheet" type="text/css"/>

    <!-- jQuery  -->
    <script src="{{ asset('assets/js/dependencies.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    </script>

    <!-- KNOB JS -->
    <!--[if IE]>
    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
    <![endif]-->
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

    <!-- Datatables-->
    <script src="{{ asset('assets/js/datatables.js') }}"></script>

    <script src="{{ asset('assets/js/forms.js')}}" type="text/javascript"></script>

    @yield('top_scripts')


</head>

<body>
<!--nav-->
@hasSection('nav')
@yield('nav')
@else
@include('nav.top')
@endif
        <!--end nav-->
<div class="wrapper">
    <div class="container">
        <div class="btn-group pull-right m-t-15">
            <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light"
                    data-toggle="dropdown" aria-expanded="false">New <span class="m-l-5"><i
                            class="fa fa-plus"></i></span></button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{route('transaction.create')}}">{{trans('general.new')}} {{trans('general.transaction')}}</a>
                </li>
                <li>
                    <a href="{{route('listing.create')}}">{{trans('general.new')}} {{trans('general.listing')}}</a>
                </li>
                <li>
                    <a href="#">{{trans('general.new')}} {{trans('payment.payment_received')}}</a>
                </li>
                <li>
                    <a href="{{route('contact.create.filter',['type'=>'agent'])}}">{{trans('general.new')}} {{trans('general.agent')}} {{trans('general.contact')}}</a>
                </li>
                <li>
                    <a href="{{route('contact.create.filter',['type'=>'client'])}}">{{trans('general.new')}} {{trans('general.client')}} {{trans('general.contact')}}</a>
                </li>
            </ul>
        </div>
        @yield('page_heading')
        @yield('content')
        @include('footer.master')
    </div>
    @hasSection('sidebar')
    @yield('sidebar')
    @else
        @include('nav.right')
    @endif
</div>
<script src="{{ asset('assets/js/app.js') }}"></script>
@yield('bottom_scripts')

</body>
</html>