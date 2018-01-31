@extends('layout.master')
@if ($user->id == Auth::id()))
@section('title', trans('user.update_profile'))
@else
    @section('title', trans('user.update_user'))
@endif
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            @if ($user->id == Auth::id())
                {{ trans('user.update_profile') }}
            @else
                {{ trans('user.update_user') }}
            @endif
        </h4>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-6">
            <div class="card-box">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" role="form" action="{{ route('user_update', ['id'=>$user->id]) }}"
                      method="post">

                    {!! csrf_field() !!}

                    <div class="row">
                        <div>
                            <div class="form-group">
                                <label class="col-md-2 control-label required">{{ trans('user.name') }}</label>

                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" required=""
                                           value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label required"
                                       for="example-email">{{ trans('user.email') }}</label>

                                <div class="col-md-10">
                                    <input type="email" class="form-control" name="email" required=""
                                           value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ trans('user.password') }}</label>

                                <div class="col-md-10">
                                    <input type="password" class="form-control" name="password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ trans('general.language') }}</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="language_id" required="">
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->id }}"
                                                    @if ($lang->id == $user->language->id) selected @endif>{{ $lang->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ trans('general.locale') }}</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="locale_id" required="">
                                        @foreach ($locales as $locale)
                                            <option value="{{ $locale->id }}"
                                                    @if ($locale->id == $user->locale->id) selected @endif>{{ $locale->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label required">{{ trans('general.currency') }}</label>

                                <div class="col-sm-10">
                                    <select class="form-control" name="currency_id" required="">
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                    @if ($currency->id == $user->currency->id) selected @endif>{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><!-- end col -->

                    </div><!-- end row -->

                    <button type="submit"
                            class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_submit') }}</button>
                </form>
            </div>
        </div><!-- end col -->
    </div>
@endsection