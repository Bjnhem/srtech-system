@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
    <div class="card table-responsive card-loss" style="border: none;">
        <div class="card-header">
            <h3 class="header-title">Quản lý lỗi OQC Final</h3>
            {{-- <h3 class="header-title">Quản Lý Kho</h3> --}}
        </div>
        <div class="card-body">
            <!-- Master Plan & Data Input -->
            <div class="row content-top">
                <!-- Master Plan Section -->
                <div class="col-lg-6 master-plan">
                    <h4 class="section-title">Master Plan</h4>
                    <div class="row">
                        <div class="col-12 mb-3 bottommargin-sm">
                            <label for="">Date Search</label>
                            <div class="input-daterange component-datepicker input-group">
                                <input type="text" value="" class="form-control text-start" id="date_search"
                                    placeholder="YYYY-MM-DD" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="shift_search">Shift</label>
                            <select id="shift_search" class="form-select">
                                <option value="A">Ca ngày</option>
                                <option value="C">Ca đêm</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="Line_search">Line</label>
                            <select id="Line_search" class="form-select">
                                <option value="All">All</option>
                                <option value="Line 1">Line 1</option>
                                <option value="Line 2">Line 2</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="khung_gio">Khung giờ</label>
                            <select id="khung_gio" class="form-select">
                                {{-- <option value="All">All</option> --}}
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" readonly>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="prod_qty">Prod. Qty</label>
                            <input type="text" class="form-control" id="prod_qty" readonly>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="ng_qty">NG Qty</label>
                            <input type="text" class="form-control" id="ng_qty" readonly>
                        </div>
                    </div>
                </div>

                <!-- Data Lỗi Input Section -->
                <div class="col-lg-6 data-loi-input">
                    <h4 class="section-title">Data Lỗi Input</h4>
                    <form id="lossForm">
                        <div class="row">
                            <input type="hidden" id="quantity" name="quantity" value="1" required>
                            <div class="col-6 mb-3">
                                <label for="code_id">Code ID</label>
                                <input type="text" id="code_id" name="code_id" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="category">Loại lỗi</label>
                                <select id="category" name="category" class="form-select" required>
                                    <option value="NG tape">NG tape</option>
                                    <option value="NG soldering">NG soldering</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="error_name">Tên lỗi</label>
                                <select id="error_name" name="error_name" class="form-select" required>
                                    <option value="Thiếu Tape BIT">Thiếu Tape BIT</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="remark">Remark</label>
                                <input type="text" id="remark" name="remark" class="form-control">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Inputs Loss Detail -->
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-sm mt-3" id="table-result">
                        <thead class="table-success">
                            <tr>
                                <th>Ngày</th>
                                {{-- <th>Shift</th>
                            <th>Line</th>
                            <th>Model</th> --}}
                                <th>Khung_gio</th>
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
            var table_name = 'Plan';
            var table = '#table-result';
            let title_add = "Add plan";
            let title_edit = "Edit plan";
            var tables;
            let id;

            let dateInput;
            let shiftSelect;
            let lineSelect;
            let modelSelect;
            let prodQtyInput;
            let timeSelect;

            
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_search').val(date);
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#table_name').val(table_name);

            // tables = $('#table-result').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     ajax: {
            //         url: "{{ route('OQC.update.show.data.plan') }}",
            //         type: "GET",
            //         data: function(d) {
            //             d.Date = $('#date_search').val();
            //             d.Shift = $('#shift_search').val();
            //             d.Line = $('#Line_search').val();
            //         },


            //     },
            //     columns: [{
            //             data: 'date',
            //             name: 'date'
            //         },
            //         {
            //             data: 'shift',
            //             name: 'shift'
            //         },
            //         {
            //             data: 'line',
            //             name: 'line'
            //         },
            //         {
            //             data: 'model',
            //             name: 'model'
            //         },
            //         {
            //             data: 'prod',
            //             name: 'prod'
            //         },
            //         {
            //             data: 'a',
            //             name: 'a'
            //         },
            //         {
            //             data: 'b',
            //             name: 'b'
            //         },
            //         {
            //             data: 'c',
            //             name: 'c'
            //         },
            //         {
            //             data: 'd',
            //             name: 'd'
            //         },
            //         {
            //             data: 'e',
            //             name: 'e'
            //         },
            //         {
            //             data: 'id',
            //             render: function(data) {
            //                 var editButton = '<button type="button" value="' + data +
            //                     '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
            //                 var deleteButton = '<button type="button" value="' + data +
            //                     '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
            //                 return editButton + deleteButton;
            //             }
            //         }
            //     ],
            //     pageLength: 10,
            //     ordering: false,
            //     searching: true,
            //     lengthChange: true,
            //     info: false,
            //     autoWidth: false,
            //     select: {
            //         style: 'single'
            //     }
            // });


            $('#date_search, #shift_search, #line_search').on('change', function() {
                show_data_check();
                // tables.ajax.reload();
            });


            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                console.log(id);
                if (data.get('Machine') == "" || data.get('Status') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('Warehouse.update.add.data') }}",
                        dataType: 'json',
                        data: data,
                        processData: false, // Không xử lý dữ liệu (FormData tự xử lý)
                        contentType: false,
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Có lỗi - vui lòng thực hiện lại');
                            }
                            toastr.success('Thành công');
                            show_data_table(table_name);
                            $('#modal-created').modal('hide');
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }

            function show_data_check() {
                // Lấy giá trị của các trường nhập liệu
                dateInput = $("#date_search").val();
                shiftSelect = $("#shift_search").val();
                lineSelect = $("#line_search").val();
                console.log(dateInput);
                console.log(shiftSelect);
                console.log(lineSelect);

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
                        shift: shiftSelect,
                        line: lineSelect,
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {
                            // Xóa các option cũ trong dropdown
                            $('#shift_search,#line_search,#model_search').empty();

                            // Thêm các option mới vào dropdown shift
                            if (response.shifts && response.shifts.length > 0) {
                                $.each(response.shifts, function(index, value) {
                                    $('#shift_search').append($('<option>', {
                                        value: value.shift,
                                        text: value.shift,
                                    }));
                                });
                            }

                            // Thêm các option mới vào dropdown line
                            if (response.lines && response.lines.length > 0) {
                                $.each(response.lines, function(index, value) {
                                    $('#line_search').append($('<option>', {
                                        value: value.line,
                                        text: value.line,
                                    }));
                                });
                            }

                            // Thêm các option mới vào dropdown model
                            if (response.models && response.models.length > 0) {
                                $.each(response.models, function(index, value) {
                                    $('#model_search').append($('<option>', {
                                        value: value.id,
                                        text: value.model,
                                    }));
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có lỗi trong quá trình AJAX
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }

            show_data_check();
            // show_model_check();

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                $('#save').show(); // Ẩn nút Save
                $('#update').hide();
                $('#modal-created').modal('show');
                id = "";
            });

            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                document.getElementById('form_data').submit();
                // save_update_data();
            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();

                $('#title_modal_data').text('Chỉnh sửa Kế Hoạch Sản Xuất');
                $('#save').hide(); // Ẩn nút Save
                $('#update').show(); // Hiển thị nút Update

                id = $(this).val();
                let rowData = tables.rows().data().toArray().find(row => row.id == id);

                if (rowData) {
                    $('#id').val(rowData.id); // ID ẩn
                    $('#date').val(rowData.date); // Ngày
                    $('#shift').val(rowData.shift); // Ca làm việc
                    $('#line').val(rowData.line); // Line sản xuất
                    $('#model').val(rowData.model); // Model sản phẩm
                    $('#prod').val(rowData.prod); // Sản lượng
                    $('#a').val(rowData.a); // Khung A
                    $('#b').val(rowData.b); // Khung B
                    $('#c').val(rowData.c); // Khung C
                    $('#d').val(rowData.d); // Khung D
                    $('#e').val(rowData.e); // Khung E
                }

                $('#modal-created').modal('show');
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
                        url: "{{ route('OQC.update.delete.data') }}",
                        data: {
                            table: table_name,
                            id_row: id
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success('Xóa thành công');
                                tables.row(row).remove().draw();

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
