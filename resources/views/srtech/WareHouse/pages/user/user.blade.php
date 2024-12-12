@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Users List</h4>
                    </div>
                    <div class="card-action">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary" role="button">Add User</a>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table text-center table-striped w-100" id="dataTable">
                            <thead>
                                <tr style="text-align: center">
                                    <th title="id">id</th>
                                    <th title="FULL NAME">FULL NAME</th>
                                    <th title="Email">Email</th>
                                    <th title="Status">Status</th>
                                    <th title="Action" width="60">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        div.dt-buttons {
            display: none
        }

        table.dataTable>thead>tr>th,
        table.dataTable>thead>tr>td {
            text-align: center;
        }
    </style>
@endsection

@section('admin-js')
    <script type="text/javascript">
        $(function() {
            window.LaravelDataTables = window.LaravelDataTables || {};
            window.LaravelDataTables["dataTable"] = $("#dataTable").DataTable({
                "serverSide": true,
                "processing": true,
                dom: 'Bfrtip',

                "ajax": {
                    "url": "{{ route('users.index') }}",
                    "type": "GET",
                    "data": function(data) {
                        for (var i = 0, len = data.columns.length; i < len; i++) {
                            if (!data.columns[i].search.value) delete data.columns[i].search;
                            if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                            if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                            if (data.columns[i].data === data.columns[i].name) delete data.columns[i]
                                .name;
                        }
                        delete data.search.regex;
                    }
                },
                "columns": [{
                        "name": "id",
                        "data": "id",
                        "title": "id",
                        "orderable": true,
                        "searchable": true
                    }, {
                        "name": "full_name",
                        "data": "full_name",
                        "title": "FULL NAME",
                        "orderable": false,
                        "searchable": true
                    },

                    {
                        "name": "email",
                        "data": "email",
                        "title": "Email",
                        "orderable": true,
                        "searchable": true
                    },

                    {
                        "name": "status",
                        "data": "status",
                        "title": "Status",
                        "orderable": true,
                        "searchable": true
                    },

                    {
                        "data": "action",
                        "name": "action",
                        "title": "Action",
                        "orderable": false,
                        "searchable": false,
                        "width": 60,
                        "className": "text-center hide-search"
                    }
                ],
                "dom": "<\"row align-items-center\"<\"col-md-2\" l><\"col-md-6\" B><\"col-md-4\"f>><\"table-responsive my-3\" rt><\"row align-items-center\" <\"col-md-6\" i><\"col-md-6\" p>><\"clear\">",
                "autoWidth": false
            });


        });
        $('.dt-buttons').prop('none', true);
    </script>
@endsection
