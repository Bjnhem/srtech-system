@extends('ilsung.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
        <div class="card table-responsive" style="border: none">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Quản lý kho</h2>
                <div class="btn-group" role="group" aria-label="Chọn hành động">
                    <button type="button" class="btn btn-outline-primary action-btn active" data-action="import">Nhập
                        kho</button>
                    <button type="button" class="btn btn-outline-primary action-btn" data-action="export">Xuất
                        kho</button>
                    <button type="button" class="btn btn-outline-primary action-btn" data-action="transfer">Chuyển
                        kho</button>
                </div>
            </div>
            {{-- <div class="card-header">
                <h2>Xuất Kho</h2>
                
                <button type="button" class="btn btn-success" id="save">Save</button>
            </div> --}}
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">

                    <div class="row">
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <div class="form-group text-center" style="width: 170px;">
                                <img src="{{ asset('checklist-ilsung/image/gallery.png') }}" alt="" id="image_prod"
                                    class="img-fluid img-thumbnail">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-sm-6 col-xl-2 mb-3">
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
                                <div class="col-sm-6 col-xl-3 mb-3 bottommargin-sm">
                                    <label for="">Code ID</label>
                                    <div class="input-group mb-3">
                                        {{-- <input type="text" class="form-control" placeholder="Code sản phẩm" id="ID_SP"> --}}
                                        <select name="ID_SP" id="ID_SP" class="form-select">
                                            <option value="">Chọn Code</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-7 mb-3">
                                    <label for="name">Tên sản phẩm</label>
                                    {{-- <input type="text" class="form-control" name="name" id="name"> --}}
                                    <select name="name" id="name" class="form-select">
                                        <option value="">Chọn sản phẩm</option>
                                    </select>
                                </div>

                                <br>


                                <div class="col-sm-6 col-xl-3 mb-3">
                                    <label for="warehouse_id_1">Kho chuyển</label>
                                    {{-- <input type="text" class="form-control" name="warehouse_1" id="warehouse_1"> --}}
                                    <select name="warehouse_1" id="warehouse_1" class="form-control">

                                    </select>
                                </div>
                                <div class=" col-sm-6 col-xl-3 mb-3">
                                    <label for="warehouse_id_2">Kho nhận</label>
                                    {{-- <input type="text" class="form-control" name="warehouse_2" id="warehouse_2"> --}}
                                    <select name="warehouse_2" id="warehouse_2" class="form-control"> </select>
                                </div>

                                <div class="col-sm-6 col-xl-3 mb-3">
                                    <label for="quantity">Số lượng</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                                </div>
                                <div class="col-sm-6 col-xl-3 mb-3">
                                    {{-- <label for="quantity_1">Action:</label> --}}
                                    <button type="button" class="btn btn-primary" id="add-product">Thêm sản phẩm</button>
                                    <button type="button" class="btn btn-success" id="save">Save</button>
                                </div>
                            </div>
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
                                <th>From</th>
                                <th>To</th>
                                <th>Q'ty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
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
            let action = 'export';
            var type = $('#Type').val();
            let Products;

            function loadInitialData(action, type) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('WareHouse.show.master.transfer') }}", // Route lấy danh sách sản phẩm có trong kho
                    dataType: "json",
                    data: {
                        Type: type
                    },
                    success: function(response) {
                        Products_all = Object.values(response.products_all);
                        reset_form()
                        // Lưu dữ liệu sản phẩm và kho
                        if (action == 'import') {
                            allProducts = Object.values(response.products_all);
                            // productByType = groupProductsByType(allProducts);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);


                        }
                        if (action == 'export') {
                            allProducts = Object.values(response.products_search);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);

                        }
                        if (action == 'transfer') {
                            allProducts = Object.values(response.products_search);
                            productWarehouses = groupWarehousesByProduct(allProducts, type, action);
                        }
                        warehouseArray = response.warehouse;

                        // console.log(warehouseArray);
                        console.log(productWarehouses);

                        // Cập nhật danh sách sản phẩm vào dropdown
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
                if (action == 'import') {
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
                console.log(product_id);
                console.log(action);
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
                if (action != 'import') {
                    for (const productType in productWarehouses) {
                        // Kiểm tra nếu tồn tại sản phẩm với ID đã chọn
                        if (productWarehouses[productType][product_id]) {

                            // Lấy danh sách kho của sản phẩm
                            productWarehouses[productType][product_id].forEach(productWarehouse => {
                                // Chỉ cần lặp qua danh sách kho của sản phẩm và thêm chúng vào dropdown
                                data_kho_stock.push({
                                    id: productWarehouse.warehouse_id,
                                    text: `${productWarehouse.warehouse_name} (Tồn: ${productWarehouse.available_qty})`, // Hiển thị tên kho và số lượng tồn
                                    'data-quantity': productWarehouse
                                        .available_qty
                                });

                            });
                            break; // Dừng vòng lặp khi tìm thấy sản phẩm
                        }
                    }
                    $('#warehouse_1').select2({
                        placeholder: "Chọn kho chuyển",
                        allowClear: true,
                        data: data_kho_stock
                    });
                    $('#warehouse_1').on('select2:select', function(e) {
                        let selectedOption = $(this).find('option:selected');
                        let maxQuantity = selectedOption.data('quantity');
                        $('#quantity').attr('max', maxQuantity);
                    });
                }



                switch (action) {
                    case 'import':
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
                    case 'export':
                        // Code xử lý cho Xuất kho
                        $('#warehouse_2').select2({
                            placeholder: "Chọn kho nhận",
                            allowClear: true,
                            data: OUT
                        });
                        break;
                    case 'transfer':
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
                $('#Type').val('All');
                $('#warehouse_1').val('').trigger('change');
                $('#warehouse_2').val('').trigger('change');
                $('#quantity').val('');
            }
            // Thêm sản phẩm vào bảng
            $(document).on('click', '.action-btn', function() {
                // Bỏ class 'active' khỏi tất cả các nút
                $('.action-btn').removeClass('active');
                // Thêm class 'active' vào nút được chọn
                $(this).addClass('active');
                // Lấy giá trị hành động từ thuộc tính data-action
                action = $(this).data('action');
                type = $('#Type').val();
      
                loadInitialData(action, type);
            });


            $(document).on('click', '#add-product', function() {
                let product_id = $('#ID_SP').val();
                var ID_SP = $('#ID_SP option:selected').text();
                var name = $('#name option:selected').text();
                let warehouse_1_id = $('#warehouse_1').val();
                let selectedProduct = allProducts.find(p => p.id == product_id);
                var selectedWarehouse = warehouseArray.find(p => p.id == warehouse_1_id);
                let warehouse_1 = selectedWarehouse.name;
                let warehouse_2 = $('#warehouse_2 option:selected').text();
                let warehouse_2_id = $('#warehouse_2').val();
                let quantity = parseInt($('#quantity').val(), 10);
                let maxQuantity = parseInt($('#quantity').attr('max'), 10);
                var imageUrl = selectedProduct.Image ? "{{ asset('') }}/" +
                    selectedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}";

                if (!product_id || !warehouse_1_id || !warehouse_2_id || !quantity) {
                    alert("Vui lòng điền đầy đủ thông tin.");
                    return;
                }

                if (quantity > maxQuantity) {
                    alert("Số lượng vượt quá tồn kho. Vui lòng kiểm tra lại.");
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
                    $('#add-product').text('Thêm sản phẩm');
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
                $('#table-result tbody tr').each(function() {
                    var row = $(this);
                    products.push({
                        product_id: row.find('td:nth-child(2)').data('product-id'),
                        warehouse_id: row.find('td:nth-child(4)').data('warehouse-id'),
                        To: row.find('td:nth-child(5)').data('warehouse-id'),
                        quantity: row.find('td:nth-child(6)').text(),
                    });
                });

                console.log(products);
                // Gửi dữ liệu qua AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('warehouse.export') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        products: products
                    },
                    success: function(response) {
                        // location.reload();
                        if (response.status == 200) {
                            toastr.success(response.success);
                            reset_form();
                            $('#table-result tbody').html('');

                            loadInitialData();

                        }
                    },
                    error: function() {
                        alert("Có lỗi xảy ra khi nhập kho.");
                    }
                });
            });
            loadInitialData(action, type);
        });
    </script>
@endsection
