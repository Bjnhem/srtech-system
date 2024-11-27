@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
    <div class="card table-responsive" style="border: none">
        <div class="card-header">
            <button type="button" id="Home" class="btn btn-success"
                onclick="window.location='{{ route('WareHouse.update.master') }}'"><span class="icon-home"></span></button>
            <button type="button" id="creat" class="btn btn-primary" data-toggle="modal"
                data-target="#addLossModal">Add</button>
        </div>
        <div class="card-body">
            <!-- Filter Form -->
            <div class="row">
                <div class="col-sm-6 col-xl-4 mb-3 bottommargin-sm">
                    <label for="date_search">Date Search</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" class="form-control text-start" id="date_search" placeholder="YYYY-MM-DD"
                            autocomplete="off">
                    </div>
                </div>
                <div class="col-sm-6 col-xl-4 mb-3">
                    <label for="shift_search">Shift</label>
                    <select name="shift" id="shift_search" class="form-select">
                        <option value="All">All</option>
                        <option value="A">Ca ngày</option>
                        <option value="C">Ca đêm</option>
                    </select>
                </div>
                <div class="col-sm-6 col-xl-4 mb-3">
                    <label for="Line_search">Line</label>
                    <select name="Line" id="Line_search" class="form-select">
                        <option value="All">All</option>
                        <option value="Line 1">Line 1</option>
                        <option value="Line 2">Line 2</option>
                        <option value="Line 3">Line 3</option>
                        <!-- Thêm các Line khác nếu cần -->
                        <option value="Line 16">Line 16</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
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
                <tbody id="table-body">
                    <!-- Dữ liệu sẽ được hiển thị ở đây -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for adding Loss -->
    <div class="modal fade" id="addLossModal" tabindex="-1" role="dialog" aria-labelledby="addLossModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLossModalLabel">Add Loss Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Loss input form -->
                    <form id="lossForm">
                        <div class="row">
                            <div class="col-6">
                                <label for="code_id">Code ID</label>
                                <input type="text" class="form-control" id="code_id" name="code_id" required>
                            </div>
                            <div class="col-6">
                                <label for="error_type">Loại lỗi</label>
                                <input type="text" class="form-control" id="error_type" name="error_type" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="error_name">Tên lỗi</label>
                                <input type="text" class="form-control" id="error_name" name="error_name" required>
                            </div>
                            <div class="col-6">
                                <label for="quantity">Số lượng</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                    required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <label for="remark">Remark</label>
                                <textarea class="form-control" id="remark" name="remark"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <!-- Javascript -->
    <script>
        // When the form is submitted
        $('#lossForm').submit(function(e) {
            e.preventDefault();

            // Collect data from form
            let formData = {
                code_id: $('#code_id').val(),
                error_type: $('#error_type').val(),
                error_name: $('#error_name').val(),
                quantity: $('#quantity').val(),
                remark: $('#remark').val(),
            };

            // Insert data into the table
            let row = `<tr>
                <td>${$('#date_search').val()}</td>
                <td>${$('#shift_search').val()}</td>
                <td>${$('#Line_search').val()}</td>
                <td>Model Data</td>
                <td>Total Data</td>
                <td>${formData.quantity}</td>
                <td>${formData.remark}</td>
                <td>
                    <button class="btn btn-info btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>`;

            // Append the new row to the table
            $('#table-body').append(row);

            // Close the modal
            $('#addLossModal').modal('hide');

            // Reset form fields
            $('#lossForm')[0].reset();
        });
    </script>
    {{-- <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
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

            $('#table_name').val(table_name);
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_search,#date').val(date);
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

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


            $('#date_search, #shift_search, #Line_search').on('change', function() {
                tables.ajax.reload();
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

            function show_model_check() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('check.list.masster') }}",
                    dataType: "json",
                    success: function(response) {

                        $('#Model').empty();
                        $('#Model').append($('<option>', {
                            value: "",
                            text: "All",
                        }));
                        $('#Model_search').append($('<option>', {
                            value: "",
                            text: "All",
                        }));

                        $.each(response.model, function(index, value) {
                            $('#Model').append($('<option>', {
                                value: value.id,
                                text: value.model,
                            }));

                            $('#Model_search').append($('<option>', {
                                value: value.id,
                                text: value.model,
                            }));
                        });

                    }
                });


            }

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
    </script> --}}
@endsection
