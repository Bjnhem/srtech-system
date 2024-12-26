@extends('pro_3m.pages.layout')
@section('content')
<div class="container-fluid" style="margin-top: 1px;">
    <!-- Content Row -->
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="text-primary mx-3"><b><i class="icon-line-database" style="padding-right: 5px"></i>
                    CHECKLIST EQM STATUS</b>
            </h5>
        </div>
        <div class="card-body">
            <div class="row" id="progress-container-2">

            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <span>Line:</span>
                    <select name="line" id="Line_search" class="form-select">
                    </select>
                </div>
                <div class=" col-sm-3 col-md-3  bottommargin-sm">
                    <label for="">Date Search</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" value="" class="form-control text-start" id="date_form"
                            placeholder="YYYY-MM-DD">
                    </div>
                </div>

                <div class="col-sm-3">
                    <span>Shift:</span>
                    <select name="shift" id="shift_search" class="form-select">
                        <option value="">All</option>
                        <option value="Ca ngày">Ca ngày</option>
                        <option value="Ca đêm">Ca đêm</option>

                    </select>
                </div>
                <div class="col-sm-3">
                    <span>Tình trạng:</span>
                    <select name="shift" id="Status_search" class="form-select">
                        <option value="">All</option>
                        <option value="Completed">Completed</option>
                        <option value="Pending" selected>Pending</option>

                    </select>
                </div>
            </div>
            <br>


            <table id="table_check_list_search" class="table table-bordered table-hover"
                style="width:100%;border-collapse:collapse;">
            </table>

        </div>

    </div>



    {{-- model show check list --}}

    <div class="modal" id="modal-check">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-primary mx-3"><b><i class="icon-line-check-square"
                                style="padding-right: 5px"></i>CHECK LIST
                            EQM ILSUNG</b>
                    </h5>
                    </h5>
                </div>
                <div class="modal-footer mx-5">
                    <button type="button" id="save-check-list" class="btn btn-success">Save
                    </button>
                    <button type="button" id="update-check-list" class="btn btn-success">Update
                    </button>
                    <button type="button" class="btn btn-warning close close-model-checklist"
                        id="close-model">Close</button>
                </div>
                <div class="modal-body mx-5" style="background-color: white">

                    <div class="row">
                        <div class="col-sm-2">
                            <span>Line:</span>
                            <select name="line" id="Line" class="form-select">
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <span>Model:</span>
                            <select name="model" id="Model" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <span>Machine:</span>
                            <select name="Machine" id="Machine" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <span>Machine-ID:</span>

                            <input name="ID_machine" type="text" id="ID_machine" class="form-control"
                                placeholder="Chọn ID máy...">
                            <div id="suggestions" style="border: 1px solid #ccc; display: none;"></div>
                            <div id="error-message" style="color: red; display: none;"></div>


                        </div>

                        <div class="col-sm-2">
                            <span>Item check list:</span>
                            <select name="item" id="Checklist_item" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <span>Khung check:</span>
                            <select name="shift" id="Khung_gio" class="form-select">
                            </select>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered text-center mt-4 table-hover" id="table-check-list"
                        style="width: 100%; text-align: center; vertical-align:middle">
                        <thead class="table-success">
                            <tr>
                                <th style="width:3%">STT</th>
                                <th style="width:7%">Machine</th>
                                <th style="width:7%">Item check</th>
                                <th style="width:auto">Nội dung</th>
                                <th style="width:7%">Remark</th>
                                <th style="width:7%">Tình trạng</th>
                                <th style="width:10%">Vấn đề</th>
                                <th style="width:7%">Tiến độ</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function () {
        var colum_table = [];
        var line_check = @json($line_search);
        var tables;
        var tables_check;
        var table_edit;
        var table = 'result';
        var table_2 = 'result_detail'
        var table_result = table;
        var table_result_detail = table_2;
        var ID_machine_list = [];
        var shift;
        var currentDate = new Date();
        var date = currentDate.toISOString().split('T')[0];
        $('#date_form').val(date);

        localStorage.setItem('activeItem', 'Checklist');
        var activeItem = localStorage.getItem('activeItem');
        let list = document.querySelectorAll(".sidebar-body-menu a");
        list.forEach((item) => item.addEventListener('click', activeLink));
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
        show_master_check();
        show_master_status();



        function show_master_status() {
            $.ajax({
                type: "GET",
                url: "{{ route('check.list.masster') }}",
                dataType: "json",
                success: function (response) {
                    $('#line_search').empty();
                    $.each(response.line, function (index, value) {
                        $('#Line_search').append($('<option>', {
                            value: value.id,
                            text: value.line_name,
                        }));
                    });

                    $('#Line_search option:selected').text(line_check);
                    search();
                    show_overview();


                }
            });

        }

        function show_master_check() {
            $.ajax({
                type: "GET",
                url: "{{ route('check.list.masster') }}",
                dataType: "json",
                // data: {
                //     id: "1"
                // },
                success: function (response) {
                    $('#Machine').empty();
                    $('#ID_machine').empty();
                    $('#line').empty();
                    $('#Model').empty();
                    $('#line').empty();
                    $('#Checklist_item').empty();
                    $('#Khung_gio').empty();
                    $('#Machine').append($('<option>', {
                        value: "",
                        text: "---",
                    }));
                    $('#Checklist_item').append($('<option>', {
                        value: "",
                        text: "---",
                    }));

                    $('#Khung_gio').append($('<option>', {
                        value: "",
                        text: "---",
                    }));

                    $('#Model').append($('<option>', {
                        value: "",
                        text: "---",
                    }));

                    ID_machine_list = [];
                    $.each(response.machine, function (index, value) {
                        $('#Machine').append($('<option>', {
                            value: value.id,
                            text: value.Machine,
                        }));
                    });
                    $.each(response.line, function (index, value) {
                        $('#Line').append($('<option>', {
                            value: value.id,
                            text: value.line_name,
                        }));
                    });
                    $.each(response.model, function (index, value) {
                        $('#Model').append($('<option>', {
                            value: value.id,
                            text: value.model,
                        }));
                    });



                    // $("#ID_machine").autocomplete({
                    //     source: ID_machine_list,
                    //     minLength: 0, // Để hiển thị gợi ý ngay khi nhấp vào ô
                    //     focus: function(event, ui) {
                    //         event.preventDefault(); // Ngăn chặn việc điền tự động
                    //     },
                    //     select: function(event, ui) {
                    //         $('#ID_machine').val(ui.item
                    //             .value); // Điền giá trị đã chọn vào input
                    //         return false; // Ngăn chặn hành vi mặc định
                    //     }
                    // }).focus(function() {
                    //     $(this).autocomplete('search',
                    //         ''); // Tìm kiếm tất cả gợi ý khi nhấp vào
                    // });


                }
            });

        }

        function show_model_check() {
            $.ajax({
                type: "GET",
                url: "{{ route('check.list.masster') }}",
                dataType: "json",
                success: function (response) {

                    $('#Model').empty();
                    $('#Model').append($('<option>', {
                        value: "",
                        text: "---",
                    }));
                    $.each(response.model, function (index, value) {
                        $('#Model').append($('<option>', {
                            value: value.id,
                            text: value.model,
                        }));
                    });
                }
            });

        }

        function show_overview() {
            $('#progress-container-2').html("");
            var shift_search = $('#shift_search option:selected').text();
            var date_form = ($('#date_form').val());
            var line = $('#Line_search option:selected').text();
            $.ajax({
                url: "{{ route('checklist.overview') }}",
                method: 'GET',

                dataType: "json",
                data: {
                    shift: shift_search,
                    date_form: date_form,
                    line: line
                },
                success: function (data) {
                    data.forEach(item => {
                        console.log(item.Locations);
                        console.log(item.completion_percentage);
                        createProgressBar(item.Locations, item.completion_percentage);
                    });
                },
                error: function (error) {
                    console.error('Error fetching data:', error);
                }
            });

        }


        $('#Machine').on('change', function () {
            var machine_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('item.checklist.search') }}",
                data: {
                    machine_id: machine_id,

                },
                success: function (response) {
                    ID_machine_list = [];
                    $('#ID_machine').empty();
                    $('#Checklist_item').empty();
                    $('#Khung_gio').empty();
                    $('#table-check-list').DataTable().clear();
                    $('#table-check-list').DataTable().destroy();
                    $('#Checklist_item').append($('<option>', {
                        value: "",
                        text: "---",
                    }));

                    $('#ID_machine').append($('<option>', {
                        value: "",
                        text: "---",
                    }));

                    $.each(response.checklist_item, function (index, value) {
                        $('#Checklist_item').append($('<option>', {
                            value: value.id,
                            text: value.item_checklist,
                        }));
                    });

                    $.each(response.ID_machine, function (index, value) {
                        ID_machine_list.push(value.Code_machine);
                    });

                    // $.each(response.khung_check, function(index, value) {
                    //     $('#Khung_gio').append($('<option>', {
                    //         value: value.id,
                    //         text: value.khung_check,
                    //     }));
                    // });

                    $("#ID_machine").autocomplete({
                        source: ID_machine_list,
                        minLength: 0, // Để hiển thị gợi ý ngay khi nhấp vào ô
                        focus: function (event, ui) {
                            event
                                .preventDefault(); // Ngăn chặn việc điền tự động
                        },
                        select: function (event, ui) {
                            $('#ID_machine').val(ui.item
                                .value); // Điền giá trị đã chọn vào input
                            return false; // Ngăn chặn hành vi mặc định
                        }
                    }).focus(function () {
                        $(this).autocomplete('search',
                            ''); // Tìm kiếm tất cả gợi ý khi nhấp vào
                    });
                }
            });

        });

        $('#Checklist_item').on('change', function () {
            var item_check = $(this).val();
            // var machine = $('#Machine').val();
            $.ajax({
                type: "GET",
                url: '{{ route('khung.check.search') }}',
                data: {
                    item_check: item_check,
                    // machine: machine,
                },

                success: function (response) {
                    $('#Khung_gio').empty();
                    $.each(response.khung_check, function (index, value) {
                        $('#Khung_gio').append($('<option>', {
                            value: value.id,
                            text: value.khung_check,
                        }));
                    });
                    var id_checklist = $('#Checklist_item').val();
                    show_check_list(id_checklist);
                }
            });

        });


        $('#Line_search').on('change', function (e) {
            e.preventDefault();
            search();
            show_overview()

        });
        $('#Shift_search').on('change', function (e) {
            e.preventDefault();
            search();
            show_overview()

        });

        $('#date_form').on('change', function (e) {
            e.preventDefault();
            search();
            show_overview()

        });
        $('#Status_search').on('change', function (e) {
            e.preventDefault();
            search();
            show_overview()

        });

        function createProgressBar(line, completion) {
            const progressContainer = $('#progress-container-2');
            const progressCol = $('<div>').addClass('col-xl-8 col-sm-8');
            const progressDiv = $('<div>').addClass('progress').attr('data-line', line);
            const progressBar = $('<div>').addClass('progress-bar').css({
                width: `${completion}%`,
                background: '#25babc'
            });

            const progressValue = $('<div>').addClass('progress-value').html(`<span>${completion}</span>%`);
            const progressTitle = $('<div>').addClass('progressbar-title').html(line);

            progressBar.append(progressValue).append(progressTitle);
            progressDiv.append(progressBar);
            progressCol.append(progressDiv);
            progressContainer.append(progressCol);

        }

        function show_check_list(ID_checklist) {
            console.log(ID_checklist);
            $.ajax({
                type: "GET",
                url: '{{ route('check.list.search') }}',
                data: {
                    item_check: ID_checklist,
                },
                success: function (response) {
                    console.log(response.data_checklist);
                    $('#table-check-list').DataTable().destroy();
                    var count = 0;
                    var data = [];
                    $.each(response.data_checklist, function (index, value) {
                        count++;
                        var status =
                            '<select name = "status" id="' + value.id +
                            '" class="form-select">\
                                                                                                                                                                                                                                                                                                             <option value = "OK">OK</option>\
                                                                                                                                                                                                                                                                                                           <option value = "NG">NG</option>\
                                                                                                                                                                                                                                                                                                           </select>';
                        var problem =
                            '<input name="problem" type="text" id="' + value.id +
                            '" class="form-control">';
                        var process =
                            '<select name = "process" id="' + value.id +
                            '"class="form-select">\
                                                                                                                                                                                                                                                                                                              <option value = "OK"></option>\
                                                                                                                                                                                                                                                                                                              <option value = "Complete">Complete</option>\
                                                                                                                                                                                                                                                                                                             <option value = "Pending">Pending</option>\
                                                                                                                                                                                                                                                                                                            <option value = "Improgress" >Improgress</option>\
                                                                                                                                                                                                                                                                                                            </select >';
                        data.push([
                            count,
                            value.Machine,
                            value.item_checklist,
                            value.Hang_muc,
                            value.Chu_ky,
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
                        "lengthMenu": [
                            [-1],
                            ["Show all"]
                        ]
                    });

                }
            });
        }

        function show_check_list_edit(ID_checklist) {
            console.log(ID_checklist);
            $.ajax({
                type: "GET",
                url: '{{ route('check.list.edit.search') }}',
                data: {
                    id_checklist: ID_checklist,
                },
                success: function (response) {
                    console.log(response.data_checklist);
                    $('#table-check-list').DataTable().destroy();
                    var count = 0;
                    var data = [];
                    $.each(response.data_checklist, function (index, value) {
                        count++;
                        if (value.Check_status == "OK")
                            var status =
                                '<select name = "status" id="' + value.id +
                                '" class="form-select">\
                                                                 <option value = "OK" selected>OK</option>\
                                                                <option value = "NG">NG</option>\
                                                                 </select>';

                        else {
                            var status =
                                '<select name = "status" id="' + value.id +
                                '" class="form-select">\
                                                                 <option value = "OK">OK</option>\
                                                                <option value = "NG" selected>NG</option>\
                                                                 </select>';
                        }
                        var problem =
                            '<input name="problem" type="text" id="' + value.id +
                            '" class="form-control">';
                        var process =
                            '<select name = "process" id="' + value.id +
                            '"class="form-select">\
                                                                                                                                                                                                                                                                                                              <option value = "OK"></option>\
                                                                                                                                                                                                                                                                                                              <option value = "Complete">Complete</option>\
                                                                                                                                                                                                                                                                                                             <option value = "Pending">Pending</option>\
                                                                                                                                                                                                                                                                                                            <option value = "Improgress" >Improgress</option>\
                                                                                                                                                                                                                                                                                                            </select >';
                        data.push([
                            count,
                            value.Machine,
                            value.item_checklist,
                            value.Hang_muc,
                            value.Khung_check,
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
                        "lengthMenu": [
                            [-1],
                            ["Show all"]
                        ]
                    });

                }
            });
        }

        $(document).on('click', '#Search', function (e) {
            e.preventDefault();
            if (tables) {
                $('#table_check_list_search').DataTable().destroy();
            }
            var line_search = $('#Line_search option:selected').text();
            var shift_search = $('#shift_search option:selected').text();
            var date_form = ($('#date_form').val());
            console.log(line_search);
            console.log(shift_search);
            console.log(date_form);

            if ($('#date_form').val() == 0) {
                alert('Vui lòng chọn thời gian kiểm tra');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.list.overview') }}",
                    dataType: 'json',
                    data: {
                        line: line_search,
                        shift: shift_search,
                        date_form: date_form,
                    },
                    success: function (users) {
                        var count = 0;
                        var data = [];
                        var colum = [];
                        var data;
                        console.log(users.data);
                        $.each(users.data, function (index, value) {
                            count++;
                            if (value.Check_status != "Pending") {
                                var view = '<button type="button" value="' + value
                                    .id_phan_loai +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary check editbtn btn-sm" id="' +
                                    value.id + '">View</button>' +
                                    ' <input type="hidden" value="' + date_form +
                                    '" id="date_check_' + value
                                        .id + '">';
                            } else {
                                var view = '<button type="button" value="' + value
                                    .id_phan_loai +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-danger check editbtn btn-sm" id="' +
                                    value.id + '">Check</button>' +
                                    ' <input type="hidden" value="' + date_form +
                                    '" id="date_check_' + value
                                        .id + '">';
                            }


                            data.push([
                                count,
                                value.Locations,
                                value.Machine,
                                value.Code_machine,
                                value.item_checklist,
                                value.Khung_check,
                                value.Shift,
                                value.Check_status,
                                value.Date_check,
                                view,
                            ]);
                        });

                        var header =
                            '<thead class="table-success" style="text-align: center; vertical-align:middle">' +
                            '<tr style="text-align: center">' +
                            '<th style="text-align: center">STT</th>' +
                            '<th style="text-align: center">Line</th>' +
                            '<th style="text-align: center">Machine</th>' +
                            '<th style="text-align: center">Code QL</th>' +
                            '<th style="text-align: center">Check List</th>' +
                            '<th style="text-align: center">Khung check</th>' +
                            '<th style="text-align: center">Shift</th>' +
                            '<th style="text-align: center">Trạng thái</th>' +
                            '<th style="text-align: center">Date</th>' +
                            '<th style="text-align: center">Edit</th>' +
                            '</tr>'
                        '</thead>'

                        $('#table_check_list_search').html(header);
                        tables = $('#table_check_list_search').DataTable({
                            data: data,
                            "info": true,
                            'ordering': false,
                            'autowidth': true,
                            "dom": 'Bfrtip',
                            select: {
                                style: 'single',
                            },

                        });
                    }
                });
            }
        });


        function search() {

            if (tables) {
                $('#table_check_list_search').DataTable().destroy();
            }
            var line_search = $('#Line_search option:selected').text();
            var shift_search = $('#shift_search option:selected').text();
            var Status_search = $('#Status_search option:selected').text();
            var date_form = ($('#date_form').val());
            if ($('#date_form').val() == 0) {
                alert('Vui lòng chọn thời gian kiểm tra');
            } else {
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.list.overview') }}",
                    dataType: 'json',
                    data: {
                        line: line_search,
                        shift: shift_search,
                        date_form: date_form,
                        Status: Status_search,
                    },
                    success: function (users) {
                        var count = 0;
                        var data = [];
                        var colum = [];
                        var data;
                        console.log(users.data);
                        $.each(users.data, function (index, value) {
                            count++;
                            if (value.Check_status != "Pending") {
                                var view =
                                    // '<button type="button" style="display:Hidden" value="' + value
                                    //     .id +
                                    //     '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary  view-check check editbtn btn-sm" id="' +
                                    //     value.ID_checklist + '">Check</button>' +
                                    //     '<input type="hidden" value ="' + value.ID_checklist +
                                    //     '" id="' + value.id + '">' +

                                    '<button type="button" value="' + value
                                        .id +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning view-edit check editbtn btn-sm" id="' +
                                    value.ID_checklist + '">Edit</button>' +
                                    ' <input type="hidden" value="' + value.ID_checklist +
                                    '" id="' + value.id + '">' +
                                    '<button type="button" value="' + value
                                        .id +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                    value.ID_checklist + '">Delete</button>' +
                                    ' <input type="hidden" value="' + value.ID_checklist +
                                    '" id="' + value.id + '">';
                            } else {
                                var view = '<button type="button" style="display:Hidden" value="' + value
                                    .id +
                                    '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary  view-check check editbtn btn-sm" id="' +
                                    value.ID_checklist + '">Check</button>' +
                                    '<input type="hidden" value ="' + value.ID_checklist +
                                    '" id="' + value.id + '">'
                                    //  +

                                    // '<button type="button" value="' + value
                                    // .id +
                                    // '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning view-edit check editbtn btn-sm" id="' +
                                    // value.ID_checklist + '">Edit</button>' +
                                    // ' <input type="hidden" value="' + value.ID_checklist +
                                    // '" id="' + value.id + '">' +
                                    // '<button type="button" value="' + value
                                    // .id +
                                    // '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                    // value.ID_checklist + '">Delete</button>' +
                                    // ' <input type="hidden" value="' + value.ID_checklist +
                                    // '" id="' + value.id + '">'
                                    ;
                            }
                            data.push([
                                count,
                                value.Locations,
                                value.Model,
                                value.Machine,
                                value.Code_machine,
                                value.item_checklist,
                                value.Khung_check,
                                value.Shift,
                                value.Check_status,
                                value.Date_check,
                                view,
                            ]);
                        });

                        var header =
                            '<thead class="table-success" style="text-align: center; vertical-align:middle">' +
                            '<tr style="text-align: center">' +
                            '<th style="text-align: center">STT</th>' +
                            '<th style="text-align: center">Line</th>' +
                            '<th style="text-align: center">Model</th>' +
                            '<th style="text-align: center">Machine</th>' +
                            '<th style="text-align: center">Code QL</th>' +
                            '<th style="text-align: center">Check List</th>' +
                            '<th style="text-align: center">Khung check</th>' +
                            '<th style="text-align: center">Shift</th>' +
                            '<th style="text-align: center">Trạng thái</th>' +
                            '<th style="text-align: center">Date</th>' +
                            '<th style="text-align: center">Edit</th>' +
                            '</tr>'
                        '</thead>'

                        $('#table_check_list_search').html(header);
                        tables = $('#table_check_list_search').DataTable({
                            data: data,
                            "info": true,
                            'ordering': false,
                            'autowidth': true,
                            // "dom": 'Bfrtip',
                            select: {
                                style: 'single',
                            },

                        });
                    }
                });
            }
        };

        var id_checklist_detail = 0;
        $(document).on('click', '.view-check', function (e) {
            e.preventDefault();
            // show_model_check();
            const button1 = document.getElementById('save-check-list');
            button1.style.display = 'unset'; // Ẩn button
            const button2 = document.getElementById('update-check-list');
            button2.style.display = 'none'; // Ẩn button
            id_checklist_detail = $(this).val();
            id_checklist = this.id;

            rowSelected = tables.rows('.selected').indexes();
            if (rowSelected.length > 0) {
                var rowData = tables.row(rowSelected[0]).data();
                // Lấy dữ liệu của dòng đầu tiên được chọn
                $('#Machine option').text(rowData[3]);
                $('#ID_machine').val(rowData[4]);
                $('#line option').text(rowData[1]);
                $('#Checklist_item option').text(rowData[5]);
                $('#Khung_gio option').text(rowData[6]);
                date = rowData[9];
                shift = rowData[7];
                $('#Model option:selected').filter(function () {
                    return $(this).text() === rowData[2];
                }).prop('selected', true);

                $('#Model').prop('disabled', false);
                $('#Machine').prop('disabled', true);
                $('#ID_machine').prop('disabled', true);
                $('#Line').prop('disabled', true);
                $('#Checklist_item').prop('disabled', true);
                $('#Khung_gio').prop('disabled', true);
            }


            show_check_list(id_checklist)

        });

        $(document).on('click', '.view-edit', function (e) {
            e.preventDefault();
            const button1 = document.getElementById('save-check-list');
            button1.style.display = 'none'; // Ẩn button
            const button2 = document.getElementById('update-check-list');
            button2.style.display = 'unset'; // Ẩn button
            id_checklist_detail = $(this).val();
            id_checklist = this.id;

            rowSelected = tables.rows('.selected').indexes();
            if (rowSelected.length > 0) {
                var rowData = tables.row(rowSelected[0]).data();
                // Lấy dữ liệu của dòng đầu tiên được chọn
                $('#Machine option').text(rowData[3]);
                $('#ID_machine').val(rowData[4]);
                $('#line option').text(rowData[1]);
                $('#Checklist_item option').text(rowData[5]);
                $('#Khung_gio option').text(rowData[6]);
                $('#Model option:selected').text(rowData[2]);
                date = rowData[9];
                shift = rowData[7];

                $('#Model option:selected').filter(function () {
                    return $(this).text() === rowData[2];
                }).prop('selected', true);

                $('#Model').prop('disabled', false);
                $('#Machine').prop('disabled', true);
                $('#ID_machine').prop('disabled', true);
                $('#Line').prop('disabled', true);
                $('#Checklist_item').prop('disabled', true);
                $('#Khung_gio').prop('disabled', true);
            }


            show_check_list_edit(id_checklist_detail)

        });


        $(document).on('click', '.view-delete', function () {
            const idChecklist = $(this).attr('id'); // Lấy ID của checklist từ nút

            if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('delete.check.list', ':id') }}".replace(':id', idChecklist),
                    success: function (response) {
                        if (response.status === 200) {
                            alert('Xóa thành công');
                            // Cập nhật lại bảng hoặc xóa hàng đã xóa
                            $('#table_check_list_search').DataTable().row($(this).closest('tr')).remove().draw();
                        } else {
                            alert('Có lỗi xảy ra. Không thể xóa.');
                        }
                    },
                    error: function () {
                        alert('Có lỗi xảy ra. Không thể xóa.');
                    }
                });
            }
        });


        // $(document).on('click', '#save-check-list', function (e) {
        //     e.preventDefault();
        //     var data = [];
        //     var data2 = [];
        //     var line = $('#Line option:selected').text();
        //     var Model = $('#Model option:selected').text();
        //     var Machine = $('#Machine option:selected').text();
        //     var Khung_gio = $('#Khung_gio option:selected').text();
        //     var ID_machine = $('#ID_machine').val();
        //     var Checklist_item = $('#Checklist_item option:selected').text();
        //     // var name =Binh ;
        //     var status_1 = 'OK';

        //     if ($('#Model option:selected').text() == "---") {
        //         alert("vui lòng chọn model nếu không có thì chọn COMMON");
        //     } else {
        //         var data = {
        //             id_checklist: id_checklist_detail,
        //             Model: Model,
        //             date: date,
        //             ID_machine: ID_machine
        //         }

        //         $.ajax({
        //             type: "POST",
        //             url: "{{ route('save.check.list', ':table') }}".replace(':table',
        //                 'checklist_result'),
        //             dataType: 'json',
        //             data: data,
        //             success: function (response) {
        //                 if (response.status == 400) {
        //                     alert('Update plan check list');

        //                 } else {
        //                     var id = response.id;
        //                     console.log(id);
        //                     $('#table-check-list').DataTable().rows().every(function () {
        //                         var rowData = this.data();
        //                         var problems = $(this.node()).find('input').val();
        //                         var status = $(this.node()).find(
        //                             'select[name="status"] option:selected')
        //                             .text();
        //                         var process = $(this.node()).find(
        //                             'select[name="process"] option:selected')
        //                             .text();
        //                         var newData = {
        //                             ID_checklist_result: id,
        //                             Locations: line,
        //                             Model: Model,
        //                             ID_item_checklist: "1",
        //                             Machine: Machine,
        //                             Hang_muc: rowData[3],
        //                             item_checklist: Checklist_item,
        //                             Khung_check: Khung_gio,
        //                             Shift: shift,
        //                             Code_machine: ID_machine,
        //                             Check_status: status,
        //                             Status: problems,
        //                             Remark: process,
        //                             Date_check: date
        //                         }
        //                         data2.push(newData);
        //                     })
        //                     $.ajax({
        //                         type: "POST",
        //                         url: "{{ route('save.check.list.detail', ':table') }}"
        //                             .replace(':table', table_2),
        //                         contentType: 'application/json',
        //                         data: JSON.stringify(data2),
        //                         success: function (users) {
        //                             alert('save check-list Thành công');
        //                             $('#table_check_list').DataTable().clear();
        //                             $('#modal-check').modal('hide');
        //                         }
        //                     });
        //                 }
        //             }
        //         });
        //     }

        //     search();
        // });



        $(document).on('click', '#save-check-list', function (e) {
            e.preventDefault();

            const line = $('#Line option:selected').text();
            const Model = $('#Model option:selected').text();
            const Machine = $('#Machine option:selected').text();
            const Khung_gio = $('#Khung_gio option:selected').text();
            const ID_machine = $('#ID_machine').val();
            const Checklist_item = $('#Checklist_item option:selected').text();

            if (Model === "---") {
                return alert("Vui lòng chọn model, nếu không có thì chọn COMMON");
            }

            const data = {
                id_checklist: id_checklist_detail,
                Model,
                date,
                ID_machine,
                details: [] // Thêm một mảng để chứa các chi tiết
            };

            $('#table-check-list').DataTable().rows().every(function () {
                const rowData = this.data();
                const problems = $(this.node()).find('input').val();
                const status = $(this.node()).find('select[name="status"] option:selected').text();
                const process = $(this.node()).find('select[name="process"] option:selected').text();

                data.details.push({
                    Locations: line,
                    Model,
                    ID_item_checklist: "1",
                    Machine,
                    Hang_muc: rowData[3],
                    item_checklist: Checklist_item,
                    Khung_check: Khung_gio,
                    Shift: shift,
                    Code_machine: ID_machine,
                    Check_status: status,
                    Status: problems,
                    Remark: process,
                    Date_check: date
                });
            });

            // Gửi yêu cầu AJAX với cả hai dữ liệu
            $.ajax({
                type: "POST",
                url: "{{ route('save.check.list', ':table') }}".replace(':table', 'checklist_result'),
                dataType: 'json',
                data: JSON.stringify(data), // Chuyển đổi thành chuỗi JSON
                contentType: 'application/json',
                success: function (response) {
                    if (response.status === 400) {
                        return alert('Update plan check list');
                    }

                    alert('Lưu check-list thành công');
                    $('#table_check_list').DataTable().clear();
                    $('#modal-check').modal('hide');
                },
                error: function () {
                    alert('Lưu check-list thất bại');
                }
            });

            search();
        });


        $(document).on('click', '#update-check-list', function (e) {
            e.preventDefault();
            var data = [];
            var data2 = [];
            var line = $('#Line option:selected').text();
            var Model = $('#Model option:selected').text();
            var Machine = $('#Machine option:selected').text();
            var Khung_gio = $('#Khung_gio option:selected').text();
            var ID_machine = $('#ID_machine').val();
            var Checklist_item = $('#Checklist_item option:selected').text();
            // var name =Binh ;
            var status_1 = 'OK';

            if ($('#Model option:selected').text() == "---") {
                alert("vui lòng chọn model nếu không có thì chọn COMMON");
            } else {

                var data = {
                    id_checklist: id_checklist_detail,
                    Model: Model,
                    date: date,
                    ID_machine: ID_machine
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('save.check.list', ':table') }}".replace(':table',
                        'checklist_result'),
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        if (response.status == 400) {
                            alert('Update plan check list');

                        } else {
                            var id = response.id;
                            console.log(id);
                            $('#table-check-list').DataTable().rows().every(function () {
                                var rowData = this.data();
                                var problems = $(this.node()).find('input').val();
                                var status = $(this.node()).find(
                                    'select[name="status"] option:selected')
                                    .text();
                                var process = $(this.node()).find(
                                    'select[name="process"] option:selected')
                                    .text();
                                var newData = {
                                    id_checklist_result: id,
                                    Locations: line,
                                    Model: Model,
                                    ID_item_checklist: "1",
                                    Machine: Machine,
                                    item_checklist: Checklist_item,
                                    Khung_check: Khung_gio,
                                    Shift: shift,
                                    Code_machine: ID_machine,
                                    Check_status: status,
                                    Status: problems,
                                    Remark: process,
                                    Date_check: date

                                }
                                data2.push(newData);
                            })
                            $.ajax({
                                type: "POST",
                                url: "{{ route('update.check.list.detail', ':table') }}"
                                    .replace(':table', id),
                                contentType: 'application/json',
                                data: JSON.stringify(data2),
                                success: function (users) {
                                    alert('Update check-list Thành công');
                                    $('#table_check_list').DataTable().clear();
                                    $('#modal-check').modal('hide');
                                }
                            });
                        }
                    }
                });
            }

            search();
        });

        function editTable(table_edit, table) {

            $('#' + table_edit).Tabledit({
                url: "check-list/edit-table/" + table,
                method: 'POST',
                dataType: 'json',
                columns: {
                    identifier: [0, 'id'],
                    editable: colum_table,
                },
                restoreButton: true,
                deleteButton: false,
                uploadButton: false,
                onSuccess: function (data, textStatus, jqXHR) {
                    if (data.action == 'delete') {
                        $('#' + data.id).remove();
                        $('#' + table_id).DataTable().ajax.reload();
                    }

                }
            });
        }

        $('#table_check_list_view').on('draw.dt', function () {
            editTable('table_check_list_view', table_edit);
        });

        $(document).on('click', '.close-model-checklist', function (e) {
            e.preventDefault();
            $('#table_check_list').DataTable().clear();
            $('#table_check_list thead tr').remove();
            $('#modal-check').modal('hide');
            show_model_check();
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