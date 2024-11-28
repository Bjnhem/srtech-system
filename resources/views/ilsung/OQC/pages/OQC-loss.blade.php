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
                                {{-- <option value="a"></option> --}}
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
                    <div class="card-body">
                        <div class="row" style="padding: 0 5px;">
                            <div class="col-3 mb-3 bottommargin-sm">
                                <label for="">Date Search</label>
                                <div class="input-daterange component-datepicker input-group">
                                    <input type="text" value="" class="form-control text-start"
                                        id="date_search_detail" placeholder="YYYY-MM-DD" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="shift_search_detail">Shift</label>
                                <select id="shift_search_detail" class="form-select">


                                </select>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="Line_search_detail">Line</label>
                                <select id="Line_search_detail" class="form-select">

                                </select>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="khung_gio_detail">Khung giờ</label>
                                <select id="khung_gio_detail" class="form-select">
                                </select>
                            </div>

                        </div>

                        <table class="table table-bordered table-hover table-sm" id="table-result">
                            <thead class="table-success">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Khung giờ</th>
                                    <th>Prod. qty</th>
                                    <th>Code ID</th>
                                    <th>Trường lỗi</th>
                                    <th>Tên lỗi</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Edit -->
    {{-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Chỉnh sửa dữ liệu</h5>
                    <div> <button type="button" id="save" class="btn btn-success">Save</button> <button
                            type="button" id="update" class="btn btn-success">Update</button> <button type="button"
                            id="close-model" class="btn btn-warning close-model-checklist">Close</button> </div>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_time_slot">Khung giờ</label>
                            <select class="form-control" id="edit_time_slot" name="time_slot">
                                <option value="a">08h-10h</option>
                                <option value="b">10h-12h</option>
                                <option value="c">13h-15h</option>
                                <option value="d">15h-17h</option>
                                <option value="e">18h-20h</option>
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
                            <input type="text" class="form-control" id="edit_error_list_id" name="error_list_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_plan_id">ID kế hoạch</label>
                            <input type="text" class="form-control" id="edit_plan_id" name="plan_id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div> --}}
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
                                            <option value="a">08h-10h</option>
                                            <option value="b">10h-12h</option>
                                            <option value="c">13h-15h</option>
                                            <option value="d">15h-17h</option>
                                            <option value="e">18h-20h</option>
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

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy các ô nhập liệu
            const inputFields = ['a', 'b', 'c', 'd', 'e']; // Các ID của khung giờ
            const prodInput = document.getElementById('prod'); // Ô tổng sản lượng

            // Hàm tính tổng
            function calculateTotal() {
                let total = 0;
                inputFields.forEach(id => {
                    const value = parseInt(document.getElementById(id).value) ||
                        0; // Lấy giá trị hoặc 0 nếu rỗng
                    total += value;
                });
                prodInput.value = total; // Gán tổng vào ô sản lượng
            }

            // Gắn sự kiện 'input' cho từng ô khung giờ
            inputFields.forEach(id => {
                const field = document.getElementById(id);
                field.addEventListener('input', calculateTotal);
            });

            var fileName = 'production_plan_form.xlsx'; // Bạn có thể thay đổi tên file ở đây nếu cần

            // Tạo URL với tham số file_name
            var url = "{{ route('OQC.download.template', ['file_name' => '__FILE_NAME__']) }}";
            url = url.replace('__FILE_NAME__', fileName); // Thay __FILE_NAME__ bằng tên file thực tế

            // Cập nhật href của thẻ a
            document.getElementById('download-template').setAttribute('href', url);
        });
    </script> --}}

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
            $('#date_search,#date_search_detail').val(date);
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#table_name').val(table_name);

            function show_khung_gio(action) {

                var shift_show = $('#shift_search').val();
                var shift_show_detail = $('#shift_search_detail').val();

                // Lựa chọn khung giờ dựa trên giá trị của shift_show
                const khung_gio_data = shift_show === "A" ? khung_A : shift_show === "C" ? khung_C : {};
                const khung_gio_data_detail = shift_show_detail === "A" ? khung_A : shift_show_detail === "C" ?
                    khung_C : {};

                if (action == 'khung_gio') {
                    // Duyệt qua các mục trong khung giờ được chọn và thêm vào dropdown
                    $('#khung_gio').empty();
                    Object.entries(khung_gio_data).forEach(([key, value]) => {
                        $('#khung_gio').append($('<option>', {
                            value: key, // Giá trị của option
                            text: value, // Nội dung hiển thị
                        }));
                    });
                }
                if (action == 'khung_gio_detail') {
                    // Duyệt qua các mục trong khung giờ được chọn và thêm vào dropdown
                    $('#khung_gio_detail').empty().append($('<option>', {
                        value: 'All',
                        text: 'All',
                    }));
                    Object.entries(khung_gio_data_detail).forEach(([key, value]) => {
                        $('#khung_gio_detail').append($('<option>', {
                            value: key, // Giá trị của option
                            text: value, // Nội dung hiển thị
                        }));
                    });
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

                // Gửi yêu cầu AJAX đến controller để lấy dữ liệu
                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.loss.data.plan.search') }}", // Route đã định nghĩa trong Laravel
                    dataType: "json",
                    data: {
                        date: dateInput,
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {
                            // Thêm các option mới vào dropdown shift
                            if (case_action == 'date') {
                                $('#shift_search').empty();
                                if (response.shifts && response.shifts.length > 0) {
                                    $.each(response.shifts, function(index, value) {
                                        $('#shift_search').append($('<option>', {
                                            value: value,
                                            text: value,
                                        }));

                                    });
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
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có lỗi trong quá trình AJAX
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }

            function show_data_check_detail() {
                // Lấy giá trị của các trường nhập liệu
                dateInput = $("#date_search_detail").val();

                // Kiểm tra nếu ngày không được chọn
                if (!dateInput) {
                    toastr.error('Vui lòng chọn ngày!');
                    return;
                }

                // Gửi yêu cầu AJAX đến controller để lấy dữ liệu
                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.loss.data.plan.search') }}", // Route đã định nghĩa trong Laravel
                    dataType: "json",
                    data: {
                        date: dateInput,
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {
                            // Thêm các option mới vào dropdown shift
                            if (case_action_detail == 'date') {
                                $('#shift_search_detail').empty();
                                if (response.shifts && response.shifts.length > 0) {
                                    $.each(response.shifts, function(index, value) {
                                        $('#shift_search_detail').append($('<option>', {
                                            value: value,
                                            text: value,
                                        }));
                                    });
                                    show_khung_gio('khung_gio_detail');
                                }

                                $('#Line_search_detail').empty();
                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search_detail').val();
                                    $.each(response.lines, function(index, value) {
                                        if (value.shift == shift_show) {
                                            $('#Line_search_detail').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));
                                        }

                                    });
                                }
                            }

                            if (case_action_detail == 'shift') {
                                $('#Line_search_detail').empty();
                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search_detail').val();
                                    $.each(response.lines, function(index, value) {
                                        if (value.shift == shift_show)
                                            $('#Line_search_detail').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));
                                    });
                                }
                            }
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
                            console.log(response.prod_qty);
                            console.log(response.NG_qty);
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
                // show_khung_gio();
                // tables.ajax.reload();
            });

            $('#shift_search').on('change', function() {
                case_action = 'shift';
                show_data_check();
                show_khung_gio('khung_gio');
                // tables.ajax.reload();
            });

            $('#Line_search').on('change', function() {
                case_action = 'line';
                show_data_check();
                // show_khung_gio();
                // tables.ajax.reload();
            });

            $('#khung_gio').on('change', function() {
                case_action = 'khung_gio';
                show_data_check();
                // show_khung_gio();
                // tables.ajax.reload();
            });

            // Hành động cho input loss
            $('#category').on('change', function() {
                data_import_action = 'item_loss_name';
                show_data_check();
            });

            $('#category').on('change', function() {
                data_import_action = 'item_loss_name';
                show_data_check();

                // tables.ajax.reload();
            });


            $('#date_search_detail').on('change', function() {
                case_action_detail = 'date';
                show_data_check_detail();
                tables.ajax.reload();
            });

            $('#shift_search_detail').on('change', function() {
                case_action_detail = 'shift';
                show_data_check_detail();
                show_khung_gio('khung_gio_detail');
                tables.ajax.reload();
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
                            tables.ajax.reload(); 
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }


            show_data_check();
            show_data_check_detail();

            tables = $('#table-result').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('OQC.update.show.data.loss.detail') }}",
                    type: "GET",
                    data: function(d) {
                        d.date = $('#date_search_detail').val();
                        d.shift = $('#shift_search_detail').val();
                        d.line = $('#Line_search_detail').val();
                        d.time = $('#khung_gio_detail').val();
                    },
                },
                columns: [{
                        data: 'date', // Ngày
                        name: 'date'
                    },
                    {
                        data: 'time_slot', // Khung giờ
                        name: 'time_slot',
                        render: function(data, type, row) {
                            // Kiểm tra nếu dữ liệu là từ khung A hay khung C và render tương ứng
                            let timeSlotLabel = '';
                            if (khung_A[data]) {
                                timeSlotLabel = khung_A[data];
                            } else if (khung_C[data]) {
                                timeSlotLabel = khung_C[data];
                            }

                            // Trả về giá trị hiển thị và giữ lại `key` dưới dạng data-attribute
                            return '<span class="time-slot" data-time-slot="' + data + '">' +
                                timeSlotLabel + '</span>';
                        }
                    },
                    {
                        data: 'prod_qty', // Prod. qty (lấy từ bảng `plans` hoặc xử lý)
                        name: 'prod_qty'
                    },
                    {
                        data: 'Code_ID', // Code ID (error_list_id từ bảng lỗi)
                        name: 'Code_ID'
                    },
                    {
                        data: 'category', // Trường lỗi (cần join bảng `errors_list` để lấy tên trường lỗi)
                        name: 'category'
                    },
                    {
                        data: 'name', // Tên lỗi (cần join bảng `errors_list` để lấy tên lỗi)
                        name: 'name'
                    },
                    {
                        data: 'remark', // Remark
                        name: 'remark'
                    },
                    {
                        data: 'id', // Hành động
                        render: function(data) {
                            var editButton = '<button type="button" value="' + data +
                                '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleteButton = '<button type="button" value="' + data +
                                '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                            return deleteButton;
                        }
                    }
                ],
                pageLength: 10,
                ordering: false,
                searching: true,
                lengthChange: true,
                info: false,
                autoWidth: false,
                select: {
                    style: 'single'
                }
            });


            // show_model_check();

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                $('#save').show(); // Ẩn nút Save
                $('#update').hide();
                $('#modal-created').modal('show');
                id = "";
            });

            $(document).on('click', '#save_loss', function(e) {
                e.preventDefault();
                id = '';
                save_update_data();
            });



            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                document.getElementById('form_data').submit();
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
