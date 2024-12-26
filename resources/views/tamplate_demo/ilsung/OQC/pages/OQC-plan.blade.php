@extends('ilsung.OQC.layouts.OQC_layout')

@section('content')
    <div class="card table-responsive" style="border: none">
        <div class="card-header">
            <h3 class="header-title">Quản lý Plan</h3>

        </div>
        <div class="card-body ">
            <div class="button-action mb-4">
                <button type="button" id="Home" class="btn btn-success"
                    onclick="window.location='{{ route('WareHouse.update.master') }}'"><span
                        class="icon-home"></span></button>
                <button type="button" id="creat" class="btn btn-primary">Add</button>
            </div>

            <div class="row">
                <div class=" col-sm-6 col-xl-4 mb-3 bottommargin-sm">
                    <label for="">Date Search</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" value="" class="form-control text-start" id="date_search"
                            placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4 mb-3">
                    <span>Shift:</span>
                    <select name="shift" id="shift_search" class="form-select">
                        <option value="All">All</option>
                        <option value="A">Ca ngày</option>
                        <option value="C">Ca đêm</option>

                    </select>
                </div>
                <div class="col-sm-6 col-xl-4 mb-3"> <span>Line:</span> <select name="Line" id="Line_search"
                        class="form-select">
                                          </select> </div>
            </div>
            <div class="table-response">
                <table class="table table-bordered table-hover table-sm" id="table-result" style="width:100%">
                    <thead class="table-success">

                        <tr>
                            <th rowspan="2">Ngày</th>
                            <th rowspan="2">Shift</th>
                            <th rowspan="2">Line</th>
                            <th rowspan="2">Model</th>
                            <th colspan="6">Khung giờ</th>
                            <th rowspan="2">Hành động</th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th>Khung A</th>
                            <th>Khung B</th>
                            <th>Khung C</th>
                            <th>Khung D</th>
                            <th>Khung E</th>
                        </tr>
                    </thead>
                </table>
            </div>



        </div>
    </div>


    <div class="modal" id="modal-created">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="text-primary mx-3" id="title_modal_data">Thêm Kế Hoạch Sản Xuất</h5>
                    <div> <button type="button" id="save" class="btn btn-success">Save</button> <button type="button"
                            id="update" class="btn btn-success">Update</button> <button type="button" id="close-model"
                            class="btn btn-warning close-model-checklist">Close</button> </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <div class="card">
                        <div class="card-header">
                            <div class="row" style="display: contents;">
                                <!-- Phần tải file Excel mẫu -->
                                <div class="col-md-3">
                                    <a href="#" id="download-template" class="btn btn-primary">
                                        <i class="icon-download"></i> Tải file mẫu
                                    </a>
                                </div>
                                <!-- Phần Thêm kế hoạch bằng File -->
                                <div class="col-md-9">
                                    <form action="{{ route('OQC.table.update.data') }}" method="post" id="form-upload"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input type="hidden" name="id" id="table_name" value="">
                                            <input class="form-control" type="file" name="excel_file"
                                                accept=".xlsx, .xls" id="file-upload">
                                            <button class="btn btn-success" type="submit">
                                                <i class="icon-line-upload"></i>
                                                <span class="hidden-xs">Upload</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12"> <!-- Phần Thêm kế hoạch bằng Form -->
                                <form action="{{ route('plan.save') }}" method="post" id="form_data"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">
                                        <!-- Ngày -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Ngày:</span>
                                            <input name="date" type="text" id="date"
                                                class="form-control datepicker" placeholder="YYYY-MM-DD"
                                                autocomplete="off">
                                        </div>
                                        <!-- Ca làm việc -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Ca làm việc:</span>
                                            <select name="shift" id="shift" class="form-select">
                                                <option value="A">A</option>
                                                <option value="C">C</option>
                                            </select>
                                        </div>
                                        <!-- Line sản xuất -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Line:</span>
                                            <select name="line" id="line" class="form-select">

                                            </select>
                                        </div>
                                        <!-- Model sản phẩm -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Model:</span>
                                            <select name="model" id="model" class="form-select">

                                            </select>
                                            {{-- <input name="model" type="text" id="model" class="form-control"
                                                placeholder="Model sản phẩm..."> --}}
                                        </div>
                                        <!-- Số lượng sản phẩm -->
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Total plan:</span>
                                            <input name="prod" type="number" id="prod" class="form-control"
                                                placeholder="Total..." min="0" value="" readonly>
                                        </div>
                                        <!-- Các khung giờ -->
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Khung A:</span>
                                            <input name="a" type="number" id="a" class="form-control"
                                                placeholder="Khung A..." min="0" value="">
                                        </div>
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Khung B:</span>
                                            <input name="b" type="number" id="b" class="form-control"
                                                placeholder="Khung B..." min="0" value="">
                                        </div>
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Khung C:</span>
                                            <input name="c" type="number" id="c" class="form-control"
                                                placeholder="Khung C..." min="0" value="">
                                        </div>
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Khung D:</span>
                                            <input name="d" type="number" id="d" class="form-control"
                                                placeholder="Khung D..." min="0" value="">
                                        </div>
                                        <div class="col-sm-6 col-xl-2 mb-3">
                                            <span>Khung E:</span>
                                            <input name="e" type="number" id="e" class="form-control"
                                                placeholder="Khung E..." min="0" value="">
                                        </div>
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
    </script>
    <script>
        $(document).ready(function() {
            var table_name = 'Plan';
            var table = '#table-result';
            let title_add = "Add plan";
            let title_edit = "Edit plan";
            var tables;
            let id;
            let case_action = 'date';

            $('#table_name').val(table_name);
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_search,#date').val(date);
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            tables = $('#table-result').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('OQC.update.show.data.plan') }}",
                    type: "GET",
                    data: function(d) {
                        d.Date = $('#date_search').val();
                        d.Shift = $('#shift_search').val();
                        d.Line = $('#Line_search').val();
                    },


                },
                columns: [{
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'shift',
                        name: 'shift'
                    },
                    {
                        data: 'line',
                        name: 'line'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'prod',
                        name: 'prod'
                    },
                    {
                        data: 'a',
                        name: 'a'
                    },
                    {
                        data: 'b',
                        name: 'b'
                    },
                    {
                        data: 'c',
                        name: 'c'
                    },
                    {
                        data: 'd',
                        name: 'd'
                    },
                    {
                        data: 'e',
                        name: 'e'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            var editButton = '<button type="button" value="' + data +
                                '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleteButton = '<button type="button" value="' + data +
                                '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                            return editButton + deleteButton;
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

            function show_data_table() {
                var date = $('#date_search').val();
                var shift = $('#shift_search').val();
                var line = $('#Line_search').val();
                console.log(date);
                console.log(shift);
                console.log(line);
                $.ajax({
                    url: "{{ route('OQC.update.show.data.loss.detail2') }}",
                    type: "GET",
                    dataType: 'json',
                    data: {
                        date: date,
                        shift: shift,
                        line: line,
                    },

                    success: function(response) {
                        var data = [];
                        console.log(response.data)
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



            $('#date_search').on('change', function() {
                case_action = 'date';
                show_data_check();
                // tables.ajax.reload();
            });

            $('#shift_search').on('change', function() {
                case_action = 'shift';
                show_data_check();
                // tables.ajax.reload();
            });

            $('#Line_search').on('change', function() {
                tables.ajax.reload();
            });


            function show_data_check() {
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
                        date: dateInput
                    },
                    success: function(response) {
                        // Kiểm tra phản hồi từ server
                        if (response.status == '400') {
                            toastr.error(response.messcess); // Hiển thị lỗi nếu có
                        } else {

                            // Thêm các option mới vào dropdown shift
                            if (case_action == 'date') {

                                $('#shift_search').empty().append($('<option>', {
                                    value: 'All',
                                    text: 'All',
                                }));
                                if (response.shifts && response.shifts.length > 0) {
                                    $.each(response.shifts, function(index, value) {
                                        $('#shift_search').append($('<option>', {
                                            value: value,
                                            text: value,
                                        }));

                                    });
                                }
                                $('#Line_search').empty().append($('<option>', {
                                    value: 'All',
                                    text: 'All',
                                }));

                                $('#line,#model').empty();

                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    $.each(response.lines, function(index, value) {
                                        if (shift_show != 'All') {
                                            if (value.shift == shift_show) {
                                                $('#Line_search').append($('<option>', {
                                                    value: value.line,
                                                    text: value.line,
                                                }));
                                            }

                                        } else {
                                            $('#Line_search,#line').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));


                                        }


                                    });
                                }

                                if (response.models && response.models.length > 0) {
                                    $.each(response.models, function(index, value) {
                                        $('#model').append($('<option>', {
                                            value: value.model,
                                            text: value.model,
                                        }));

                                    });
                                }



                            }
                            if (case_action == 'shift') {

                                $('#Line_search').empty().append($('<option>', {
                                    value: 'All',
                                    text: 'All',
                                }));
                                // Thêm các option mới vào dropdown line
                                if (response.lines && response.lines.length > 0) {
                                    var shift_show = $('#shift_search').val();
                                    $.each(response.lines, function(index, value) {
                                        if (shift_show != 'All') {
                                            if (value.shift == shift_show) {
                                                $('#Line_search').append($('<option>', {
                                                    value: value.line,
                                                    text: value.line,
                                                }));
                                            }
                                        } else {
                                            $('#Line_search').append($('<option>', {
                                                value: value.line,
                                                text: value.line,
                                            }));

                                        }


                                    });
                                }
                            }
                            tables.ajax.reload();

                            // show_data_qty_plan_check();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có lỗi trong quá trình AJAX
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại!');
                    }
                });
            }

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

            function show_model_check() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('OQC.table.update.data.show') }}",
                    dataType: "json",
                    success: function(response) {

                        $('#model').empty();
                        $.each(response.model, function(index, value) {
                            $('#model').append($('<option>', {
                                value: value.model,
                                text: value.model,
                            }));

                        });

                        // $.each(response.line, function(index, value) {
                        //     $('#line').append($('<option>', {
                        //         value: value.line_name,
                        //         text: value.line_name,
                        //     }));

                        // });


                    }
                });


            }

            // show_model_check();
            show_data_check();

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
                console.log(rowData);
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
