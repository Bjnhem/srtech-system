@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
    <div class="card table-responsive card-loss" style="border: none;">
        <div class="card-header">
            <h3 class="header-title">Quản lý lỗi OQC Final</h3>
        </div>
        <div class="card-body">
            <!-- Master Plan & Data Input -->
            <div class="row content-top">
                <!-- Master Plan Section -->
                <div class="col-lg-6 master-plan">
                    <h4 class="section-title">Master Plan</h4>
                    <div class="row">
                        <div class="col-4 mb-3 bottommargin-sm">
                            <label for="">Date Search</label>
                            <div class="input-daterange component-datepicker input-group">
                                <input type="text" value="" class="form-control text-start" id="date_search"
                                    placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                                     
                            <label for="shift_search">Shift</label>
                            <select id="shift_search" class="form-select">
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="Line_search">Line</label>
                            <select id="Line_search" class="form-select">  
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="khung_gio">Khung giờ</label>
                            <select id="khung_gio" class="form-select">
                               
                            </select>      
                        </div>
                        <div class="col-6 mb-3">
                            <label for="model_search">Model</label>
                            <select id="model_search" class="form-select" name="model_search">
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="prod_qty">Prod. Qty</label>
                            <input type="text" class="form-control" id="prod_qty" readonly>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="NG_qty">NG Qty</label>
                            <input type="text" class="form-control" id="NG_qty" readonly>
                        </div>
                    </div>
                </div>

                <!-- Data Lỗi Input Section -->
                <div class="col-lg-6 data-loi-input">
                    <h4 class="section-title">Data Lỗi Input</h4>
                    <form method="post" id="form_data" enctype="multipart/form-data">
                        <div class="row">
                            {{-- <input type="hidden" id="NG_qty" name="NG_qty" value="1" required> --}}
                            <div class="col-4 mb-3">
                                <label for="code_id">Code ID</label>
                                <input type="text" id="Code_ID" name="Code_ID" class="form-control" required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="code_id">NG Qty</label>
                                <input type="number" id="NG_qty" name="NG_qty" class="form-control" value="1"
                                    min="1" required>
                            </div>

                            <div class="col-4 mb-3">
                                <label for="remark">Remark</label>
                                <input type="text" id="remark" name="remark" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="category">Loại lỗi</label>
                                <select id="category" name="category" class="form-select" required>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="name">Tên lỗi</label>
                                <select id="name" name="name" class="form-select" required>
                                </select>
                            </div>

                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-primary w-100" style="margin-top: 20px"
                                    id="save_loss">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>

            <!-- Data Inputs Loss Detail -->
            <div class="row data-detail">

                <h4 class="section-title">Data loss detail</h4>
                <div class="card ">
                    <div class="card-body table-response">

                        <table class="table table-bordered table-hover table-sm" id="table-result">
                            <thead class="table-success">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Line</th>
                                    <th>Khung giờ</th>
                                    <th>Prod. qty</th>
                                    <th>Code ID</th>
                                    <th>Tên lỗi</th>
                                    <!-- <th>Remark</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modal-created">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mx-3" id="title_modal_data">Chỉnh sửa dữ liệu</h5>
                    <div>
                        <button type="button" id="update" class="btn btn-success">Update</button>
                        <button type="button" id="close-model"
                            class="btn btn-warning close-model-checklist">Close</button>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <div class="card">

                        <div class="card-body">
                            <div class="col-12"> <!-- Phần Thêm kế hoạch bằng Form -->
                                <form action="" method="post" id="form_data" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="edit_id" name="id">
                                    <div class="form-group">
                                        <label for="edit_time_slot">Khung giờ</label>
                                        <select class="form-control" id="edit_time_slot" name="time_slot">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_prod_qty">Sản phẩm (Prod. qty)</label>
                                        <input type="number" class="form-control" id="edit_prod_qty" name="prod_qty">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_NG_qty">Lỗi (NG qty)</label>
                                        <input type="number" class="form-control" id="edit_NG_qty" name="NG_qty">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_remark">Ghi chú</label>
                                        <textarea class="form-control" id="edit_remark" name="remark"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_Code_ID">Code ID</label>
                                        <input type="text" class="form-control" id="edit_Code_ID" name="Code_ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_error_list_id">ID lỗi</label>
                                        <input type="text" class="form-control" id="edit_error_list_id"
                                            name="error_list_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_plan_id">ID kế hoạch</label>
                                        <input type="text" class="form-control" id="edit_plan_id" name="plan_id">
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table_name = 'LineLoss';
            var table = '#table-result';
            let title_add = "Add plan";
            let title_edit = "Edit plan";
            var tables;
            let id;
            let case_action = 'date';
            let case_action_detail = 'date';
            let data_import_action = 'item_loss';

            let dateInput;
            let shiftSelect;
            let lineSelect;
            let modelSelect;
            let prodQtyInput;
            let timeSelect;

            const khung_A = {
                a: '08h-10h',
                b: '10h-12h',
                c: '13h-15h',
                d: '15h-17h',
                e: '18h-20h'
            };
            const khung_C = {
                a: '20h-22h',
                b: '22h-00h',
                c: '01h-03h',
                d: '03h-05h',
                e: '06h-08h'
            };

            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            const hours = currentDate.getHours();
            // const hours = 7;
            $('#date_search,#date_search_detail').val(date);
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#table_name').val(table_name);

            function show_khung_gio(action) {
                // const hours = currentDate.getHours();
                var shift_show = $('#shift_search').val();
                // Lựa chọn khung giờ dựa trên giá trị của shift_show
                const khung_gio_data = shift_show === "A" ? khung_A : shift_show === "C" ? khung_C : {};

                if (action == 'khung_gio') {
                    // Duyệt qua các mục trong khung giờ được chọn và thêm vào dropdown
                    $('#khung_gio').empty();
                    Object.entries(khung_gio_data).forEach(([key, value]) => {
                        $('#khung_gio').append($('<option>', {
                            value: key, // Giá trị của option
                            text: value, // Nội dung hiển thị
                        }));
                    });

                    let selectedKey = null;

                    // Lấy giờ hiện tại
                    // const currentDate = new Date();
                    // const hours = currentDate.getHours();

                    Object.entries(khung_gio_data).forEach(([key, value]) => {
                        const [start, end] = value.split('-').map(time => parseInt(time.replace('h', '')));

                        // Xử lý trường hợp khoảng giờ qua đêm (VD: 22h-00h)
                        if ((start <= hours && hours < end) || (start > end && (hours >= start || hours <
                                end))) {
                            selectedKey = key;
                        }
                    });

                    // Set option được chọn nếu tìm thấy
                    if (selectedKey) {
                        $('#khung_gio').val(selectedKey);
                    }
                }



            }

            function show_data_check() {
                // Lấy giá trị của các trường nhập liệu
                dateInput = $("#date_search").val();

                // Kiểm tra nếu ngày không được chọn
                if (!dateInput) {
                    toastr.error('Vui lòng chọn ngày!');
                    return;
                }


                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.loss.data.plan.search') }}",
                    dataType: "json",
                    data: {
                        date: dateInput
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        // console.log(case_action);
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {
                            // Thêm các option mới vào dropdown shift
                            if (case_action == 'date') {
                                var shiftSelect;

                                $('#shift_search').empty();
                                if (response.shifts && response.shifts.length > 0) {
                                    $.each(response.shifts, function(index, value) {
                                        console.log(value);
                                        console.log(hours);
                                        if (hours >= 8 && hours < 20 && value == "A") {
                                            shiftSelect = 'A'
                                        }
                                        if (value == "C") {
                                            if (hours >= 20 || hours < 8) {
                                                shiftSelect = 'C'

                                            }
                                        }

                                        $('#shift_search').append($('<option>', {
                                            value: value,
                                            text: value,
                                        }));
                                        // console.log(value);

                                    });
                                    console.log(shiftSelect);
                                    if (!shiftSelect) {
                                        shiftSelect = response.shifts[0];
                                        alert(
                                            `Shift hiện tại không có plan. Chọn mặc định shift: ${shiftSelect}`
                                        );
                                    }

                                    $('#shift_search').val(shiftSelect);
                                    show_khung_gio('khung_gio');

                                }

                                $('#Line_search').empty();
                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    $.each(response.lines, function(index, value) {
                                        if (value.shift == shift_show) {
                                            $('#Line_search').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));
                                        }

                                    });
                                }
                                $('#model_search').empty();
                                if (response.models && response.models.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    var line_show = $('#Line_search').val();

                                    $.each(response.models, function(index, value) {
                                        if (value.shift == shift_show && value.line ==
                                            line_show) {
                                            $('#model_search').append($('<option>', {
                                                value: value.id,
                                                text: value.model,
                                            }));
                                        }
                                    });
                                }
                            }
                            if (case_action == 'shift') {
                                $('#Line_search').empty();
                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    $.each(response.lines, function(index, value) {
                                        if (value.shift == shift_show)
                                            $('#Line_search').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));
                                    });
                                }

                                $('#model_search').empty();
                                // Thêm các option mới vào dropdown model
                                if (response.models && response.models.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    var line_show = $('#Line_search').val();
                                    $.each(response.models, function(index, value) {
                                        if (value.shift == shift_show && value.line ==
                                            line_show) {
                                            $('#model_search').append($('<option>', {
                                                value: value.id,
                                                text: value.model,
                                            }));
                                        }

                                    });
                                }
                            }
                            if (case_action == 'line') {
                                $('#model_search').empty();
                                // Thêm các option mới vào dropdown model
                                if (response.models && response.models.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    var line_show = $('#Line_search').val();
                                    $.each(response.models, function(index, value) {

                                        if (value.shift == shift_show && value.line ==
                                            line_show) {
                                            $('#model_search').append($('<option>', {
                                                value: value.id,
                                                text: value.model,
                                            }));
                                        }
                                    });
                                }


                            }
                            if (data_import_action == 'item_loss') {
                                $('#category').empty();
                                // Thêm các option mới vào dropdown model
                                if (response.category && response.category.length > 0) {
                                    $.each(response.category, function(index, value) {
                                        $('#category').append($('<option>', {
                                            value: value,
                                            text: value,
                                        }));

                                    });
                                }

                                $('#name').empty();
                                // Thêm các option mới vào dropdown model
                                if (response.item_loss && response.item_loss.length > 0) {
                                    var category = $('#category').val();
                                    $.each(response.item_loss, function(index, value) {
                                        if (value.category == category) {
                                            $('#name').append($('<option>', {
                                                value: value.id,
                                                text: value.name,
                                            }));
                                        }
                                    });
                                }


                            }

                            if (data_import_action == 'item_loss_name') {
                                $('#name').empty();
                                // Thêm các option mới vào dropdown model
                                if (response.item_loss && response.item_loss.length > 0) {
                                    var category = $('#category').val();
                                    $.each(response.item_loss, function(index, value) {
                                        if (value.category == category) {
                                            $('#name').append($('<option>', {
                                                value: value.id,
                                                text: value.name,
                                            }));
                                        }
                                    });
                                }


                            }


                            show_data_qty_plan_check();
                            show_data_table();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có lỗi trong quá trình AJAX
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }


            function show_data_qty_plan_check() {
                // Lấy giá trị của các trường nhập liệu
                dateInput = $("#date_search").val();
                shiftSelect = $("#shift_search").val();
                lineSelect = $("#Line_search").val();
                timeSelect = $("#khung_gio").val();
                modelSelect = $("#model_search option:selected").text();

                // Kiểm tra nếu ngày không được chọn
                if (!dateInput) {
                    toastr.error('Vui lòng chọn ngày!');
                    return;
                }

                // Gửi yêu cầu AJAX đến controller để lấy dữ liệu
                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.loss.data.plan.search.prod.qty') }}", // Route đã định nghĩa trong Laravel
                    dataType: "json",
                    data: {
                        date: dateInput,
                        shift: shiftSelect,
                        line: lineSelect,
                        time: timeSelect,
                        model: modelSelect,
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {
                            // console.log(response.prod_qty);
                            // console.log(response.NG_qty);
                            $('#prod_qty').val(response.prod_qty);
                            $('#NG_qty').val(response.NG_qty);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có lỗi trong quá trình AJAX
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }


            // Hành động cho master plan

            $('#date_search').on('change', function() {
                case_action = 'date';
                show_data_check();

            });

            $('#shift_search').on('change', function() {
                case_action = 'shift';
                show_data_check();
                show_khung_gio('khung_gio');

            });

            $('#Line_search').on('change', function() {
                case_action = 'line';
                show_data_check();
            });

            $('#khung_gio').on('change', function() {
                case_action = 'khung_gio';
                show_data_check();
            });

            // Hành động cho input loss
            $('#category').on('change', function() {
                data_import_action = 'item_loss_name';
                show_data_check();
            });

            $('#category').on('change', function() {
                data_import_action = 'item_loss_name';
                show_data_check();
            });


            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));

                var plan_id = $('#model_search').val();
                var error_list_id = $('#name').val();
                var prod_qty = $('#prod_qty').val();
                var time_slot = $('#khung_gio').val();

                data.append('table', table_name);
                data.append('id', id);
                data.append('plan_id', plan_id);
                data.append('prod_qty', prod_qty);
                data.append('time_slot', time_slot);
                data.append('error_list_id', error_list_id);

                // for (let pair of data.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // }
                if (data.get('Code_ID') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('OQC.update.add.data.loss.detail') }}",
                        dataType: 'json',
                        data: data,
                        processData: false, // Không xử lý dữ liệu (FormData tự xử lý)
                        contentType: false,
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Có lỗi - vui lòng thực hiện lại');
                            }
                            toastr.success('Thành công');
                            show_data_qty_plan_check();
                            show_data_table();
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }

            function show_data_table() {
                var date = $('#date_search').val();
                var shift = $('#shift_search').val();
                var line = $('#Line_search').val();
                var time = $('#khung_gio').val();
                // console.log(date);
                // console.log(shift);
                // console.log(line);
                // console.log(time);
                $.ajax({
                    url: "{{ route('OQC.update.show.data.loss.detail2') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        date: date,
                        shift: shift,
                        line: line,
                        time: time,
                    },

                    success: function(response) {
                        var data = [];
                        // console.log(response.data)
                        $.each(response.data, function(index, value) {
                            // console.log(value);
                            let timeSlotLabel = '';
                            if (value.shift == "A") {
                                timeSlotLabel = khung_A[value.time_slot];
                            } else if (value.shift == "C") {
                                timeSlotLabel = khung_C[value.time_slot];
                            }
                            var tim_slot = '<span class="time-slot" data-time-slot="' + value
                                .time_slot + '">' +
                                timeSlotLabel + '</span>';

                            var deleteButton = '<button type="button" value="' + value.id +
                                '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                            data.push([
                                value.date,
                                value.line,
                                tim_slot,
                                value.prod_qty,
                                value.Code_ID,
                                value.name,
                                deleteButton
                            ]);
                        });

                        if (tables) {
                            tables.clear();
                            tables.rows.add(data).draw();
                        } else {
                            tables = $('#table-result').DataTable({
                                data: data,
                                "searching": true,
                                "autoWidth": false,
                                "paging": true,
                                "ordering": false,
                                "info": false,
                                select: {
                                    style: 'single',
                                },
                            });
                        }


                    },
                    error: function() {
                        toastr.success('Có lỗi - vui lòng thực hiện lại');
                    }
                });
            }

            show_data_check();

            $(document).on('click', '#save_loss', function(e) {
                e.preventDefault();
                id = '';
                save_update_data();
            });



            $(document).on('click', '#delete', function() {
                const id = $(this).val(); // Lấy ID của checklist từ nút

                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('OQC.update.delete.data.loss.detail') }}",
                        data: {
                            table: table_name,
                            id_row: id
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success('Xóa thành công');
                                tables.row(row).remove().draw();
                                show_data_qty_plan_check();

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

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

            $(document).on('click', '#close-model', function(e) {
                e.preventDefault();
                $('#modal-created').modal('hide');
                document.getElementById('form_data').reset();
            });
        });
    </script>
@endsection
