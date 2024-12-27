@extends('srtech.WareHouse.layouts.WareHouse_layout')


@section('content')
    <div class="card form-card">
        <div class="card-header">
            <h3 class="mb-0">QUẢN LÝ TỒN KHO</h3>
        </div>

        <div class="card-body">
            <!-- Tab navigation -->
            <ul class="nav nav-tabs" id="stockTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="byProductTab" data-bs-toggle="tab" href="#byProduct" role="tab"
                        aria-controls="byProduct" aria-selected="true">By Product</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="byWarehouseTab" data-bs-toggle="tab" href="#byWarehouse" role="tab"
                        aria-controls="byWarehouse" aria-selected="false">By Warehouse</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="byDetailTab" data-bs-toggle="tab" href="#byDetail" role="tab"
                        aria-controls="byDetail" aria-selected="false">By Detail</a>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- Tab 1: By Product -->
                <div class="tab-pane fade show active" id="byProduct" role="tabpanel" aria-labelledby="byProductTab">
                    <form id="productSearchForm">
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <label for="Type_product">Phân loại:</label>
                                <select name="Type_product" id="Type_product" class="form-select">

                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ID_SP_product">Code ID:</label>
                                <select name="ID_SP_product" id="ID_SP_product" class="form-select">

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name_product">Tên sản phẩm:</label>
                                <select name="name_product" id="name_product" class="form-select">
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm mt-4" id="table-stock-by-product"
                            style="width:100%">
                            <thead class="table-success">
                                <tr>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Q'ty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 2: By Warehouse -->
                <div class="tab-pane fade" id="byWarehouse" role="tabpanel" aria-labelledby="byWarehouseTab">
                    <form id="warehouseSearchForm">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="location_warehouse">Loại kho:</label>
                                <select name="location_warehouse" id="location_warehouse" class="form-select">
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="name_warehouse">Tên kho:</label>
                                <select name="name_warehouse" id="name_warehouse" class="form-select">
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm mt-4" id="table-stock-by-warehouse"
                            style="width:100%">
                            <thead class="table-success">
                                <tr>
                                    <th>STT</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated here via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab 3: By Detail -->
                <div class="tab-pane fade" id="byDetail" role="tabpanel" aria-labelledby="byDetailTab">
                    <div id="form-search" class="mt-2">
                        <form id="searchForm">
                            <div class="row product-fields">
                                <div class="col-md-2 mb-3">
                                    <label for="Type">Phân loại:</label>
                                    <select name="Type" id="Type" class="form-select">
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label for="warehouse_location">Loại hàng:</label>
                                    <select name="warehouse_location" id="warehouse_location" class="form-select">
                                    </select>
                                </div>

                                <div class="col-2 mb-3">
                                    <label for="warehouse">Chọn kho:</label>
                                    <select name="warehouse" id="warehouse" class="form-select">
                                    </select>
                                </div>

                                <div class="col-3 mb-3">
                                    <label for="ID_SP">Code ID:</label>
                                    <select name="ID_SP" id="ID_SP" class="form-select">
                                        <option value="">Chọn Code</option>
                                    </select>
                                </div>
                                <div class="col-3 mb-3">
                                    <label for="name">Tên sản phẩm:</label>
                                    <select name="name" id="name" class="form-select">
                                        <option value="">Chọn sản phẩm</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm mt-4" id="table-result-stock"
                                style="width:100%">
                                <thead class="table-success">
                                    <tr>
                                        <th>Image</th>
                                        <th>Type</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Kho</th>
                                        <th>Q'ty</th>

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
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script src="{{ asset('SR-TECH/js/exceljs.min.js') }}"></script>>

    {{-- js cho tab detail --}}
    <script>
        function show_stock_by_detail() {
            type = $('#Type').val();
            let product_id = $('#ID_SP').val();
            let warehouse = $('#warehouse').val();
            warehouse_location = $('#warehouse_location').val();

            $.ajax({
                url: "{{ route('warehouse.stock.data.by.detail') }}",
                method: 'GET',
                data: {
                    type: type,
                    product_id: product_id,
                    warehouse_id: warehouse,
                    warehouse_location: warehouse_location,
                },
                success: function(data) {

                    var data_table = [];
                    data.products.forEach(function(stock) {
                        var typeCell = '';
                        var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
                            .Image :
                            "{{ asset('checklist-ilsung/image/gallery.png') }}";

                        if (stock.stock_quantity == 0) {
                            typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                '</span>';
                        } else {

                            typeCell = stock.stock_quantity;
                        }

                        data_table.push([
                            '<img src="' + imageUrl +
                            '" alt="Image" width="40">',
                            stock.type,
                            stock.ID_SP,
                            stock.product_name,
                            stock.warehouse_name,
                            typeCell
                        ])
                    });

                    // Chèn dữ liệu vào bảng

                    $('#table-result-stock').DataTable({
                        data: data_table,
                        destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                        ordering: false,
                        dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                        buttons: [{
                            extend: 'excelHtml5',
                            text: 'Tải Excel', // Text của nút
                            title: 'Lịch sử tồn kho', // Tiêu đề của file Excel
                            exportOptions: {
                                columns: ':visible' // Chỉ xuất các cột đang hiển thị
                            }
                        }],
                        language: {
                            emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                        }
                    });
                },
                error: function() {
                    alert('Không thể tải lịch sử, vui lòng thử lại.');
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            // select by detail
            $('#Type').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.type, function(item) {
                                return {
                                    id: item.type,
                                    text: item.type
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#ID_SP').select2({
                placeholder: "Tìm kiếm ID",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.product') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const type = $('#Type').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            type: type
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
                    url: "{{ route('warehouse.get.product') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const type = $('#Type').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            type: type
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

            $('#warehouse_location').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.location, function(item) {
                                return {
                                    id: item.location,
                                    text: item.location
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#warehouse').select2({
                placeholder: "Chọn kho",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.warehouse') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        product_id = $('#name').val();
                        const warehouse_location = $('#warehouse_location').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            product_id: product_id,
                            warehouse_location: warehouse_location

                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
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

            $(document).on('select2:open', () => {
                setTimeout(() => forceFocusFn(), 1); // Thời gian trễ nhỏ để đảm bảo Select2 đã render xong
            });

            // Khi chọn sản phẩm từ #name
            $('#name').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#ID_SP').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.ID_SP
                }));
                show_stock_by_detail();
            });

            // Khi chọn sản phẩm từ #ID_SP
            $('#ID_SP').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#name').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.name
                }));
                show_stock_by_detail();

            });

            $('#warehouse').on('select2:select', function(e) {
                show_stock_by_detail();

            });

            // Khi xóa sản phẩm theo tên
            $('#name,#ID_SP').on('select2:unselect', function(e) {
                $('#ID_SP,#name').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            $('#warehouse').on('select2:unselect', function(e) {
                $('#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#Type").on("change", function() {
                $('#ID_SP,#name,#warehouse,#warehouse_location').val(null).trigger(
                    'change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#warehouse_location").on("change", function() {
                $('#ID_SP,#name,#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });


            function updateWarehouseDropdown() {
                event.preventDefault();
                $('#warehouse').val(null).trigger('change');
                $('#warehouse').select2('data', null); // Clear dữ liệu hiện tại
            }


            show_stock_by_detail();
        });
    </script>


    {{-- js cho tab by product --}}
    <script>
        $(document).ready(function() {

            // select by product
            $('#ID_SP_product').select2({
                placeholder: "Tìm kiếm ID",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.product') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const type = $('#Type_product').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            type: type
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

            $('#name_product').select2({
                placeholder: "Tìm kiếm sản phẩm",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.product') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const type = $('#Type_product').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            type: type
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

            $('#Type_product').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.type, function(item) {
                                return {
                                    id: item.type,
                                    text: item.type
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            function forceFocusFn() {
                const searchInput = document.querySelector('.select2-container--open .select2-search__field');
                if (searchInput) {
                    searchInput.focus(); // Đặt con trỏ vào ô tìm kiếm
                }
            }


            $(document).on('select2:open', () => {
                setTimeout(() => forceFocusFn(), 1); // Thời gian trễ nhỏ để đảm bảo Select2 đã render xong
            });

            // Khi chọn sản phẩm từ #name
            $('#name_product').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#ID_SP_product').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.ID_SP
                }));
                show_stock_by_product();

            });

            // Khi chọn sản phẩm từ #ID_SP
            $('#ID_SP_product').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#name_product').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.name
                }));
                show_stock_by_product();

            });

            // Khi xóa sản phẩm theo tên
            $('#name_product,#ID_SP_product').on('select2:unselect', function(e) {
                $('#ID_SP_product,#name_product').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_product();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#Type_product").on("change", function() {
                $('#ID_SP_product,#name_product').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_product();
            });


            // show history "History"
            function show_stock_by_product() {
                let type = $('#Type_product').val();
                let product_id = $('#ID_SP_product').val();
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.stock.data.by.product') }}",
                    method: 'GET',
                    data: {
                        type: type,
                        product_id: product_id,
                    },
                    success: function(data) {
                        var data_table = [];
                        data.products.forEach(function(stock) {
                            var typeCell = '';
                            var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
                                .Image :
                                "{{ asset('checklist-ilsung/image/gallery.png') }}";

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';
                            } else {

                                typeCell = stock.stock_quantity;
                            }
                            var button_detail = '<a href="#" id="' + stock.product_id +
                                '" class="text-success mx-1 editIcon show_detail" value="' +
                                stock.product_name + '" ID_SP="' + stock.ID_SP +
                                '">Detail</a>';

                            data_table.push([
                                '<img src= "' + imageUrl +
                                '" alt="Image" width="40">',
                                stock.type,
                                stock.ID_SP,
                                stock.product_name,
                                typeCell,
                                button_detail

                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-stock-by-product').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                            ordering: false,
                            dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel', // Text của nút
                                title: 'Lịch sử tồn kho theo sản phẩm', // Tiêu đề của file Excel
                                exportOptions: {
                                    columns: ':visible' // Chỉ xuất các cột đang hiển thị
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                    },
                    error: function() {
                        alert('vui lòng thử lại.');
                    }
                });
            }
            show_stock_by_product();

            $('#table-stock-by-product').on('click', '.show_detail', function(e) {
                e.preventDefault();

                // Lấy warehouse_id từ button được click
                let product_id = $(this).attr('id'); // Lấy ID từ button
                let product_name = $(this).attr('value'); // Lấy ID từ button
                let ID_SP = $(this).attr('id_sp'); // Lấy ID từ button

                // Chuyển sang tab "Detail"
                $('#byDetailTab').tab('show'); // Bật tab 'Detail'

                // Điền giá trị warehouse_id vào dropdown của tab "Detail"
                $('#ID_SP').empty().append($('<option>', {
                    value: product_id,
                    text: ID_SP
                }));

                $('#name').empty().append($('<option>', {
                    value: product_id,
                    text: product_name
                }));


                // Gọi hàm load dữ liệu cho tab "Detail"
                show_stock_by_detail(); // Load dữ liệu mới
            });

        });
    </script>

    {{-- js cho tab by warehouse --}}
    <script>
        $(document).ready(function() {
            // select by warehouse

            $('#location_warehouse').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.location, function(item) {
                                return {
                                    id: item.location,
                                    text: item.location
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#name_warehouse').select2({
                placeholder: "Chọn kho",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.warehouse') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        const warehouse_location = $('#location_warehouse').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            warehouse_location: warehouse_location
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.warehouse_1.map(product => ({
                                id: product.warehouse_id,
                                text: product.name,
                            })),
                            pagination: {
                                more: data.hasMore_1 // Kiểm tra nếu có thêm dữ liệu
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

            $(document).on('select2:open', () => {
                setTimeout(() => forceFocusFn(), 1); // Thời gian trễ nhỏ để đảm bảo Select2 đã render xong
            });


            $('#location_warehouse').on('select2:select', function(e) {
                $('#name_warehouse').val(null).trigger('change');
                $('#name_warehouse').select2('data', null); // Clear dữ liệu hiện tại
                show_stock_by_warehouse();
            });

            $('#name_warehouse').on('select2:select', function(e) {
                show_stock_by_warehouse();
            });

            // Khi xóa sản phẩm theo tên
            $('#location_warehouse').on('select2:unselect', function(e) {
                $('#location_warehouse,#name_warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_warehouse();
            });

            $('#warehouse').on('select2:unselect', function(e) {
                $('#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_warehouse();
            });

            function show_stock_by_warehouse() {

                let warehouse = $('#name_warehouse').val();
                let warehouse_location = $('#location_warehouse').val();

                $.ajax({
                    url: "{{ route('warehouse.stock.data.by.warehouse') }}",
                    method: 'GET',
                    data: {
                        warehouse_id: warehouse,
                        warehouse_location: warehouse_location,
                    },
                    success: function(data) {

                        var data_table = [];
                        var count = 0;
                        data.products.forEach(function(stock) {
                            count++;
                            var typeCell = '';

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';

                            } else {

                                typeCell = stock.stock_quantity;
                            }

                            var button_detail = '<a href="#" id="' + stock.warehouse_id +
                                '" class="text-success mx-1 editIcon show_detail" value="' +
                                stock.name + '">Detail</a>';


                            data_table.push([
                                count,
                                stock.location,
                                stock.name,
                                typeCell,
                                button_detail
                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-stock-by-warehouse').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                            ordering: false,
                            dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel', // Text của nút
                                title: 'Lịch sử tồn kho theo kho', // Tiêu đề của file Excel
                                exportOptions: {
                                    columns: ':visible' // Chỉ xuất các cột đang hiển thị
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                    },
                    error: function() {
                        toastr.error('vui lòng thử lại.');
                    }
                });
            }

            $('#table-stock-by-warehouse').on('click', '.show_detail', function(e) {
                e.preventDefault();

                // Lấy warehouse_id từ button được click
                let warehouse_id = $(this).attr('id'); // Lấy ID từ button
                let warehouse_name = $(this).attr('value'); // Lấy ID từ button
                console.log(warehouse_id);
                console.log(warehouse_name);

                // Chuyển sang tab "Detail"
                $('#byDetailTab').tab('show'); // Bật tab 'Detail'

                // Điền giá trị warehouse_id vào dropdown của tab "Detail"
                $('#warehouse').empty().append($('<option>', {
                    value: warehouse_id,
                    text: warehouse_name
                }));
                // $('#warehouse').val(warehouse_id).trigger('change'); // Update dropdown

                // Gọi hàm load dữ liệu cho tab "Detail"
                show_stock_by_detail(); // Load dữ liệu mới
            });

            show_stock_by_warehouse();
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            // select by detail
            $('#Type').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.type, function(item) {
                                return {
                                    id: item.type,
                                    text: item.type
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

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

            $('#warehouse_location').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.location, function(item) {
                                return {
                                    id: item.location,
                                    text: item.location
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#warehouse').select2({
                placeholder: "Chọn kho",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_warehouse_stock') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        product_id = $('#name').val();
                        warehouse_location = $('#warehouse_loaction').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            product_id: product_id

                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
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


                    },
                    cache: true
                },

            });


            // select by product
            $('#ID_SP_product').select2({
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

            $('#name_product').select2({
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

            $('#Type_product').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.type, function(item) {
                                return {
                                    id: item.type,
                                    text: item.type
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });



            // select by warehouse

            $('#location_warehouse').select2({
                placeholder: "Chọn loại hàng",
                allowClear: true,
                ajax: {
                    url: "{{ route('warehouse.get.type') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        return {
                            search: params.term || '',
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data.location, function(item) {
                                return {
                                    id: item.location,
                                    text: item.location
                                };
                            }),

                        };
                    },
                    cache: true // Lưu trữ tạm thời kết quả để giảm số lần truy vấn
                },
            });

            $('#name_warehouse').select2({
                placeholder: "Chọn kho",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_warehouse_stock') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        product_id = $('#name').val();
                        warehouse_location = $('#warehouse_loaction').val();
                        return {
                            search: params.term || '',
                            page: page,
                            pageSize: 10,
                            product_id: product_id

                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
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


            $(document).on('select2:open', () => {
                setTimeout(() => forceFocusFn(), 1); // Thời gian trễ nhỏ để đảm bảo Select2 đã render xong
            });

            // Khi chọn sản phẩm từ #name
            $('#name').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#ID_SP').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.ID_SP
                }));

                // updateWarehouseDropdown();
                show_stock_by_product();

            });

            // Khi chọn sản phẩm từ #ID_SP
            $('#ID_SP').on('select2:select', function(e) {
                let selectedProduct = e.params.data;
                product_id = selectedProduct.id;
                $('#name').empty().append($('<option>', {
                    value: selectedProduct.id,
                    text: selectedProduct.name
                }));
                show_stock_by_product();

            });

            $('#warehouse').on('select2:select', function(e) {
                // updateWarehouseDropdown();
                show_stock_by_detail();

            });

            // Khi xóa sản phẩm theo tên
            $('#name,#ID_SP').on('select2:unselect', function(e) {
                $('#ID_SP,#name').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            $('#warehouse').on('select2:unselect', function(e) {
                $('#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#Type").on("change", function() {
                $('#ID_SP,#name,#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_detail();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#warehouse_location").on("change", function() {
                $('#ID_SP,#name,#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                console.log('a');
                show_stock_by_detail();
            });


            function updateWarehouseDropdown() {
                event.preventDefault();
                $('#warehouse').val(null).trigger('change');
                $('#warehouse').select2('data', null); // Clear dữ liệu hiện tại
            }
            // show history "History"
            function show_stock_by_product() {
                type = $('#Type_product').val();
                let product_id = $('#ID_SP_product').val();
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.stock.data.by.product') }}",
                    method: 'GET',
                    data: {
                        type: type,
                        product_id: product_id,
                    },
                    success: function(data) {
                        var data_table = [];
                        data.products.forEach(function(stock) {
                            var typeCell = '';
                            var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
                                .Image :
                                "{{ asset('checklist-ilsung/image/gallery.png') }}";

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';

                            } else {

                                typeCell = stock.stock_quantity;
                            }
                            var button_detail = '<a href="#" id="' + stock.product_id +
                                '" class="text-success mx-1 editIcon show_detail"><i class="bi-pencil-square h4"  style="font-size:1.5rem; color: #06b545;"></i></a>';

                            data_table.push([
                                '<img src="' + imageUrl +
                                '" alt="Image" width="40">',
                                stock.ID_SP,
                                stock.product_name,
                                typeCell,
                                button_detail

                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-stock-by-product').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                            ordering: false,
                            dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel', // Text của nút
                                title: 'Lịch sử tồn kho theo sản phẩm', // Tiêu đề của file Excel
                                exportOptions: {
                                    columns: ':visible' // Chỉ xuất các cột đang hiển thị
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                    },
                    error: function() {
                        alert('vui lòng thử lại.');
                    }
                });
            }

            function show_stock_by_warehouse() {

                let warehouse = $('#name_warehouse').val();
                let warehouse_location = $('#location_warehouse').val();

                $.ajax({
                    url: "{{ route('warehouse.stock.data.by.warehouse') }}",
                    method: 'GET',
                    data: {
                        warehouse_id: warehouse,
                        warehouse_location: warehouse_location,
                    },
                    success: function(data) {

                        var data_table = [];
                        var count = 0;
                        data.products.forEach(function(stock) {
                            count++;
                            var typeCell = '';

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';

                            } else {

                                typeCell = stock.stock_quantity;
                            }

                            var button_detail = '<a href="#" id="' + stock.product_id +
                                '" class="text-success mx-1 editIcon show_detail"><i class="bi-pencil-square h4"  style="font-size:1.5rem; color: #06b545;"></i></a>';


                            data_table.push([
                                count,
                                stock.location,
                                stock.name,
                                typeCell,
                                button_detail
                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-stock-by-warehouse').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                            ordering: false,
                            dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel', // Text của nút
                                title: 'Lịch sử tồn kho theo kho', // Tiêu đề của file Excel
                                exportOptions: {
                                    columns: ':visible' // Chỉ xuất các cột đang hiển thị
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                    },
                    error: function() {
                        toastr.error('vui lòng thử lại.');
                    }
                });
            }

            function show_stock_by_detail() {
                type = $('#Type').val();
                let product_id = $('#ID_SP').val();
                let warehouse = $('#warehouse').val();
                warehouse_location = $('#warehouse_location').val();
                console.log(warehouse_location);
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.stock.data.by.detail') }}",
                    method: 'GET',
                    data: {
                        type: type,
                        product_id: product_id,
                        warehouse_id: warehouse,
                        warehouse_location: warehouse_location,
                    },
                    success: function(data) {
                        // Xử lý dữ liệu và hiển thị trong modal
                        let historyRows = '';
                        var data_table = [];
                        data.products.forEach(function(stock) {
                            var typeCell = '';
                            var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
                                .Image :
                                "{{ asset('checklist-ilsung/image/gallery.png') }}";

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';

                            } else {

                                typeCell = stock.stock_quantity;
                            }

                            const warehouseList = stock.warehouse_name.split(', ').map(
                                item => {
                                    return `<li>${item}</li>`; // Tạo mỗi kho và số lượng thành một item trong list
                                }).join('');

                            data_table.push([
                                '<img src="' + imageUrl +
                                '" alt="Image" width="40">',
                                stock.ID_SP,
                                stock.product_name,
                                stock.warehouse_name,
                                typeCell
                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-result-stock').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
                            ordering: false,
                            dom: 'Bfrtip', // Chỉ định vị trí của các thành phần: buttons, filters, table...
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel', // Text của nút
                                title: 'Lịch sử tồn kho', // Tiêu đề của file Excel
                                exportOptions: {
                                    columns: ':visible' // Chỉ xuất các cột đang hiển thị
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                    },
                    error: function() {
                        alert('Không thể tải lịch sử, vui lòng thử lại.');
                    }
                });
            }

            show_stock_by_detail();
            show_stock_by_product();
            show_stock_by_warehouse();
        });
    </script> --}}
@endsection
