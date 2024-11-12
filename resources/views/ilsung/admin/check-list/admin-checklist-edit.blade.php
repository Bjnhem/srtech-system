@extends('pro_3m.admin.check-list.admin-layout')
@section('content')
    <div class="container-fluid" style="margin-top: 1px;">
        <!-- Content Row -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="text-primary mx-3"><b><i class="icon-line-check-square" style="padding-right: 5px"></i>CHECK LIST
                        PRO-3M</b>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <ul id="myTab" class="nav nav-tabs boot-tabs mb-5">
                        <li class="nav-item">
                            <button class="nav-link   " id="glass" data-bs-toggle="tab" data-bs-target="#all-post"
                                type="button" role="tab" aria-controls="nav-disabled"
                                aria-selected="false">GLASS</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link " id="pad" data-bs-toggle="tab" data-bs-target="#smart-post"
                                type="button" role="tab" aria-controls="nav-disabled"
                                aria-selected="false">PAD</button>
                        </li>
                        <li class="nav-item"> <button class="nav-link  active" id="FTG" data-bs-toggle="tab"
                                data-bs-target="#study-post" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">FTG</button></li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <span>Checklist:</span>
                        <select name="check_list" id="check_list" class="form-select">

                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>Loại Line:</span>
                        <select name="line_type" id="line_type" class="form-select">

                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>Công Đoạn:</span>
                        <select name="cong_doan" id="cong_doan" class="form-select">
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>Phân Loại:</span>
                        <select name="phan_loai" id="phan_loai" class="form-select">
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="add_check_list" class="form-control btn-primary"></i>Thêm nội
                            dung
                        </button>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="delete_check_list" class="form-control btn-danger"></i>Xóa
                            check list
                        </button>
                    </div>



                    {{--  <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="save-check-list" class="form-control btn-success"></i>Save
                        </button>
                    </div> --}}

                </div>
                <br>
                <table class="table table-bordered text-center mt-4 table-hover" id="table-check-list"
                    style="width: 100%; text-align: center; vertical-align:middle">
                    <thead class="table-success">
                        {{--  <tr>
                            <th style="width:3%">STT</th>
                            <th style="width:3%">ID</th>
                            <th style="width:3%">ID phân loại</th>
                            <th style="width:7%">Check List</th>
                            <th style="width:7%">Công đoạn</th>
                            <th style="width:7%">Phân loại</th>
                            <th style="width:auto">Nội dung</th>
                        </tr> --}}
                    </thead>
                </table>
            </div>
        </div>

    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            localStorage.setItem('activeItem', 'Checklist-Edit');
            var table_1 = 'check_list_detail'
            var colum_table = [];
            var tables;
            var tab = @json($view);
            show_check_list(tab);

            var table = 'result';
            var table_2 = 'result_detail'
            var table_result = tab + '_' + table;
            var table_result_detail = tab + '_' + table_2;
            var buttom = document.querySelectorAll("#myTab button");
            buttom.forEach((item) => item.addEventListener('click', function(event) {
                tab = this.id;
                table_result = tab + '_' + table;
                table_result_detail = tab + '_' + table_2;
                show_check_list(tab);
            }));

            function show_check_list(tab) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.show.check.list') }}",
                    dataType: "json",
                    data: {
                        group: tab,
                    },
                    success: function(response) {
                        $('#check_list').empty();
                        $('#cong_doan').empty();
                        $('#line_type').empty();
                        $('#phan_loai').empty();
                        $('#line').empty();
                        $('#check_list').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#check_list').append($('<option>', {
                                value: value.id,
                                text: value.check_list,
                            }));
                        });
                    }
                });
            }

            $('#check_list').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.line.type.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();
                        $('#cong_doan').empty();
                        $('#line_type').empty();

                        // $('#table-check-list').DataTable().destroy();
                        $('#line_type').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#line_type').append($('<option>', {
                                value: value.id,
                                text: value.line_type,
                            }));
                        });
                    }
                });

            });

            $('#line_type').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.cong.doan.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();
                        $('#cong_doan').empty();

                        // $('#table-check-list').DataTable().destroy();
                        $('#cong_doan').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#cong_doan').append($('<option>', {
                                value: value.id,
                                text: value.cong_doan,
                            }));
                        });
                    }
                });

            });

            $('#cong_doan').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.phan.loai.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();

                        // $('#table-check-list').DataTable().destroy();
                        $('#phan_loai').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data2, function(index, value) {
                            $('#phan_loai').append($('<option>', {
                                value: value.id,
                                text: value.phan_loai,
                            }));
                        });
                    }
                });
            });

            $('#phan_loai').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.check.list.search.edit') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(users) {
                        var colum = users.colums;
                        colum_table = [];
                        var count = 0;
                        var data = [];
                        $.each(users.colums, function(index, value) {
                            if (value != 'id') {
                                count++;
                                colum_table.push([count, value]);
                            }
                        });
                        if (tables) {
                            tables.clear();
                            tables.rows.add(users.data);
                            tables.draw();

                        } else {

                            tables = $('#table-check-list').DataTable({
                                data: users.data,
                                "info": false,
                                'ordering': false,
                                'autowidth': true,
                                "dom": 'Bfrtip',

                                select: {
                                    style: 'multi',
                                },

                                columns: colum.map(function(columnMane) {
                                    return {
                                        title: columnMane,
                                        data: columnMane,
                                    };
                                })


                            });
                            $('#add-check-list').css('display', 'block');
                        }
                    }
                });


            });

            $(document).on('click', '#add_check_list', function(e) {
                e.preventDefault();
                var phan_loai = $('#phan_loai option:selected').val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.check.list.new_row') }}',
                    data: {
                        id: phan_loai,
                        table: table_1
                    },
                    success: function(users) {
                        tables.clear();
                        tables.rows.add(users.data);
                        tables.draw();
                    }
                });

            });

           

            $('#table-check-list').on('draw.dt', function() {
                table_id = 'table-check-list';
                editTable();
            });

            $(document).on('click', '#delete_check_list', function(e) {
                e.preventDefault();
                var rowSelect = tables.rows('.selected').data();
                var rowSelected = tables.rows('.selected').indexes();
                var idsrow = rowSelect.toArray().map(row => row.id);

                console.log(idsrow);
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.check.list.delete.edit') }}",
                    dataType: "json",
                    data: {
                        table1: table_1,
                        rowId: idsrow,
                    },
                    success: function(users, ) {
                        for (var i = rowSelected.length - 1; i >= 0; i--) {
                            tables.row(rowSelected[i]).remove();
                        }
                        tables.draw();
                    }
                });
            });


            function editTable() {
                $('#' + table_id).Tabledit({
                    url: "admin-dashboard/table/edit-table/" + table_1,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: false,
                    deleteButton: false,
                    uploadButton: false,
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            $('#' + data.id).remove();
                            $('#' + table_id).DataTable().ajax.reload();
                        }

                    }
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
        });
    </script>
@endsection
