@extends('ilsung.WareHouse.layouts.WareHouse_layout')

@section('content')
    <div class="tab-content mt-4" id="nav-tabContent">
        {{-- =====  Hoạt động nổi bật ===== --}}

        <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
            <div class="card table-responsive" style="border: none">
                <div class="card-header">
                    <button type="button" id="Home" class="btn btn-success"
                        onclick="window.location='{{ route('WareHouse.update.master') }}'"><span
                            class="icon-home"></span></button>
                    <button type="button" id="creat" class="btn btn-primary">Add</button>

                </div>
                <div class="card-body ">

                    <div class="row">
                        <div class="col-sm-6 col-xl-4 mb-3 bottommargin-sm">
                            <label for="">Code sản phẩm</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Code sản phẩm"
                                    aria-label="Nhập ID SP" aria-describedby="Code_machine" id="ID_SP_search">
                                <button class="btn btn-outline-secondary btn-primary" type="button"
                                    id="Scan_QR">Search</button>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-4 mb-3">
                            <span>Sản phẩm:</span>
                            <select name="Status" id="Status_search" class="form-select">
                                <option value="All">All</option>
                                <option value="JIG">JIG</option>
                                <option value="MRO">MRO</option>
                                <option value="Spare part">Spare part</option>
                                <option value="SET">SET</option>
                                <option value="TSCD">TSCD</option>
                            </select>
                        </div>

                        <div class="col-sm-6 col-xl-4 mb-3">
                            <span>Model:</span>
                            <select name="Model" id="Model_search" class="form-select">
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success">
                            <tr>
                                <th>STT</th>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Code Purchase</th>
                                <th>Model</th>
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
                    {{-- <h4>Update bằng file CSV</h4> --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <form action="{{ route('Warehouse.table.update.data') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="hidden" name="id" id="table_name" value="">
                                        <input class="form-control" type="file" name="csv_file" accept=".csv"
                                            id="file-upload">
                                        <button class="btn btn-success" type="submit"><i class="icon-line-upload"></i>
                                            <span class="hidden-xs">Upload</span></button>

                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <form action="" method="post" id="form_data">
                                    @csrf
                                    <div class="row">

                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">
                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Sản phẩm:</span>
                                            <select name="Type" id="Type" class="form-select">
                                                <option value="JIG">JIG</option>
                                                <option value="MRO">MRO</option>
                                                <option value="Spare part">Spare part</option>
                                                <option value="SET">SET</option>
                                                <option value="TSCD">TSCD</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-12 col-xl-4 mb-3">
                                            <span>ID Sản phẩm</span>
                                            <input name="ID_SP" type="text" id="ID_SP" class="form-control">
                                        </div>

                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Model:</span>
                                            <select name="Model" id="Model" class="form-select">
                                            </select>
                                        </div>
                                        <div class="col-sm-12 col-xl-6 mb-3">
                                            <span>Name:</span>
                                            <select name="name" id="name" class="form-select">
                                            </select>
                                        </div>


                                        <div class="col-sm-12 col-xl-6 mb-3">
                                            <span>Code Purchase:</span>
                                            <input name="Code_Purchase" type="text" id="Code_Purchase"
                                                class="form-control" placeholder="Code mua hàng...">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="" class="control-label">Image</label>
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="Image"
                                                    id="Image">
                                                {{-- <button class="btn btn-success" type="submit">         </button> --}}

                                            </div>

                                        </div>
                                        <div class="form-group col-6 d-flex justify-content-center">
                                            <img src="" alt="" id="cimg"
                                                class="img-fluid img-thumbnail">
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
    <style>
        img#cimg {
            height: 30vh;
            width: 30vh;
            object-fit: cover;
            /* border-radius: 100% 100%; */
        }
    </style>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
            var table_name = 'Product';
            var table = '#table-result';
            let title_add = "Add sản phẩm";
            let title_edit = "Edit sản phẩm";
            var tables;
            let id;
            $('#table_name').val(table_name);

            function show_data_table(tab) {
                var Model_search = $('#Model_search option:selected').text();
                var Type_search = $('#Type_search option:selected').text();
            
                $.ajax({
                    type: "GET",
                    url: "{{ route('Warehouse.update.show.data') }}",
                    dataType: "json",
                    data: {
                        table: tab,
                        Model: Model_search,
                        Type: Type_search,
                       
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
                            var images = '<img src="' + value.Image +
                                '" alt="" id="image_avatar"' +
                                '              class="img-fluid img-thumbnail">';
                            data.push([
                                count,
                                value.ID_SP,
                                images,
                                value.name,
                                value.Code_Purchase,
                                value.Model,
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

            function displayImg(input, _this) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cimg').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
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

            show_data_table(table_name);
            $(document).on('click', '#creat', function(e) {
                e.preventDefault();
                $('#title_modal_data').text(title_add);
                const button1 = document.getElementById('save');
                button1.style.display = 'unset'; // Ẩn button
                const button2 = document.getElementById('update');
                button2.style.display = 'none'; // Ẩn button
                $('#modal-created').modal('show');
                id = "";
            });

            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                save_update_data();

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
                    $('#Machine').val(rowData[1]);
                    $('#Status').val(rowData[2]);

                }
                $('#modal-created').modal('show');
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
