@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    {{-- <div class="tab-pane fade show active" id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0"> --}}
    <div class="card" style="border: none">
        <!-- Header -->
        <div class="card-header">
            <h3 class="header-title">Quản Lý Kho</h3>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-light action-btn active" data-action="Import">Nhập
                    Kho</button>
                <button type="button" class="btn btn-outline-light action-btn" data-action="Export">Xuất Kho</button>
                <button type="button" class="btn btn-outline-light action-btn" data-action="Transfer">Chuyển
                    Kho</button>
            </div>
        </div>


        <!-- Form Content -->
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <input type="hidden" name="id" value="">

                <!-- Form Fields -->
                <div class="row gy-3">
                    <!-- Image Preview -->
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('checklist-ilsung/image/gallery.png') }}" alt="Product Image" id="image_prod"
                            class="img-thumbnail w-75">
                    </div>

                    <!-- Product Information -->
                    <div class="col-md-9">
                        <div class="row">
                            <!-- Type -->
                            <div class="col-md-4">
                                <label for="Type" class="form-label">Phân Loại</label>
                                <select name="Type" id="Type" class="form-select">
                                    <option value="All">All</option>
                                    <option value="JIG">JIG</option>
                                    <option value="MRO">MRO</option>
                                    <option value="Spare part">Spare part</option>
                                    <option value="SET">SET</option>
                                    <option value="TSCD">TSCD</option>
                                </select>
                            </div>

                            <!-- Code ID -->
                            <div class="col-md-4">
                                <label for="ID_SP" class="form-label">Code ID</label>
                                <select name="ID_SP" id="ID_SP" class="form-select">
                                    <option value="">Chọn Code</option>
                                </select>
                            </div>

                            <!-- Product Name -->
                            <div class="col-md-4">
                                <label for="name" class="form-label">Tên Sản Phẩm</label>
                                <select name="name" id="name" class="form-select">
                                    <option value="">Chọn sản phẩm</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Warehouse Transfer -->
                            <div class="col-md-4">
                                <label for="warehouse_1" class="form-label">Kho Chuyển</label>
                                <select name="warehouse_1" id="warehouse_1" class="form-select">
                                    <!-- Dynamic Content -->
                                </select>
                            </div>

                            <!-- Warehouse Receive -->
                            <div class="col-md-4">
                                <label for="warehouse_2" class="form-label">Kho Nhận</label>
                                <select name="warehouse_2" id="warehouse_2" class="form-select">
                                    <!-- Dynamic Content -->
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-4">
                                <label for="quantity" class="form-label">Số Lượng</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" required
                                    value="1">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex mt-4 gap-2" style="justify-content: end">
                            <button type="button" class="btn btn-primary" id="add-product">Thêm</button>
                            <button type="button" class="btn btn-success save-transfer" id="save">Lưu</button>
                        </div>
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

            <!-- History Section -->
            <div class="mt-5">
                <h5 class="text-primary">Lịch Sử Nhập/Xuất Kho</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-history">
                        <thead class="table-dark">
                            <tr>
                                <th>Ngày</th>
                                <th>Nhập/Xuất</th>
                                <th>Mã ID_SP</th>
                                <th>Sản Phẩm</th>
                                <th>Kho Xuất</th>
                                <th>Kho Nhập</th>
                                <th>Số Lượng</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Dynamic Rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let allProducts = []; // Dữ liệu sản phẩm có trong kho
            let productWarehouses = {}; // Danh sách các kho có chứa sản phẩm
            let productWarehouses_all = []; // Danh sách các kho có chứa sản phẩm
            let editingRow = null; // Lưu trữ dòng đang chỉnh sửa
            let warehouseArray = [];
            let action = 'Import';
            var type = $('#Type').val();
            let Products;

            function loadInitialData(action, type) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('WareHouse.show.master.transfer') }}", // Route lấy danh sách sản phẩm có trong kho
                    dataType: "json",
                    data: {
                        Type: type,
                        action: action
                    },
                    success: function(response) {
                        Products_all = Object.values(response.products_all);
                        // reset_form()
                        // Lưu dữ liệu sản phẩm và kho
                        if (action == 'Import') {
                            allProducts = Object.values(response.products_all);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);
                        }
                        if (action == 'Export') {
                            allProducts = Object.values(response.products_search);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);

                        }
                        if (action == 'Transfer') {
                            allProducts = Object.values(response.products_search);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);
                        }
                        warehouseArray = response.warehouse;
                        // console.log(warehouseArray);
                        updateProductDropdown(productWarehouses);
                    }
                });
            }

            function groupWarehousesByProduct(products, selectedType, action) {
                let grouped = {};
                // Lọc sản phẩm theo loại nếu được chỉ định

                let filteredProducts = [];
                if (selectedType == 'All') {
                    filteredProducts = Object.values(products);
                } else {
                    filteredProducts = Object.values(products).filter(product => product.Type === selectedType);
                }

                // Duyệt qua các sản phẩm sau khi đã lọc
                if (action == 'Import') {
                    filteredProducts.forEach(product => {
                        if (!grouped[product.Type]) {
                            grouped[product.Type] = [];
                        }
                        grouped[product.Type].push(product);
                    });
                } else {

                    filteredProducts.forEach(product => {
                        // Khởi tạo nhóm cho loại sản phẩm nếu chưa có
                        if (!grouped[product.Type]) {
                            grouped[product.Type] = {};
                        }

                        // Khởi tạo nhóm cho ID sản phẩm nếu chưa có
                        if (!grouped[product.Type][product.id]) {
                            grouped[product.Type][product.id] = [];
                        }

                        // Duyệt qua các chuyển kho của sản phẩm và thêm vào nhóm
                        product.stock_movements.forEach(stock => {
                            grouped[product.Type][product.id].push({
                                warehouse_id: stock.warehouse_id,
                                warehouse_name: stock.warehouse_name,
                                available_qty: stock.available_qty
                            });
                        });
                    });
                }


                return grouped;
            }

            // Cập nhật dropdown sản phẩm
            function updateProductDropdown(Products) {
                let products = [];
                let seenProductIds = new Set(); // Sử dụng Set để theo dõi các ID đã thêm vào

                // Lặp qua từng loại sản phẩm
                for (const productType in Products) {
                    // Kiểm tra nếu giá trị là mảng (dữ liệu dạng kiểu thứ hai)
                    if (Array.isArray(Products[productType])) {
                        // Duyệt qua các sản phẩm trong mảng
                        Products[productType].forEach(product => {
                            // Thêm sản phẩm vào mảng products
                            products.push({
                                id: product.id, // Lấy id của sản phẩm
                                name: product.name, // Lấy tên sản phẩm
                                ID_SP: product.ID_SP // Lấy ID_SP của sản phẩm
                            });
                        });
                    } else {
                        // Dữ liệu dạng kiểu thứ nhất (có kho của sản phẩm)
                        for (const productId in Products[productType]) {
                            const warehouses = Products[productType][productId]; // Lấy danh sách kho của sản phẩm

                            // Duyệt qua các kho của sản phẩm và thêm vào mảng products
                            warehouses.forEach(warehouse => {
                                let matchedProduct = Products_all.find(p => p.id === parseInt(
                                    productId));
                                if (!seenProductIds.has(productId)) {
                                    products.push({
                                        id: productId, // Sử dụng productId làm id
                                        name: matchedProduct.name, // Dùng name của matchedProduct
                                        ID_SP: matchedProduct.ID_SP // Dùng ID_SP của matchedProduct
                                    });

                                    // Đánh dấu productId là đã được thêm vào
                                    seenProductIds.add(productId);
                                }
                            });
                        }
                    }
                }

                $('#ID_SP, #name').empty().append($('<option>', {
                    value: '',
                    text: '-- Chọn kho --'
                }));

                // Gắn danh sách vào dropdown
                $('#ID_SP').select2({
                    placeholder: "Tìm kiếm ID",
                    allowClear: true,
                    data: products.map(product => ({
                        id: product.id,
                        text: product.ID_SP,
                    }))
                });

                // Gắn danh sách vào dropdown
                $('#name').select2({
                    placeholder: "Tìm kiếm sản phẩm",
                    allowClear: true,
                    data: products.map(product => ({
                        id: product.id,
                        text: product.name
                    }))
                });

                setupProductSelectionEvents(Products_all);
            }

            // Đồng bộ name và ID_SP
            function setupProductSelectionEvents(filteredProducts) {

                $('#name').on('select2:select', function(e) {
                    let selectedID = e.params.data.id;
                    let matchedProduct = filteredProducts.find(p => p.id === parseInt(selectedID));
                    if (matchedProduct) {
                        $('#ID_SP').val(selectedID).trigger('change');
                    }
                    $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                    $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                        matchedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}");

                    updateWarehouseDropdown(selectedID, action, type);
                });

                $('#ID_SP').on('select2:select', function(e) {
                    let selectedID = e.params.data.id;
                    let matchedProduct = filteredProducts.find(p => p.id === parseInt(selectedID));
                    $('#name').val(selectedID).trigger('change');
                    $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                    $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                        matchedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                    updateWarehouseDropdown(selectedID, action, type);
                });



            }

            // Cập nhật danh sách kho chuyển dựa trên sản phẩm được chọn
            function updateWarehouseDropdown(product_id, action, type) {
                event.preventDefault();
                let OUT = [];
                let IN = [];
                let data_kho_stock = [];
                let warehouses = [];
                $('#warehouse_1').empty().append($('<option>', {
                    value: '',
                    text: '-- Chọn kho chuyển --'
                }));
                $('#warehouse_2').empty().append($('<option>', {
                    value: '',
                    text: '-- Chọn kho nhận --'
                }));


                warehouseArray.forEach(warehouse => {
                    if (warehouse.status === "OUT")
                        OUT.push({
                            id: warehouse.id,
                            text: warehouse.name
                        });
                    if (warehouse.status === "IN")
                        IN.push({
                            id: warehouse.id,
                            text: warehouse.name
                        });
                });
                if (action != 'Import') {
                    for (const productType in productWarehouses) {
                        // Kiểm tra nếu tồn tại sản phẩm với ID đã chọn
                        if (productWarehouses[productType][product_id]) {

                            // Lấy danh sách kho của sản phẩm
                            productWarehouses[productType][product_id].forEach(productWarehouse => {
                                // Chỉ cần lặp qua danh sách kho của sản phẩm và thêm chúng vào dropdown
                                data_kho_stock.push({
                                    id: productWarehouse.warehouse_id,
                                    text: `${productWarehouse.warehouse_name} (Tồn: ${productWarehouse.available_qty})`, // Hiển thị tên kho và số lượng tồn
                                    'data-quantity': productWarehouse.available_qty
                                });

                            });
                            break; // Dừng vòng lặp khi tìm thấy sản phẩm
                        }
                    }
                    $('#warehouse_1').select2({
                        placeholder: "Chọn kho chuyển",
                        allowClear: true,
                        data: data_kho_stock,
                        templateSelection: function(data) {
                            if (!data.id) return data.text;
                            $(data.element).attr('data-quantity', data['data-quantity']);
                            return data.text;
                        }
                    });
                    $('#warehouse_1').on('select2:select', function(e) {
                        let selectedData = e.params.data;
                        let maxQuantity = selectedData['data-quantity'];
                        console.log("Max Quantity:", maxQuantity);
                        $('#quantity').attr('max', maxQuantity);
                    });
                }



                switch (action) {
                    case 'Import':
                        $('#warehouse_1').select2({
                            placeholder: "Chọn kho chuyển",
                            allowClear: true,
                            data: OUT
                        });
                        $('#warehouse_2').select2({
                            placeholder: "Chọn kho nhận",
                            allowClear: true,
                            data: IN
                        });
                        break;
                    case 'Export':
                        // Code xử lý cho Xuất kho
                        $('#warehouse_2').select2({
                            placeholder: "Chọn kho nhận",
                            allowClear: true,
                            data: OUT
                        });
                        break;
                    case 'Transfer':
                        $('#warehouse_2').select2({
                            placeholder: "Chọn kho nhận",
                            allowClear: true,
                            data: IN
                        });
                        break;
                }
            }

            function reset_form() {

                // Reset form sau khi thêm hoặc cập nhật
                $('#image_prod').attr('src', "{{ asset('checklist-ilsung/image/gallery.png') }}");
                $('#ID_SP').val('').trigger('change');
                $('#name').val('').trigger('change');
                $('#Type').val(type);
                $('#warehouse_1').val('').trigger('change');
                $('#warehouse_2').val('').trigger('change');
                $('#quantity').val('');
            }

            // show history "History"
            function show_historty() {
                type = $('#Type').val();
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.data.history') }}",
                    method: 'get',
                    data: {
                        action: action,
                        type: type
                    },
                    success: function(data) {
                        // Xử lý dữ liệu và hiển thị trong modal
                        let historyRows = '';
                        var data_table = [];
                        data.history.forEach(function(stock) {
                            var typeCell = '';
                            switch (stock.type) {
                                case 'Import':
                                    typeCell = '<span style="color: green;">' + stock.type +
                                        '</span>';
                                    break;
                                case 'Export':
                                    typeCell = '<span style="color: red;">' + stock.type +
                                        '</span>';
                                    break;
                                case 'Transfer':
                                    typeCell = '<span style="color: blue;">' + stock.type +
                                        '</span>';
                                    break;
                                default:
                                    typeCell = stock
                                        .type; // Nếu không có loại nào phù hợp, giữ nguyên
                            }
                            data_table.push([
                                stock.created_at,
                                typeCell,
                                stock.ID_SP,
                                stock.product_name,
                                stock.from_warehouse_name,
                                stock.to_warehouse_name,
                                stock.quantity,
                            ])
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-history').DataTable({
                            data: data_table,
                            destroy: true, // Hủy bảng cũ nếu có để tái tạo lại bảng mới
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


            // Thêm sản phẩm vào bảng
            $(document).on('click', '.action-btn', function() {
                $('.action-btn').removeClass('active');
                $(this).addClass('active');
                action = $(this).data('action');
                type = $('#Type').val();

                loadInitialData(action, type);
            });


            $(document).on('click', '#add-product', function() {
                let product_id = $('#ID_SP').val();
                var ID_SP = $('#ID_SP option:selected').text();
                var name = $('#name option:selected').text();
                let warehouse_1_id = $('#warehouse_1').val();

                let warehouse_2 = $('#warehouse_2 option:selected').text();
                let warehouse_2_id = $('#warehouse_2').val();
                let quantity = parseInt($('#quantity').val(), 10);
                let maxQuantity = parseInt($('#quantity').attr('max'), 10);


                if (!product_id || !warehouse_1_id || !warehouse_2_id || !quantity) {
                    alert("Vui lòng điền đầy đủ thông tin.");
                    return;
                }

                let selectedProduct = allProducts.find(p => p.id == product_id);
                var selectedWarehouse = warehouseArray.find(p => p.id == warehouse_1_id);
                let warehouse_1 = selectedWarehouse.name;
                var imageUrl = selectedProduct.Image ? "{{ asset('') }}/" +
                    selectedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}";
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
                    $(editingRow).find('td').eq(1).text(ID_SP).data('product_id', product_id); // Lưu ID kho
                    $(editingRow).find('td').eq(2).text(name).data('product_id', product_id); // Lưu ID kho
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
                        '<button class="btn btn-warning btn-sm edit-product">Sửa</button> ' +
                        '<button class="btn btn-danger btn-sm remove-product">Xóa</button>' +
                        '</td>' +
                        '</tr>';
                    $('#table-result tbody').append(newRow);
                }

                reset_form();
            });

            // Sửa dòng trong bảng
            $(document).on('click', '.edit-product', function(e) {
                event.preventDefault();
                var row = $(this).closest('tr');
                var product_id = row.find('td').eq(1).data('product-id'); // Lấy ID 
                var warehouse_1 = row.find('td').eq(3).data('warehouse-id'); // Lấy ID kho chuyển
                var warehouse_2 = row.find('td').eq(4).data('warehouse-id'); // Lấy ID kho nhận
                var quantity = row.find('td').eq(5).text();


                var selectedProduct = allProducts.find(product => product.id === product_id);
                // console.log(selectedProduct);

                if (selectedProduct) {
                    // Điền dữ liệu vào form
                    $('#ID_SP').val(product_id).trigger('change');
                    $('#name').val(product_id).trigger('change');
                    $('#Type').val(selectedProduct.Type).trigger(
                        'change'); // Điền đúng Type vào trường #Type
                    $('#warehouse_1').val(warehouse_1).trigger('change');
                    $('#warehouse_2').val(warehouse_2).trigger('change');
                    $('#quantity').val(quantity);
                    $('#image_prod').attr('src', selectedProduct.Image ? "{{ asset('') }}/" +
                        selectedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                }
                // Lưu dòng đang sửa
                editingRow = row;

                // Thay nút "Thêm sản phẩm" thành "Cập nhật"
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
                    alert("Không có dữ liệu trong bảng. Vui lòng thêm sản phẩm trước khi lưu.");
                    return; // Dừng thực hiện nếu bảng trống
                }
                var products = [];
                var warehouse_id;
                var To;
                $('#table-result tbody tr').each(function() {
                    var row = $(this);
                    if (action == 'Import') {
                        warehouse_id = row.find('td:nth-child(4)').data('warehouse-id');
                        To = row.find('td:nth-child(5)').data('warehouse-id');
                    } else {
                        warehouse_id = row.find('td:nth-child(4)').data('warehouse-id');
                        To = row.find('td:nth-child(5)').data('warehouse-id');
                    }
                    products.push({
                        product_id: row.find('td:nth-child(2)').data('product-id'),
                        warehouse_id: warehouse_id,
                        To: To,
                        quantity: row.find('td:nth-child(6)').text(),
                        action: action
                    });
                });

                console.log(products);
                // Gửi dữ liệu qua AJAX
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
                            var success = action + ' ' + response.success;
                            toastr.success(success);
                            reset_form();
                            $('#table-result tbody').html('');
                            loadInitialData(action, type);
                            show_historty();
                        }
                    },
                    error: function() {
                        alert("Có lỗi xảy ra khi nhập kho.");
                    }
                });
            });


            show_historty();
            loadInitialData(action, type);
        });
    </script>
@endsection
