@extends('layout.master')
@section('title', trans('general.edit').' '.trans('general.listing'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            {{trans('general.edit')}} {{trans('general.listing')}}
        </h4>
    </div>
@endsection
@section('content')
    {!! Form::model($listing,['id'=>'listing_form','method' => 'put', 'route' => ['listing.update',$listing->id],'class' => 'form-horizontal', 'role'=>'form']) !!}
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
                        {!! Form::label('listing_id', trans('listing.id') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('listing_id', $listing->listing_id, ['required','class'=>'form-control','placeholder'=>trans('listing.id')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('address', trans('property.address') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::text('address', $listing->property->address, ['required','class'=>'form-control','placeholder'=>trans('property.address')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('state_id', trans('property.state') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('state_id', $states, $listing->property->state_id, ['required','id'=>'state_select','class'=>'form-control select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('city_id', trans('property.city') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('city_id', $cities , $listing->property->city_id, ['required','id'=>'city_select','class'=>'form-control select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('postal_code', trans('property.postal_code') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-4 input-group">
                            {!! Form::text('postal_code', $listing->property->postal_code, ['required','class'=>'form-control','placeholder'=>trans('property.postal_code')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('beds', trans('property.beds') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-4 input-group">
                            {!! Form::text('beds', $listing->property->beds, ['readonly','class'=>'vertical-spin','placeholder'=>trans('property.beds')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('baths', trans('property.baths') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-4 input-group">
                            {!! Form::text('baths', $listing->property->baths, ['readonly','class'=>'vertical-spin','placeholder'=>trans('property.baths')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('year_built', trans('property.year_built') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-4 input-group">
                            {!! Form::text('year_built', $listing->property->year_built, ['class'=>'form-control','placeholder'=>trans('property.year_built')]) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('habitable_area_sq_m', trans('property.habitable_area_sq_m') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-lg-7 input-group">
                            {!! Form::text('habitable_area_sq_m', $listing->property->habitable_area_sq_m, ['class'=>'form-control','placeholder'=>trans('property.habitable_area_sq_m')]) !!}
                            <span class="input-group-addon bg-primary b-0 text-white">Sq M</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('status_id', trans('general.status') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-lg-9 input-group">
                            {!! Form::select('status_id', \KW\Transactions\Models\ListingStatus::get()->lists('name','id'), $listing->status_id, ['required','class'=>'form-control select2']) !!}
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

        $("#listing_form").validate({
            errorPlacement: function(error, element) {
                error.insertBefore(element.parent("div"));
            }
        });
        $('.select2').change(function(){
            $(this).valid()
        });
        //TODO money format
        $("#habitable_area_sq_m").inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 0,
            digitsOptional: false,
            autoGroup: true,
            rightAlign: true,
            oncleared: function () {
                self.Value('');
            }
        });
        $("#year_built").inputmask('9999');
        var status_select = $("#status_id").select2({
            placeholder: '{{trans('general.select')}}'
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
        });
        //Bootstrap-TouchSpin
        $("#beds.vertical-spin").TouchSpin({
            verticalbuttons: true,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        $("#baths.vertical-spin").TouchSpin({
            verticalbuttons: true,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus',
            step: 0.5,
            decimals: 1,
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
    </script>
@endsection