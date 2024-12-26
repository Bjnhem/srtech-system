@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="card" style="border: none;">
        <div class="card-header">
            <h3 class="header-title">Danh sách kho</h3>
        </div>
        <div class="card-body">
            <!-- Master Plan & Data Input -->
            <div class="row content-top">
                <!-- Master Plan Section -->
                <div class="col-4 master-plan">
                    <h4 class="section-title" id="title-add">Thêm User</h4>
                    <div class="row">
                        <div class="col-12">
                            <form action="" method="post" id="form_data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span for="username" class="form-label">Tên đăng nhập</span>
                                            <input id="username" type="text" name="username" value=""
                                                class="form-control" placeholder="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span for="part" class="form-label">Bộ phận</span>
                                            <input id="part" type="text" name="part" value=""
                                                class="form-control" placeholder="" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12 form-edit">
                                        <div class="form-group">
                                            <span for="user_type" class="form-label">Phân quyền</span>
                                            <select name="user_type" id="user_type" class="form-select">
                                                <option value="user">User</option>
                                                <option value="admin">Admin</option>
                                                <option value="leader">Leader</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12 form-edit">
                                        <div class="form-group ">
                                            <span for="status" class="form-label">Trạng thái</span>
                                            <select name="status" id="status" class="form-select">
                                                <option value="active">Active</option>
                                                <option value="pending">Pending</option>
                                                <option value="Not_user">Not User</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <span for="password" class="form-label">Password</span>
                                            <input class="form-control" type="password" placeholder=" " id="password"
                                                name="password" required autocomplete="new-password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <span for="confirm-password" class="form-label">Confirm Password</span>
                                            <input id="password_confirmation" class="form-control" type="password"
                                                placeholder=" " name="password_confirmation" required>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-xl-12" id="button-save">
                                        <button type="button" id="close-model"
                                            class="btn btn-warning close-model-checklist">Reset</button>
                                        <button type="button" id="save" class="btn btn-success">Đăng ký</button>
                                        <button type="button" id="update" class="btn btn-primary">Update</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-8 data-loi-input">
                    <h4 class="section-title">Danh sách User</h4>
                    <div class="table-responsive">
                        <table class="table text-center table-striped w-100" id="table-result">
                            <thead>
                                <tr style="text-align: center">
                                    <th title="id">id</th>
                                    <th title="username">User</th>
                                    <th title="part">Part</th>
                                    <th title="user_type">Phân quyền</th>
                                    <th title="Status">Status</th>
                                    <th title="Action" width="60">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="table-responsive">
        <table class="table text-center table-striped w-100" id="dataTable">
            <thead>
                <tr style="text-align: center">
                    <th title="id">id</th>
                    <th title="FULL NAME">FULL NAME</th>
                    <th title="Email">Email</th>
                    <th title="Status">Status</th>
                    <th title="Action" width="60">Action</th>
                </tr>
            </thead>

        </table>
    </div> --}}
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            var table_name = 'User';
            var table = '#table-result';
            var tables;
            let id;
            let title_add = "Add User";
            let title_edit = "Edit User";
            $('#update').hide();
            show_data_table(table_name);

            function show_data_table(tab) {

                $.ajax({
                    type: "GET",
                    url: "{{ route('User.update.show.data') }}",
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
                            var edit = '<button type="button" value="' + id +
                                '"class="btn btn-success editbtn btn-sm" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleted = '<button type="button" value="' + id +
                                '" data-bs-toggle="modal" data-bs-target="#DeleteModal" class="btn btn-danger editbtn btn-sm" id="delete"><span class="icon-trash1"></span></button>';

                            data.push([
                                count,
                                value.username,
                                value.part,
                                value.user_type,
                                value.status,
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
                console.log(data.get('part'));
                if (data.get('username') == ""||data.get('part') == "") {
                    return alert(
                        "Vui lòng điền đầy đủ thông tin");
                } else {
                    // Gửi yêu cầu AJAX với cả hai dữ liệu
                    $.ajax({
                        type: "POST",
                        url: "{{ route('User.update.add.data') }}",
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
                $('#username').val(rowData[1]);
                $('#part').val(rowData[2]);
                $('#user_type').val(rowData[3]);
                $('#status').val(rowData[4]);
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
                        url: "{{ route('User.delete.data') }}",
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
