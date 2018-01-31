@extends('layout.master')
@section('title', trans('general.edit').' '.trans('general.transaction'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">{{trans('general.edit')}} {{trans('general.transaction')}}</h4>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
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

                {!! Form::model($transaction, ['method' => 'put', 'route' => ['transaction.update',$transaction->id],'class' => 'form-horizontal', 'role'=>'form','id'=>'transaction_form']) !!}
                {!! Form::hidden('payments') !!}

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('type_id', trans('transaction.transaction_type') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('type_id', \KW\Transactions\Models\TransactionType::get()->lists('name','id'), null, ['class'=>'form-control select2 required','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row @if (Auth::user()->isAgent()) hidden @endif">
                    <div class="form-group row">
                        <?php $agentsInOffice = \KW\Transactions\Models\User::agents()->inOffice(Cookie::get('kw_office'))->get() ?>
                        {!! Form::label('agent_id', trans('general.agent') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('agent_id', $agentsInOffice->lists('name','id'), null, ['class'=>'form-control select2 required','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('agent_commission', trans('financial.agent_commission') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group">
                            <?php $translatedLists = \KW\Transactions\Models\FinancialAttributeType::get()->lists('name', 'id') ?>
                            {!! Form::hidden('agent_commission_type', null) !!}
                            {!! Form::text('agent_commission', null, ['class'=>'form-control currency required','placeholder'=>trans('financial.agent_commission')]) !!}
                            <span class="input-group-btn"><button class="btn btn-info bootstrap-touchspin-up attr_type" title="click to change" id="agent_commission_type_icon">{{$translatedLists[$transaction->agent_commission_type]}}</button></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('listing_id', trans('general.listing') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('listing_id', \KW\Transactions\Models\Listing::activeOrPendingOrSold()->get()->lists('name','id'), null, ['class'=>'form-control select2 required','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('price', trans('transaction.sale_price') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::text('price', null, ['class'=>'form-control currency required','placeholder'=>trans('transaction.sale_price')]) !!}
                            <span class="input-group-addon bg-primary b-0 text-white">{{$locale->currency_code}}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('effective_date', trans('transaction.sale_date') ,['class' => 'col-lg-3 control-label required']) !!}
                        <div class="col-sm-7 input-group" id="fix">
                            {!! Form::text('effective_date', $transaction->effective_date->format('Y-m-d'), ['readonly','class'=>'form-control datepicker-autoclose required','placeholder'=>trans('transaction.sale_date')]) !!}
                            <span class="input-group-btn"><button class="btn btn-primary datepicker-trigger"><i class="ti-calendar"></i></button></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('buyer_agent_contact_id', trans('transaction.buyer_agent') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('buyer_agent_contact_id', \KW\Transactions\Models\Contact::agents()->get()->lists('full_name','id'), null, ['class'=>'form-control select2','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('buyer_contact_id', trans('transaction.buyer') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('buyer_contact_id', \KW\Transactions\Models\Contact::clients()->get()->lists('full_name','id'), null, ['class'=>'form-control select2','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('seller_agent_contact_id', trans('transaction.seller_agent') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('seller_agent_contact_id', \KW\Transactions\Models\Contact::agents()->get()->lists('full_name','id'), null, ['class'=>'form-control select2','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('seller_contact_id', trans('transaction.seller') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::select('seller_contact_id', \KW\Transactions\Models\Contact::clients()->get()->lists('full_name','id'), null, ['class'=>'form-control select2','placeholder'=>trans('general.select')]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('finalized', trans('transaction.submit') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::checkbox('finalized', '1', in_array($transaction->status->rawname, ['submitted', 'accepted']) ? 1 : 0, ['data-color'=>'#00b19d','data-plugin'=>"switchery",'data-switchery'=>"true"]) !!}
                        </div>
                    </div>
                </div>

                @if (Auth::user()->can('approve_transaction') && Auth::user()->isManagingOffice($transaction->office->id))
                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('approve', trans('transaction.approve') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::checkbox('approve', '1', $transaction->status->rawname == 'accepted' ? 1 : 0 , ['data-color'=>'#10c469','data-plugin'=>"switchery",'data-switchery'=>"true"]) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group row">
                        {!! Form::label('reject', trans('transaction.reject') ,['class' => 'col-lg-3 control-label']) !!}
                        <div class="col-sm-7 input-group">
                            {!! Form::checkbox('reject', '1', $transaction->status->rawname == 'rejected' ? 1 : 0 , ['data-color'=>'#ff5b5b','data-plugin'=>"switchery",'data-switchery'=>"true"]) !!}
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <button type="submit"
                            class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_save') }}</button>
                    <!--<button type="button"
                            class="btn btn-warning waves-effect waves-light pull-right m-r-10">{{ trans('transaction.withdraw') }}</button>-->
                </div>

                {!! Form::close() !!}
            </div>
        </div><!-- end col -->
        <!--</div>
        <div class="row">-->
        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <button id="addToTable"
                                        class="btn btn-primary waves-effect waves-light">{{trans('transaction.add_payment')}}
                                    <i
                                            class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="m-b-30 pull-right">
                                <h5><strong>{{trans('general.total')}} {{trans('general.commission')}}</strong>: <span
                                            id="total_commission">0.00</span> {{$locale->currency_code}}</h5>
                            </div>
                        </div>
                    </div>

                    <label id="payments-error" class="error" for="payments" style="display:none">{{ trans('validation.custom.payments.required') }}</label>
                    <label id="payments-commission-error" class="error" for="payments" style="display:none">{{ trans('validation.custom.payments.invalid') }}</label>

                    <div class="">
                        <div id="datatable-editable_wrapper"
                             class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped dataTable no-footer" id="datatable-editable"
                                           role="grid" aria-describedby="datatable-editable_info">
                                        <thead>
                                        <tr role="row">
                                            <th>ID</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="datatable-editable"
                                                rowspan="1" colspan="1"
                                                aria-label="Rendering engine: activate to sort column descending"
                                                aria-sort="ascending"
                                                style="width: 256px;">{{trans('transaction.expected_amount')}}
                                                ({{$locale->currency_code}})
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="datatable-editable"
                                                rowspan="1" colspan="1"
                                                aria-label="Browser: activate to sort column ascending"
                                                style="width: 336px;">{{trans('transaction.expected_date')}}
                                            </th>
                                            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions"
                                                style="width: 135px;">{{trans('general.actions')}}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($transaction->payments as $payment)
                                            <tr>
                                                <td class="payment_id">{{$payment->id}}</td>
                                                <td class="amount">{{number_format($payment->est_amount,2)}}</td>
                                                <td class="date">{{$payment->est_paid_date->format('Y-m-d')}}</td>
                                                <td class="actions">
                                                    <a href="#" class="on-editing save-row hidden"><i
                                                                class="fa fa-save"></i></a>
                                                    <a href="#" class="on-editing cancel-row hidden"><i
                                                                class="fa fa-times"></i></a>
                                                    <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                                    <a href="#" class="on-default remove-row"><i
                                                                class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: panel body -->

            </div> <!-- end panel -->


            <div class="panel">
                <div class="panel-body">
                    <h4 class="header-title m-t-0 m-b-30">{{ trans('general.add_note') }}</h4>

                    @if (session('addNoteStatus'))
                        <div class="alert alert-success">
                            {{ session('addNoteStatus') }}
                        </div>
                    @endif

                    {!! Form::model($transaction, ['method' => 'put', 'route' => ['transaction.addNote',$transaction->id],'class' => 'form-horizontal', 'role'=>'form']) !!}

                    <div class="row">
                        <div class="form-group row">
                            {!! Form::label('note', ' ', ['class' => 'col-lg-1 control-label']) !!}
                            <div class="col-sm-10 input-group">
                                {!! Form::textarea('note', null, ['class'=>'form-control mentions','placeholder'=>trans('general.note'),'rows'=>8]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <button type="submit"
                                class="btn btn-primary waves-effect waves-light pull-right">{{ trans('general.form_add_note') }}</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div> <!-- end col-->
    </div>
    <div class="row">
        <h4 class="page-title">
            {{trans('general.notes')}}
        </h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">
                <table id="notes_table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>{{ trans('general.date') }}</th>
                        <th>{{ trans('general.note') }}</th>
                        <th>{{ trans('general.user') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($transaction->notes as $note)
                        <tr>
                            <td>{{ $note->created_at }}</td>
                            <td>{{ $note->getNoteText() }}</td>
                            <td>{{ $note->user->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <h4 class="page-title">
            {{trans('general.history')}}
        </h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card-box">

                <table id="history_table" class="table table-striped table-bordered dt-responsive nowrap"
                       cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>{{ trans('general.date') }}</th>
                        <th>{{ trans('general.action') }}</th>
                        <th>{{ trans('general.user') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($transaction->logs as $log)
                        <tr>
                            <td style="white-space: nowrap">{{ $log->created_at }}</td>
                            <td>
                                {!! $log->formatted_line !!}
                            </td>
                            <td style="white-space: nowrap">{{ $log->user->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- end col -->
    </div>
    <!-- MODAL -->
    <div id="dialog" class="modal-block mfp-hide">
        <section class="panel panel-info panel-color">
            <header class="panel-heading">
                <h2 class="panel-title">Are you sure?</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>Are you sure that you want to delete this row?</p>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12 text-right">
                        <button id="dialogConfirm" class="btn btn-primary waves-effect waves-light">Confirm</button>
                        <button id="dialogCancel" class="btn btn-default waves-effect">Cancel</button>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- end Modal -->
@endsection

@section('bottom_scripts')
    <script src="//cdn.datatables.net/plug-ins/1.10.11/api/sum().js"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script type="text/javascript">
        var configureFields = function () {
            $(".currency").inputmask("numeric", {
                radixPoint: ".",
                groupSeparator: ",",
                digits: 2,
                digitsOptional: false,
                autoGroup: true,
                rightAlign: true,
                oncleared: function () {
                    self.Value('');
                }
            });
            $('.datepicker-autoclose').datepicker({
                autoclose: true,
                todayHighlight: true,
                startDate: '-30d',
                container: '#fix',
                format: 'yyyy-mm-dd'

            });
            $('.datepicker-trigger').on('click', function () {
                $(this).parent().prev('.datepicker-autoclose').datepicker( "show" );
                return false;
            });
        };

        function checkToggle(c, chk) {
            c.checked = chk;
            if (typeof Event === 'function' || !document.fireEvent) {
                var event = document.createEvent('HTMLEvents');
                event.initEvent('change', true, true);
                c.dispatchEvent(event);
            } else {
                c.fireEvent('onchange');
            }
        }

        var attrTypes = {!! $translatedLists !!};

        $(document).ready(function () {
            $('#history_table,#notes_table').DataTable({
                bFilter: false,
                bLengthChange: false,
                iDisplayLength: 10,
                order: [[0, 'desc']],
                paging: true,
                deferRender: true,
            });

            $("#type_id").on("change", function () {
                cur_selected = $("#type_id option:selected");
                if (cur_selected.val() == 4) { //lease
                    $("#price").attr("placeholder", '{{trans('transaction.lease_price')}}');
                    $("#effective_date").attr("placeholder", '{{trans('transaction.lease_date')}}');
                    $("label[for='price']").html('{{trans('transaction.lease_price')}}');
                    $("label[for='effective_date']").html('{{trans('transaction.lease_date')}}');
                }
                else {
                    $("#price").attr("placeholder", '{{trans('transaction.sale_price')}}');
                    $("#effective_date").attr("placeholder", '{{trans('transaction.sale_date')}}');
                    $("label[for='price']").html('{{trans('transaction.sale_price')}}');
                    $("label[for='effective_date']").html('{{trans('transaction.sale_date')}}');
                }
                $("label[for='buyer_contact_id']").parent().show();
                $("label[for='buyer_agent_contact_id']").parent().show();
                $("label[for='seller_contact_id']").parent().show();
                $("label[for='seller_agent_contact_id']").parent().show();

                if (cur_selected.val() == 1) { //buyer side
                    $("label[for='buyer_contact_id']").parent().hide();
                    $("label[for='buyer_agent_contact_id']").parent().hide();
                }

                else if (cur_selected.val() == 2) { //seller side
                    $("label[for='seller_contact_id']").parent().hide();
                    $("label[for='seller_agent_contact_id']").parent().hide();
                }

                else {
                    $("label[for='seller_contact_id']").parent().hide();
                    $("label[for='seller_agent_contact_id']").parent().hide();
                    $("label[for='buyer_contact_id']").parent().hide();
                    $("label[for='buyer_agent_contact_id']").parent().hide();
                }
            });
            $("#type_id").trigger('change');

            $('#agent_commission_type_icon').on('click', function (e) {
                var firstEntry = null;
                var entryFound = false;
                var k;
                for (k in attrTypes) {
                    if (firstEntry===null) {
                        firstEntry = k;
                    }
                    if (entryFound==true) {
                        $(this).text(attrTypes[k]);
                        $("input[name='agent_commission_type']").val(k);
                        entryFound = false;
                        $("#agent_commission").trigger('change');
                        break;
                    } else if (k==$("input[name='agent_commission_type']").val()) {
                        entryFound = true;
                    }
                }
                if (entryFound) {
                    $(this).text(attrTypes[firstEntry]);
                    $("input[name='agent_commission_type']").val(firstEntry);
                    $("#agent_commission").trigger('change');
                }
                return false;
            });
            $('#agent_id').on("change", function () {
                if (!$(this).val()) return false;
                $.ajax({
                    type: 'POST',
                    url: '{{route('customFinancialAttribute.agent')}}',
                    dataType: 'json',
                    data: {user_id: $(this).val(), name: 'agent_commission'}
                }).done(function (data) {
                    if (data.success) {
                        $('#agent_commission').val(data.attributes[0]['value']);
                        $("input[name='agent_commission_type']").val(data.attributes[0]['type_id']);
                        $('#agent_commission_type_icon').text(attrTypes[data.attributes[0]['type_id']]);
                        $("#agent_commission").trigger('change');
                    }
                });
            });

            $('#price').on('change', function () {
                $("#agent_commission").trigger('change');
            });

            $('#agent_commission').on('change', function () {
                var c = $('#agent_commission').inputmask('unmaskedvalue');
                if (c) {
                    if (attrTypes[$("input[name='agent_commission_type']").val()] == '%') {
                        c = $('#price').inputmask('unmaskedvalue') * $('#agent_commission').inputmask('unmaskedvalue') / 100;
                    }
                    $('#total_commission').text(c.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                }
            });
            $("#agent_commission").trigger('change');


            var finalized = document.querySelector('#finalized');
            var reject = document.querySelector('#reject');
            var approve = document.querySelector('#approve');
            if (approve) {
                approve.addEventListener('change', function () {
                    if (approve.checked) {
                        checkToggle(reject, false);
                        checkToggle(finalized, true);
                    }
                });
            }
            if (reject) {
                reject.addEventListener('change', function () {
                    if (reject.checked) {
                        checkToggle(approve, false);
                        checkToggle(finalized, false);
                    }
                });
            }
            finalized.addEventListener('change', function () {
                if (!finalized.checked && approve) {
                    checkToggle(approve, false);
                } else if (reject && reject.checked) {
                    checkToggle(finalized, false);
                }
            });

            $.fn.datepicker.defaults.language = '{{$locale->language_code}}';
            //$.fn.datepicker.defaults.format = '{{$locale->date_format}}';
            configureFields();
        });

    </script>
    <script>
        (function ($) {

            'use strict';

            var EditableTable = {

                options: {
                    addButton: '#addToTable',
                    table: '#datatable-editable',
                    dialog: {
                        wrapper: '#dialog',
                        cancelButton: '#dialogCancel',
                        confirmButton: '#dialogConfirm',
                    }
                },

                initialize: function () {
                    this
                            .setVars()
                            .build()
                            .events();
                },

                setVars: function () {
                    this.$table = $(this.options.table);
                    this.$addButton = $(this.options.addButton);

                    // dialog
                    this.dialog = {};
                    this.dialog.$wrapper = $(this.options.dialog.wrapper);
                    this.dialog.$cancel = $(this.options.dialog.cancelButton);
                    this.dialog.$confirm = $(this.options.dialog.confirmButton);

                    return this;
                },

                build: function () {
                    this.datatable = this.$table.DataTable({
                        dom: 'rt',
                        aoColumns: [
                            null,
                            null,
                            null,
                            {"bSortable": false}
                        ],
                        "language": {
                            "paginate": {
                                "previous": "<<",
                                "next": ">> "
                            }
                        }
                    });

                    window.dt = this.datatable;

                    return this;
                },

                events: function () {
                    var _self = this;

                    this.$table
                            .on('click', 'a.save-row', function (e) {
                                e.preventDefault();

                                _self.rowSave($(this).closest('tr'));
                            })
                            .on('click', 'a.cancel-row', function (e) {
                                e.preventDefault();

                                _self.rowCancel($(this).closest('tr'));
                            })
                            .on('click', 'a.edit-row', function (e) {
                                e.preventDefault();

                                _self.rowEdit($(this).closest('tr'));
                            })
                            .on('click', 'a.remove-row', function (e) {
                                e.preventDefault();

                                var $row = $(this).closest('tr');

                                $.magnificPopup.open({
                                    items: {
                                        src: _self.options.dialog.wrapper,
                                        type: 'inline'
                                    },
                                    preloader: false,
                                    modal: true,
                                    callbacks: {
                                        change: function () {
                                            _self.dialog.$confirm.on('click', function (e) {
                                                e.preventDefault();

                                                _self.rowRemove($row);
                                                $.magnificPopup.close();
                                            });
                                        },
                                        close: function () {
                                            _self.dialog.$confirm.off('click');
                                        }
                                    }
                                });
                            });

                    this.$addButton.on('click', function (e) {
                        e.preventDefault();

                        _self.rowAdd();
                    });

                    this.dialog.$cancel.on('click', function (e) {
                        e.preventDefault();
                        $.magnificPopup.close();
                    });

                    return this;
                },

                // ==========================================================================================
                // ROW FUNCTIONS
                // ==========================================================================================
                rowAdd: function () {
                    this.$addButton.attr({'disabled': 'disabled'});

                    var actions,
                            data,
                            $row;

                    actions = [
                        '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                        '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                        '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                        '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
                    ].join(' ');

                    data = this.datatable.row.add(['','','', actions]);
                    $row = this.datatable.row(data[0]).nodes().to$();

                    $row
                            .addClass('adding')
                            .find('td:first')
                            .addClass('payment_id');

                    $row
                            .addClass('adding')
                            .find('td:nth-child(2)')
                            .addClass('amount');

                    $row
                            .addClass('adding')
                            .find('td:nth-child(3)')
                            .addClass('date');

                    $row
                            .addClass('adding')
                            .find('td:last')
                            .addClass('actions');

                    this.rowEdit($row);
                    this.datatable.order([0, 'asc']).draw(); // always show fields
                    configureFields();
                },

                rowCancel: function ($row) {
                    var _self = this,
                            $actions,
                            i,
                            data;

                    if ($row.hasClass('adding')) {
                        this.rowRemove($row);
                    } else {

                        data = this.datatable.row($row.get(0)).data();
                        this.datatable.row($row.get(0)).data(data);

                        $actions = $row.find('td.actions');
                        if ($actions.get(0)) {
                            this.rowSetActionsDefault($row);
                        }

                        this.datatable.draw();
                    }
                },

                rowEdit: function ($row) {
                    var _self = this,
                            data;

                    data = this.datatable.row($row.get(0)).data();

                    $row.children('td').each(function (i) {
                        var $this = $(this);

                        if ($this.hasClass('actions')) {
                            _self.rowSetActionsEditing($row);
                        } else if ($this.hasClass('amount')) {
                            $this.html('<div class="input-group">' +
                                    '<input type="text"' +
                                    'name="amount" value="' + data[i] + '" placeholder="" class="form-control currency"' +
                                    'value="' + data[i] + '">' +
                                    '<span class="input-group-addon bg-primary b-0 text-white">{{$locale->currency_code}}</span>');

                        }
                        else if ($this.hasClass('date')){
                            $this.html('<div class="input-group">' +
                                    '<input type="text" name="date" readonly="readonly" class="form-control datepicker-autoclose" value="' + data[i] + '">' +
                                    '<span class="input-group-btn"><button class="btn btn-primary datepicker-trigger"><i class="ti-calendar"></i></button></span>' +
                                    '</div>');
                        }
                    });
                    configureFields();
                },

                rowSave: function ($row) {
                    var _self = this,
                            $actions,
                            values = [];

                    if ($row.hasClass('adding')) {
                        this.$addButton.removeAttr('disabled');
                        $row.removeClass('adding');
                    }

                    values = $row.find('td').map(function () {
                        var $this = $(this);

                        if ($this.hasClass('actions')) {
                            _self.rowSetActionsDefault($row);
                            return _self.datatable.cell(this).data();
                        }else if ($this.hasClass('payment_id')) {
                            return _self.datatable.cell(this).data();
                        } else {
                            return $.trim($this.find('input').val());
                        }
                    });

                    this.datatable.row($row.get(0)).data(values);

                    $actions = $row.find('td.actions');
                    if ($actions.get(0)) {
                        this.rowSetActionsDefault($row);
                    }

                    this.datatable.draw();
                },

                rowRemove: function ($row) {
                    if ($row.hasClass('adding')) {
                        this.$addButton.removeAttr('disabled');
                    }

                    this.datatable.row($row.get(0)).remove().draw();
                },

                rowSetActionsEditing: function ($row) {
                    $row.find('.on-editing').removeClass('hidden');
                    $row.find('.on-default').addClass('hidden');
                },

                rowSetActionsDefault: function ($row) {
                    $row.find('.on-editing').addClass('hidden');
                    $row.find('.on-default').removeClass('hidden');
                }

            };

            $(function () {
                $("#transaction_form").validate({
                    errorPlacement: function(error, element) {
                        error.insertBefore(element.parent("div"));
                    }
                });
                $('.select2').change(function(){
                    $(this).valid()
                });
                $("#transaction_form").submit(function (event) {
                    var data = EditableTable.datatable
                            .rows()
                            .data();

                    if ($('#finalized').prop('checked')) {
                        var c = $('#agent_commission').inputmask('unmaskedvalue');
                        if (attrTypes[$("input[name='agent_commission_type']").val()] == '%') {
                            c = $('#price').inputmask('unmaskedvalue') * $('#agent_commission').inputmask('unmaskedvalue') / 100;
                        }
                        $('#payments-error').hide();
                        $('#payments-commission-error').hide();

                        var paymentSum = EditableTable.datatable.column(1).data().sum();
                        console.log(paymentSum);

                        if (data.length == 0) {
                            $('#payments-error').show();
                            $('#addToTable').focus();
                            event.preventDefault();
                            return false;
                        } else if (paymentSum != c) {
                            $('#payments-commission-error').show();
                            $('#addToTable').focus();
                            event.preventDefault();
                            return false;
                        }
                    }

                    var filteredData = [];
                    $.each(data, function (index, value) {
                        var payment = {};
                        payment.id = value[0];
                        payment.est_amount = value[1];
                        payment.est_paid_date = value[2];
                        filteredData.push(payment);
                    });
                    var sdata = JSON.stringify(filteredData);
                    $("input[name='payments']").val(sdata);
                });
                EditableTable.initialize();
            });

        }).apply(this, [jQuery]);
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                type: 'POST',
                url: '{{ route('api.mentions') }}',
                dataType: 'json'
            }).done(function (data) {
                $(".mentions").mention({
                    delimiter: '@',
                    sensitive : true,
                    emptyQuery: true,
                    queryBy: ['username'],
                    users: data
                });
            });

        });
    </script>
@endsection
