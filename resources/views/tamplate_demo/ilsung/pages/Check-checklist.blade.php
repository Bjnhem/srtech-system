@extends('ilsung.layouts.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            {{-- <div class="row" id="progress-container-1">
            </div>
            <br> --}}
            <div class="row">
                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="Code_machine">Machine-ID</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nhập code machine"
                            aria-label="Nhập code machine" aria-describedby="Code_machine" id="Code_machine">
                        <button class="btn btn-outline-secondary btn-primary" type="button" id="Scan_QR">Scan</button>
                    </div>
                </div>

                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="Line_search">Line:</label>
                    <select name="line" id="Line_search" class="form-select">
                        <!-- Options will be populated here -->
                    </select>
                </div>

                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="Machine_search">Machine:</label>
                    <select name="Machine" id="Machine_search" class="form-select">
                        <!-- Options will be populated here -->
                    </select>
                </div>

                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="date_form">Date Search</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" class="form-control text-start" id="date_form" placeholder="YYYY-MM-DD"
                            autocomplete="off">
                    </div>
                </div>

                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="shift_search">Shift:</label>
                    <select name="shift" id="shift_search" class="form-select">
                        <option value="">All</option>
                        <option value="Ca ngày">Ca ngày</option>
                        <option value="Ca đêm">Ca đêm</option>
                    </select>
                </div>

                <div class="col-12 col-sm-4 col-md-4 mb-3">
                    <label for="Status_search">Tình trạng:</label>
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
                    <thead class="table-success" style="text-align: center; vertical-align:middle">
                        <tr style="text-align: center">
                            <th style="text-align: center">STT</th>
                            <th style="text-align: center">Line</th>
                            <th style="text-align: center">Model</th>
                            <th style="text-align: center">Machine</th>
                            <th style="text-align: center">Code QL</th>
                            <th style="text-align: center">Check List</th>
                            <th style="text-align: center">Khung check</th>
                            <th style="text-align: center">Edit</th>
                        </tr>
                    </thead>
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
                    <div>
                        <button type="button" id="save-check-list" class="btn btn-success">Save</button>
                        <button type="button" id="update-check-list" class="btn btn-success">Update</button>
                        <button type="button" id="close-model" class="btn btn-warning close-model-checklist">Close</button>
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
                            {{-- <div id="suggestions" style="border: 1px solid #ccc; display: none;"></div>
                            <div id="error-message" style="color: red; display: none;"></div> --}}


                        </div>

                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Item check list:</span>
                            <input name="Checklist_item" type="text" id="Checklist_item" class="form-control">
                            {{-- <select name="item" id="Checklist_item" class="form-select">
                            </select> --}}
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Khung check:</span>
                            <select name="shift" id="Khung_gio" class="form-select">
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row table-responsive">
                        <table class="table table-bordered text-center mt-4 table-hover col-12" id="table-check-list"
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
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

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
            const hours = currentDate.getHours();
            var rowSelected;
            // console.log(hours);
            // const hours = 22;

            if (hours > 8 && hours < 20) {
                $('#shift_search').val('Ca ngày');
            } else {
                $('#shift_search').val('Ca đêm');
            }
            $('#date_form').val(date);


            show_master_check();
            show_master_status();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

            function reader_QR() {
                var lastResult, countResults = 0;
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

                function onScanSuccess(decodedText, decodedResult) {
                    if (decodedText !== lastResult) {
                        ++countResults;
                        lastResult = decodedText;

                        // $('#Code_machine').val(lastResult);

                        // html5QrcodeScanner.clear();
                        // $('#modal-scan').modal('hide');

                        checkMachineID(lastResult);
                        // search();
                        // show_overview()

                    }
                }

            }

            const Scan = document.getElementById('Scan_QR');
            Scan.addEventListener('click', () => {
                $('#modal-scan').modal('show');
                reader_QR();
            });

            function checkMachineID(machineID) {
                console.log(machineID);
                $.ajax({
                    type: "POST",
                    url: "{{ route('check.machine') }}",
                    contentType: 'application/json', // Đảm bảo là gửi dữ liệu dưới dạng JSON
                    data: JSON.stringify({
                        machine_id: machineID,
                    }),
                    success: function(users) {
                        if (users.isValid) {
                            console.log(machineID);
                            $('#Code_machine').val(machineID);
                            toastr.success("Mã QR hợp lệ: " + machineID);
                            html5QrcodeScanner.clear();
                            $('#modal-scan').modal('hide');
                            search();
                            show_overview()

                        } else {
                            // Nếu mã QR không hợp lệ
                            const userChoice = confirm(
                                "Mã QR không hợp lệ. Bạn có muốn quét lại hoặc thoát?");
                            if (userChoice) {} else {
                                html5QrcodeScanner.clear();
                                $('#modal-scan').modal('hide');
                            }
                        }
                    },
                    error: function() {
                        alert("Lỗi kết nối khi kiểm tra mã máy.");
                    }


                });
            }


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

                        $('#Line_search').val(line_check);
                        search();
                        // show_overview();
                        // show_data_table();
                        // initializeDataTable();



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
                        $('#Machine_search').empty();
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
                        $('#Machine_search').append($('<option>', {
                            value: "",
                            text: "All",
                        }));
                        // $('#Checklist_item').append($('<option>', {
                        //     value: "",
                        //     text: "---",
                        // }));

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
                            $('#Machine_search').append($('<option>', {
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
                                value: value.model,
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
                                value: value.model,
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
                    url: "{{ route('checklist.overview.data') }}",
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
                            createProgressBar(item.Locations + '  - (' +
                                data
                                .completed_checklists +
                                '/' + data.total_checklists + ')',
                                item
                                .completion_percentage);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

            }

            $('#Line_search,#Code_machine,#shift_search,#Machine_search,#date_form,#Status_search').on('change',
                function(e) {
                    e.preventDefault();
                    search();
                });



            function createProgressBar(line, completion) {
                const progressContainer = $('#progress-container-1');
                const progressCol = $('<div>').addClass('col-xl-8 col-sm-8');
                const progressDiv = $('<div>').addClass('progress').attr('data-line', line);
                const progress = $('<div>').addClass('progress-bar').css({
                    width: `${completion}%`,
                    background: '#25babc'
                });

                const progressValue = $('<div>').addClass('progress-value').html(
                    `<span>${completion}</span>%`);
                const progressTitle = $('<div>').addClass('progressbar-title').html(
                    'Rate completed ' + line);

                progress.append(progressValue).append(progressTitle);
                progressDiv.append(progress);
                progressCol.append(progressDiv);
                progressContainer.append(progressCol);

            }

            function show_check_list(ID_checklist) {
                // console.log(ID_checklist);
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
                                value.id +
                                '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_OK_' + value
                                .id + '">' +
                                '<label class="btn btn-outline-success" for="status_OK_' +
                                value
                                .id + '">OK</label>';

                            // ' <input type="checkbox" value="OK" class="status_OK" check_id="' +
                            // value.id + '" id="status_OK_' + value.id + '" > ';
                            var status_NG =
                                '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                value.id +
                                '" autocomplete="off"  check_id="' +
                                value.id + '" id="status_NG_' + value
                                .id + '">' +
                                '<label class="btn btn-outline-danger" for="status_NG_' +
                                value
                                .id + '">NG</label>';


                            // ' <input type="checkbox" value="NG" class="status_NG" check_id="' +
                            // value.id + '" id="status_NG_' + value.id + '" > ';
                            var problem =
                                '<input name="problem"  type="text" id="' +
                                value.id +
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
                            'order': false,
                            'searching': false,
                            "lengthMenu": [
                                [-1],
                                ["Show all"]
                            ],
                            initComplete: function() {
                                // Căn giữa các tiêu đề cột
                                $('#table-check-list thead th').css('text-align', 'center');
                            },
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
                // console.log(ID_checklist);
                $.ajax({
                    type: "GET",
                    url: '{{ route('check.list.edit.search') }}',
                    data: {
                        id_checklist: ID_checklist,
                    },
                    success: function(response) {
                        // console.log(response.data_checklist);
                        // $('#table-check-list').DataTable().destroy();
                        var count = 0;
                        var data = [];
                        $.each(response.data_checklist, function(index, value) {
                            count++;

                            if (value.Check_status == "OK") {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id +
                                    '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' +
                                    value.id + '" checked>' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id +
                                    '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' +
                                    value.id + '">' +
                                    '<label class="btn btn-outline-danger" for="status_NG_' +
                                    value
                                    .id + '">NG</label>';
                            } else {
                                var status_OK =
                                    '<input type="radio" class="btn-check status_OK" name="options-outlined_' +
                                    value.id +
                                    '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_OK_' +
                                    value.id + '">' +
                                    '<label class="btn btn-outline-success" for="status_OK_' +
                                    value
                                    .id + '">OK</label>';

                                var status_NG =
                                    '<input type="radio" class="btn-check status_NG" name="options-outlined_' +
                                    value.id +
                                    '" autocomplete="off"  check_id="' +
                                    value.id + '" id="status_NG_' +
                                    value.id + '" checked>' +
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
                                '<input name="problem"  type="text" id="' +
                                value.id +
                                '" class="form-control problem" value="' +
                                Status + '">';

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
                            ],
                            initComplete: function() {
                                // Căn giữa các tiêu đề cột
                                $('#table-check-list thead th').css('text-align', 'center');
                            },
                        });


                    }
                });
            }

            function show_data_table() {
                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                return $('#table_check_list_search').DataTable({
                    processing: true, // Cho phép xử lý dữ liệu trong lúc tải
                    serverSide: true, // Bật chế độ server-side pagination
                    ajax: {
                        url: "{{ route('check.list.overview') }}", // Đường dẫn đến route mà ta đã định nghĩa
                        type: "post",
                        data: function(d) {
                            d.line_search = $('#Line_search option:selected').text();
                            d.Machine_search = $('#Machine_search option:selected').text();
                            d.shift_search = $('#shift_search option:selected').text();
                            d.Status_search = $('#Status_search option:selected').text();
                            d.Code_machine = $('#Code_machine').val();
                            d.date_form = ($('#date_form').val());
                        },
                    },

                    columns: [{
                            data: null, // Không cần dữ liệu vì chúng ta sẽ tính số thứ tự
                            name: null,
                            render: function(data, type, row, meta) {
                                return meta.row +
                                    1; // meta.row trả về chỉ số dòng, cộng thêm 1 để bắt đầu từ 1
                            },
                            title: 'STT' // Tên cột sẽ hiển thị là "STT"
                        },
                        {
                            data: 'Locations',
                            name: 'Locations'
                        },
                        {
                            data: 'Model',
                            name: 'Model'
                        },
                        {
                            data: 'Machine',
                            name: 'Machine'
                        },
                        {
                            data: 'Code_machine',
                            name: 'Code_machine'
                        },
                        {
                            data: 'item_checklist',
                            name: 'item_checklist'
                        },
                        {
                            data: 'Khung_check',
                            name: 'Khung_check'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                var editButton = '';
                                var deleteButton = '';
                                var viewButton = '';
                                var checkButton = '';

                                // Dựa trên trạng thái Check_status để quyết định nút hiển thị
                                if (row.Check_status === "Completed") {
                                    // Thêm nút View, Edit và Delete khi trạng thái là "Completed"
                                    viewButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-success btn-sm view-show check editbtn" id="view_' +
                                        data + '"><span class="icon-eye"></span></button>';
                                    editButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning btn-sm editbtn" id="edit_' +
                                        data + '"><span class="icon-pencil2"></span></button>';
                                    deleteButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger btn-sm deletebtn" id="delete_' +
                                        data + '"><span class="icon-trash1"></span></button>';
                                } else if (row.Check_status === "Pending") {
                                    // Thêm nút Check khi trạng thái là "Pending"
                                    checkButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary btn-sm checkbtn" id="check_' +
                                        data + '"><span class="icon-check"></span></button>';
                                } else {
                                    // Thêm nút Delete All khi trạng thái là khác
                                    deleteButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger btn-sm deletebtn" id="delete_all_' +
                                        data +
                                        '"><span class="icon-trash1"></span></button>';
                                }

                                // Trả về tất cả các nút sẽ được hiển thị trong cột hành động
                                return viewButton + editButton + checkButton + deleteButton;
                            },
                            title: 'Actions' // Tiêu đề cho cột hành động
                        }
                    ],
                    pageLength: 10, // Mỗi trang có 20 bản ghi
                    ordering: false, // Tắt chức năng sắp xếp (có thể bật lại nếu cần)
                    searching: true, // Cho phép tìm kiếm
                    lengthChange: true, // Cho phép thay đổi số bản ghi mỗi trang
                    info: false, // Tắt thông tin số lượng bản ghi (total, filtered)
                    autoWidth: false,
                    select: {
                        style: 'single',
                    }, // Tự động điều chỉnh chiều rộng của cột
                });
            }
            // var tables; // Định nghĩa biến để chứa DataTable

            function initializeDataTable() {
                // Khởi tạo DataTable nếu chưa được khởi tạo
                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                tables = $('#table_check_list_search').DataTable({
                    processing: true, // Cho phép xử lý dữ liệu trong lúc tải
                    serverSide: true, // Bật chế độ server-side pagination
                    ajax: {
                        url: "{{ route('check.list.overview') }}", // Đường dẫn đến route mà ta đã định nghĩa
                        type: "post",
                        data: function(d) {
                            d.line_search = $('#Line_search option:selected').text();
                            d.Machine_search = $('#Machine_search option:selected').text();
                            d.shift_search = $('#shift_search option:selected').text();
                            d.Status_search = $('#Status_search option:selected').text();
                            d.Code_machine = $('#Code_machine').val();
                            d.date_form = ($('#date_form').val());
                        },
                    },
                    columns: [{
                            data: null, // Không cần dữ liệu vì chúng ta sẽ tính số thứ tự
                            name: null,
                            render: function(data, type, row, meta) {
                                return meta.row +
                                    1; // meta.row trả về chỉ số dòng, cộng thêm 1 để bắt đầu từ 1
                            },
                            title: 'STT' // Tên cột sẽ hiển thị là "STT"
                        },
                        {
                            data: 'Locations',
                            name: 'Locations'
                        },
                        {
                            data: 'Model',
                            name: 'Model'
                        },
                        {
                            data: 'Machine',
                            name: 'Machine'
                        },
                        {
                            data: 'Code_machine',
                            name: 'Code_machine'
                        },
                        {
                            data: 'item_checklist',
                            name: 'item_checklist'
                        },
                        {
                            data: 'Khung_check',
                            name: 'Khung_check'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                var editButton = '';
                                var deleteButton = '';
                                var viewButton = '';
                                var checkButton = '';

                                // Dựa trên trạng thái Check_status để quyết định nút hiển thị
                                if (row.Check_status === "Completed") {
                                    // Thêm nút View, Edit và Delete khi trạng thái là "Completed"
                                    viewButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-success btn-sm view-show check editbtn" id="view_' +
                                        data + '"><span class="icon-eye"></span></button>';
                                    editButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning btn-sm editbtn" id="edit_' +
                                        data + '"><span class="icon-pencil2"></span></button>';
                                    deleteButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger btn-sm deletebtn" id="delete_' +
                                        data + '"><span class="icon-trash1"></span></button>';
                                } else if (row.Check_status === "Pending") {
                                    // Thêm nút Check khi trạng thái là "Pending"
                                    checkButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary btn-sm checkbtn" id="check_' +
                                        data + '"><span class="icon-check"></span></button>';
                                } else {
                                    // Thêm nút Delete All khi trạng thái là khác
                                    deleteButton = '<button type="button" value="' + data +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger btn-sm deletebtn" id="delete_all_' +
                                        data +
                                        '"><span class="icon-trash1"></span></button>';
                                }

                                // Trả về tất cả các nút sẽ được hiển thị trong cột hành động
                                return viewButton + editButton + checkButton + deleteButton;
                            },
                            title: 'Actions' // Tiêu đề cho cột hành động
                        }
                    ],
                    pageLength: 10, // Mỗi trang có 10 bản ghi
                    ordering: false,
                    searching: true,
                    lengthChange: true,
                    info: false,
                    autoWidth: false,
                    select: {
                        style: 'single'
                    }, // Tự động điều chỉnh chiều rộng của cột
                });
            }

            function updateDataTable() {
                // Kiểm tra xem DataTable đã được khởi tạo hay chưa
                if ($.fn.dataTable.isDataTable('#table_check_list_search')) {
                    // Nếu DataTable đã được khởi tạo rồi, chỉ cần reload dữ liệu
                    tables.ajax.reload();
                } else {
                    // Nếu chưa khởi tạo, khởi tạo mới DataTable
                    initializeDataTable();
                }
            }



            function search() {
                if (tables) {
                    $('#table_check_list_search').DataTable().destroy();
                }
                var line_search = $('#Line_search option:selected').text();
                var Machine_search = $('#Machine_search option:selected').text();
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
                            Machine_search: Machine_search
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
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-success view-show check editbtn btn-sm" id="' +
                                        value.ID_checklist +
                                        '">View</button>' +
                                        ' <input type="hidden" value="' +
                                        value.ID_checklist +
                                        '" id="' + value.id + '">' +
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-warning view-edit check editbtn btn-sm" id="' +
                                        value.ID_checklist +
                                        '">Edit</button>' +
                                        ' <input type="hidden" value="' +
                                        value.ID_checklist +
                                        '" id="' + value.id + '">' +
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                        value.ID_checklist +
                                        '">Delete</button>' +
                                        ' <input type="hidden" value="' +
                                        value.ID_checklist +
                                        '" id="' + value.id + '">';
                                } else if (value.Check_status ==
                                    "Pending") {
                                    var view =
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-check" class="btn btn-primary  view-check check editbtn btn-sm" id="' +
                                        value.ID_checklist +
                                        '">Check</button>' +
                                        '<input type="hidden" value ="' +
                                        value.ID_checklist +
                                        '" id="' + value.id + '">';
                                } else {
                                    var view =
                                        '<button type="button" value="' +
                                        value
                                        .id +
                                        '" data-bs-toggle="modal" data-bs-target="#modal-delete" class="btn btn-danger view-delete check editbtn btn-sm" id="' +
                                        value.ID_checklist +
                                        '">Delete All</button>' +
                                        ' <input type="hidden" value="' +
                                        value.ID_checklist +
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
                                    view,
                                ]);
                            });

                            // var header =
                            //     '<thead class="table-success" style="text-align: center; vertical-align:middle">' +
                            //     '<tr style="text-align: center">' +
                            //     '<th style="text-align: center">STT</th>' +
                            //     '<th style="text-align: center">Line</th>' +
                            //     '<th style="text-align: center">Model</th>' +
                            //     '<th style="text-align: center">Machine</th>' +
                            //     '<th style="text-align: center">Code QL</th>' +
                            //     '<th style="text-align: center">Check List</th>' +
                            //     '<th style="text-align: center">Khung check</th>' +
                            //     '<th style="text-align: center">Edit</th>' +
                            //     '</tr>'
                            // '</thead>'


                            // $('#table_check_list_search').html(header);
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
                $('#save-check-list').show(); // Ẩn nút Save
                $('#update-check-list').hide(); // Hiển thị nút Update
                id_checklist_detail = $(this).val();
                id_checklist = this.id;
                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];
                }
                var rowData = tables.row(rowSelected).data();
                // Lấy dữ liệu của dòng đầu tiên được chọn
                $('#Machine option').text(rowData[3]);
                $('#ID_machine').val(rowData[4]);
                $('#Line option').text(rowData[1]);
                $('#Checklist_item').val(rowData[5]);
                $('#Khung_gio option').text(rowData[6]);

                date = rowData[9];
                shift = rowData[7];

                $('#Model').prop('disabled', false);
                $('#Machine,#ID_machine,#Line,#Checklist_item,#Khung_gio').prop('disabled', true);

                show_check_list(id_checklist)

            });


            $(document).on('click', '.view-edit', function(e) {
                e.preventDefault();
                $('#save-check-list').hide(); // Ẩn nút Save
                $('#update-check-list').show(); // Hiển thị nút Update
                id_checklist_detail = $(this).val();
                id_checklist = this.id;

                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];    
                }
               
                var rowData = tables.row(rowSelected).data();
                console.log(rowData);
                // Lấy dữ liệu của dòng đầu tiên được chọn
                $('#Machine option').text(rowData[3]);
                $('#ID_machine').val(rowData[4]);
                $('#Line option').text(rowData[1]);
                $('#Checklist_item').val(rowData[5]);
                $('#Khung_gio option').text(rowData[6]);
                $('#Model').val(rowData[2]);
                date = rowData[9];
                shift = rowData[7];              

                $('#Model').prop('disabled', false);
                $('#Machine,#ID_machine,#Line,#Checklist_item,#Khung_gio').prop('disabled', true);
                show_check_list_edit(id_checklist_detail)

            });

            $(document).on('click', '.view-show', function(e) {
                e.preventDefault();
                $('#save-check-list').hide(); // Ẩn nút Save
                $('#update-check-list').hide(); // Hiển thị nút Update
                id_checklist_detail = $(this).val();
                id_checklist = this.id;
                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];    
                }
                var rowData = tables.row(rowSelected).data();
           
                // Lấy dữ liệu của dòng đầu tiên được chọn
                $('#Machine option').text(rowData[3]);
                $('#ID_machine').val(rowData[4]);
                $('#Line option').text(rowData[1]);
                $('#Checklist_item').val(rowData[5]);
                $('#Khung_gio option').text(rowData[6]);
                $('#Model').val(rowData[2]);
                date = rowData[9];
                shift = rowData[7];              

                $('#Model').prop('disabled', true);
                $('#Machine,#ID_machine,#Line,#Checklist_item,#Khung_gio').prop('disabled', true);

                show_check_list_edit(id_checklist_detail)

            });


            $(document).on('click', '.view-delete', function() {
                const idChecklist = $(this).val(); // Lấy ID của checklist từ nút
                // id_checklist_detail = $(this).val();
                const row = $(this).closest(
                    'tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('delete.check.list', ':id') }}"
                            .replace(':id', idChecklist),
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success('Xóa thành công');
                                // alert('Xóa thành công');
                                // Cập nhật lại bảng hoặc xóa hàng đã xóa
                                $('#table_check_list_search')
                                    .DataTable().row(row).remove()
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
                    const status_OK = $(this.node()).find('.status_OK')
                        .prop('checked');
                    const status_NG = $(this.node()).find('.status_NG')
                        .prop('checked');
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
                    return alert(
                        "Vui lòng chọn model, nếu không có thì chọn COMMON");
                } else if (shouldExit) {
                    alert("Kiểm tra hạng mục checklist chưa check");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('save.check.list', ':table') }}"
                            .replace(':table',
                                'checklist_result'),
                        dataType: 'json',
                        data: JSON.stringify(
                            data), // Chuyển đổi thành chuỗi JSON
                        contentType: 'application/json',
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Update plan check list');
                                // return alert('Update plan check list');
                            }
                            toastr.success('Lưu check-list thành công');
                            // alert('Lưu check-list thành công');
                            $('#table_check_list').DataTable().clear();
                            show_overview();
                            $('#modal-check').modal('hide');
                        },
                        error: function() {
                            // alert('Lưu check-list thất bại');
                            toastr.danger('Lưu check-list thất bại');

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
                    const status_OK = $(this.node()).find('.status_OK')
                        .prop('checked');
                    const status_NG = $(this.node()).find('.status_NG')
                        .prop('checked');
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
                        // alert('Update check-list Thành công');
                        toastr.success('Update check-list Thành công')
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


        });
    </script>
@endsection
