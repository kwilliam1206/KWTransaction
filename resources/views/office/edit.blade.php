@extends('layout.master')
@section('title', trans('office.edit_office'))
@section('page_heading')
    <div class="row">
        <h4 class="page-title">
            {{ trans('office.edit_office') }}
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

                {!! Form::model($office, array('route' => ['office.update', $office->id], 'method' => 'put', 'class' => 'form-horizontal')) !!}

                <div class="row">
                    <div>
                        <div class="form-group">
                            <label class="col-md-2 control-label required">{{ trans('office.name') }}</label>

                            <div class="col-md-10">
                                {!! Form::text('name', null, ['required' => '', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label required">{{ trans('general.region') }}</label>

                            <div class="col-sm-10">
                                {!! Form::select('region_id', \KW\Transactions\Models\Region::get()->lists('name', 'id'), null, ['required' => '', 'class' => 'form-control']) !!}
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

        <div class="col-lg-6">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="m-b-30">
                                <h4><strong>{{ trans('financial.financial_attributes') }}</strong></h4>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!--<div class="m-b-30 pull-right">
                                <button id="addToTable"
                                        class="btn btn-primary waves-effect waves-light">{{trans('financial.add_attribute')}}
                                    <i
                                            class="fa fa-plus"></i></button>
                            </div>-->
                        </div>
                    </div>

                    <div id="datatable-editable_wrapper"
                         class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="datatable-editable" class="table table-striped table-bordered dt-responsive nowrap dataTable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>{{trans('financial.attribute_name')}}</th>
                                        <th class="hidden">{{trans('financial.attribute_type')}}</th>
                                        <th style="width: 130px;">{{trans('financial.attribute_value')}}</th>
                                        <th style="width: 70px;">{{trans('general.actions')}}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php $translatedLists = \KW\Transactions\Models\FinancialAttributeType::get()->lists('name', 'id') ?>
                                        @foreach ($officeFinancialAttributes as $attr)
                                        <tr>
                                            <td class="id">{{ $attr->financialAttribute->id }}</td>
                                            <td class="name">{{ $attr->financialAttribute->name }}</td>
                                            <td class="type hidden">{{ $attr->type_id }}</td>
                                            <td class="value"><span>{{ $attr->value }}</span>
                                                <span class="input-group-addon bootstrap-touchspin-postfix" style="width:auto;float:right;">{{ $translatedLists[$attr->type_id] }}</span>
                                            </td>
                                            <td class="actions">
                                                <a href="#" class="on-editing save-row hidden"><i
                                                            class="fa fa-save"></i></a>
                                                <a href="#" class="on-editing cancel-row hidden"><i
                                                            class="fa fa-times"></i></a>
                                                <a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
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

        </div> <!-- end col-->
    </div>
@endsection

@section('bottom_scripts')
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
                            .events()
                    ;
                },

                setVars: function () {
                    this.$table = $(this.options.table);
                    this.$addButton = $(this.options.addButton);

                    // dialog
                    this.dialog = {};
                    this.dialog.$wrapper = $(this.options.dialog.wrapper);
                    this.dialog.$cancel = $(this.options.dialog.cancelButton);
                    this.dialog.$confirm = $(this.options.dialog.confirmButton);

                    this.attrTypes = {!! $translatedLists !!};

                    return this;
                },

                build: function () {
                    this.datatable = this.$table.DataTable({
                        searching: false,
                        lengthChange: false,
                        pageLength: 15,
                        aoColumns: [
                            null,
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

                configureFields: function () {
                    var _self = this;

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
                        '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>'
                    ].join(' ');

                    data = this.datatable.row.add(['','','', actions]);
                    $row = this.datatable.row(data[0]).nodes().to$();

                    $row
                            .addClass('adding')
                            .find('td:first')
                            .addClass('id');

                    $row
                            .addClass('adding')
                            .find('td:nth-child(2)')
                            .addClass('name');

                    $row
                            .addClass('adding')
                            .find('td:nth-child(3)')
                            .addClass('type');

                    $row
                            .addClass('adding')
                            .find('td:nth-child(4)')
                            .addClass('value');

                    $row
                            .addClass('adding')
                            .find('td:last')
                            .addClass('actions');

                    this.rowEdit($row);
                    this.datatable.order([0, 'asc']).draw(); // always show fields
                    this.configureFields();
                },

                rowCancel: function ($row) {
                    var _self = this,
                            $actions,
                            i,
                            data;

                    if ($row.hasClass('adding')) {
                        this.rowRemove($row);
                    } else {

                        $row.off('click', 'button.attr_type');

                        data = this.datatable.row($row.get(0)).data();
                        this.datatable.row($row.get(0)).data(data);

                        //console.log('Cancel: ' + data);
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

                    data = $row.find('td').map(function () {
                        var $this = $(this);

                        if ($this.hasClass('value')) {
                            return $.trim($this.find("span:first-child").text());
                        } else {
                            return _self.datatable.cell(this).data();
                        }
                    });

                    //console.log('Edit: ' + JSON.stringify(data));
                    $row.children('td').each(function (i) {
                        var $this = $(this);

                        if ($this.hasClass('actions')) {
                            _self.rowSetActionsEditing($row);
                        } else if ($this.hasClass('value')) {
                            $this.html('<div class="input-group">' +
                                    '<input type="text"' +
                                    'name="value" value="' + data[i] + '" placeholder="" class="form-control currency"' +
                                    'value="' + data[i] + '">' +
                                    '<span class="input-group-btn"><button class="btn btn-info bootstrap-touchspin-up attr_type" title="click to change">' + _self.attrTypes[data[i-1]] + '</button></span>');

                            $row.on('click', 'button.attr_type', function (e) {
                                var cVal = $(this).closest('tr').find('td.type').text();
                                var firstEntry = null;
                                var entryFound = false;
                                var k;
                                for (k in _self.attrTypes) {
                                    if (firstEntry===null) {
                                        firstEntry = k;
                                    }
                                    if (entryFound==true) {
                                        $(this).text(_self.attrTypes[k]);
                                        $(this).closest('tr').find('td.type').text(k);
                                        entryFound = false;
                                        break;
                                    } else if (k==cVal) {
                                        entryFound = true;
                                    }
                                }
                                if (entryFound) {
                                    $(this).text(_self.attrTypes[firstEntry]);
                                    $(this).closest('tr').find('td.type').text(firstEntry);
                                }
                            })
                        }
                    });
                    this.configureFields();
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
                        } else if ($this.hasClass('type')) {
                            return $.trim($this.text());
                        } else if ($this.hasClass('value')) {
                            $this.find('input').prop('disabled', true);
                            $this.find('button').prop('disabled', true);
                            return $.trim($this.find('input').val());
                        } else {
                            return _self.datatable.cell(this).data();
                        }
                    });

                    //console.log('Save: ' + JSON.stringify(values));
                    $.ajax({
                        type: 'PUT',
                        url: '{{route('customFinancialAttribute.upsert')}}',
                        dataType: 'json',
                        data: {id: values[0], type_id: values[2], value: values[3], region_id: '{{$office->region->id}}', office_id: '{{$office->id}}' }
                    }).done(function (data) {
                        if (data.success) {
                            $row.off('click', 'button.attr_type');

                            values[3] = '<span>' + values[3] + '</span><span class="input-group-addon bootstrap-touchspin-postfix" style="width:auto;float:right;">' + _self.attrTypes[values[2]] + '</span>';
                            _self.datatable.row($row.get(0)).data(values);
                            _self.datatable.draw();

                            $actions = $row.find('td.actions');
                            if ($actions.get(0)) {
                                _self.rowSetActionsDefault($row);
                            }
                        }
                    });
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
                EditableTable.initialize();
            });

        }).apply(this, [jQuery]);
    </script>
@endsection