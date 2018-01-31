@extends('layout.master')
@section('title', trans('nav.add_region'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            {{ trans('nav.add_region') }}
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

                {!! Form::open(array('route' => 'region.store', 'class' => 'form-horizontal')) !!}

                <div class="row">
                    <div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('region.name') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('name', null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.default_language') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('default_language', \KW\Transactions\Models\Language::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.default_locale') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('default_locale', \KW\Transactions\Models\Locale::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.default_currency') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('default_currency', \KW\Transactions\Models\Currency::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div><!-- end col -->

                </div><!-- end row -->

                <button type="submit"
                        class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_submit') }}</button>

                {!! Form::close() !!}

            </div>
        </div><!-- end col -->
    </div>
@endsection