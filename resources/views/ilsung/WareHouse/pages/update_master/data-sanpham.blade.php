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
                            <select name="Type" id="Type_search" class="form-select">
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
                                {{-- <th>STT</th> --}}
                                <th>Image</th>
                                <th>ID</th>
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
                                        {{-- <label for="" class="control-label">Update theo file:</label> --}}
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
                                <form action="{{ route('product.save') }}" method="post" id="form_data"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">
                                        <input name="ID_SP" type="hidden" id="ID_SP" class="form-control">
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

                                        {{-- <div class="col-sm-12 col-xl-4 mb-3">
                                            <span>ID Sản phẩm</span>
                                            <input name="ID_SP" type="text" id="ID_SP" class="form-control">
                                        </div> --}}

                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Model:</span>
                                            <select name="Model" id="Model" class="form-select">
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Code Purchase:</span>
                                            <input name="Code_Purchase" type="text" id="Code_Purchase"
                                                class="form-control" placeholder="Code mua hàng...">
                                        </div>
                                        <div class="col-sm-12 col-xl-12 mb-3">
                                            <span>Sản phẩm:</span>
                                            <input name="name" id="name" type="text" class="form-control"
                                                placeholder="Tên sản phẩm...">

                                        </div>



                                        <div class="form-group col-6">
                                            <label for="" class="control-label">Image</label>
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="Image"
                                                    id="Image">

                                            </div>

                                        </div>
                                        <div class="form-group col-6 d-flex justify-content-center">
                                            <img src="" alt="" id="cimg"
                                                class="img-fluid img-thumbnail">
                                        </div>
                                    </div>
                                    {{-- <button class="btn btn-primary" type="submit">Lưu</button> --}}
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

            show_model_check();

            tables = $(table).DataTable({
                processing: true, // Cho phép xử lý dữ liệu trong lúc tải
                serverSide: true, // Bật chế độ server-side pagination
                ajax: {
                    url: "{{ route('Warehouse.update.show.data.product') }}", // Đường dẫn đến route mà ta đã định nghĩa
                    type: "GET",
                    data: function(d) {
                        // Thêm các tham số tìm kiếm từ các form hoặc dropdowns
                        console.log('Sending data:', d);
                        d.Type = $('#Type_search')
                            .val(); // Lấy giá trị từ input hoặc select
                        d.Model = $('#Model_search option:selected')
                            .text(); // Lấy giá trị model search
                        d.ID_SP = $('#ID_SP_search').val();

                    },
                   

                },

                columns: [{
                        data: 'Image',
                        render: function(data) {
                            return '<img src="' + '{{ asset('') }}' +
                                data +
                                '" alt="Image" class="img-fluid img-thumbnail" style="max-width: 50px; max-height: 50px;">';
                        }
                    }, {
                        data: 'ID_SP',
                        name: 'ID_SP'
                    }, // Cột ID_Sản phẩm

                    {
                        data: 'name',
                        name: 'name'
                    }, // Cột tên sản phẩm
                    {
                        data: 'Code_Purchase',
                        name: 'Code_Purchase'
                    }, // Cột code purchase
                    {
                        data: 'Model',
                        name: 'Model'
                    },
                    {
                        data: 'id',
                        render: function(data) {
                            // Thêm nút sửa và xóa
                            var editButton =
                                '<button type="button" value="' + data +
                                '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                            var deleteButton =
                                '<button type="button" value="' + data +
                                '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                            return editButton + deleteButton;
                        }
                    }
                ],
                pageLength: 10, // Mỗi trang có 20 bản ghi
                ordering: false, // Tắt chức năng sắp xếp (có thể bật lại nếu cần)
                searching: true, // Cho phép tìm kiếm
                lengthChange: true, // Cho phép thay đổi số bản ghi mỗi trang
                info: false, // Tắt thông tin số lượng bản ghi (total, filtered)
                autoWidth: false,
                select: {
                    style: 'single',
                }, // Tự động điều chỉnh chiều rộng của cột

            });

            
            $('#Model_search, #Type_search').on('change', function() {
                tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi

            });
            $(document).on('click', '#Scan_QR', function(e) {
                e.preventDefault();
                tables.ajax.reload();
            });

            document.getElementById('Image').addEventListener('change', function(event) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cimg').src = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            });


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

                // Hiển thị modal với tiêu đề chỉnh sửa
                $('#title_modal_data').text('Chỉnh sửa sản phẩm');
                $('#save').hide(); // Ẩn nút Save
                $('#update').show(); // Hiển thị nút Update

                // Lấy ID từ nút Edit (giá trị ID hoặc dòng nào đó)
                id = $(this).val();
                let rowData = tables.rows().data().toArray().find(row => row.id == id);

                if (rowData) {
                    // Gán dữ liệu vào các trường form
                    $('#id').val(rowData.id); // ID ẩn
                    $('#ID_SP').val(rowData.ID_SP); // ID Sản phẩm
                    $('#name').val(rowData.name); // Tên sản phẩm
                    $('#Code_Purchase').val(rowData.Code_Purchase); // Mã mua hàng

                    // Gán loại sản phẩm (Type) vào select box
                    $('#Type').val(rowData.Type);

                    $('#Model option').each(function() {
                        if ($(this).text() === rowData.Model) {
                            $(this).prop('selected', true); // Chọn option có text khớp
                        }
                    });
                    // Hiển thị ảnh sản phẩm
                    // document.getElementById('cimg').src = e.target.result;
                    var imageBasePath = "{{ asset('') }}";
                    $('#cimg').attr('src', rowData.Image ? imageBasePath + rowData.Image :
                        imageBasePath +
                        'default-image.png');

                }

                // Hiển thị modal
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
                $('#modal-created').modal('hide');
                document.getElementById('form_data').reset();

            });
        });
    </script>
@endsection
