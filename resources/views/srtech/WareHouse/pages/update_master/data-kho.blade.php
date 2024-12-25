@extends('srtech.WareHouse.layouts.WareHouse_layout')

@section('content')
    <div class="card form-card">
        <div class="card-header">
            <h3 class="header-title">Danh sách kho</h3>
        </div>
        <div class="card-body">
            <div class="row content-top">
                <div class="col-4">
                    <div class="master-plan">
                        <h4 class="section-title" id="title-add">Thêm kho mới</h4>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" id="download-template"
                                    class="btn btn-primary">
                                    <i class="icon-download"></i> Tải file mẫu
                                </a>
                            </div>
                            <div class="col-12 mt-4">
                                <form action="{{ route('warehouse.update.kho') }}" method="post" id="form-upload"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input class="form-control" type="file" name="excel_file" accept=".xlsx, .xls"
                                            id="file-upload">
                                        <button class="btn btn-success" type="submit">
                                            <i class="icon-line-upload"></i> Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mt-5">
                                <form action="" method="post" id="form_data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-12 col-xl-12 mb-4">
                                            <span>Tên kho:</span>
                                            <input name="name" type="text" id="name" class="form-control"
                                                placeholder="Nhập tên kho...">
                                        </div>
                                        <div class="col-sm-12 col-xl-12 mb-4">
                                            <span>Location:</span>
                                            <input name="location" type="text" id="location" class="form-control"
                                                placeholder="Nhập vị trí...">
                                        </div>
                                        <div class="col-12 mb-4">
                                            <span>Phân loại:</span>
                                            <select name="status" id="status" class="form-select">
                                                <option value="IN">Nội bộ</option>
                                                <option value="OUT">Bên ngoài</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-xl-12" id="button-save">
                                            <button type="button" id="close-model"
                                                class="btn btn-warning close-model-checklist">Reset</button>
                                            <button type="button" id="save" class="btn btn-success">Save</button>
                                            <button type="button" id="update" class="btn btn-primary">Update</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="data-loi-input">
                        <h4 class="section-title">Danh sách kho</h4>
                        <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                            <thead class="table-success">
                                <tr>
                                    <th>STT</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Phân loại</th>
                                    <th>Edit</th>
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
    <script src="{{ asset('SR-TECH/js/exceljs.min.js') }}"></script>>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var fileName = 'warehouse_format_form.xlsx'; // Bạn có thể thay đổi tên file ở đây nếu cần
            // Tạo URL với tham số file_name
            var url = "{{ route('warehouse.download.template', ['file_name' => '__FILE_NAME__']) }}";
            url = url.replace('__FILE_NAME__', fileName); // Thay __FILE_NAME__ bằng tên file thực tế
            // Cập nhật href của thẻ a
            document.getElementById('download-template').setAttribute('href', url);
        });
    </script>
    <script>
        $(document).ready(function() {
            var table_name = 'Warehouse';
            var table = '#table-result';
            let title_add = "Add new Kho";
            let title_edit = "Edit Kho";
            var tables;
            let id;
            var rowSelected;
            $('#update').hide();

            show_data_table(table_name);

            function show_data_table(tab) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('Warehouse.update.show.data') }}",
                    dataType: "json",
                    data: {
                        table: tab,
                    },
                    success: function(response) {
                        var data = [];
                        var count = 0;
                        // console.log(response.data);
                        $.each(response.data, function(index, value) {
                            count++;
                            id = value.id;

                            var edit1 = '<a href="#" value="' + id +
                                '" id="edit" class="text-success mx-1 editIcon"><i class="bi-pencil-square h4"  style="font-size:1.5rem; color: #06b545;"></i></a>';
                            var deleted1 = '<a href="#" value="' + id +
                                '" id="delete"class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"  style="font-size:1.5rem; color: #ff0000;"></i></a>';


                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-success editbtn btn-sm" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete"><span class="icon-trash1"></span></button>';

                            data.push([
                                count,
                                value.name,
                                value.location,
                                value.status,
                                edit1 + deleted1,
                            ]);

                        });

                        if (tables) {
                            tables.clear();
                            tables.rows.add(data).draw();
                        } else {
                            tables = $(table).DataTable({
                                data: data,
                                "searching": true,
                                "autoWidth": false,
                                "paging": true,
                                "ordering": false,
                                "info": false,
                                select: {
                                    style: 'single',
                                },
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    text: 'Tải Excel',
                                    title: 'Danh sách kho',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                }],
                            });
                        }




                    }
                });
            }

            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                if (data.get('name') == "" || data.get('location') == "") {
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

                            toastr.success(response.success);
                            show_data_table(table_name);
                            $('#save').show(); // Ẩn nút Save
                            $('#update').hide();
                            document.getElementById('form_data').reset();
                            $('#title-add').text(title_add);
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }
            }


            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                save_update_data();
            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                $('#title-add').text(title_edit);
                $('#save').hide(); // Ẩn nút Save
                $('#update').show();
                id = $(this).attr('value');
                console.log(id);


                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];
                }
                var rowData = tables.row(rowSelected).data();
                $('#name').val(rowData[1]);
                $('#location').val(rowData[2]);
                $('#status').val(rowData[3]);
            });


            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                save_update_data();
            });


            $(document).on('click', '#delete', function() {
                const id = $(this).attr('value'); // Lấy ID của checklist từ nút

                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('Warehouse.update.delete.data') }}",
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
                document.getElementById('form_data').reset();
                $('#save').show(); // Ẩn nút Save
                $('#update').hide();
                $('#title-add').text(title_add);
            });

        });
    </script>
@endsection
