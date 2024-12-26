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
                        <span>Line:</span>
                        <select name="line" id="line" class="form-select">
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>Shift:</span>
                        <select name="shift" id="shift" class="form-select">
                            <option value="Shift1A">Shift1A</option>
                            <option value="Shift2A">Shift2A</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <br>
                    </div>
                    <div class="col-sm-2">
                        <span> Tình trạng: </span>
                        <select name="status" id="status" class="form-select">
                            <option value="ON" selected>ON</option>
                            <option value="OFF">OFF</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <span>Gen:</span>
                        <input name="gen" type="number" id="gen" class="form-control" placeholder="Nhập gen...">
                    </div>
                    <div class="col-sm-2">
                        <span>Tên:</span>
                        <input name="name" type="text" id="name" class="form-control" placeholder="Nhập tên...">
                    </div>
                    <div class="col-sm-2">
                        <span>Bộ phận:</span>
                        <input name="part" type="text" id="part" class="form-control">
                    </div>

                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="save-check-list" class="form-control btn-info"><i class="icon-line-check"></i>Save
                        </button>
                    </div>

                </div>
                <br>
                <table class="table table-bordered text-center mt-4 table-hover" id="table-check-list"
                    style="width: 100%; text-align: center; vertical-align:middle">
                    <thead class="table-success">
                        <tr>
                            <th style="width:3%">STT</th>
                            <th style="width:7%">Check List</th>
                            <th style="width:7%">Công đoạn</th>
                            <th style="width:7%">Phân loại</th>
                            <th style="width:auto">Nội dung</th>
                            <th style="width:7%">Tình trạng</th>
                            <th style="width:10%">Vấn đề</th>
                            <th style="width:7%">Tiến độ</th>
                        </tr>
                    </thead>
                </table>
            </div>


        </div>

        @include('pro_3m.pages.check-list.checklist-search')
        <!-- Bootstrap Modal Lỗi -->
        <div class="modal fade" id="myModalErrorMater" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div id="upModalErrorMater">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <span id="lblTileError"></span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger">
                                <strong>Error!</strong>
                                <span id="lblNoiDungError"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--Modal đăng nhập-->
        <div class="modal fade" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div id="upModalLogin">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <span id="lblTileLogin">Đăng nhập hệ thống</span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <label for="txtGEN">GEN:</label>
                            <input name="ctl00$txtGEN" type="number" id="txtGEN" class="form-control"
                                placeholder="12345678">
                            <br>
                            <label for="txtPassword">Password</label>
                            <input name="ctl00$txtPassword" type="password" id="txtPassword" class="form-control"
                                placeholder="Mật khẩu">
                        </div>

                        <div class="modal-footer">

                            <input type="button" name="ctl00$btnDangNhap" value="Đăng nhập"
                                onclick="javascript:__doPostBack('ctl00$btnDangNhap','')" id="btnDangNhap"
                                class="btn btn-primary">
                            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Đóng</button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--Modal đổi Password-->
        <div class="modal fade" id="myModalPassChange" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div id="upModalPassChange">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">
                                <span id="lblTilePassChange">Đổi mật khẩu</span>
                            </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <label>Mật khẩu cũ</label>
                            <input name="ctl00$txtPassOld" type="password" id="txtPassOld" class="form-control"
                                placeholder="Mật khẩu cũ">
                            <br>
                            <label>Mật khẩu mới</label>
                            <input name="ctl00$txtPassNew" type="password" id="txtPassNew" class="form-control"
                                placeholder="Mật khẩu mới">
                            <br>
                            <label>Nhập lại mật khẩu mới</label>
                            <input name="ctl00$txtPassNew2" type="password" id="txtPassNew2" class="form-control"
                                placeholder="Nhập lại mật khẩu mới">
                        </div>


                        <div class="modal-footer">
                            <input type="button" name="ctl00$btnPassChange" value="Đổi mật khẩu"
                                onclick="javascript:__doPostBack('ctl00$btnPassChange','')" id="btnPassChange"
                                class="btn btn-primary pull-left">
                            <button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Đóng</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- model show check list --}}

        
    </div>
@endsection

@section('admin-js')
{{-- @include('pro_3m.pages.check-list.checklist-js') --}}

