@extends('layout.master')
@section('title', trans('general.new').' '.trans('general.client'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            {{trans('general.new')}} {{trans('general.client')}} {{trans('general.contact')}}
        </h4>
    </div>
@endsection
@section('content')
    {!! Form::open(['id'=>'contact_form','method' => 'post', 'route' => ['contact.store'],'class' => 'form-horizontal', 'role'=>'form']) !!}
    {!! Form::hidden('type_id',$contact_type->id) !!}
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

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('first_name', trans('contact.first_name') ,['class' => 'required col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('first_name', null, ['required','class'=>'form-control','placeholder'=>trans('contact.first_name')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('last_name', trans('contact.last_name') ,['class' => 'required col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('last_name', null, ['required','class'=>'form-control','placeholder'=>trans('contact.last_name')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('email', trans('general.email') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::email('email', null, ['class'=>'form-control','placeholder'=>trans('general.email')]) !!}
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('home_phone', trans('contact.home_phone') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('home_phone', null, ['class'=>'form-control','placeholder'=>trans('contact.home_phone')]) !!}
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('mobile_phone', trans('contact.mobile_phone') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('mobile_phone', null, ['class'=>'form-control','placeholder'=>trans('contact.mobile_phone')]) !!}
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('office_phone', trans('contact.office_phone') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('office_phone', null, ['class'=>'form-control','placeholder'=>trans('contact.office_phone')]) !!}
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('primary_phone', trans('contact.primary_phone') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('primary_phone', \KW\Transactions\Models\PhoneType::get()->pluck('name', 'id'), null, ['class'=>'form-control select2','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('address', trans('property.address') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('address', null, ['class'=>'form-control','placeholder'=>trans('property.address')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('state_id', trans('property.state') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('state_id', $states, null, ['required','id'=>'state_select','placeholder'=>trans('general.select'),'class'=>'form-control select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('city_id', trans('property.city') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('city_id', [] , null, ['required','id'=>'city_select','placeholder'=>trans('general.select'),'class'=>'form-control select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('postal_code', trans('property.postal_code') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-4 input-group">
                            {!! Form::text('postal_code', null, ['required','class'=>'form-control','placeholder'=>trans('property.postal_code')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <button type="submit"
                            class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_submit') }}</button>
                </div>

            </div>
        </div><!-- end col -->
    </div>
    {!! Form::close() !!}
@endsection
@section('bottom_scripts')
    <script>
        $("#contact_form").validate({
            errorPlacement: function(error, element) {
                error.insertBefore(element.parent("div"));
            }
        });
        $('.select2').change(function(){
            $(this).valid()
        });
        var state_select = $("#state_select").select2({
            placeholder: '{{trans('general.select')}}',
            tags: true,
            createTag: function (params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true
                }
            }
        });
        var city_select = $("#city_select").select2({
            placeholder: '{{trans('general.select')}}',
            tags: true,
            createTag: function (params) {
                return {
                    id: params.term,
                    text: params.term,
                    newOption: true,
                }
            }
        });

        $("#state_select").on("change", function () {
            $("#city_select option").remove();
            $('#city_select').append(new Option('', ''));
            $("#city_select").trigger("change");
            $.ajax({
                type: 'POST',
                url: '{{route('api.cities_by_state_id')}}',
                dataType: 'json',
                data: {state_id: $("#state_select").val()}
            }).done(function (data) {
                data = $.map(data, function (item) {
                    $('#city_select').append(new Option(item.name, item.id));
                    //$("#city_select").append(data).val("").trigger("change");
                    //return {id: item.id, text: item.name};
                });
                //console.log(data);
                $("#city_select").trigger("change");
            });
        });//Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
    </script>
@endsection