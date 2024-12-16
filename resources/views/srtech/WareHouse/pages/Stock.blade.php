@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="card">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center"
            style="background: linear-gradient(90deg, #1e3a8a, #4f46e5); box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <h3 class="mb-0" style="font-weight: bold; letter-spacing: 1px; color:white">Quản lý tồn kho</h3>
        </div>

        <div class="card-body">
            <!-- Form -->
            <div id="form-search" class="mt-2">
                <form id="searchForm">
                    <!-- Radio buttons to select search type -->
                    {{-- <div class="radio-buttons text-center">
                        <label class="radio-button mx-3">
                            <input type="radio" name="item_search" value="product" checked />
                            <span class="radio-icon"><i class="fas fa-box"></i></span>
                            <span class="radio-text">Sản phẩm</span>
                        </label>
                        <label class="radio-button mx-3">
                            <input type="radio" name="item_search" value="warehouse" />
                            <span class="radio-icon"><i class="fas fa-warehouse"></i></span>
                            <span class="radio-text">Kho</span>
                        </label>
                    </div> --}}

                    <!-- Search fields for products -->
                    <div class="row product-fields">
                        <div class="col-md-2 mb-3">
                            <label for="Type">Phân loại:</label>
                            <select name="Type" id="Type" class="form-select">
                                <option value="All">All</option>
                                <option value="JIG">JIG</option>
                                <option value="MRO">MRO</option>
                                <option value="Spare part">Spare part</option>
                                <option value="SET">SET</option>
                                <option value="TSCD">TSCD</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="warehouse">Chọn kho:</label>
                            <select name="warehouse" id="warehouse" class="form-select">
                                {{-- <option value="">-- Chọn kho --</option> --}}
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="ID_SP">Code ID:</label>
                            <select name="ID_SP" id="ID_SP" class="form-select">
                                <option value="">Chọn Code</option>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label for="name">Tên sản phẩm:</label>
                            <select name="name" id="name" class="form-select">
                                <option value="">Chọn sản phẩm</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search fields for warehouse -->
                    <div class="row warehouse-fields" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <label for="warehouse">Chọn kho:</label>
                            <select name="warehouse" id="warehouse" class="form-select">
                                {{-- <option value="">-- Chọn kho --</option> --}}
                            </select>
                        </div>
                    </div>

                    <!-- Results Table for Products -->
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-sm mt-4" id="table-result-stock"
                            style="width:100%">
                            <thead class="table-success">
                                <tr>
                                    <th>Image</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Kho</th>
                                    <th>Q'ty</th>
                                    
                                </tr>
                            </thead>
                           
                        </table>
                    </div>
                </form>
            </div>
        </div>


    </div>

    <!-- Modal hiển thị lịch sử nhập/xuất -->
    <div class="modal fade" id="historyModal_product" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen"> <!-- modal-xl để modal rộng hơn -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="historyModalLabel">Chi tiết Lịch Sử Nhập/Xuất</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <!-- Chi tiết Tồn Kho -->
                    <div class="mb-4">
                        <h5 class="text-success">Chi Tiết Tồn Kho</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm mt-2" id="table-result-detail-kho"
                                style="width:100%">
                                <thead class="table-success">
                                    <tr>
                                        <th>Hình Ảnh</th>
                                        <th>Mã Sản Phẩm (ID)</th>
                                        <th>Tên Sản Phẩm</th>
                                        <th>Kho</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                </thead>
                                <tbody id="historywarehouse">
                                    <!-- Dữ liệu sẽ được render bằng JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div> --}}

                    <!-- Lịch Sử Nhập/Xuất -->

                    {{-- <h5 class="text-primary">Lịch Sử Nhập/Xuất Kho</h5> --}}
                    {{-- <div class="card-body body-product"> --}}
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover table-sm mt-2" id="table-history-detail"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Type</th>
                                    <th>Mã SP</th>
                                    <th>Sản Phẩm</th>
                                    <th>Kho</th>
                                    <th>Remark</th>
                                    <th>Số Lượng</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.2.0/exceljs.min.js"></script>

    <script>
        $(document).ready(function() {
            let selectedSearchType = "product"; // Mặc định tìm kiếm theo sản phẩm
            let type_change = 'change';
            let product_change = 'change';
            let allProducts = [];
            let action = "Export";
            let product_id = '';
            // Hàm tải dữ liệu từ server và hiển thị


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

            $('#warehouse').select2({
                placeholder: "Chọn kho chuyển",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_warehouse_stock') }}", // API để lấy dữ liệu sản phẩm
                    dataType: 'json',
                    delay: 250, // Thời gian trễ khi gõ (ms)
                    data: function(params) {
                        const page = params.page || 1;
                        product_id = $('#name').val();
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

                // updateWarehouseDropdown();
                show_stock_by_product();

            });

            $('#warehouse').on('select2:select', function(e) {
                // updateWarehouseDropdown();
                show_stock_by_product();

            });

            // Khi xóa sản phẩm theo tên
            $('#name,#ID_SP').on('select2:unselect', function(e) {
                $('#ID_SP,#name').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_product();
            });

            $('#warehouse').on('select2:unselect', function(e) {
                $('#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_product();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#Type").on("change", function() {
                $('#ID_SP,#name,#warehouse').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
                show_stock_by_product();
            });



            $("input[name='item_search']").on("change", function() {
                const selectedValue = $("input[name='item_search']:checked").val();

                if (selectedValue === "product") {
                    $(".product-fields,.body-product").show();
                    $(".warehouse-fields,#table-result-kho").hide();
                } else if (selectedValue === "warehouse") {
                    $(".product-fields,.body-product").hide();
                    $(".warehouse-fields,#table-result-kho").show();

                }
                selectedSearchType = $(this).val();
                // loadFilters();

            });


            function updateWarehouseDropdown() {
                event.preventDefault();
                $('#warehouse').val(null).trigger('change');
                $('#warehouse').select2('data', null); // Clear dữ liệu hiện tại

            }
            // show history "History"
            function show_stock_by_product() {
                type = $('#Type').val();
                let product_id = $('#ID_SP').val();
                let warehouse = $('#warehouse').val();
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.stock.data') }}",
                    method: 'GET',
                    data: {
                        type: type,
                        product_id: product_id,
                        warehouse_id: warehouse
                    },
                    success: function(data) {
                        // Xử lý dữ liệu và hiển thị trong modal
                        let historyRows = '';
                        var data_table = [];
                        data.products.forEach(function(stock) {
                            var typeCell = '';
                            // var button =
                            //     '<button class="btn btn-warning btn-sm history-product" id="' +
                            //     stock.product_id + '">History</button>';

                            var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
                                .Image :
                                "{{ asset('checklist-ilsung/image/gallery.png') }}";

                            if (stock.stock_quantity == 0) {
                                typeCell = '<span style="color: red;">' + stock.stock_quantity +
                                    '</span>';

                            } else {
                                // typeCell = '<span style="color: green;">' + stock.stock_quantity +
                                //     '</span>';
                                typeCell = stock.stock_quantity;
                            }

                            const warehouseList = stock.warehouse_name.split(', ').map(
                                item => {
                                    return `<li>${item}</li>`; // Tạo mỗi kho và số lượng thành một item trong list
                                }).join('');

                            data_table.push([
                                '<img src="' + imageUrl +
                                '" alt="Hình ảnh sản phẩm" width="40">',
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
                            }]
                        });
                    },
                    error: function() {
                        alert('Không thể tải lịch sử, vui lòng thử lại.');
                    }
                });
            }


         


            show_stock_by_product();

            // function loadFilters() {
            //     let currentType = $('#Type').val();
            //     let currentProductID = $('#ID_SP').val();
            //     let currentName = $('#name').val();
            //     let currentWarehouse = $('#warehouse').val();
            //     $.ajax({
            //         url: "{{ route('warehouse.stock.data') }}",
            //         method: 'GET',
            //         data: {
            //             type: currentType,
            //             product_id: currentProductID,
            //             name: currentName,
            //             warehouse: currentWarehouse
            //         },
            //         success: function(data) {
            //             // console.log(data);
            //             let warehouseOptions = [];
            //             let typeOption = [];
            //             let productID = [];
            //             let productName = [];
            //             allProducts = Object.values(data.products);
            //             // Cập nhật lại danh sách kho
            //             data.warehouses.forEach(function(warehouse) {
            //                 warehouseOptions.push({
            //                     id: warehouse.warehouse_id,
            //                     text: warehouse.name
            //                 });

            //             });
            //             // Cập nhật lại danh sách sản phẩm

            //             data.products.forEach(function(product) {
            //                 productID.push({
            //                     id: product.product_id,
            //                     text: product.ID_SP
            //                 });
            //                 productName.push({
            //                     id: product.product_id,
            //                     text: product.name
            //                 });
            //             });

            //             // Hàm hiển thị kết quả stock vào DataTable
            //             let stockRows = [];
            //             let stockRows_kho = [];
            //             if (selectedSearchType === "product") {
            //                 data.stock.forEach(function(stock) {
            //                     var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
            //                         .Image :
            //                         "{{ asset('checklist-ilsung/image/gallery.png') }}";

            //                     var stockValue = Number(stock.stock);
            //                     var stockLimitValue = Number(stock.stock_limit);
            //                     console.log(stockValue);
            //                     console.log(stockLimitValue);
            //                     var stockCell = stockValue < stockLimitValue ?
            //                         '<span style="color: red; font-weight: bold;">' +
            //                         stockValue + '</span>' :
            //                         stockValue;
            //                     stockRows.push([
            //                         '<img src="' + imageUrl +
            //                         '" alt="Hình ảnh sản phẩm" width="40">',
            //                         stock.ID_SP,
            //                         stock.product_name,
            //                         stock.warehouses,
            //                         stockCell,
            //                         '<button class="btn btn-warning btn-sm history-product" id="' +
            //                         stock.product_id + '">History</button>'
            //                     ]);
            //                 });

            //                 // Khởi tạo DataTable cho bảng sản phẩm
            //                 $('#table-result').DataTable({
            //                     data: stockRows,
            //                     destroy: true, // Xóa bảng cũ để không bị trùng lặp
            //                     columns: [{
            //                             title: 'Hình ảnh'
            //                         },
            //                         {
            //                             title: 'Mã ID'
            //                         },
            //                         {
            //                             title: 'Tên sản phẩm'
            //                         },
            //                         {
            //                             title: 'Kho'
            //                         },
            //                         {
            //                             title: 'Số lượng'
            //                         },
            //                         {
            //                             title: 'Tùy chọn'
            //                         }
            //                     ],
            //                     dom: 'Bfrtip', // Thêm nút tải xuống
            //                     buttons: [{
            //                         extend: 'excelHtml5',
            //                         text: 'Tải Excel',
            //                         title: 'Dữ liệu tồn kho theo sản phẩm', // Tiêu đề file Excel
            //                         exportOptions: {
            //                             columns: ':visible' // Chỉ xuất các cột visible
            //                         }
            //                     }]
            //                 });
            //             } else if (selectedSearchType === "warehouse") {
            //                 data.stock_kho.forEach(function(stock) {

            //                     var imageUrl = stock.Image ? "{{ asset('') }}/" + stock
            //                         .Image :
            //                         "{{ asset('checklist-ilsung/image/gallery.png') }}";


            //                     stockRows_kho.push([
            //                         stock.warehouse_name,
            //                         '<img src="' + imageUrl +
            //                         '" alt="Hình ảnh sản phẩm" width="40">',
            //                         stock.ID_SP,
            //                         stock.product_name,
            //                         stock.stock
            //                     ]);
            //                 });

            //                 // Khởi tạo DataTable cho bảng kho
            //                 $('#table-result-warehouse').DataTable({
            //                     data: stockRows_kho,
            //                     destroy: true, // Xóa bảng cũ để không bị trùng lặp
            //                     columns: [{
            //                             title: 'Kho'
            //                         },
            //                         {
            //                             title: 'Hình ảnh'
            //                         },
            //                         {
            //                             title: 'Mã ID'
            //                         },
            //                         {
            //                             title: 'Tên sản phẩm'
            //                         },
            //                         {
            //                             title: 'Số lượng'
            //                         }
            //                     ],
            //                     dom: 'Bfrtip', // Thêm nút tải xuống
            //                     buttons: [{
            //                         extend: 'excelHtml5',
            //                         text: 'Tải Excel',
            //                         title: 'Dữ liệu tồn kho theo kho', // Tiêu đề file Excel
            //                         exportOptions: {
            //                             columns: ':visible' // Chỉ xuất các cột visible
            //                         }
            //                     }]
            //                 });
            //             }

            //             if (product_change == 'change') {
            //                 $('#ID_SP, #name').empty().append($('<option>', {
            //                     value: '',
            //                     text: '-- Chọn kho --'
            //                 }));

            //                 // Gắn danh sách vào dropdown
            //                 $('#ID_SP').select2({
            //                     placeholder: "Tìm kiếm ID",
            //                     allowClear: true,
            //                     data: productID

            //                 });

            //                 // Gắn danh sách vào dropdown
            //                 $('#name').select2({
            //                     placeholder: "Tìm kiếm sản phẩm",
            //                     allowClear: true,
            //                     data: productName

            //                 });
            //             }
            //             if (type_change == 'change') {
            //                 $('#Type').empty().append($('<option>', {
            //                     value: 'All',
            //                     text: 'All'
            //                 }));
            //                 data.Type.forEach(function(product) {
            //                     $('#Type').append($('<option>', {
            //                         value: product.type,
            //                         text: product.type
            //                     }));

            //                 });
            //             }

            //             $('#warehouse').select2({
            //                 placeholder: "Chọn kho",
            //                 allowClear: true,
            //                 data: warehouseOptions,
            //             });



            //         }
            //     });
            // }

            // // Đồng bộ name và ID_SP
            // function setupProductSelectionEvents() {

            //     $('#name').on('select2:select', function(e) {
            //         let selectedID = e.params.data.id;
            //         // let matchedProduct = allProducts.find(p => p.id === parseInt(              selectedID));

            //         $('#ID_SP').val(selectedID).trigger('change');
            //     });

            //     $('#ID_SP').on('select2:select', function(e) {
            //         let selectedID = e.params.data.id;
            //         // let matchedProduct = allProducts.find(p => p.id === parseInt(
            //         //     selectedID));
            //         $('#name').val(selectedID).trigger('change');
            //     });

            //     // Khi xóa sản phẩm theo tên
            //     $('#name').on('select2:unselect', function(e) {
            //         $('#ID_SP').val(null).trigger('change'); // Xóa dữ liệu ở ID_SP
            //     });

            //     // Khi xóa sản phẩm theo ID
            //     $('#ID_SP').on('select2:unselect', function(e) {
            //         $('#name').val(null).trigger('change'); // Xóa dữ liệu ở name
            //     });

            //     let forceFocusFn = function() {
            //         // Gets the search input of the opened select2
            //         var searchInput = document.querySelector('.select2-container--open .select2-search__field');
            //         // If exists
            //         if (searchInput)
            //             searchInput.focus(); // focus
            //     };

            //     // Every time a select2 is opened
            //     $(document).on('select2:open', () => {
            //         // We use a timeout because when a select2 is already opened and you open a new one, it has to wait to find the appropiate
            //         setTimeout(() => forceFocusFn(), 200);
            //     });
            // }

            // $("input[name='item_search']").on("change", function() {
            //     const selectedValue = $("input[name='item_search']:checked").val();

            //     if (selectedValue === "product") {
            //         $(".product-fields,.body-product").show();
            //         $(".warehouse-fields,#table-result-kho").hide();
            //     } else if (selectedValue === "warehouse") {
            //         $(".product-fields,.body-product").hide();
            //         $(".warehouse-fields,#table-result-kho").show();

            //     }
            //     selectedSearchType = $(this).val();
            //     // $(".product-fields").toggle(selectedSearchType === "product");
            //     // $(".warehouse-fields").toggle(selectedSearchType === "warehouse");
            //     loadFilters();

            // });
            // // Xử lý khi thay đổi bộ lọc
            // $("#Type").on("change", function() {
            //     $('#ID_SP').val('').trigger('change');
            //     $('#name').val('').trigger('change');
            //     type_change = 'none';
            //     product_change = 'change';
            //     loadFilters();
            // });

            // // Xử lý khi thay đổi bộ lọc
            // $("#warehouse").on("change", function() {
            //     loadFilters();
            // });

            // $('#name,#ID_SP').on("change", function() {
            //     type_change = 'none';
            //     product_change = 'none';
            //     loadFilters();
            // });

            // loadFilters();
            // setupProductSelectionEvents();

            // Xử lý nút "History"


        });
    </script>
@endsection
