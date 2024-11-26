@extends('ilsung.OQC.layouts.OQC_layout')

@section('content')
    <div class="card table-responsive" style="border: none">
        <div class="card-header">
            <button type="button" id="Home" class="btn btn-success"
                onclick="window.location='{{ route('WareHouse.update.master') }}'"><span class="icon-home"></span></button>
            <button type="button" id="creat" class="btn btn-primary">Add</button>

        </div>
        <div class="card-body ">
            {{-- <div class="row">
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
                    </div> --}}
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
                        <option value="Ca ngày">Ca ngày</option>
                        <option value="Ca đêm">Ca đêm</option>

                    </select>
                </div>
                <div class="col-sm-6 col-xl-4 mb-3"> <span>Line:</span> <select name="Line" id="Line_search"
                        class="form-select">
                        <option value="All">All</option> <!-- Tạo 16 line -->
                        <option value="Line 1">Line 1</option>
                        <option value="Line 2">Line 2</option>
                        <option value="Line 3">Line 3</option> <!-- ... Thêm các line khác ... -->
                        <option value="Line 16">Line 16</option>
                    </select> </div>
            </div>
            <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
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

    {{-- <div class="modal" id="modal-created">
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


                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <!-- Phần Thêm sản phẩm bằng File -->
                                <form action="{{ route('Warehouse.table.update.data') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group">
                                        <input type="hidden" name="id" id="table_name" value="">
                                        <input class="form-control" type="file" name="csv_file" accept=".csv"
                                            id="file-upload">
                                        <button class="btn btn-success" type="submit">
                                            <i class="icon-line-upload"></i>
                                            <span class="hidden-xs">Upload</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-12">
                                <!-- Phần Thêm sản phẩm bằng Form -->
                                <form action="{{ route('product.save') }}" method="post" id="form_data"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input name="id" type="hidden" id="id" class="form-control"
                                            value="">
                                        <input name="ID_SP" type="hidden" id="ID_SP" class="form-control">

                                        <!-- Loại sản phẩm -->
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

                                        <!-- Model sản phẩm -->
                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Model:</span>
                                            <select name="Model" id="Model" class="form-select">
                                            </select>
                                        </div>

                                        <!-- Code Purchase -->
                                        <div class="col-sm-6 col-xl-4 mb-3">
                                            <span>Code Purchase:</span>
                                            <input name="Code_Purchase" type="text" id="Code_Purchase"
                                                class="form-control" placeholder="Code mua hàng...">
                                        </div>

                                        <!-- Tên sản phẩm -->
                                        <div class="col-sm-12 col-xl-12 mb-3">
                                            <span>Sản phẩm:</span>
                                            <input name="name" id="name" type="text" class="form-control"
                                                placeholder="Tên sản phẩm...">
                                        </div>

                                        <!-- Giới hạn tồn kho -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Giới hạn tồn:</span>
                                            <input name="stock_limit" type="number" id="stock_limit"
                                                class="form-control" placeholder="Nhập giới hạn tồn kho..."
                                                min="0" value="1">
                                        </div>

                                        <!-- Hình ảnh sản phẩm -->
                                        <div class="form-group col-5">
                                            <label for="" class="control-label">Image</label>
                                            <div class="input-group">
                                                <input class="form-control" type="file" name="Image"
                                                    id="Image">
                                            </div>
                                        </div>

                                        <!-- Hiển thị ảnh trước khi upload -->
                                        <div class="form-group col-4 d-flex justify-content-center">
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
    </div> --}}

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
                            <div class="row">

                                <!-- Phần Thêm kế hoạch bằng File -->
                                <div class="col-md-9">
                                    <form action="{{ route('OQC.table.update.data') }}" method="post"
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
                                <!-- Phần tải file Excel mẫu -->
                                <div class="col-md-3">
                                    <a href="{{ route('OQC.download.template') }}" class="btn btn-primary">
                                        <i class="icon-download"></i> Tải file mẫu
                                    </a>
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
                                                <!-- Tạo 16 line -->
                                                <option value="Line 1">Line 1</option>
                                                <option value="Line 2">Line 2</option>
                                                <option value="Line 3">Line 3</option>
                                                <!-- ... Thêm các line khác ... -->
                                                <option value="Line 16">Line 16</option>
                                            </select>
                                        </div>
                                        <!-- Model sản phẩm -->
                                        <div class="col-sm-6 col-xl-3 mb-3">
                                            <span>Model:</span>
                                            <input name="model" type="text" id="model" class="form-control"
                                                placeholder="Model sản phẩm...">
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
                }, {
                    data: 'shift',
                    name: 'shift'
                }, {
                    data: 'line',
                    name: 'line'
                }, {
                    data: 'model',
                    name: 'model'
                }, {
                    data: 'prod',
                    name: 'prod'
                }, {
                    data: 'a',
                    name: 'a'
                }, {
                    data: 'b',
                    name: 'b'
                }, {
                    data: 'c',
                    name: 'c'
                }, {
                    data: 'd',
                    name: 'd'
                }, {
                    data: 'e',
                    name: 'e'
                }, {
                    data: 'id',
                    render: function(data) {
                        var editButton = '<button type="button" value="' + data +
                            '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
                        var deleteButton = '<button type="button" value="' + data +
                            '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
                        return editButton + deleteButton;
                    }
                }],
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
            $('#date_search, #shift_search, #Line_search').on('change', function() {
                table.draw();
            });


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

            // tables = $(table).DataTable({
            //     processing: true, // Cho phép xử lý dữ liệu trong lúc tải
            //     serverSide: true, // Bật chế độ server-side pagination
            //     ajax: {
            //         url: "{{ route('Warehouse.update.show.data.product') }}", // Đường dẫn đến route mà ta đã định nghĩa
            //         type: "GET",
            //         data: function(d) {
            //             // Thêm các tham số tìm kiếm từ các form hoặc dropdowns
            //             console.log('Sending data:', d);
            //             d.Type = $('#Type_search')
            //                 .val(); // Lấy giá trị từ input hoặc select
            //             d.Model = $('#Model_search option:selected')
            //                 .text(); // Lấy giá trị model search
            //             d.ID_SP = $('#ID_SP_search').val();

            //         },


            //     },

            //     columns: [{
            //             data: 'Image',
            //             render: function(data) {
            //                 return '<img src="' + '{{ asset('') }}' +
            //                     data +
            //                     '" alt="Image" class="img-fluid img-thumbnail" style="max-width: 50px; max-height: 50px;">';
            //             }
            //         }, {
            //             data: 'ID_SP',
            //             name: 'ID_SP'
            //         }, // Cột ID_Sản phẩm

            //         {
            //             data: 'name',
            //             name: 'name'
            //         }, // Cột tên sản phẩm
            //         {
            //             data: 'Code_Purchase',
            //             name: 'Code_Purchase'
            //         }, // Cột code purchase
            //         {
            //             data: 'Model',
            //             name: 'Model'
            //         },
            //         {
            //             data: 'stock_limit',
            //             name: 'stock_limit'
            //         },
            //         {
            //             data: 'id',
            //             render: function(data) {
            //                 // Thêm nút sửa và xóa
            //                 var editButton =
            //                     '<button type="button" value="' + data +
            //                     '" class="btn btn-success btn-sm editbtn" style="margin-right:5px" id="edit"><span class="icon-pencil2"></span></button>';
            //                 var deleteButton =
            //                     '<button type="button" value="' + data +
            //                     '" class="btn btn-danger btn-sm deletebtn" id="delete"><span class="icon-trash1"></span></button>';
            //                 return editButton + deleteButton;
            //             }
            //         }
            //     ],
            //     pageLength: 10, // Mỗi trang có 20 bản ghi
            //     ordering: false, // Tắt chức năng sắp xếp (có thể bật lại nếu cần)
            //     searching: true, // Cho phép tìm kiếm
            //     lengthChange: true, // Cho phép thay đổi số bản ghi mỗi trang
            //     info: false, // Tắt thông tin số lượng bản ghi (total, filtered)
            //     autoWidth: false,
            //     select: {
            //         style: 'single',
            //     }, // Tự động điều chỉnh chiều rộng của cột

            // });


            $('#Model_search, #Type_search').on('change', function() {
                tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi
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

            // $(document).on('click', '#edit', function(e) {
            //     e.preventDefault();

            //     // Hiển thị modal với tiêu đề chỉnh sửa
            //     $('#title_modal_data').text('Chỉnh sửa sản phẩm');
            //     $('#save').hide(); // Ẩn nút Save
            //     $('#update').show(); // Hiển thị nút Update

            //     // Lấy ID từ nút Edit (giá trị ID hoặc dòng nào đó)
            //     id = $(this).val();
            //     let rowData = tables.rows().data().toArray().find(row => row.id == id);

            //     if (rowData) {
            //         // Gán dữ liệu vào các trường form
            //         $('#id').val(rowData.id); // ID ẩn
            //         $('#ID_SP').val(rowData.ID_SP); // ID Sản phẩm
            //         $('#name').val(rowData.name); // Tên sản phẩm
            //         $('#Code_Purchase').val(rowData.Code_Purchase); // Mã mua hàng
            //         $('#stock_limit').val(rowData.stock_limit); // Mã mua hàng

            //         // Gán loại sản phẩm (Type) vào select box
            //         $('#Type').val(rowData.Type);

            //         $('#Model option').each(function() {
            //             if ($(this).text() === rowData.Model) {
            //                 $(this).prop('selected', true); // Chọn option có text khớp
            //             }
            //         });
            //         // Hiển thị ảnh sản phẩm
            //         // document.getElementById('cimg').src = e.target.result;
            //         var imageBasePath = "{{ asset('') }}";
            //         $('#cimg').attr('src', rowData.Image ? imageBasePath + rowData.Image :
            //             imageBasePath +
            //             'default-image.png');

            //     }

            //     // Hiển thị modal
            //     $('#modal-created').modal('show');
            // });

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
    </script>
@endsection
