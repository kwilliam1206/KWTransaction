@extends('layout.stand-alone')
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center" style="white-space: nowrap">
        <a href="{{ route('dashboard') }}" class="logo"><span>KW <span style="">FrontDoor</span></span></a>
    </div>
    <div class="m-t-20 card-box" style="background: rgba(255,255,255,.7)">
        <div class="panel-body">
            @if (count($errors))
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal m-t-20" action="{{ route('login_post') }}" method="post">

                {!! csrf_field() !!}

                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" type="email" name="email" required=""
                               placeholder="{{trans('auth.email')}}" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required=""
                               placeholder="{{trans('auth.password')}}">
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-custom">
                            <input id="checkbox-signup" type="checkbox" name="remember">
                            <label for="checkbox-signup" style="color: #777777!important">
                                {{trans('auth.remember_me')}}
                            </label>
                        </div>

                    </div>
                </div>

                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block"
                                type="submit">{{trans('auth.login')}}</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{{ route('reset_password') }}" class="text-muted" style="color: #777777!important"><i
                                    class="fa fa-lock m-r-5"></i> {{trans('auth.forgotten_password')}}</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- end card-box-->

</div>
<!-- end wrapper page -->


<style>
    .text-muted {
        color: #777777 !important;
    }
</style>
<script>
    var resizefunc = [];
</script>