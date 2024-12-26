@extends('Checklist_EQM.admin.check-list.admin-layout')

@section('content')
    <div class="container">
        <ul id="myTab" class="nav nav-tabs boot-tabs mb-5">
            <li class="nav-item">
                <button class="nav-link active" id="check-list-1" value="Model_master" data-bs-toggle="tab"
                    data-bs-target="#check-list" type="button" role="tab" aria-controls="nav-disabled"
                    aria-selected="false">Model</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="line-type-1" value="line" data-bs-toggle="tab" data-bs-target="#line-type"
                    type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">Line</button>
            </li>
            <li class="nav-item"> <button class="nav-link" id="cong-doan-1" value="Machine_master" data-bs-toggle="tab"
                    data-bs-target="#study-post" type="button" role="tab" aria-controls="nav-home"
                    aria-selected="true">Machine</button></li>
            <li class="nav-item"> <button class="nav-link" id="phan-loai-1" value="Machine_list" data-bs-toggle="tab"
                    data-bs-target="#mind-post" type="button" role="tab" aria-controls="nav-profile"
                    aria-selected="false">machine list</button></li>
            <li class="nav-item">
                <button class="nav-link" id="line-1" value="Checklist_item" data-bs-toggle="tab" data-bs-target="#line1"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Item check</button>

            </li>
            <li class="nav-item">
                <button class="nav-link" id="line-1" value="Checklist_master" data-bs-toggle="tab" data-bs-target="#line1"
                    type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Master checklist</button>

            </li>
            <li class="nav-item">
                <button class="nav-link" id="nhan_vien-1" value="nhan_vien_check_list" data-bs-toggle="tab"
                    data-bs-target="#nhan-vien" type="button" role="tab" aria-controls="nav-disabled"
                    aria-selected="false">Nhân Viên</button>
            </li>
        </ul>
        <div class="tab-content mt-4" id="nav-tabContent">
            {{-- =====  Hoạt động nổi bật ===== --}}
            <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1"
                tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                
                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                {{--  <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="delete-row" class="form-control btn-danger"></i>Xóa
                                    </button>
                                </div> --}}
                            </div>

                            {{--  <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                                <thead class="table-success"></thead>
                            </table> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="line-type" role="tabpanel" aria-labelledby="line-type-1" tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                <div class="col-sm-2">
                                    <span>Loại Line:</span>
                                    <select name="line_type" id="line_type" class="form-select">

                                    </select>
                                </div>


                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                {{--  <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="delete-row" class="form-control btn-danger"></i>Xóa
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="cong-doan" role="tabpanel" aria-labelledby="cong-doan-1" tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                {{-- <div class="col-sm-2">
                                <span>Loại Line:</span>
                                <select name="line_type" id="line_type" class="form-select">

                                </select>
                            </div>
                           
                            <div class="col-sm-2">
                                <span>Phân Loại:</span>
                                <select name="phan_loai" id="phan_loai" class="form-select">
                                </select>
                            </div> --}}
                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                {{--  <div class="col-sm-2">
                            <span>
                                <br>
                            </span>
                            <button id="delete-row" class="form-control btn-danger"></i>Xóa
                            </button>
                        </div> --}}
                            </div>

                            {{--  <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success"></thead>
                    </table> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="phan-loai" role="tabpanel" aria-labelledby="phan-loai-1" tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                {{-- <div class="col-sm-2">
                            <span>Loại Line:</span>
                            <select name="line_type" id="line_type" class="form-select">

                            </select>
                        </div>
                       
                        <div class="col-sm-2">
                            <span>Phân Loại:</span>
                            <select name="phan_loai" id="phan_loai" class="form-select">
                            </select>
                        </div> --}}
                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                {{--  <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="delete-row" class="form-control btn-danger"></i>Xóa
                        </button>
                    </div> --}}
                            </div>

                            {{--  <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                    <thead class="table-success"></thead>
                </table> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="line1" role="tabpanel" aria-labelledby="line-1" tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                <div class="col-sm-2">
                                    <span>Loại Line:</span>
                                    <select name="line_type" id="line_type" class="form-select">

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
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="delete-row" class="form-control btn-danger"></i>Xóa
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nhan-vien" role="tabpanel" aria-labelledby="nhan-vien-1" tabindex="0">
                <div class="container">
                    <div class="card card-ke-hoach table-responsive">
                        <div class="card-body ">
                            <div class="row mb-5">
                                <div class="col-sm-2">
                                    <span>Group:</span>
                                    <input type="text" name="Group" id="Group" class="form-control">

                                </div>

                                <div class="col-sm-2">
                                    <span>Checklist:</span>
                                    <input type="text" name="check_list" id="check_list" class="form-control">

                                </div>
                                {{-- <div class="col-sm-2">
                            <span>Loại Line:</span>
                            <select name="line_type" id="line_type" class="form-select">

                            </select>
                        </div>
                       
                        <div class="col-sm-2">
                            <span>Phân Loại:</span>
                            <select name="phan_loai" id="phan_loai" class="form-select">
                            </select>
                        </div> --}}
                                <div class="col-sm-2">
                                    <span>
                                        <br>
                                    </span>
                                    <button id="add_check_list" class="form-control btn-primary"></i>Thêm
                                    </button>
                                </div>
                                {{--  <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="delete-row" class="form-control btn-danger"></i>Xóa
                        </button>
                    </div> --}}
                            </div>

                            {{--  <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                    <thead class="table-success"></thead>
                </table> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card card-ke-hoach table-responsive">
                <div class="card-body ">
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success"></thead>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('admin-js')
        <script>
            $(document).ready(function() {
                localStorage.setItem('activeItem', 'master');
                var table = 'check_list';
                var colum_table = [];
                var colums = [];
                var tables;

                /*  $('#model').val() = table; */
                data_table_view(table);


                var buttom = document.querySelectorAll("#myTab button");
                buttom.forEach((item) => item.addEventListener('click', function(event) {
                    table = $(this).val();
                    colums = [];
                    data_table_view(table);

                }));

                function editTable() {
                    $('#table-result').Tabledit({
                        url: "admin-dashboard/master/edit-table/" + table,
                        method: 'POST',
                        dataType: 'json',
                        columns: {
                            identifier: [0, 'id'],
                            editable: colum_table,
                        },
                        restoreButton: false,
                        deleteButtom: false,
                        onSuccess: function(data, textStatus, jqXHR) {
                            if (data.action == 'delete') {
                                data_table_view(table);
                            }
                        }
                    });
                }

                function data_table_view(id_table) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.show.model') }}",
                        dataType: "json",
                        data: {
                            table: id_table,
                        },
                        success: function(users) {
                            var colum = users.colums;
                            var count = 0;
                            // console.log(colum);
                            $.each(colum, function(index, value) {
                                if (value != 'id') {
                                    count++;
                                    colum_table.push([count, value]);

                                    window[value] = [];
                                    colums.push(value);
                                }
                            });
                            console.log(colums);
                            /*  var group = [];
                              var check_list = [];  */

                            $.each(users.data, function(index, value) {
                                $.each(colums, function(index, row) {
                                    window[row].push(value[row]);
                                    window[row] = [...new Set(window[row])];
                                });


                            });

                            $.each(colums, function(index, row) {
                                $("#" + row).autocomplete({
                                    source: window[row]
                                });
                            });






                            if (tables) {
                                $('#table-result').DataTable().clear().destroy();
                                $('#table-result thead tr').remove();
                            }
                            tables = $('#table-result').DataTable({
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

                        }
                    });
                }


                $(document).on('click', '#add_check_list', function(e) {
                    e.preventDefault();
                    var model = table;
                    var group_master = $('#group').val();
                    var check_list_master = $('#check_list_master').val();
                    if (group == '' || check_list_master == '') {
                        alert('Bạn nhập thiếu thông tin');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('master.add.check.list.name') }}",
                            dataType: "json",
                            data: {
                                table: model,
                                Group: group_master,
                                check_list: check_list_master
                            },
                            success: function(users) {
                                if (users.status == 200) {
                                    data_table_view(table);
                                    alert('Thêm thành công');
                                }

                                if (users.status == 400) {
                                    alert('Check list đã tồn tại');

                                }
                            }
                        });
                    }
                });
                $(document).on('click', '#new-row', function(e) {
                    e.preventDefault();
                    var model = table;
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.new_row') }}",
                        dataType: "json",
                        data: {
                            table: model,
                        },
                        success: function(users, ) {
                            var colum = users.colums;
                            var count = 0;
                            colum_table = [];
                            $.each(colum, function(index, value) {
                                if (value != 'id') {
                                    count++;
                                    colum_table.push([count, value]);
                                }
                            });

                            var table = $('#table-result').DataTable();
                            table.clear().rows.add(users.data).draw();
                        }
                    });
                });

                $(document).on('click', '#delete-row', function(e) {
                    e.preventDefault();
                    var model = table;
                    var rowSelect = tables.rows('.selected').data();
                    var idsrow = rowSelect.toArray().map(row => row.id);
                    console.log(idsrow);
                    $.ajax({
                        type: "GET",
                        url: "{{ route('master.delete_row') }}",
                        dataType: "json",
                        data: {
                            table: model,
                            rowId: idsrow,
                        },
                        success: function(users, ) {
                            var colum = users.colums;
                            var count = 0;
                            colum_table = [];
                            $.each(colum, function(index, value) {
                                if (value != 'id') {
                                    count++;
                                    colum_table.push([count, value]);
                                }
                            });
                            var tables = $('#table-result').DataTable();
                            tables.clear().rows.add(users.data).draw();
                        }
                    });
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    }
                });

                $('#table-result').on('draw.dt', function() {
                    editTable();
                });

            });
        </script>
    @endsection
