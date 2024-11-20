@extends('ilsung.WareHouse.layouts.WareHouse_layout')
@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
        <div class="card table-responsive" style="border: none">
            <div class="card-header">
                <h2>Nhập Kho</h2>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
            <div class="card-body">
                <form action="{{ route('warehouse.import') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">

                    <div class="row">
                        <div class="col-sm-6 col-xl-4 mb-3 bottommargin-sm">
                            <label for="">Code sản phẩm</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Code sản phẩm" id="ID_SP">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-4 mb-3">
                            <span>Phân loại:</span>
                            <select name="Type" id="Type" class="form-select">
                                <option value="All">All</option>
                                <option value="JIG">JIG</option>
                                <option value="MRO">MRO</option>
                                <option value="Spare part">Spare part</option>
                                <option value="SET">SET</option>
                                <option value="TSCD">TSCD</option>
                            </select>
                        </div>

                        <div class="col-sm-6 col-xl-4 mb-3">
                            <label for="name">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="name" id="name">

                        </div>
                        <br>


                        <div class="col-sm-6 col-xl-3 mb-3">
                            <label for="warehouse_id_1">Kho chuyển</label>
                            <input type="text" class="form-control" name="warehouse_1" id="warehouse_1">
                            {{-- <select name="warehouse_1" id="warehouse_1" class="form-control">

                            </select> --}}
                        </div>
                        <div class=" col-sm-6 col-xl-3 mb-3">
                            <label for="warehouse_id_2">Kho nhận</label>
                            <input type="text" class="form-control" name="warehouse_2" id="warehouse_2">
                            {{-- <select name="warehouse_2" id="warehouse_2" class="form-control">

                            </select> --}}
                        </div>

                        <div class="col-sm-6 col-xl-3 mb-3">
                            <label for="quantity">Số lượng</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                        <div class="col-sm-6 col-xl-3 mb-3">
                            {{-- <label for="quantity_1">Action:</label> --}}
                            <button type="button" class="btn btn-primary" id="add-product">Thêm sản phẩm</button>
                        </div>
                    </div>
                    {{-- <h3>Sản phẩm đã chọn</h3> --}}
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success">
                            <tr>
                                {{-- <th>STT</th> --}}
                                <th>Image</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code Purchase</th>
                                <th>Model</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>

    {{-- model show check list --}}
    <div class="modal" id="modal-check">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <!-- Tiêu đề bên trái -->
                    <h5 class="text-primary mx-3">
                        CHECK LIST EQM
                    </h5>
                    <div>
                        <button type="button" id="save-check-list" class="btn btn-success">Save</button>
                        <button type="button" id="update-check-list" class="btn btn-success">Update</button>
                        <button type="button" id="close-model" class="btn btn-warning close-model-checklist">Close</button>
                    </div>
                </div>
                <div class="modal-body" style="background-color: white">
                    <div class="row">
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Model:</span>
                            <select name="model" id="Model" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Line:</span>
                            <select name="line" id="Line" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Machine:</span>
                            <select name="Machine" id="Machine" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Machine-ID:</span>

                            <input name="ID_machine" type="text" id="ID_machine" class="form-control"
                                placeholder="Chọn ID máy...">
                            <div id="suggestions" style="border: 1px solid #ccc; display: none;"></div>
                            <div id="error-message" style="color: red; display: none;"></div>


                        </div>

                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Item check list:</span>
                            <select name="item" id="Checklist_item" class="form-select">
                            </select>
                        </div>
                        <div class="col-sm-4 col-xl-2 mb-3">
                            <span>Khung check:</span>
                            <select name="shift" id="Khung_gio" class="form-select">
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row table-responsive">
                        <table class="table table-bordered text-center mt-4 table-hover col-12" id="table-check-list"
                            style="width: 100%; text-align: center; vertical-align:middle">
                            <thead class="table-success">
                                <tr>
                                    <th style="width:3%" rowspan="2">STT</th>
                                    <th style="width:77" rowspan="2">Nội dung</th>
                                    <th style="width:10%" colspan="2">Tình trạng</th>
                                    <th style="width:10%" rowspan="2">Vấn đề</th>
                                </tr>
                                <tr>
                                    <th style="width:5%">OK</th>
                                    <th style="width:5%">NG</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- modal Scan --}}
    <div class="modal" id="modal-scan">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-primary mx-3">Quét QR Code</b>
                    </h5>

                </div>
                <div class="modal-footer mx-5">
                    <button type="button" class="btn btn-warning close close-model-scan"
                        id="close-model-scan">Close</button>
                </div>
                <div class="modal-body mx-5" style="background-color: white; ">
                    <div id="qr-reader" style="width:100%"></div>
                    <button id="closeScanBtn" style="display: none;">Đóng Quét</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table_name = 'Product';
            var table = '#table-result';
            let title_add = "Add sản phẩm";
            let title_edit = "Edit sản phẩm";
            var tables;
            let id;
            var product_JIG = [];
            var product_MRO = [];
            var product_SET = [];
            var product_TSCD = [];
            var product_Spartpart = [];
            var product = [];
            var IN = [];
            var OUT = [];

            function show_data_check() {
                var type = $('#Type').val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('WareHouse.show.master') }}",
                    dataType: "json",
                    data: {
                        Type: type
                    },
                    success: function(response) {
                        product_JIG = [];
                        product_MRO = [];
                        product_SET = [];
                        product_TSCD = [];
                        product_Spartpart = [];
                        product = [];
                        IN = [];
                        OUT = [];
                        $.each(response.product, function(index, value) {
                            product.push(value.name);
                            if (value.Type == 'JIG') {
                                product_JIG.push(value.name);
                            }
                            if (value.Type == 'MRO') {
                                product_JIG.push(value.name);
                            }
                            if (value.Type == 'SET') {
                                product_JIG.push(value.name);
                            }
                            if (value.Type == 'TSCD') {
                                product_JIG.push(value.name);
                            }
                            if (value.Type == 'Spart part') {
                                product_JIG.push(value.name);
                            }
                        });

                        $("#name").autocomplete({
                            source: function(request, response) {
                                // Lọc danh sách sản phẩm theo từ khóa người dùng nhập vào
                                var term = request.term
                                    .toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường
                                var filteredProducts = product.filter(function(item) {
                                    // Kiểm tra xem tên sản phẩm có chứa từ khóa tìm kiếm không
                                    return item.toLowerCase().indexOf(term) !== -1;
                                });

                                // Giới hạn số lượng gợi ý trả về (tối đa 15 sản phẩm)
                                var limitedResults = filteredProducts.slice(0, 10);

                                // Trả về kết quả tìm kiếm
                                response(limitedResults);
                            },
                            minLength: 1, // Hiển thị gợi ý sau khi người dùng gõ ít nhất 1 ký tự
                            focus: function(event, ui) {
                                event.preventDefault(); // Ngăn chặn điền tự động
                            },
                            select: function(event, ui) {
                                $('#name').val(ui.item
                                    .value); // Điền giá trị đã chọn vào input
                                return false; // Ngăn chặn hành vi mặc định
                            }
                        });

                        $("#warehouse_1").autocomplete({
                            source: function(request, response) {
                                // Lọc danh sách sản phẩm theo từ khóa người dùng nhập vào
                                var term = request.term
                                    .toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường
                                var filteredProducts = OUT.filter(function(item) {
                                    // Kiểm tra xem tên sản phẩm có chứa từ khóa tìm kiếm không
                                    return item.toLowerCase().indexOf(term) !== -1;
                                });

                                // Giới hạn số lượng gợi ý trả về (tối đa 15 sản phẩm)
                                var limitedResults = filteredProducts.slice(0, 10);

                                // Trả về kết quả tìm kiếm
                                response(limitedResults);
                            },
                            minLength: 1, // Hiển thị gợi ý sau khi người dùng gõ ít nhất 1 ký tự
                            focus: function(event, ui) {
                                event.preventDefault(); // Ngăn chặn điền tự động
                            },
                            select: function(event, ui) {
                                $('#warehouse_1').val(ui.item
                                    .value); // Điền giá trị đã chọn vào input
                                return false; // Ngăn chặn hành vi mặc định
                            }
                        });
                        $("#warehouse_2").autocomplete({
                            source: function(request, response) {
                                // Lọc danh sách sản phẩm theo từ khóa người dùng nhập vào
                                var term = request.term
                                    .toLowerCase(); // Lấy từ khóa tìm kiếm và chuyển thành chữ thường
                                var filteredProducts = IN.filter(function(item) {
                                    // Kiểm tra xem tên sản phẩm có chứa từ khóa tìm kiếm không
                                    return item.toLowerCase().indexOf(term) !== -1;
                                });

                                // Giới hạn số lượng gợi ý trả về (tối đa 15 sản phẩm)
                                var limitedResults = filteredProducts.slice(0, 10);

                                // Trả về kết quả tìm kiếm
                                response(limitedResults);
                            },
                            minLength: 1, // Hiển thị gợi ý sau khi người dùng gõ ít nhất 1 ký tự
                            focus: function(event, ui) {
                                event.preventDefault(); // Ngăn chặn điền tự động
                            },
                            select: function(event, ui) {
                                $('#warehouse_2').val(ui.item
                                    .value); // Điền giá trị đã chọn vào input
                                return false; // Ngăn chặn hành vi mặc định
                            }
                        });



                        $('#name').empty();
                        $('#warehouse_1').append($('<option>', {
                            value: "",
                            text: "Chọn kho chuyển",
                        }));
                        $('#warehouse_2').append($('<option>', {
                            value: "",
                            text: "Chọn kho nhận",
                        }));


                        $.each(response.warehouse, function(index, value) {
                            if (value.status == "OUT") {
                                OUT.push(value.name);
                                // $('#warehouse_1').append($('<option>', {
                                //     value: value.id,
                                //     text: value.name,
                                // }));
                            }

                            if (value.status == "IN") {
                                IN.push(value.name);
                                // $('#warehouse_2').append($('<option>', {
                                //     value: value.id,
                                //     text: value.name,
                                // }));
                            }



                        });

                    }
                });


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

            show_data_check();
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


            // $('#Model_search, #Type_search').on('change', function() {
            //     tables.ajax.reload(); // Tải lại dữ liệu của DataTable khi filter thay đổi
            // });

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
