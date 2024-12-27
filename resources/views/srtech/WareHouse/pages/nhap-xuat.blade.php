@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="card form-card">
        <div class="card-header">
            <h3 class="mb-0" id="title-header">NHẬP KHO</h3>

        </div>

        <!-- Form Content -->
        <div class="card-body">

            <div class="header-nhap-xuat">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-light action-btn active" data-action="Import">Nhập
                        Kho</button>
                    <button type="button" class="btn btn-outline-light action-btn" data-action="Export">Xuất Kho</button>
                    <button type="button" class="btn btn-outline-light action-btn" data-action="Transfer">Chuyển
                        Kho</button>
                </div>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="row gy-3">
                    <div class="col-12 col-md-2 text-center">
                        <label for="Image" class="form-label">Image</label>
                        <img src="{{ asset('checklist-ilsung/image/gallery.png') }}" alt="Product Image" id="image_prod"
                            class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <label for="ID_SP" class="form-label">Code ID</label>
                                <select name="ID_SP" id="ID_SP" class="form-select">
                                </select>
                            </div>

                            <div class="col-12 col-md-8">
                                <label for="name" class="form-label">Tên Sản Phẩm</label>
                                <select name="name" id="name" class="form-select">

                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-4">
                                <label for="warehouse_1" class="form-label">Kho Chuyển</label>
                                <select name="warehouse_1" id="warehouse_1" class="form-select">
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="warehouse_2" class="form-label">Kho Nhận</label>
                                <select name="warehouse_2" id="warehouse_2" class="form-select">
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="quantity" class="form-label" id="stock_title">Số lượng: </label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required
                                    value="1">
                                <small id="quantity-error" style="color: red; display: none;">Số lượng vượt quá tồn
                                    kho</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3 justify-content-end">
                        <button type="button" class="btn btn-primary" id="add-product">Thêm</button>
                        <button type="button" class="btn btn-success save-transfer" id="save">Lưu</button>
                    </div>
                </div>

            </form>

            <!-- Product Table -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover" id="table-result">
                    <thead class="table-success">
                        <tr>
                            <th>Image</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Q'ty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic Rows -->
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script src="{{ asset('SR-TECH/js/exceljs.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let editingRow = null; // Lưu trữ dòng đang chỉnh sửa
            let action = 'Import';
            let product_id = '';
            var action_title = 'NHẬP KHO';
            let image_path;
            let maxQuantity = 0;


            $('#ID_SP').select2({
                placeholder: "Tìm kiếm ID",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_search') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            action: action
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.products.map(product => ({
                                id: product.id,
                                text: product.ID_SP,
                                name: product.name, // Lưu trữ ID_SP trong kết quả trả về
                                Image: product.Image
                            })),
                            pagination: {
                                more: data.hasMore // Có thêm dữ liệu nữa không
                            }
                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#name').select2({
                placeholder: "Tìm kiếm sản phẩm",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_search') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            action: action
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.products.map(product => ({
                                id: product.id,
                                text: product.name,
                                ID_SP: product.ID_SP, // Lưu trữ ID_SP trong kết quả trả về
                                Image: product.Image
                            })),
                            pagination: {
                                more: data.hasMore // Có thêm dữ liệu nữa không
                            }
                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#warehouse_1').select2({
                placeholder: "Chọn kho chuyển",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_warehouse') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            product_id: product_id,
                            action: action,

                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;

                        if (action == 'Import') {
                            return {
                                results: data.warehouse_1.map(product => ({
                                    id: product.id,
                                    text: product.name,
                                    quantity: 0,

                                })),
                                pagination: {
                                    more: data.hasMore_1 // Kiểm tra nếu có thêm dữ liệu
                                }
                            };
                        } else {
                            return {
                                results: data.warehouse_1.map(product => ({
                                    id: product.warehouse_id,
                                    text: product.name,
                                    quantity: product.stock_quantity,

                                })),
                                pagination: {
                                    more: data.hasMore_1 // Kiểm tra nếu có thêm dữ liệu
                                }
                            };
                        }

                    },
                    cache: true
                },

            });


            $('#warehouse_2').select2({
                placeholder: "Chọn kho nhận",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_warehouse') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const requestData = {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            product_id: product_id || null,
                            action: action || null,
                        };

                        return requestData;
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.warehouse_2.map(product => ({
                                id: product.id,
                                text: product.name,
                                quantity: 0,

                            })),
                            pagination: {
                                more: data.hasMore_2 // Kiểm tra nếu có thêm dữ liệu
                            }
                        };



                    },
                    cache: true
                },
            });

            function forceFocusFn() {
                const searchInput = document.querySelector('.select2-container--open .select2-search__field');
                if (searchInput) {
                    searchInput.focus(); // Đặt con trỏ vào ô tìm kiếm
                }
            }

            // Hàm kiểm tra giá trị nhập vào trong ô "quantity"
            function validateQuantity() {
                // Lấy giá trị từ input và ép kiểu về số
                var quantityInput = $('#quantity').val().trim(); // Xóa khoảng trắng ở đầu/cuối chuỗi
                var errorMessage = document.getElementById('quantity-error');

                // Kiểm tra maxQuantity và action đã được định nghĩa chưa
                if (typeof maxQuantity === 'undefined' || typeof action === 'undefined') {
                    console.error('maxQuantity hoặc action chưa được định nghĩa!');
                    return; // Thoát hàm nếu thiếu dữ liệu cần thiết
                }

                // Nếu input rỗng hoặc không phải số, hiển thị lỗi ngay lập tức
                if (quantityInput === '' || isNaN(quantityInput)) {
                    errorMessage.style.display = 'block';
                    errorMessage.innerText = 'Số lượng phải lớn hơn 0';
                    return; // Dừng kiểm tra tiếp
                }

                // Ép kiểu về số sau khi kiểm tra
                quantityInput = parseFloat(quantityInput);

                // Kiểm tra giá trị nhập vào
                if (quantityInput == 'NaN') {
                    // Nếu giá trị là 0 hoặc âm
                    errorMessage.style.display = 'block';
                    errorMessage.innerText = 'Số lượng phải lớn hơn 0'; // Hiển thị thông báo lỗi
                } else if (action !== 'Import') {
                    // Nếu không phải 'Import' thì kiểm tra số lượng tồn kho
                    if (quantityInput > parseFloat(maxQuantity)) {
                        errorMessage.style.display = 'block';
                        errorMessage.innerText = 'Số lượng vượt quá tồn kho'; // Hiển thị lỗi tồn kho
                    } else {
                        errorMessage.style.display = 'none'; // Ẩn thông báo lỗi
                    }
                } else {
                    // Nếu là 'Import', không kiểm tra giới hạn
                    errorMessage.style.display = 'none';
                }
            }

            $(document).on('select2:open', () => {
                setTimeout(() => forceFocusFn(), 1); // Thời gian trễ nhỏ để đảm bảo Select2 đã render xong
            });

            // Khi chọn sản phẩm từ #name
            $('#name').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                image_path = selectedProduct.Image;
                $('#ID_SP').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.ID_SP
                }));
                $('#image_prod').attr('src', image_path ? "{{ asset('') }}/" +
                    image_path : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                maxQuantity = '';
                updateWarehouseDropdown();

            });

            // Khi chọn sản phẩm từ #ID_SP
            $('#ID_SP').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                image_path = selectedProduct.Image;
                $('#name').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.name
                }));
                $('#image_prod').attr('src', image_path ? "{{ asset('') }}/" +
                    image_path : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                maxQuantity = '';
                updateWarehouseDropdown();

            });

            // Khi xóa sản phẩm theo tên
            $('#name,#ID_SP').on('select2:unselect', function(e) {
                $('#ID_SP').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                $('#name').val(null).trigger('change'); // Xóa dữ liệu ở name

                $('#stock_title').text('Số lượng:');

            });


            function updateWarehouseDropdown() {
                event.preventDefault();
                $('#stock_title').text('Số lượng:');
                document.getElementById('quantity-error').style.display = 'none';
                $('#quantity').val(1).trigger('input');
                $('#warehouse_1').val(null).trigger('change');
                $('#warehouse_2').val(null).trigger('change');

                // Gửi yêu cầu cập nhật lại dữ liệu
                $('#warehouse_1').select2('data', null); // Clear dữ liệu hiện tại
                $('#warehouse_2').select2('data', null); // Clear dữ liệu hiện tại

                if (action != 'Import') {
                    $('#warehouse_1').on('select2:select', function(e) {
                        let selectedData = e.params.data;
                        if (action === 'Export' || action === 'Transfer') {
                            maxQuantity = selectedData.quantity || 0;
                            $('#quantity').attr('max', maxQuantity);
                            $('#stock_title').text('Số lượng tồn: ' + maxQuantity);
                        }
                    });

                } else {
                    $('#stock_title').text('Số lượng:');

                }
            }

            function reset_form() {

                // Reset form sau khi thêm hoặc cập nhật
                $('#image_prod').attr('src', "{{ asset('checklist-ilsung/image/gallery.png') }}");
                $('#ID_SP').val('').trigger('change');
                $('#name').val('').trigger('change');
                // $('#Type').val(type);
                $('#warehouse_1').val('').trigger('change');
                $('#warehouse_2').val('').trigger('change');
                $('#quantity').val('1');
                $('#stock_title').text('Số lượng:');

            }


            // show history "History"
            // function show_historty() {
            //     type = $('#Type').val();
            //     // Gửi yêu cầu lấy lịch sử
            //     $.ajax({
            //         url: "{{ route('warehouse.data.history') }}",
            //         method: 'get',
            //         data: {
            //             action: action,
            //             type: type
            //         },
            //         success: function(data) {
            //             // Xử lý dữ liệu và hiển thị trong modal
            //             let historyRows = '';
            //             var data_table = [];
            //             data.history.forEach(function(stock) {
            //                 var typeCell = '';
            //                 switch (stock.type) {
            //                     case 'Import':
            //                         typeCell = '<span style="color: green;">' + stock.type +
            //                             '</span>';
            //                         break;
            //                     case 'Export':
            //                         typeCell = '<span style="color: red;">' + stock.type +
            //                             '</span>';
            //                         break;
            //                     case 'Transfer':
            //                         typeCell = '<span style="color: blue;">' + stock.type +
            //                             '</span>';
            //                         break;
            //                     default:
            //                         typeCell = stock
            //                             .type; // Nếu không có loại nào phù hợp, giữ nguyên
            //                 }
            //                 data_table.push([
            //                     stock.created_at,
            //                     typeCell,
            //                     stock.ID_SP,
            //                     stock.product_name,
            //                     stock.warehouse_name,
            //                     stock.Remark,
            //                     stock.quantity,
            //                 ])
            //             });

            //             // Chèn dữ liệu vào bảng

            //             $('#table-history').DataTable({
            //                 data: data_table,
            //                 destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
            //                 dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
            //                 buttons: [{
            //                     extend: 'excelHtml5',
            //                     text: 'Tải Excel', // Text của nút
            //                     title: 'Lịch sử tồn kho', // Tiêu đề của file Excel
            //                     exportOptions: {
            //                         columns: ':visible' // Chỉ xuất các cột đang hiển thị
            //                     }
            //                 }]
            //             });
            //         },
            //         error: function() {
            //             alert('Không thể tải lịch sử, vui lòng thử lại.');
            //         }
            //     });
            // }

            function add_product() {

                let product_id = $('#ID_SP').val();
                var ID_SP = $('#ID_SP option:selected').text();
                var name = $('#name option:selected').text();
                let warehouse_1_id = $('#warehouse_1').val();
                let warehouse_1 = $('#warehouse_1 option:selected').text();
                let warehouse_2 = $('#warehouse_2 option:selected').text();
                let warehouse_2_id = $('#warehouse_2').val();
                let quantity = parseInt($('#quantity').val(), 10);
                let maxQuantity = parseInt($('#quantity').attr('max'), 10);

                if (!product_id || !warehouse_1_id || !warehouse_2_id || !quantity) {
                    alert("Vui lòng điền đầy đủ thông tin.");
                    return;
                }

                var imageUrl = image_path ? "{{ asset('') }}/" +
                    image_path : "{{ asset('checklist-ilsung/image/gallery.png') }}";
                if (quantity > maxQuantity) {
                    toastr.error('Số lượng vượt quá tồn kho. Vui lòng kiểm tra lại.', 'Lỗi', {
                        positionClass: 'toast-top-center',
                        closeButton: true,
                        timeOut: 5000,
                        progressBar: true
                    });
                    return;
                }


                // Nếu đang chỉnh sửa, cập nhật dòng
                if (editingRow) {
                    $(editingRow).find('td').eq(1).text(ID_SP).data('product_id',
                        product_id); // Lưu ID kho
                    $(editingRow).find('td').eq(2).text(name).data('product_id',
                        product_id); // Lưu ID kho
                    $(editingRow).find('td').eq(3).text(warehouse_1).data('warehouse-id',
                        warehouse_1_id); // Lưu ID kho
                    $(editingRow).find('td').eq(4).text(warehouse_2).data('warehouse-id',
                        warehouse_2_id); // Lưu ID kho
                    $(editingRow).find('td').eq(5).text(quantity);
                    $(editingRow).find('td').eq(0).html('<img src="' + imageUrl +
                        '" alt="Hình ảnh sản phẩm" width="50">');
                    // Đặt lại trạng thái "Sửa" và "Thêm sản phẩm"
                    $('#add-product').text('Thêm');
                    editingRow = null;
                } else {
                    // Thêm dòng mới
                    var newRow = '<tr>' +
                        '<td><img src="' + imageUrl + '" alt="Hình ảnh sản phẩm" width="40"></td>' +
                        '<td data-product-id="' + product_id + '">' + ID_SP + '</td>' +
                        '<td data-product-id="' + product_id + '">' + name + '</td>' +
                        '<td data-warehouse-id="' + warehouse_1_id + '">' + warehouse_1 + '</td>' +
                        '<td data-warehouse-id="' + warehouse_2_id + '">' + warehouse_2 + '</td>' +
                        '<td>' + quantity + '</td>' +
                        '<td>' +
                        '<a href="#" id="edit" class="text-success mx-1 editIcon edit-product"><i class="bi-pencil-square h4"  style="font-size:1.5rem; color: #06b545;"></i></a>' +
                        '<a href="#" id="delete"class="text-danger mx-1 deleteIcon remove-product"><i class="bi-trash h4"  style="font-size:1.5rem; color: #ff0000;"></i></a>' +
                        '</td>' +
                        '</tr>';
                    $('#table-result tbody').append(newRow);
                }
                reset_form();

            }

            function save() {
                var products = [];
                var warehouse_id;
                var To;
                $('#table-result tbody tr').each(function() {
                    var row = $(this);
                    if (action == 'Import') {
                        warehouse_id = row.find('td:nth-child(5)').data('warehouse-id');
                        target_warehouse_id = row.find('td:nth-child(4)').data('warehouse-id');
                    }
                    if (action == 'Export') {
                        warehouse_id = row.find('td:nth-child(4)').data('warehouse-id');
                        target_warehouse_id = row.find('td:nth-child(5)').data('warehouse-id');
                    }
                    if (action == 'Transfer') {
                        warehouse_id = row.find('td:nth-child(4)').data('warehouse-id');
                        target_warehouse_id = row.find('td:nth-child(5)').data('warehouse-id');
                    }
                    products.push({
                        product_id: row.find('td:nth-child(2)').data('product-id'),
                        warehouse_id: warehouse_id,
                        target_warehouse_id: target_warehouse_id,
                        quantity: row.find('td:nth-child(6)').text(),
                        action: action
                    });
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('warehouse.transfer') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        products: products
                    },
                    success: function(response) {
                        // location.reload();
                        if (response.status == 200) {
                            var success = action_title + ' ' + response.success;
                            toastr.success(success);
                            reset_form();
                            $('#table-result tbody').html('');
                        }
                    },
                    error: function() {
                        toastr.error("Có lỗi - vui lòng kiểm tra lại.");
                    }
                });
            }

            document.getElementById('quantity').addEventListener('input', validateQuantity);


            $(document).on('click', '.action-btn', function() {
                $('.action-btn').removeClass('active');
                $(this).addClass('active');
                action = $(this).data('action');
                if (action == 'Import') {
                    action_title = 'NHẬP KHO';
                }
                if (action == 'Export') {
                    action_title = 'XUẤT KHO';
                }

                if (action == 'Transfer') {
                    action_title = 'CHUYỂN KHO';
                }

                $('#title-header').text(action_title);
                reset_form();
                updateWarehouseDropdown();
                type = $('#Type').val();

            });


            $(document).on('click', '#add-product', function() {
                add_product();
            });

            // Sửa dòng trong bảng

            $(document).on('click', '.edit-product', function(e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định của trình duyệt
                // Lấy dòng hiện tại (tr) được click
                var row = $(this).closest('tr');

                // Lấy dữ liệu từ các cột trong dòng
                var product_id = row.find('td').eq(1).data('product-id'); // ID sản phẩm
                var warehouse_1 = row.find('td').eq(3).data('warehouse-id'); // ID kho chuyển
                var warehouse_2 = row.find('td').eq(4).data('warehouse-id'); // ID kho nhận
                var quantity = row.find('td').eq(5).text(); // Số lượng
                var image = row.find('td img').attr('src'); // Lấy src của ảnh trong cột đầu tiên


                // Điền dữ liệu vào form
                $('#ID_SP').val(product_id).trigger('change'); // ID sản phẩm
                $('#name').val(product_id).trigger('change'); // Tên sản phẩm
                $('#warehouse_1').val(warehouse_1).trigger('change'); // Kho chuyển
                $('#warehouse_2').val(warehouse_2).trigger('change'); // Kho nhận
                $('#quantity').val(quantity); // Số lượng

                // Hiển thị ảnh sản phẩm
                $('#image_prod').attr('src', image ? image :
                    "{{ asset('checklist-ilsung/image/gallery.png') }}");

                // Lưu dòng đang chỉnh sửa để cập nhật
                editingRow = row;

                // Thay đổi nút "Thêm sản phẩm" thành "Cập nhật"
                $('#add-product').text('Cập nhật');
            });


            // Xóa dòng trong bảng
            $(document).on('click', '.remove-product', function() {
                $(this).closest('tr').remove();
            });


            // Lưu dữ liệu
            $(document).on('click', '#save', function(e) {
                e.preventDefault(); // Ngăn chặn form submit mặc định
                if ($('#table-result tbody tr').length === 0) {
                    add_product();
                    save();
                } else {
                    save();
                }

            });
        });
    </script>
@endsection
