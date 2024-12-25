@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="card form-card">
        <div class="card-header">
            <h3 class="header-title">Danh sách sản phẩm</h3>
        </div>
        <div class="card-body">
            <div class="row content-top">
                <div class="col-12">
                    <div class="master-plan-product">
                        <h4 class="section-title" id="title-product">Thêm sản phẩm</h4>
                        <div class="card-header mb-4">
                            <div class="row align-items-center" style="display: flex">
                                <!-- Phần tải file mẫu -->
                                <div class="col-2">
                                    <a href="#" id="download-template" class="btn btn-primary">
                                        <i class="icon-download"></i> Tải file mẫu
                                    </a>
                                </div>

                                <!-- Phần upload file -->
                                <div class="col-10">
                                    <form action="{{ route('warehouse.update.product') }}" method="post" id="form-upload"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <input class="form-control" type="file" name="excel_file"
                                                accept=".xlsx, .xls" id="file-upload">
                                            <button class="btn btn-success" type="submit">
                                                <i class="icon-line-upload"></i> Upload
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <form action="{{ route('product.save') }}" method="post" id="form_data"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">
                                        <input name="ID_SP" type="hidden" id="ID_SP" class="form-control">

                                        <!-- Loại sản phẩm -->
                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Sản phẩm:</span>
                                            <select name="Type" id="Type" class="form-select">
                                                <option value="JIG">JIG</option>
                                                <option value="MRO">MRO</option>
                                                <option value="Spare part">Spare part</option>
                                                <option value="SET">SET</option>
                                                <option value="TSCD">TSCD</option>
                                            </select>
                                        </div>

                                        <!-- Model sản phẩm -->
                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Model:</span>
                                            <select name="Model" id="Model" class="form-select">
                                            </select>
                                        </div>

                                        <!-- Code Purchase -->
                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Code Purchase:</span>
                                            <input name="Code_Purchase" type="text" id="Code_Purchase"
                                                class="form-control" placeholder="Code mua hàng...">
                                        </div>

                                        <!-- Giới hạn tồn kho -->
                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Giới hạn tồn:</span>
                                            <input name="stock_limit" type="number" id="stock_limit" class="form-control"
                                                placeholder="Giới hạn tồn kho..." min="0" value="0">
                                        </div>

                                        <!-- Tên sản phẩm -->
                                        <div class="col-6 mb-3">
                                            <span>Sản phẩm:</span>
                                            <input name="name" id="name" type="text" class="form-control"
                                                placeholder="Tên sản phẩm...">
                                        </div>

                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Vendor:</span>
                                            <input name="vendor" id="vendor" type="text" class="form-control"
                                                placeholder="Vendor">
                                        </div>
                                        <div class="col-sm-3 col-xl-3 mb-3">
                                            <span>Version:</span>
                                            <input name="version" id="version" type="text" class="form-control"
                                                placeholder="Version">
                                        </div>

                                        <!-- Hình ảnh sản phẩm -->
                                        <div class="form-group col-12">
                                            <span>Image:</span>
                                            {{-- <label for="" class="control-label">Image</label> --}}
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="Image" id="Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    {{-- <div class="row"> --}}
                                    <!-- Hiển thị ảnh trước khi upload -->
                                    <div class="form-group ">
                                        <span>Hình ảnh:</span>
                                        <div class="form-group col-12 d-flex justify-content-center">
                                            <img src="{{ asset('checklist-ilsung/image/gallery.png') }}" alt=""
                                                id="cimg" class="img-fluid img-thumbnail">
                                        </div>
                                    </div>


                                    {{-- </div> --}}
                                </div>
                                <div class="col-sm-12 col-xl-12" id="button-save-product">
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

            <div class="row">
                <div class="col-12">

                    <div class="data-detail">
                        <h4 class="section-title">List sản phẩm</h4>
                        <div class="row">
                            <div class="col-sm-4 col-xl-4 mb-3 bottommargin-sm">
                                <label for="">Code sản phẩm</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Code sản phẩm"
                                        aria-label="Nhập ID SP" aria-describedby="Code_machine" id="ID_SP_search">
                                    <button class="btn btn-outline-secondary btn-primary" type="button"
                                        id="Scan_QR">Search</button>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xl-4 mb-3">
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

                            <div class="col-sm-4 col-xl-4 mb-3">
                                <span>Model:</span>
                                <select name="Model" id="Model_search" class="form-select">
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm " id="table-result"
                                style="width:100%">
                                <thead class="table-success">
                                    <tr>
                                        {{-- <th>STT</th> --}}
                                        <th>Image</th>
                                        <th>ID-SP</th>
                                        <th>Name</th>
                                        <th>Code Purchase</th>
                                        <th>Model</th>
                                        <th>Limit</th>
                                        <th>Vendor</th>
                                        <th>Version</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

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
            var fileName = 'product_format_form.xlsx'; // Bạn có thể thay đổi tên file ở đây nếu cần
            // Tạo URL với tham số file_name
            var url = "{{ route('warehouse.download.template', ['file_name' => '__FILE_NAME__']) }}";
            url = url.replace('__FILE_NAME__', fileName); // Thay __FILE_NAME__ bằng tên file thực tế
            // Cập nhật href của thẻ a
            document.getElementById('download-template').setAttribute('href', url);
        });
    </script>
    <script>
        $(document).ready(function() {
            var table_name = 'Product';
            var table = '#table-result';
            let title_add = "Add sản phẩm";
            let title_edit = "Edit sản phẩm";
            var tables;
            let id;
            $('#update').hide();
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
                            document.getElementById('form_data').reset();
                            $('#save').show();
                            $('#update').hide();
                            $('#title-product').text(title_add);
                            $('#cimg').attr('src', "{{ asset('checklist-ilsung/image/gallery.png') }}");
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
                    url: "{{ route('model.masster') }}",
                    dataType: "json",
                    success: function(response) {

                        $('#Model').empty();
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
                                '" alt="Image" class="img-fluid img-thumbnail" style="max-width: 30px; max-height: 30px;">';
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
                        data: 'stock_limit',
                        name: 'stock_limit'
                    },
                    {
                        data: 'vendor',
                        name: 'vendor'
                    },
                    {
                        data: 'version',
                        name: 'version'
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

                            var edit = '<a href="#" value="' + data +
                                '" id="edit" class="text-success mx-1 editIcon"><i class="bi-pencil-square h4"  style="font-size:1.5rem; color: #06b545;"></i></a>';
                            var deleted = '<a href="#" value="' + data +
                                '" id="delete"class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"  style="font-size:1.5rem; color: #ff0000;"></i></a>';

                            return edit + deleted;
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
                dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                buttons: [{
                    extend: 'excelHtml5',
                    text: 'Tải Excel', // Text của nút
                    title: 'Danh sách sản phẩm', // Tiêu đề của file Excel
                    exportOptions: {
                        columns: ':visible' // Chỉ xuất các cột đang hiển thị
                    }
                }],
                language: {
                    emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                }
            });


            $('#Model_search, #Type_search').on('change', function() {
                tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi

            });



            document.getElementById('Image').addEventListener('change', function(event) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cimg').src = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            });


            $(document).on('click', '#save', function(e) {
                e.preventDefault();
                document.getElementById('form_data').submit();
                $('#cimg').attr('src', "{{ asset('checklist-ilsung/image/gallery.png') }}");
                id = "";
            });

            $(document).on('click', '#edit', function(e) {
                e.preventDefault();
                $('#title-product').text(title_edit);
                $('#save').hide(); // Ẩn nút Save
                $('#update').show(); // Hiển thị nút Update

                id = $(this).attr('value');
                let rowData = tables.rows().data().toArray().find(row => row.id == id);

                if (rowData) {
                    // Gán dữ liệu vào các trường form
                    $('#id').val(rowData.id); // ID ẩn
                    $('#ID_SP').val(rowData.ID_SP); // ID Sản phẩm
                    $('#name').val(rowData.name); // Tên sản phẩm
                    $('#Code_Purchase').val(rowData.Code_Purchase); // Mã mua hàng
                    $('#stock_limit').val(rowData.stock_limit); // Mã mua hàng
                    $('#version').val(rowData.version); // Mã mua hàng
                    $('#vendor').val(rowData.vendor); // Mã mua hàng

                    // Gán loại sản phẩm (Type) vào select box
                    $('#Type').val(rowData.Type);

                    $('#Model option').each(function() {
                        if ($(this).text() === rowData.Model) {
                            $(this).prop('selected', true); // Chọn option có text khớp
                        }
                    });
                    // Hiển thị ảnh sản phẩm
                    var imageBasePath = "{{ asset('') }}";
                    $('#cimg').attr('src', rowData.Image ? imageBasePath + rowData.Image :
                        imageBasePath +
                        'default-image.png');

                }
            });

            $(document).on('click', '#update', function(e) {
                e.preventDefault();
                document.getElementById('form_data').submit();
                id = "";
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
                $('#save').show();
                $('#update').hide();
                $('#title-product').text(title_add);
                $('#cimg').attr('src', "{{ asset('checklist-ilsung/image/gallery.png') }}");


            });
        });
    </script>
@endsection
