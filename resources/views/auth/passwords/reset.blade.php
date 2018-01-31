@extends('layout.stand-alone')
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class="text-center" style="white-space: nowrap">
        <a href="{{ route('dashboard') }}" class="logo"><span>KW<span
                        style="color:black!important;">TS</span></span></a>
    </div>

    <div class="m-t-20 card-box" style="background: rgba(255,255,255,.3)">
        <div class="text-center">
            <h4 class="text-uppercase font-bold m-b-0">{{trans('auth.reset_password')}}</h4>

            <p class="text-muted m-b-0 font-13 m-t-20"></p>
        </div>
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

            <form class="form-horizontal m-t-20" action="{{ route('reset_password_post') }}" method="post">

                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="email" name="email" required=""
                               placeholder="{{trans('auth.email')}}" value="{{ $email or old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" required=""
                               placeholder="{{trans('auth.password')}}">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password_confirmation" required=""
                               placeholder="{{trans('auth.confirm_password')}}">
                    </div>
                </div>

                <div class="form-group text-center m-t-20 m-b-0">
                    <div class="col-xs-12">
                        <button class="btn btn-custom btn-bordred btn-block waves-effect waves-light"
                                type="submit">{{trans('auth.reset_password')}}</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>
<!-- end wrapper page -->


<script>
    var resizefunc = [];
</script>