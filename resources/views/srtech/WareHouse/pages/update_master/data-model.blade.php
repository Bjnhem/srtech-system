@extends('srtech.WareHouse.layouts.WareHouse_layout')

@section('content')
    <div class="tab-content mt-4" id="nav-tabContent">
        {{-- =====  Hoạt động nổi bật ===== --}}

        <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
            <div class="card table-responsive" style="border: none">
                <div class="card-header">
                    <button type="button" id="Home" class="btn btn-success"
                        onclick="window.location='{{ route('WareHouse.update.master') }}'"><span class="icon-home"></span></button>
                    <button type="button" id="creat" class="btn btn-primary">Add</button>
                </div>
                <div class="card-body ">
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        {{-- <thead class="table-success"></thead> --}}
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



    <div class="modal" id="modal-created">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <!-- Tiêu đề bên trái -->
                    <h5 class="text-primary mx-3" id="title_modal_data">

                    </h5>
                    <div>
                        <button type="button" id="save" class="btn btn-success">Save</button>
                        <button type="button" id="update" class="btn btn-success">Update</button>
                        <button type="button" id="close-model" class="btn btn-warning close-model-checklist">Close</button>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <form action="" method="post" id="form_data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Model:</span>
                                <input name="model" type="text" id="model" class="form-control"
                                    placeholder="Nhập model...">
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Model name:</span>
                                <input name="Name" type="text" id="Name" class="form-control"
                                    placeholder="Nhập model name...">
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-3">
                                <span>Status:</span>
                                <select name="Status" id="Status" class="form-select">
                                    <option value="Use">Use</option>
                                    <option value="Not Use">Not Use</option>
                                </select>
                            </div>

                        </div>
                    </form>

                    <br>

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

            // data_table_view(table);
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

            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                const button1 = document.getElementById('save');
                button1.style.display = 'unset'; // Ẩn button
                const button2 = document.getElementById('update');
                button2.style.display = 'none'; // Ẩn button
                $('#modal-created').modal('show');
            });
            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', "");
                if (data.get('model') == "" || data.get('Name') == "") {
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
                                toastr.danger('Có lỗi khi add - vui lòng thực hiện lại');
                            }
                            toastr.success('Add model thành công');
                            show_data_table(table_name);
                            $('#modal-created').modal('hide');
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }



            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_edit);
                const button1 = document.getElementById('save');
                button1.style.display = 'none'; // Ẩn button
                const button2 = document.getElementById('update');
                button2.style.display = 'unset'; // Ẩn button
                id = $(this).val();

                rowSelected = tables.rows('.selected').indexes();
                // console.log(rowSelected[1]);
                if (rowSelected.length > 0) {
                    var rowData = tables.row(rowSelected[0]).data();
                    // Lấy dữ liệu của dòng đầu tiên được chọn
                    // console.log(rowData[1]);
                    $('#model').val(rowData[1]);
                    $('#Name').val(rowData[2]);
                    $('#Status').val(rowData[3]);
                }
                $('#modal-created').modal('show');
            });

            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                const data = new FormData(document.getElementById('form_data'));
                data.append('table', table_name);
                data.append('id', id);
                console.log(id);
                if (data.get('model') == "" || data.get('Name') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('update.add.data') }}",
                        dataType: 'json',
                        data: data,
                        processData: false, // Không xử lý dữ liệu (FormData tự xử lý)
                        contentType: false,
                        success: function(response) {
                            if (response.status === 400) {
                                toastr.danger('Có lỗi khi add - vui lòng thực hiện lại');
                            }
                            toastr.success('Update thành công');
                            show_data_table(table_name);
                            $('#modal-created').modal('hide');
                            document.getElementById('form_data').reset();
                        },
                        error: function() {
                            toastr.success('Có lỗi - vui lòng thực hiện lại');
                        }
                    });
                }



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
