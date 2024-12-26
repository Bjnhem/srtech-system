@extends('ilsung.layouts.layout')

@section('content')
    <div class="tab-content mt-4" id="nav-tabContent">
        {{-- =====  Hoạt động nổi bật ===== --}}

        <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
            <div class="card table-responsive" style="border: none">
                <div class="card-header">
                    <button type="button" id="Home" class="btn btn-success"
                        onclick="window.location='{{ route('update.master') }}'"><span class="icon-home"></span></button>
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
    <script>
        $(document).ready(function() {
            var table_name = 'Model_master';
            var table = '#table-result';
            var tables;
            let id;
            let title_add = "Add new Model";
            let title_edit = "Edit Model";
            var rowSelected;

                // data_table_view(table);
                show_data_table(table_name);

            function editTable() {
                $('#table-result').Tabledit({
                    url: "Update-master/edit-table/" + table_name,
                    method: 'POST',
                    dataType: 'json',
                    columns: {
                        identifier: [0, 'id'],
                        editable: colum_table,
                    },
                    restoreButton: true,
                    deleteButtom: true,
                    onSuccess: function(data, textStatus, jqXHR) {
                        if (data.action == 'delete') {
                            data_table_view(table);
                        }
                    }
                });
            }

            function show_data_table(tab) {

                $.ajax({
                    type: "GET",
                    url: "{{ route('update.show.data') }}",
                    dataType: "json",
                    data: {
                        table: tab,
                    },
                    success: function(response) {
                        var data = [];
                        var count = 0;
                        console.log(response.data);
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
                $('#save').show(); // Ẩn nút Save
                $('#update').hide(); // Hiển thị nút Update
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
                        url: "{{ route('update.add.data') }}",
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
                $('#save').hide(); // Ẩn nút Save
                $('#update').show(); // Hiển thị nút Update
                id = $(this).val();

                var rowcont = tables.rows('.selected').indexes();
                if (rowcont[0] != null) {
                    rowSelected = rowcont[0];
                }
                var rowData = tables.row(rowSelected).data();
              
                $('#model').val(rowData[1]);
                $('#Name').val(rowData[2]);
                $('#Status').val(rowData[3]);

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

            // $('#table-result').on('draw.dt', function() {
            //     editTable();
            // });

        });
    </script>
@endsection
