@extends('ilsung.layouts.layout')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="row" id="progress-container-1">
            </div>
            <br>
            <div class="row">

                <div class=" col-sm-6 col-xl-3 mb-3 bottommargin-sm">

                    <label for="">Machine-ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nhập code machine"
                            aria-label="Nhập code machine" aria-describedby="Code_machine" id="Code_machine">
                        <button class="btn btn-outline-secondary btn-primary" type="button" id="Scan_QR">Scan</button>
                    </div>
                </div>
                <div class=" col-sm-6 col-xl-3 mb-3 bottommargin-sm">
                    <label for="">Date Search</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" value="" class="form-control text-start" id="date_form"
                            placeholder="YYYY-MM-DD">
                    </div>
                </div>
                <div class="col-sm-4 col-xl-2 mb-3">
                    <span>Line:</span>
                    <select name="line" id="Line_search" class="form-select">
                    </select>
                </div>
                <div class="col-sm-4 col-xl-2 mb-3">
                    <span>Shift:</span>
                    <select name="shift" id="shift_search" class="form-select">
                        <option value="">All</option>
                        <option value="Ca ngày">Ca ngày</option>
                        <option value="Ca đêm">Ca đêm</option>

                    </select>
                </div>
                <div class="col-sm-4 col-xl-2 mb-3">
                    <span>Tình trạng:</span>
                    <select name="shift" id="Status_search" class="form-select">
                        <option value="">All</option>
                        <option value="Completed">Completed</option>
                        <option value="Pending" selected>Pending</option>

                    </select>
                </div>
            </div>
            <br>

            <div class="table-responsive">
                <table id="table_check_list_search" class="table table-bordered table-hover"
                    style="width:100%;border-collapse:collapse;">
                </table>
            </div>


        </div>
    </div>


    {{-- model show check list --}}
    <div class="modal" id="modal-check">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <!-- Tiêu đề bên trái -->
                    <h5 class="text-primary mx-3">
                        CHECK LIST EQM
                    </h5>

                    <!-- Các nút button nằm bên phải -->
                    <div>
                        <button type="button" id="save-check-list" class="btn btn-success">Save</button>
                        <button type="button" id="update-check-list" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-warning close-model-checklist"
                            id="close-model">Close</button>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <div class="row">


                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Model:</span>
                            <select name="model" id="Model" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Line:</span>
                            <select name="line" id="Line" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Machine:</span>
                            <select name="Machine" id="Machine" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Machine-ID:</span>

                            <input name="ID_machine" type="text" id="ID_machine" class="form-control"
                                placeholder="Chọn ID máy...">
                            <div id="suggestions" style="border: 1px solid #ccc; display: none;"></div>
                            <div id="error-message" style="color: red; display: none;"></div>


                        </div>

                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Item check list:</span>
                            <select name="item" id="Checklist_item" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
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
                                <th style="width:3%" rowspan="2">STT</th>
                                <th style="width:77" rowspan="2">Nội dung</th>
                                <th style="width:10%" colspan="2">Tình trạng</th>
                                <th style="width:10%" rowspan="2">Vấn đề</th>
                            </tr>
                            <tr>
                                <th style="width:5%">OK</th>
                                <th style="width:5%">NG</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal Scan --}}
    <div class="modal" id="modal-scan">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-primary mx-3">Quét QR Code</b>
                    </h5>

                </div>
                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-warning close close-model-scan"
                        id="close-model-scan">Close</button>
                </div>
                <div class="modal-body mx-5" style="background-color: white; ">
                    <div id="qr-reader" style="width:100%"></div>
                    <button id="closeScanBtn" style="display: none;">Đóng Quét</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var colum_table = [];
            var line_check = @json($line_id);
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

            function reader_QR() {
                var lastResult, countResults = 0;

                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;
                        // Handle on success condition with the decoded message.

                        $('#Code_machine').val(lastResult);
                        // console.log(`Scan result ${decodedText}`, decodedResult);
                        html5QrcodeScanner.clear();
                        $('#modal-scan').modal('hide');
                        search();
                        show_overview()

                    }
                }


                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: 250,
                        experimentalFeatures: {
                            useBarCodeDetectorIfSupported: true
                        },
                        rememberLastUsedCamera: true,
                        showTorchButtonIfSupported: true
                    });
                html5QrcodeScanner.render(onScanSuccess);
            }

            const qrInput = document.getElementById('Scan_QR');
            qrInput.addEventListener('click', () => {
                $('#modal-scan').modal('show');
                reader_QR();
            });

            function show_master_status() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('check.list.masster') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#line_search').empty();
                        $.each(response.line, function(index, value) {
                            $('#Line_search').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                        });

                        // $('#Line_search option:selected').text(line_check);
                        $('#Line_search').val(line_check);
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
                    success: function(response) {
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
                        $.each(response.machine, function(index, value) {
                            $('#Machine').append($('<option>', {
                                value: value.id,
                                text: value.Machine,
                            }));
                        });
                        $.each(response.line, function(index, value) {
                            $('#Line').append($('<option>', {
                                value: value.id,
                                text: value.line_name,
                            }));
                        });
                        $.each(response.model, function(index, value) {
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
                    success: function(response) {

                        $('#Model').empty();
                        $('#Model').append($('<option>', {
                            value: "",
                            text: "---",
                        }));
                        $.each(response.model, function(index, value) {
                            $('#Model').append($('<option>', {
                                value: value.id,
                                text: value.model,
                            }));
                        });
                    }
                });

            }

            function show_overview() {
                $('#progress-container-1').html("");
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
                    success: function(data) {
                        var data_detail = data.progressData;
                        data_detail.forEach(item => {
                            createProgressBar(item.Locations + '  - (' + data
                                .completed_checklists +
                                '/' + data.total_checklists + ')', item
                                .completion_percentage);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

            }

            $('#Line_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            $('#Code_machine').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });
            $('#Shift_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            $('#date_form').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });
            $('#Status_search').on('change', function(e) {
                e.preventDefault();
                search();
                show_overview()

            });

            function createProgressBar(line, completion) {
                const progressContainer = $('#progress-container-1');
                const progressCol = $('<div>').addClass('col-xl-8 col-sm-8');
                const progressDiv = $('<div>').addClass('progress').attr('data-line', line);
                const progress = $('<div>').addClass('progress-bar').css({
                    width: `${completion}%`,
                    background: '#25babc'
                });

                const progressValue = $('<div>').addClass('progress-value').html(`<span>${completion}</span>%`);
                const progressTitle = $('<div>').addClass('progressbar-title').html(
                    'Rate completed ' + line);

                progress.append(progressValue).append(progressTitle);
                progressDiv.append(progress);
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
                    success: function(response) {
                        // console.log(response.data_checklist);
                        // $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_checklist, function(index, value) {
                            count++;
                            var status_OK =
                                '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                value.id + '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_OK_' + value.id + '">' +
                                '<label class="btn btn-outline-success" for="status_OK_' + value
                                .id + '">OK</label>';

                            // ' <input type="checkbox" value="OK" class="status_OK" check_id="' +
                            // value.id + '" id="status_OK_' + value.id + '" > ';
                            var status_NG =
                                '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                value.id + '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_NG_' + value.id + '">' +
                                '<label class="btn btn-outline-danger" for="status_NG_' + value
                                .id + '">NG</label>';


                            // ' <input type="checkbox" value="NG" class="status_NG" check_id="' +
                            // value.id + '" id="status_NG_' + value.id + '" > ';
                            var problem =
                                '<input name="problem"  type="text" id="' + value.id +
                                '" class="form-control problem">';

                            data.push([
                                count,
                                value.Hang_muc,
                                status_OK,
                                status_NG,
                                problem,
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

                        // document.querySelectorAll(".status_OK").forEach(function(okCheckbox) {
                        //     okCheckbox.addEventListener('change', function() {
                        //         // Lấy id của mục hiện tại
                        //         const itemId = okCheckbox.getAttribute('check_id');
                        //         console.log(itemId);
                        //         // const ngCheckbox = document.querySelector('.status_NG[data-id="' + itemId +
                        //         //     '"]');
                        //         const Id = "status_NG_" + itemId;
                        //         const ngCheckbox = document.getElementById(Id);


                        //         // Nếu checkbox OK được chọn, bỏ chọn checkbox NG
                        //         if (okCheckbox.checked) {
                        //             ngCheckbox.checked = false;
                        //         }
                        //     });
                        // });

                        // document.querySelectorAll('.status_NG').forEach(function(ngCheckbox) {
                        //     ngCheckbox.addEventListener('change', function() {
                        //         // Lấy id của mục hiện tại
                        //         const itemId = ngCheckbox.getAttribute('check_id');
                        //         const Id = "status_OK_" + itemId;
                        //         console.log(itemId);
                        //         // const okCheckbox = document.querySelector('.status_OK[data-id="' + itemId +
                        //         //     '"]');
                        //         const okCheckbox = document.getElementById(Id);

                        //         // Nếu checkbox NG được chọn, bỏ chọn checkbox OK
                        //         if (ngCheckbox.checked) {
                        //             okCheckbox.checked = false;
                        //         }
                        //     });
                        // });


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
                    success: function(response) {
                        console.log(response.data_checklist);
                        // $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_checklist, function(index, value) {
                            count++;

                            if (value.Check_status == "OK") {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' + value.id + '" checked>' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' + value.id + '">' +
                                    '<label class="btn btn-outline-danger" for="status_NG_' +
                                    value
                                    .id + '">NG</label>';
                            } else {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' + value.id + '">' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id + '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' + value.id + '" checked>' +
                                    '<label class="btn btn-outline-danger" for="status_NG_' +
                                    value
                                    .id + '">NG</label>';

                            }
                            if (value.Status == null) {
                                var Status = "";
                            } else {
                                var Status = value.Status;
                            }

                            var problem =
                                '<input name="problem"  type="text" id="' + value.id +
                                '" class="form-control problem" value="' + Status + '">';

                            data.push([
                                count,
                                value.Hang_muc,
                                status_OK,
                                status_NG,
                                problem,
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

            function search() {

                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                var line_search = $('#Line_search option:selected').text();
                var shift_search = $('#shift_search option:selected').text();
                var Status_search = $('#Status_search option:selected').text();
                var Code_machine = $('#Code_machine').val();
                var date_form = ($('#date_form').val());
                if ($('#date_form').val() == 0) {
                    alert('Vui lòng chọn thời gian kiểm tra');
                } else {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('check.list.overview') }}',
                        dataType: 'json',
                        data: {
                            line: line_search,
                            shift: shift_search,
                            date_form: date_form,
                            Status: Status_search,
                            Code_machine: Code_machine,
                        },
                        success: function(users) {
                            var count = 0;
                            var data = [];
                            var colum = [];
                            var data;
                            console.log(users.data);
                            $.each(users.data, function(index, value) {
                                count++;
                                if (value.Check_status == "Completed") {
                                    var view =
                                        '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-success view-show check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">View</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">' +
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
                                } else if (value.Check_status == "Pending") {
                                    var view =
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary  view-check check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Check</button>' +
                                        '<input type="hidden" value ="' + value.ID_checklist +
                                        '" id="' + value.id + '">';
                                } else {
                                    var view = '<button type="button" value="' + value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                        value.ID_checklist + '">Delete All</button>' +
                                        ' <input type="hidden" value="' + value.ID_checklist +
                                        '" id="' + value.id + '">';
                                }
                                data.push([
                                    count,
                                    value.Locations,
                                    value.Model,
                                    value.Machine,
                                    value.Code_machine,
                                    value.item_checklist,
                                    value.Khung_check,
                                    // value.Shift,
                                    // value.Check_status,
                                    // value.Date_check,
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
                                // '<th style="text-align: center">Shift</th>' +
                                // '<th style="text-align: center">Trạng thái</th>' +
                                // '<th style="text-align: center">Date</th>' +
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
            $(document).on('click', '.view-check', function(e) {
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
                    $('#Model option:selected').filter(function() {
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

            $(document).on('click', '.view-edit', function(e) {
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

                    $('#Model option:selected').filter(function() {
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

            $(document).on('click', '.view-show', function(e) {
                e.preventDefault();
                const button1 = document.getElementById('save-check-list');
                button1.style.display = 'none'; // Ẩn button
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
                    $('#Model option:selected').text(rowData[2]);
                    date = rowData[9];
                    shift = rowData[7];

                    $('#Model option:selected').filter(function() {
                        return $(this).text() === rowData[2];
                    }).prop('selected', true);

                    $('#Model').prop('disabled', true);
                    $('#Machine').prop('disabled', true);
                    $('#ID_machine').prop('disabled', true);
                    $('#Line').prop('disabled', true);
                    $('#Checklist_item').prop('disabled', true);
                    $('#Khung_gio').prop('disabled', true);
                }


                show_check_list_edit(id_checklist_detail)

            });


            $(document).on('click', '.view-delete', function() {
                const idChecklist = $(this).val(); // Lấy ID của checklist từ nút
                // id_checklist_detail = $(this).val();
                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('delete.check.list', ':id') }}".replace(':id', idChecklist),
                        success: function(response) {
                            if (response.status === 200) {
                                alert('Xóa thành công');
                                // Cập nhật lại bảng hoặc xóa hàng đã xóa
                                $('#table_check_list_search').DataTable().row(row).remove()
                                    .draw();

                            } else {
                                alert('Có lỗi xảy ra. Không thể xóa.');
                            }
                        },
                        error: function() {
                            alert('Có lỗi xảy ra. Không thể xóa.');
                        }
                    });
                }
            });


            $(document).on('click', '#save-check-list', function(e) {
                e.preventDefault();
                let shouldExit = false;
                const line = $('#Line option:selected').text();
                const Model = $('#Model option:selected').text();
                const Machine = $('#Machine option:selected').text();
                const Khung_gio = $('#Khung_gio option:selected').text();
                const ID_machine = $('#ID_machine').val();
                const Checklist_item = $('#Checklist_item option:selected').text();
                const data = {
                    id_checklist: id_checklist_detail,
                    Model,
                    date,
                    ID_machine,
                    details: [] // Thêm một mảng để chứa các chi tiết
                };
                $('#table-check-list').DataTable().rows().every(function() {
                    if (shouldExit) {
                        return false; // Nếu flag là true, thoát khỏi vòng lặp
                    }
                    const rowData = this.data();
                    const problems = $(this.node()).find('.problem').val();
                    const status_OK = $(this.node()).find('.status_OK').prop('checked');
                    const status_NG = $(this.node()).find('.status_NG').prop('checked');
                    if (!status_OK && !status_NG) {
                        shouldExit = true;
                        return;
                    } else {
                        if (status_OK) {
                            var status = 'OK';
                        } else {
                            var status = 'NG';
                        }
                        data.details.push({
                            Locations: line,
                            Model: Model,
                            ID_item_checklist: "1",
                            Machine: Machine,
                            Hang_muc: rowData[1],
                            item_checklist: Checklist_item,
                            Khung_check: Khung_gio,
                            Shift: shift,
                            Code_machine: ID_machine,
                            Check_status: status,
                            Status: problems,
                            // Remark: process,
                            Date_check: date
                        });
                    }


                });

                if (Model === "---") {
                    return alert("Vui lòng chọn model, nếu không có thì chọn COMMON");
                } else if (shouldExit) {
                    alert("Kiểm tra hạng mục checklist chưa check");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('save.check.list', ':table') }}".replace(':table',
                            'checklist_result'),
                        dataType: 'json',
                        data: JSON.stringify(data), // Chuyển đổi thành chuỗi JSON
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.status === 400) {
                                return alert('Update plan check list');
                            }
                            alert('Lưu check-list thành công');
                            $('#table_check_list').DataTable().clear();
                            show_overview();
                            $('#modal-check').modal('hide');
                        },
                        error: function() {
                            alert('Lưu check-list thất bại');
                        }
                    });
                    search();
                }



            });


            $(document).on('click', '#update-check-list', function(e) {
                e.preventDefault();
                var data = [];
                // var data2 = [];
                let shouldExit = false;
                var line = $('#Line option:selected').text();
                var Model = $('#Model option:selected').text();
                var Machine = $('#Machine option:selected').text();
                var Khung_gio = $('#Khung_gio option:selected').text();
                var ID_machine = $('#ID_machine').val();
                var Checklist_item = $('#Checklist_item option:selected').text();
                $('#table-check-list').DataTable().rows().every(function() {
                    if (shouldExit) {
                        return false; // Nếu flag là true, thoát khỏi vòng lặp
                    }
                    const rowData = this.data();
                    const problems = $(this.node()).find('.problem').val();
                    const status_OK = $(this.node()).find('.status_OK').prop('checked');
                    const status_NG = $(this.node()).find('.status_NG').prop('checked');
                    if (!status_OK && !status_NG) {
                        shouldExit = true;
                        return;
                    } else {
                        if (status_OK) {
                            var status = 'OK';
                        } else {
                            var status = 'NG';
                        }
                        data.push({
                            id_checklist_result: id_checklist_detail,
                            Locations: line,
                            Model: Model,
                            ID_item_checklist: "1",
                            Machine: Machine,
                            Hang_muc: rowData[1],
                            item_checklist: Checklist_item,
                            Khung_check: Khung_gio,
                            Shift: shift,
                            Code_machine: ID_machine,
                            Check_status: status,
                            Status: problems,
                            // Remark: process,
                            Date_check: date

                        });
                    }


                });


                $.ajax({
                    type: "POST",
                    url: "{{ route('update.check.list.detail', ':table') }}"
                        .replace(':table', id_checklist_detail),
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(users) {
                        alert('Update check-list Thành công');
                        $('#table_check_list').DataTable().clear();
                        $('#modal-check').modal('hide');
                    }
                });



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
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            $('#' + data.id).remove();
                            $('#' + table_id).DataTable().ajax.reload();
                        }

                    }
                });
            }

            $('#table_check_list_view').on('draw.dt', function() {
                editTable('table_check_list_view', table_edit);
            });

            $(document).on('click', '#close-model', function(e) {
                e.preventDefault();
                $('#table_check_list').DataTable().clear();
                $('#table_check_list thead tr').remove();
                $('#modal-check').modal('hide');
                show_model_check();
            });

            $(document).on('click', '.close-model-scan', function(e) {
                e.preventDefault();
                $('#modal-scan').modal('hide');
                html5QrcodeScanner.clear();
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
