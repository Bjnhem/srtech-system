@extends('srtech.WareHouse.layouts.WareHouse_layout')

@section('content')
    <div class="card" style="border: none;">
        <div class="card-header">
            <h3 class="header-title">Danh sách Model</h3>
        </div>
        <div class="card-body">
            <div class="row content-top">
                <div class="col-4 master-plan">
                    <h4 class="section-title" id="title-add">Thêm Model</h4>
                    <div class="row">

                        <div class="col-12 mt-5">
                            <form action="" method="post" id="form_data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label>Model:</label>
                                        <input name="model" type="text" id="model" class="form-control"
                                            placeholder="Nhập model...">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Model name:</label>
                                        <input name="Name" type="text" id="Name" class="form-control"
                                            placeholder="Nhập model name...">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Status:</label>
                                        <select name="Status" id="Status" class="form-select">
                                            <option value="Use">Use</option>
                                            <option value="Not Use">Not Use</option>
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

                <div class="col-8 data-loi-input">
                    <h4 class="section-title">Danh sách model</h4>
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success">
                            <tr>
                                <th>STT</th>
                                <th>Model</th>
                                <th>Model Name</th>
                                <th>Tình trạng</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('SR-TECH/js/exceljs.min.js') }}"></script>>
    <script>
        $(document).ready(function() {
            var table_name = 'Model_master';
            var table = '#table-result';
            var tables;
            let id;
            let title_add = "Add new Model";
            let title_edit = "Edit Model";
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
                        $.each(response.data, function(index, value) {
                            count++;
                            id = value.id;

                            var view = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#modal-show" class="btn btn-primary editbtn btn-sm" id="view"><span class="icon-eye2"></span></button>';

                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-success editbtn btn-sm" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete"><span class="icon-trash1"></span></button>';

                            data.push([
                                count,
                                value.model,
                                value.Name,
                                value.Status,
                                edit + deleted,
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
                            });
                        }




                    }
                });
            }

            function save_update_data() {
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                if (data.get('Name') == "" || data.get('model') == "") {
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

                id = $(this).val();
                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];
                }
                var rowData = tables.row(rowSelected).data();
                $('#model').val(rowData[1]);
                $('#Name').val(rowData[2]);
                $('#Status').val(rowData[3]);
            });

            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                save_update_data();
            });


            $(document).on('click', '#delete', function() {
                const id = $(this).val(); // Lấy ID của checklist từ nút

                const row = $(this).closest('tr'); // Lưu tham chiếu đến dòng chứa nút
                if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('update.delete.data') }}",
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