<script>
    $(document).ready(function() {
        var table = 'result_check_list';
        var table_2 = 'result_check_list_detail'
        var colum_table = [];
        var tables;
        var tab = @json($view);
        show_check_list(tab);
        var buttom = document.querySelectorAll("#myTab button");
        buttom.forEach((item) => item.addEventListener('click', function(event) {
            tab = this.id;
            show_check_list(tab);
        }));

        function show_check_list(tab) {
            $.ajax({
                type: "GET",
                url: "{{ route('show.check.list') }}",
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
                    $('#check_list_search').empty();
                    $('#cong_doan_search').empty();
                    $('#line_type_search').empty();
                    $('#phan_loai_search').empty();
                    $('#line_search').empty();
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

                    $('#check_list_search').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data, function(index, value) {
                        $('#check_list_search').append($('<option>', {
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
                url: '{{ route('line.type.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#phan_loai').empty();
                    $('#cong_doan').empty();
                    $('#line_type').empty();
                    $('#line').empty();
                    $('#table-check-list').DataTable().destroy();
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
                url: '{{ route('cong.doan.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#phan_loai').empty();
                    $('#cong_doan').empty();
                    $('#line').empty();
                    $('#table-check-list').DataTable().destroy();
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
                url: '{{ route('phan.loai.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#phan_loai').empty();
                    $('#line').empty();
                    $('#table-check-list').DataTable().destroy();
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

                    $('#line').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data1, function(index, value) {
                        $('#line').append($('<option>', {
                            value: value.id,
                            text: value.line,
                        }));
                    });
                }
            });
        });

        $('#phan_loai').on('change', function() {
            var check_list_search = $(this).val();
            $.ajax({
                type: "GET",
                url: '{{ route('check.list.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#table-check-list').DataTable().destroy();
                    var count = 0;
                    var data = [];
                    $.each(response.data_check_list, function(index, value) {
                        count++;

                        var status =
                            '<select name = "status" id="' + value.id +
                            '" class="form-select">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <option value = "OK">OK</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <option value = "NG">NG</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </select>';
                        var problem =
                            ' <input name="problem" type="text" id="' + value.id +
                            '" class="form-control">';
                        var process =
                            '<select name = "process" id="' + value.id +
                            '" class="form-select">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <option value = "Complete">Complete</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <option value = "Pending" >pending</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <option value = "Improgress" >Improgress</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </select >';
                        data.push([
                            count,
                            $('#check_list option:selected').text(),
                            $('#cong_doan option:selected').text(),
                            $('#phan_loai option:selected').text(),
                            value.comment,
                            status,
                            problem,
                            process
                        ]);
                    });
                    $('#table-check-list').DataTable().destroy();
                    $('#table-check-list').DataTable({
                        data: data,
                        "info": false,
                        'ordering': false,
                        'searching': false,

                        /*   drawCallback: function() {
                              $('#table-result-traning tbody td:nth-child(6)').each(function(
                                  index) {
                                  $(this).html(status);
                              })
                              $('#table-result-traning tbody td:nth-child(7)').each(function(
                                  index) {
                                  $(this).html('ok');
                              })
                              $('#table-result-traning tbody td:nth-child(8)').each(function(
                                  index) {
                                  $(this).html('anh');
                              })
                          } */
                    });

                }
            });


        });

        $(document).on('click', '#save-check-list', function(e) {
            e.preventDefault();
            var data = [];
            var data2 = [];
            var group = tab;
            var check_list = $('#check_list option:selected').text();
            var cong_doan = $('#cong_doan option:selected').text();
            var line_type = $('#line_type option:selected').text();
            var phan_loai = $('#phan_loai option:selected').text();
            var line = $('#line option:selected').text();
            var shifts = $('#shift option:selected').text();
            var tinh_trang = $('#status option:selected').text();
            var name = $('#gen').val() + ' - ' + $('#name').val();
            var part = $('#part').val();
            var problems_1 = "";
            var status_1 = 'OK';
            var process_1 = 'Complate';

            if (line == '---' || shifts == '---' || tinh_trang == '---' || phan_loai == '---' || name ==
                ' - ' || part == '') {
                alert('Bạn điền thiếu thông tin');
            } else {
                $('#table-check-list').DataTable().rows().every(function() {
                    var status = $(this.node()).find('select[name="status"] option:selected')
                        .text();
                    var process = $(this.node()).find('select[name="process"] option:selected')
                        .text();

                    if (status == 'NG') {
                        status_1 = "NG";
                    }
                    if (process != 'Complate') {
                        process_1 = process;
                    }
                });
                var data3 = {
                    groups: group,
                    check_list: check_list,
                    phan_loai: phan_loai,
                    cong_doan: cong_doan,
                    line_type: line_type,
                    line: line,
                    shifts: shifts,
                    name: name,
                    part: part,
                    tinh_trang: tinh_trang,
                    status: status_1,
                    problem: problems_1,
                    process: process_1,
                }
                data2.push(data3);
                console.log(data2);

                $.ajax({
                    type: "POST",
                    url: "{{ route('save.check.list') }}",
                    contentType: 'application/json',
                    data: JSON.stringify(data2),
                    success: function(users) {
                        var id = users.id;
                        $('#table-check-list').DataTable().rows().every(function() {
                            var rowData = this.data();
                            var problems = $(this.node()).find('input').val();
                            var status = $(this.node()).find(
                                    'select[name="status"] option:selected')
                                .text();
                            var process = $(this.node()).find(
                                    'select[name="process"] option:selected')
                                .text();
                            var newData = {
                                id_check_list: id,
                                check_list: rowData[1],
                                cong_doan: rowData[2],
                                phan_loai: rowData[3],
                                comment: rowData[4],
                                line: line,
                                line_type: line_type,
                                shifts: shifts,
                                name: name,
                                part: part,
                                tinh_trang: tinh_trang,
                                status: status,
                                problem: problems,
                                process: process,
                            }
                            data.push(newData);
                        })
                        $.ajax({
                            type: "POST",
                            url: "{{ route('save.check.list.detail') }}",
                            contentType: 'application/json',
                            data: JSON.stringify(data),
                            success: function(users) {
                                alert('save check-list Thành công');
                            }
                        });
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var table = 'result_check_list';
        var table_2 = 'result_check_list_detail'
        var colum_table = [];
        var tables;
       
        /*     js cho search checklist */

        $('#check_list_search').on('change', function() {
            var check_list_search = $(this).val();
            $.ajax({
                type: "GET",
                url: '{{ route('line.type.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#cong_doan_search').empty();
                    $('#phan_loai_search').empty();
                    $('#line_type_search').empty();
                    $('#line_search').empty();
                    // $('#table_check_list_search').DataTable().destroy();
                    $('#line_type_search').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data, function(index, value) {
                        $('#line_type_search').append($('<option>', {
                            value: value.id,
                            text: value.line_type,
                        }));
                    });
                }
            });

        });

        $('#line_type_search').on('change', function() {
            var check_list_search = $(this).val();
            $.ajax({
                type: "GET",
                url: '{{ route('cong.doan.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#cong_doan_search').empty();
                    $('#phan_loai_search').empty();
                    $('#line_search').empty();
                    // $('#table-check-list').DataTable().destroy();
                    $('#cong_doan_search').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data, function(index, value) {
                        $('#cong_doan_search').append($('<option>', {
                            value: value.id,
                            text: value.cong_doan,
                        }));
                    });
                }
            });

        });

        $('#cong_doan_search').on('change', function() {
            var check_list_search = $(this).val();
            $.ajax({
                type: "GET",
                url: '{{ route('phan.loai.search') }}',
                data: {
                    id: check_list_search,
                },
                success: function(response) {
                    $('#phan_loai_search').empty();
                    $('#line_search').empty();
                    // $('#table_check_list_search').DataTable().destroy();
                    $('#line_search').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data1, function(index, value) {
                        $('#line_search').append($('<option>', {
                            value: value.id,
                            text: value.line,
                        }));
                    });
                    $('#phan_loai_search').append($('<option>', {
                        value: null,
                        text: '---',
                    }));
                    $.each(response.data2, function(index, value) {
                        $('#phan_loai_search').append($('<option>', {
                            value: value.id,
                            text: value.phan_loai,
                        }));
                    });
                }
            });
        });

        function Convertdate(date) {

            var data = date.split('/');
            var dateconvert = data[2] + '-' + data[0] + '-' + data[1];
            return dateconvert;
        }

        $(document).on('click', '#Search', function(e) {
            e.preventDefault();
            if (tables) {
                $('#table_check_list_search').DataTable().destroy();
            }
            var check_list_search = $('#check_list_search option:selected').text();
            var phan_loai_search = $('#phan_loai_search option:selected').text();
            var cong_doan_search = $('#cong_doan_search option:selected').text();
            var line_type_search = $('#line_type_search option:selected').text();
            var line_search = $('#line_search option:selected').text();
            var shift_search = $('#shift_search option:selected').text();
            var tinh_trang = $('#status_search option:selected').text();
            var date_form = Convertdate($('#date_form').val());
            var date_to = Convertdate($('#date_to').val());

            if ($('#date_form').val() == 0 || $('#date_to').val() == 0) {
                alert('Vui lòng chọn thời gian kiểm tra');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('search.check.list') }}",
                    dataType: 'json',
                    data: {
                        check_list: check_list_search,
                        cong_doan: cong_doan_search,
                        line_type: line_type_search,
                        phan_loai: phan_loai_search,
                        line: line_search,
                        shift: shift_search,
                        tinh_trang: tinh_trang,
                        date_form: date_form,
                        date_to: date_to,
                        table: table
                    },
                    success: function(users) {
                        var count = 0;
                        var data = [];
                        var colum = [];
                        var data;
                        colum_table = [];
                        $.each(users.colums, function(index, value) {
                            colum.push([value]);
                        });
                        colum.push(['View']);
                        $.each(users.data, function(index, value) {

                            var time = new Date(value.created_at);

                            var date = time.getDate() + '-' + (time.getMonth() +
                                    1) +
                                '-' + time.getFullYear();
                            var view = '<button type="button" value="' + value.id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view"><span class="icon-eye2"></span></button>';
                            data.push([
                                value.id,
                                value.groups,
                                value.check_list,
                                value.cong_doan,
                                value.phan_loai,
                                value.line,
                                value.shifts,
                                value.name,
                                value.part,
                                value.status,
                                value.problem,
                                value.process,
                                value.tinh_trang,
                                date,
                                view,
                            ]);
                        });

                        tables = $('#table_check_list_search').DataTable({
                            data: data,
                            "info": false,
                            'ordering': false,
                            'autowidth': true,
                            "dom": 'Bfrtip',
                            /* select: {
                                style: 'multi',
                            }, */

                        });
                    }
                });
            }
        });

        $(document).on('click', '#view', function(e) {
            e.preventDefault();
            var id = $(this).val();
            console.log(id);
            $.ajax({
                type: "post",
                url: "{{ route('search.check.list.view') }}",
                dataType: "json",
                data: {
                    id: id,
                    table: table_2,
                },
                success: function(users) {
                    var colum = users.colums;
                    var count = 0;
                    $.each(colum, function(index, value) {
                        if (value != 'id') {
                            count++;
                            colum_table.push([count, value]);
                        }
                    });
                    /*  if ($.fn.DataTable.isDataTable('#table_check_list_view')) {
                         tables_view= $('#table_check_list_view').DataTable();
                         tables_view.ajax.reload();
                         
                     } 
                     else { */
                    $('#table_check_list_view').DataTable({
                        data: users.data,
                        "info": false,
                        'ordering': false,
                        'autowidth': true,
                        "dom": 'Bfrtip',
                        columns: colum.map(function(columnMane) {
                            return {
                                title: columnMane,
                                data: columnMane,
                            };
                        })
                    });
                    /* } */


                }
            });

        });

        $(document).on('click', '#close-model', function(e) {
            e.preventDefault();
            console.log('abc');
            $('#table_check_list_view').DataTable().clear().destroy();
            $('#table_check_list_view thead tr').remove();
            // $('#table_check_list_view').empty();
            $('#modal-show').modal('hide');
        });

        function editTable() {

            $('#table_check_list_view').Tabledit({
                url: "check-list/edit-table/" + table_2,
                method: 'POST',
                dataType: 'json',
                columns: {
                    identifier: [0, 'id'],
                    editable: colum_table,
                },
                restoreButton: true,
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

        $('#table_check_list_view').on('draw.dt', function() {
            editTable();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            }
        });
    });
