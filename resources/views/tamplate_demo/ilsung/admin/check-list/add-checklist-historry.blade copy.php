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
                        <li class="nav-item"> <button class="nav-link  " id="ftg" data-bs-toggle="tab"
                                data-bs-target="#study-post" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">FTG</button></li>
                        <li class="nav-item">
                            <button class="nav-link" id="glass" data-bs-toggle="tab" data-bs-target="#all-post"
                                type="button" role="tab" aria-controls="nav-disabled"
                                aria-selected="false">GLASS</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link active" id="pad" data-bs-toggle="tab" data-bs-target="#smart-post"
                                type="button" role="tab" aria-controls="nav-disabled"
                                aria-selected="false">PAD</button>
                        </li>

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


                    <div class="col-sm-12">
                        <br>
                    </div>
                    <div class="col-sm-2">
                        <span>Shift:</span>
                        <select name="shift" id="shift" class="form-select">
                            <option value="">---</option>
                            <option value="Shift1A">Shift1A</option>
                            <option value="Shift2A">Shift2A</option>
                            <option value="Staff">Staff</option>
                        </select>
                    </div>
                    <div class=" col-sm-2 col-md-2  bottommargin-sm">
                        <label for="">Date Search</label>

                        <div class="input-daterange component-datepicker multidate input-group">
                            <input type="text" value="" class="form-control text-start" id="date_form"
                                placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        {{-- <button id="add-check-list-historry-FTG" class="form-control btn-success"><i
                                class="icon-line-check"></i>Add-historry
                        </button>  --}}
                         <button id="add-plan-checklist" class="form-control btn-success"><i
                            class="icon-line-check"></i>Created plan checklist
                    </button>
                    </div>

                  {{--   <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="add-check-list-historry" class="form-control btn-success"><i
                                class="icon-line-check"></i>Add-historry
                        </button>
                    </div> --}}

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

    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            localStorage.setItem('activeItem', 'historry');
            var table = 'result';
            var table_2 = 'result_detail'
            var colum_table = [];
            var tables;
            var tab = @json($view);
            show_check_list(tab);

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
                    url: '{{ route('admin.cong.doan.search') }}',
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
                    url: '{{ route('admin.phan.loai.search') }}',
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
                    url: '{{ route('admin.check.list.search') }}',
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
                                '" class="form-control">\
                                                                                                                                                                                        <option value = "OK">OK</option>\
                                                                                                                                                                                        <option value = "NG">NG</option>\
                                                                                                                                                                                         </select>';
                            var problem =
                                '<input name="problem" type="text" id="' + value.id +
                                '" class="form-control">';
                            var process =
                                '<select name = "process" id="' + value.id +
                                '"class="form-select ">\
                                                                                                                                                                                            <option value = "OK"></option>\
                                                                                                                                                                                            <option value = "Complete">Complete</option>\
                                                                                                                                                                                            <option value = "Pending">Pending</option>\
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

            function Convertdate(date) {
                var data = date.split('/');
                var dateconvert = data[2] + '-' + data[0] + '-' + data[1];
                return dateconvert;
            }

            function Convert_year(date) {
                var data = date.split('/');
                var dateconvert = data[2] + '_' + data[0];
                return dateconvert;
            }

            $(document).on('click', '#add-check-list-historry-FTG', function(e) {
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
                var process_1 = '';
                var date = Convertdate($('#date_form').val());
                var year = Convert_year($('#date_form').val());

                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
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
                        date: date,
                        table_2: table_result_detail + '_' + year,
                        table: table_result + '_' + year,
                       
                    }

                    console.log(table_result + '_' + year);
                    console.log(table_result_detail + '_' + year);


                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.save.check.list.historry') }}",
                        dataType: 'json',
                        data: data3,
                        success: function(response) {
                            if (response.status == 200) {
                                alert("Số check list đã tạo: " + response.count)
                            } else {

                                alert("Tạo Checklist lỗi")


                            }
                        }

                    });
                }
            });

            $(document).on('click', '#add-check-list-historry', function(e) {
                e.preventDefault();
                var check_list = $('#check_list option:selected').text();
                var cong_doan = $('#cong_doan option:selected').text();
                var line_type = $('#line_type option:selected').text();
                var phan_loai = $('#phan_loai option:selected').text();
                var line = $('#line option:selected').text();
                var shifts = $('#shift option:selected').text();
                var date = Convertdate($('#date_form').val());


                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    var data = {
                        groups: tab,
                        check_list: check_list,
                        phan_loai: phan_loai,
                        cong_doan: cong_doan,
                        line_type: line_type,
                        line: line,
                        shifts: shifts,
                        date: date,
                        table_2: table_result_detail,
                        table: table_result
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.save.check.list.historry') }}",
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 200) {
                                alert("Số check list đã tạo: " + response.count)
                            } else {

                                alert("Tạo Checklist lỗi")
                            }
                        }

                    });
                }
            });

            $(document).on('click', '#add-plan-checklist', function(e) {
                e.preventDefault();
                var check_list = $('#check_list option:selected').text();
                var cong_doan = $('#cong_doan option:selected').text();
                var line_type = $('#line_type option:selected').text();
                var phan_loai = $('#phan_loai option:selected').text();
                var line = $('#line option:selected').text();
                var shifts = $('#shift option:selected').text();
                var date = Convertdate($('#date_form').val());


                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    var data = {
                        groups: tab,
                        check_list: check_list,
                        phan_loai: phan_loai,
                        cong_doan: cong_doan,
                        line_type: line_type,
                        line: line,
                        shifts: shifts,
                        date: date,
                        table_2: table_result_detail,
                        table: table_result
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.save.check.list.historry') }}",
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 200) {
                                alert("Số check list đã tạo: " + response.count)
                            } else {

                                alert("Tạo Checklist lỗi")
                            }
                        }

                    });
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

        });
    </script>
@endsection
