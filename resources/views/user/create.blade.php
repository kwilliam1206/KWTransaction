@extends('layout.master')
@section('title', trans('nav.add_user'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            {{ trans('nav.add_user') }}
        </h4>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-6">
            <div class="card-box">

                @if (count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::open(array('route' => 'user.store', 'class' => 'form-horizontal')) !!}

                <div class="row">
                    <div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('user.first_name') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('first_name', null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('user.last_name') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('last_name', null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('user.username') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('username', null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required"
                                   for="example-email">{{ trans('user.email') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('email', null, ['required' => '', 'type' => 'email', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('user.password') }}</label>

                            <div class="col-md-10">
                                {!! Form::password('password', ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.language') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('language_id', \KW\Transactions\Models\Language::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.locale') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('locale_id', \KW\Transactions\Models\Locale::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.currency') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('currency_id', \KW\Transactions\Models\Currency::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <fieldset>
                            <legend>{{ trans('general.user_role') }}</legend>
                            <div class="fieldset-content">
                                <div class="form-group">
                                    <label class="col-md-2 control-label required">{{ trans('general.role') }}</label>

                                    <div class="col-md-10">
                                        {!! Form::select('role_1', \KW\Transactions\Models\Role::get()->lists('display_name', 'id'), null, ['required' => '', 'placeholder' => 'Select role...', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label required">{{ trans('general.office') }}</label>

                                    <div class="col-md-10">
                                        {!! Form::select('office_1', \KW\Transactions\Models\Office::get()->lists('name', 'id'), null, ['required' => '', 'placeholder' => 'Select office...', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <button type="button"
                                        class="btn btn-sm btn-warning waves-effect waves-light">{{ trans('user.remove_role') }}</button>
                            </div>
                        </fieldset>
                    </div><!-- end col -->

                </div><!-- end row -->

                <button type="submit"
                        class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_submit') }}</button>

                {!! Form::close() !!}
            </div>
        </div><!-- end col -->
    </div>
@endsection