</script>

  {{--   <link rel="stylesheet" href="{{ asset('smart-ver2/css/components/datepicker.css') }}" type="text/css" />
    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
 
    <script>
        $(document).ready(function() {
            var table = 'result_check_list';
            var table_2 = 'result_check_list_detail'
            var colum_table = [];
            var tables;

            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true
            });
            localStorage.setItem('activeItem', 'overview');
            var activeItem = localStorage.getItem('activeItem');
            let list = document.querySelectorAll(".sidebar-body-menu a");

            if (activeItem) {
                var selectedItem = document.getElementById(activeItem);
                if (selectedItem) {
                    selectedItem.classList.add('active');
                }
            }

            function activeLink() {
                var itemId = this.id;
                list.forEach((item) => {
                    item.classList.remove("active");
                });
                this.classList.add("active");
                localStorage.setItem('activeItem', itemId);
            }
            list.forEach((item) => item.addEventListener('click', activeLink));

            var tab = 'FTG';
            show_check_list(tab, );

            var buttom = document.querySelectorAll("#myTab button");
            buttom.forEach((item) => item.addEventListener('click', function(event) {
                tab = this.id;
                show_check_list(tab);
            }));

            function show_check_list(tab) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('show.check.list') }}",
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
                        $('#check_list_search').empty();
                        $('#cong_doan_search').empty();
                        $('#line_type_search').empty();
                        $('#phan_loai_search').empty();
                        $('#line_search').empty();
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

                        $('#check_list_search').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#check_list_search').append($('<option>', {
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
                    url: '{{ route('line.type.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();
                        $('#cong_doan').empty();
                        $('#line_type').empty();
                        $('#line').empty();
                        $('#table-check-list').DataTable().destroy();
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
                    url: '{{ route('cong.doan.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();
                        $('#cong_doan').empty();
                        $('#line').empty();
                        $('#table-check-list').DataTable().destroy();
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
                    url: '{{ route('phan.loai.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai').empty();
                        $('#line').empty();
                        $('#table-check-list').DataTable().destroy();
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

                        $('#line').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data1, function(index, value) {
                            $('#line').append($('<option>', {
                                value: value.id,
                                text: value.line,
                            }));
                        });
                    }
                });
            });


            $('#phan_loai').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('check.list.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_check_list, function(index, value) {
                            count++;

                            var status =
                                '<select name = "status" id="' + value.id +
                                '" class="form-select">\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <option value = "OK">OK</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <option value = "NG">NG</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </select>';
                            var problem =
                                ' <input name="problem" type="text" id="' + value.id +
                                '" class="form-control">';
                            var process =
                                '<select name = "process" id="' + value.id +
                                '" class="form-select">\
                                                                                                                                                                                                                                                                                                                                                                                                                                              <option value = "Complete">Complete</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                               <option value = "Pending" >pending</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                 <option value = "Improgress" >Improgress</option>\
                                                                                                                                                                                                                                                                                                                                                                                                                                                </select >';
                            data.push([
                                count,
                                $('#check_list option:selected').text(),
                                $('#cong_doan option:selected').text(),
                                $('#phan_loai option:selected').text(),
                                value.comment,
                                status,
                                problem,
                                process
                            ]);
                        });
                        $('#table-check-list').DataTable().destroy();
                        $('#table-check-list').DataTable({
                            data: data,
                            "info": false,
                            'ordering': false,
                            'searching': false,

                            /*   drawCallback: function() {
                                  $('#table-result-traning tbody td:nth-child(6)').each(function(
                                      index) {
                                      $(this).html(status);
                                  })
                                  $('#table-result-traning tbody td:nth-child(7)').each(function(
                                      index) {
                                      $(this).html('ok');
                                  })
                                  $('#table-result-traning tbody td:nth-child(8)').each(function(
                                      index) {
                                      $(this).html('anh');
                                  })
                              } */
                        });

                    }
                });


            });


            $(document).on('click', '#save-check-list', function(e) {
                e.preventDefault();
                var data = [];
                var data2 = [];
                var group = tab;
                var check_list = $('#check_list option:selected').text();
                var cong_doan = $('#cong_doan option:selected').text();
                var line_type = $('#line_type option:selected').text();
                var phan_loai = $('#phan_loai option:selected').text();
                var line = $('#line option:selected').text();
                var shifts = $('#shift option:selected').text();
                var tinh_trang = $('#status option:selected').text();
                var name = $('#gen').val() + ' - ' + $('#name').val();
                var part = $('#part').val();
                var problems_1 = "";
                var status_1 = 'OK';
                var process_1 = 'Complate';

                if (line == '---' || shifts == '---' || tinh_trang == '---' || gen == '---' || name ==
                    '---' || part ==
                    '---') {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    $('#table-check-list').DataTable().rows().every(function() {
                        var status = $(this.node()).find('select[name="status"] option:selected')
                            .text();
                        var process = $(this.node()).find('select[name="process"] option:selected')
                            .text();

                        if (status == 'NG') {
                            status_1 = "NG";
                        }
                        if (process != 'Complate') {
                            process_1 = process;
                        }
                    });
                    var data3 = {
                        groups: group,
                        check_list: check_list,
                        phan_loai: phan_loai,
                        cong_doan: cong_doan,
                        line_type: line_type,
                        line: line,
                        shifts: shifts,
                        name: name,
                        part: part,
                        tinh_trang: tinh_trang,
                        status: status_1,
                        problem: problems_1,
                        process: process_1,
                    }
                    data2.push(data3);
                    console.log(data2);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('save.check.list') }}",
                        contentType: 'application/json',
                        data: JSON.stringify(data2),
                        success: function(users) {
                            var id = users.id;
                            $('#table-check-list').DataTable().rows().every(function() {
                                var rowData = this.data();
                                var problems = $(this.node()).find('input').val();
                                var status = $(this.node()).find(
                                        'select[name="status"] option:selected')
                                    .text();
                                var process = $(this.node()).find(
                                        'select[name="process"] option:selected')
                                    .text();
                                var newData = {
                                    id_check_list: id,
                                    check_list: rowData[1],
                                    cong_doan: rowData[2],
                                    phan_loai: rowData[3],
                                    comment: rowData[4],
                                    line: line,
                                    line_type: line_type,
                                    shifts: shifts,
                                    name: name,
                                    part: part,
                                    tinh_trang: tinh_trang,
                                    status: status,
                                    problem: problems,
                                    process: process,
                                }
                                data.push(newData);
                            })
                            $.ajax({
                                type: "POST",
                                url: "{{ route('save.check.list.detail') }}",
                                contentType: 'application/json',
                                data: JSON.stringify(data),
                                success: function(users) {
                                    alert('save check-list Thành công');
                                }
                            });
                        }
                    });
                }
            });


            /*     js cho search checklist */

            $('#check_list_search').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('line.type.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#cong_doan_search').empty();
                        $('#phan_loai_search').empty();
                        $('#line_type_search').empty();
                        $('#line_search').empty();
                        // $('#table_check_list_search').DataTable().destroy();
                        $('#line_type_search').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#line_type_search').append($('<option>', {
                                value: value.id,
                                text: value.line_type,
                            }));
                        });
                    }
                });

            });

            $('#line_type_search').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('cong.doan.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#cong_doan_search').empty();
                        $('#phan_loai_search').empty();
                        $('#line_search').empty();
                        // $('#table-check-list').DataTable().destroy();
                        $('#cong_doan_search').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data, function(index, value) {
                            $('#cong_doan_search').append($('<option>', {
                                value: value.id,
                                text: value.cong_doan,
                            }));
                        });
                    }
                });

            });

            $('#cong_doan_search').on('change', function() {
                var check_list_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('phan.loai.search') }}',
                    data: {
                        id: check_list_search,
                    },
                    success: function(response) {
                        $('#phan_loai_search').empty();
                        $('#line_search').empty();
                        // $('#table_check_list_search').DataTable().destroy();
                        $('#line_search').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data1, function(index, value) {
                            $('#line_search').append($('<option>', {
                                value: value.id,
                                text: value.line,
                            }));
                        });
                        $('#phan_loai_search').append($('<option>', {
                            value: null,
                            text: '---',
                        }));
                        $.each(response.data2, function(index, value) {
                            $('#phan_loai_search').append($('<option>', {
                                value: value.id,
                                text: value.phan_loai,
                            }));
                        });
                    }
                });
            });



            function Convertdate(date) {

                var data = date.split('/');
                var dateconvert = data[2] + '-' + data[0] + '-' + data[1];
                return dateconvert;
            }

            $(document).on('click', '#Search', function(e) {
                e.preventDefault();
                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                var check_list_search = $('#check_list_search option:selected').text();
                var phan_loai_search = $('#phan_loai_search option:selected').text();
                var cong_doan_search = $('#cong_doan_search option:selected').text();
                var line_type_search = $('#line_type_search option:selected').text();
                var line_search = $('#line_search option:selected').text();
                var shift_search = $('#shift_search option:selected').text();
                var tinh_trang = $('#status_search option:selected').text();
                var date_form = Convertdate($('#date_form').val());
                var date_to = Convertdate($('#date_to').val());

                if ($('#date_form').val() == 0 || $('#date_to').val() == 0) {
                    alert('Vui lòng chọn thời gian kiểm tra');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('search.check.list') }}",
                        dataType: 'json',
                        data: {
                            check_list: check_list_search,
                            cong_doan: cong_doan_search,
                            line_type: line_type_search,
                            phan_loai: phan_loai_search,
                            line: line_search,
                            shift: shift_search,
                            tinh_trang: tinh_trang,
                            date_form: date_form,
                            date_to: date_to,
                            table: table
                        },
                        success: function(users) {
                            var count = 0;
                            var data = [];
                            var colum = [];
                            var data;
                            colum_table = [];
                            $.each(users.colums, function(index, value) {
                                colum.push([value]);
                            });
                            colum.push(['View']);
                            $.each(users.data, function(index, value) {

                                var time = new Date(value.created_at);

                                var date = time.getDate() + '-' + (time.getMonth() +
                                        1) +
                                    '-' + time.getFullYear();
                                var view = '<button type="button" value="' + value.id +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view"><span class="icon-eye2"></span></button>';
                                data.push([
                                    value.id,
                                    value.groups,
                                    value.check_list,
                                    value.cong_doan,
                                    value.phan_loai,
                                    value.line,
                                    value.shifts,
                                    value.name,
                                    value.part,
                                    value.status,
                                    value.problem,
                                    value.process,
                                    value.tinh_trang,
                                    date,
                                    view,
                                ]);
                            });

                            tables = $('#table_check_list_search').DataTable({
                                data: data,
                                "info": false,
                                'ordering': false,
                                'autowidth': true,
                                "dom": 'Bfrtip',
                                /* select: {
                                    style: 'multi',
                                }, */

                            });
                        }
                    });
                }
            });

            $(document).on('click', '#view', function(e) {
                e.preventDefault();
                var id = this.id;
                $.ajax({
                    type: "post",
                    url: "{{ route('search.check.list.view') }}",
                    dataType: "json",
                    data: {
                        id: id,
                        table: table_2,
                    },
                    success: function(users) {
                        var colum = users.colums;
                        var count = 0;
                        $.each(colum, function(index, value) {
                            if (value != 'id') {
                                count++;
                                colum_table.push([count, value]);
                            }
                        });
                        // $('#table_check_list_view').DataTable().destroy();
                        $('#table_check_list_view').DataTable({
                            data: users.data,
                            "info": false,
                            'ordering': false,
                            'autowidth': true,
                            "dom": 'Bfrtip',

                            /*  select: {
                                                    style: 'multi',
                                                },
                     */
                            columns: colum.map(function(columnMane) {
                                return {
                                    title: columnMane,
                                    data: columnMane,
                                };
                            })


                        });

                    }
                });

            });

            function editTable() {

                $('#table_check_list_view').Tabledit({
                    url: "check-list/edit-table/" + table_2,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: true,
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

            $('#table_check_list_view').on('draw.dt', function() {
                editTable();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
        });
    </script> --}}

    {{--  <script>
        $(document).ready(function() {
            var route_prefix = "laravel-filemanager";
            $('#lfm').filemanager('image', {
                prefix: route_prefix
            });
            $('#model').val(@json($model));
            var active_limit_Item = localStorage.getItem('active_limit_Item');
            let list_limit = document.querySelectorAll("#table-limit tbody td");
            image_list = document.querySelectorAll(".image_slide img");
            list_limit.forEach((item) => item.addEventListener('click', active_limit_item));
            image_list.forEach((item) => item.addEventListener('dblclick', show_image));

            if (activeItem) {
                var selectedItem = document.getElementById(activeItem);
                if (selectedItem) {
                    selectedItem.classList.add('table-active');
                }
            }

            function active_limit_item() {
                var itemId = this.id;
                list_limit.forEach((item) => {
                    item.classList.remove("table-active");
                });
                this.classList.add("table-active");
                localStorage.setItem('active_limit_Item', itemId);
                $.ajax({
                    type: "GET",
                    url: '{{ route('limit.item.search') }}',
                    data: {
                        limit_item: itemId,
                    },
                    success: function(response) {
                        $('#slider').html(response);
                    }
                });
            }

            function show_image() {
                $('#modal-image-show').modal('show');
            }


            $('#model').on('change', function() {
                var model_search = $(this).val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('model.search') }}',
                    data: {
                        model: model_search,
                    },
                    success: function(response) {
                        $('#limit-data').html(response);
                        $('#model').val(model_search);
                    }
                });

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var table_slider = 'limit_table';
            var slider_id = 'table-slider';
            var colum_table = [];
            var tables;
            var table;
            var table_id;

            // console.log(table);
            var route_prefix = "laravel-filemanager";
            $('#lfm-2').filemanager('image', {
                prefix: route_prefix
            });

            var image_path = document.getElementById('image_path_text');

            $(document).on('click', '#lfm-2', function(e) {
                e.preventDefault();
                document.getElementById('upload-file').style.display = 'block';
            });

            data_table_view(table_slider, slider_id, 'all');

            function editTable() {
                $('#' + table_id).Tabledit({
                    url: "admin-dashboard/table/edit-table/" + table,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: false,
                    deleteButtom: false,
                    uploadButtom: true,
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            $('#' + data.id).remove();
                            $('#' + table_id).DataTable().ajax.reload();
                        }

                    }
                });
            }

            function data_table_view(table, id_table, model_search) {

                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.limit.list') }}',
                    dataType: "json",
                    data: {
                        table: table,
                        model: model_search,
                    },
                    success: function(users, ) {
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

                        tables = $('#' + id_table).DataTable({
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

            $('#find-model').on('change', function() {
                var model_search = $(this).val();
                tables.destroy();
                data_table_view(table_slider, slider_id, model_search);
                table_id = slider_id;
                table = table_slider;
                editTable();
            });

            $(document).on('click', '#new-row-slider', function(e) {
                e.preventDefault();
                var model = table_slider;
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.new_row') }}",
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

                        var table = $('#' + slider_id).DataTable();
                        table.clear().rows.add(users.data).draw();
                    }
                });
            });


            $(document).on('click', '#delete-row-slider', function(e) {
                e.preventDefault();
                var model = table_slider;
                var rowSelect = tables.rows('.selected').data();
                var idsrow = rowSelect.toArray().map(row => row.id);
                // console.log(idsrow);
                $.ajax({
                    type: "GET",
                    url: "{{ route('table.delete_row') }}",
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
                        var tables = $('#' + slider_id).DataTable();
                        tables.clear().rows.add(users.data).draw();
                    }
                });
            });

            $(document).on('click', '#upload-image', function(e) {
                e.preventDefault();
                // // console.log($('#thumbnail').val());
                // var table_model = $("#myTab .nav-link.active").attr('id');
                var image_path = $('#thumbnail').val();

                table = table_slider;
                table_id = slider_id;
                $.ajax({
                    type: "GET",
                    url: "{{ route('limit.upload.image') }}",
                    dataType: "json",
                    data: {
                        id: $('#image_id').val(),
                        table: table,
                        filepath: image_path,
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
                        $('#upload-image').modal('hide');
                        var tables = $('#' + table_id).DataTable();
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

            $('#' + slider_id).on('draw.dt', function() {
                table_id = slider_id;
                table = table_slider;
                editTable();
            });
        });
    </script> --}}
@endsection
