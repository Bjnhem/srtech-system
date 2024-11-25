@extends('ilsung.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
        <div class="card table-responsive" style="border: none">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Quản lý tồn kho</h2>
            </div>

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
                                <div class="col-sm-6 col-xl-6 mb-3">
                                    <span>Phân loại:</span>
                                    <select name="Type" id="Type" class="form-select">
                                        <option value="All">All</option>

                                    </select>
                                </div>
                                <div class="col-sm-6 col-xl-6 mb-3">
                                    <label for="warehouse_id">Kho chuyển</label>
                                    <select name="warehouse_id" id="warehouse" class="form-control">
                                    </select>
                                </div>
                                <div class="col-sm-6 col-xl-6 mb-3 bottommargin-sm">
                                    <label for="">Code ID</label>
                                    <div class="input-group mb-3">
                                        {{-- <input type="text" class="form-control" placeholder="Code sản phẩm" id="ID_SP"> --}}
                                        <select name="ID_SP" id="ID_SP" class="form-select">
                                            <option value="">Chọn Code</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xl-6 mb-3">
                                    <label for="name">Tên sản phẩm</label>
                                    {{-- <input type="text" class="form-control" name="name" id="name"> --}}
                                    <select name="name" id="name" class="form-select">
                                        <option value="">Chọn sản phẩm</option>
                                    </select>
                                </div>




                            </div>
                        </div>
                    </div>
                    {{-- <h3>Sản phẩm đã chọn</h3> --}}
                    <table class="table table-bordered table-hover table-sm " id="table-result" style="width:100%">
                        <thead class="table-success">
                            <tr>
                                <th>Image</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Kho</th>
                                <th>Q'ty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sẽ được render bằng JavaScript -->
                        </tbody>
                    </table>
                </form>

                <!-- Modal hiển thị lịch sử nhập/xuất -->

                <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl"> <!-- modal-xl để modal rộng hơn -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="historyModalLabel">Lịch sử Nhập/Xuất Kho</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Bảng responsive -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Type</th>
                                                <th>ID_SP</th>
                                                <th>Name</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Số lượng</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody id="historyTableBody">
                                            <!-- Dữ liệu sẽ được chèn tại đây -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


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
                // var type = $('#Type').val();

                // Hàm tải lại danh sách kho, sản phẩm và tên khi người dùng chọn loại sản phẩm (type)
                function loadFilters() {
                    let currentType = $('#Type').val();
                    let currentProductID = $('#ID_SP').val();
                    let currentName = $('#name').val();
                    let currentWarehouse = $('#warehouse').val();

                    $.ajax({
                        url: "{{ route('warehouse.stock.data') }}",
                        method: 'GET',
                        data: {
                            type: currentType,
                            product_id: currentProductID,
                            name: currentName,
                            warehouse: currentWarehouse
                        },
                        success: function(data) {
                            console.log(data);
                            let warehouseOptions = [];
                            let typeOption = [];
                            let productID = [];
                            let productName = [];
                            data.Type.forEach(function(product) {

                                $('#Type').empty().append($('<option>', {
                                    value: 'All',
                                    text: 'All'
                                }));
                                $('#Type').append($('<option>', {
                                    value: product.type,
                                    text: product.type
                                }));

                            });

                            // Cập nhật lại danh sách kho
                            data.warehouses.forEach(function(warehouse) {
                                warehouseOptions.push({
                                    id: warehouse.warehouse_id,
                                    text: warehouse.name
                                });

                            });
                            console.log(warehouseOptions);
                            // Cập nhật lại danh sách sản phẩm

                            data.products.forEach(function(product) {
                                productID.push({
                                    id: product.product_id,
                                    text: product.ID_SP
                                });
                                productName.push({
                                    id: product.product_id,
                                    text: product.name
                                });
                            });

                            // Hiển thị kết quả stock vào bảng
                            let stockRows = '';

                            data.stock.forEach(function(stock) {
                                var imageUrl = stock.Image ? "{{ asset('') }}/" +
                                    stock.Image :
                                    "{{ asset('checklist-ilsung/image/gallery.png') }}";
                                stockRows +=
                                    '<tr>' +
                                    '<td><img src="' + imageUrl +
                                    '" alt="Hình ảnh sản phẩm" width="40"></td>' +
                                    '<td data-product-id="' + stock.product_id + '">' + stock
                                    .ID_SP + '</td>' +
                                    '<td data-product-id="' + stock.product_id + '">' + stock
                                    .product_name +
                                    '</td>' +
                                    '<td data-warehouse-id="' + stock.warehouse_id + '">' + stock
                                    .warehouse_name + '</td>' +
                                    '<td>' + stock.stock + '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-warning btn-sm edit-product">History</button> ' +
                                    '</td>' +
                                    '</tr>';

                            });
                            $('#table-result tbody').html(stockRows);
                            $('#ID_SP, #name,#warehouse').empty().append($('<option>', {
                                value: '',
                                text: '-- Chọn kho --'
                            }));

                            // Gắn danh sách vào dropdown
                            $('#ID_SP').select2({
                                placeholder: "Tìm kiếm ID",
                                allowClear: true,
                                data: productID

                            });

                            // Gắn danh sách vào dropdown
                            $('#name').select2({
                                placeholder: "Tìm kiếm sản phẩm",
                                allowClear: true,
                                data: productName

                            });
                            $('#warehouse').select2({
                                placeholder: "Chọn kho",
                                allowClear: true,
                                data: warehouseOptions,
                            });

                            if (currentType) {
                                $('#Type').val(currentType); // Gán giá trị mà không trigger 'change'
                            }
                            if (currentProductID) {
                                $('#ID_SP').val(currentProductID); // Gán giá trị mà không trigger 'change'
                            }
                            if (currentName) {
                                $('#name').val(currentName); // Gán giá trị mà không trigger 'change'
                            }
                            if (currentWarehouse) {
                                console.log(currentWarehouse);
                                $('#warehouse').val(
                                    currentWarehouse); // Gán giá trị mà không trigger 'change'
                            }

                            // Optional: nếu muốn trigger 'change' chỉ một lần duy nhất sau khi tất cả dropdowns đã được cập nhật
                            // $('#Type').trigger('change');
                            // $('#ID_SP').trigger('change');
                            // $('#name').trigger('change');
                            // $('#warehouse').trigger('change');



                        }
                    });
                }

                // Lắng nghe sự kiện thay đổi của dropdown và cập nhật dữ liệu
                $('#Type, #ID_SP, #name, #warehouse').on('change', function(e) {
                    e.preventDefault(); // Ngăn chặn form submit mặc định
                    loadFilters();
                    // console.log(warehouse);
                    // $('#Type').val(type);
                    // $('#warehouse').val(warehouse).trigger('change');

                });

                // Lần đầu tiên load dữ liệu
                loadFilters();


                function loadInitialData(action, type) {
                    type = $('#Type').val();
                    let product_id = $('#ID_SP').val();
                    let name = $('#name').val();
                    let warehouse = $('#warehouse').val();
                    $.ajax({
                        type: "GET",
                        url: "{{ route('WareHouse.show.master.transfer') }}", // Route lấy danh sách sản phẩm có trong kho
                        dataType: "json",
                        data: {
                            Type: type
                        },
                        success: function(response) {
                            // Lưu dữ liệu sản phẩm và kho
                            Products_all = Object.values(response.products_all);
                            allProducts = Object.values(response.products_search);
                            productWarehouses = groupWarehousesByProduct(allProducts, type,
                                action);
                            warehouseArray = response.warehouse;
                            let Type_list = response.Type;
                            console.log(Type_list);
                            // Cập nhật danh sách sản phẩm vào dropdown
                            updateProductDropdown(productWarehouses);
                            updateWarehouseDropdown();
                            $('#Type').empty().append($('<option>', {
                                value: '',
                                text: 'All'
                            }));

                            Type_list.forEach(types => {
                                $('#Type').append($('<option>', {
                                    value: types.type,
                                    text: types.type
                                }));
                            });


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
                        filteredProducts = Object.values(products).filter(product => product.Type ===
                            selectedType);
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
                                const warehouses = Products[productType][
                                    productId
                                ]; // Lấy danh sách kho của sản phẩm

                                // Duyệt qua các kho của sản phẩm và thêm vào mảng products
                                warehouses.forEach(warehouse => {
                                    let matchedProduct = Products_all.find(p => p.id === parseInt(
                                        productId));
                                    if (!seenProductIds.has(productId)) {
                                        products.push({
                                            id: productId, // Sử dụng productId làm id
                                            name: matchedProduct
                                                .name, // Dùng name của matchedProduct
                                            ID_SP: matchedProduct
                                                .ID_SP // Dùng ID_SP của matchedProduct
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
                        let matchedProduct = filteredProducts.find(p => p.id === parseInt(
                            selectedID));
                        if (matchedProduct) {
                            $('#ID_SP').val(selectedID).trigger('change');
                        }
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                        $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                            matchedProduct.Image :
                            "{{ asset('checklist-ilsung/image/gallery.png') }}");
                    });

                    $('#ID_SP').on('select2:select', function(e) {
                        let selectedID = e.params.data.id;
                        let matchedProduct = filteredProducts.find(p => p.id === parseInt(
                            selectedID));
                        $('#name').val(selectedID).trigger('change');
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                        $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                            matchedProduct.Image :
                            "{{ asset('checklist-ilsung/image/gallery.png') }}");
                    });



                }

                // Cập nhật danh sách kho chuyển dựa trên sản phẩm được chọn
                function updateWarehouseDropdown() {
                    event.preventDefault();
                    let OUT = [];
                    let IN = [];
                    let data_kho_stock = [];

                    $('#warehouse_1').empty().append($('<option>', {
                        value: '',
                        text: '-- Chọn kho chuyển --'
                    }));
                    warehouseArray.forEach(warehouse => {
                        if (warehouse.status === "IN")
                            IN.push({
                                id: warehouse.id,
                                text: warehouse.name
                            });
                    });

                    for (const productType in productWarehouses) {
                        // Lấy danh sách kho của sản phẩm
                        productWarehouses[productType].forEach(productWarehouse => {
                            // Chỉ cần lặp qua danh sách kho của sản phẩm và thêm chúng vào dropdown
                            data_kho_stock.push({
                                id: productWarehouse.warehouse_id,
                                text: `${productWarehouse.warehouse_name} (Tồn: ${productWarehouse.available_qty})`, // Hiển thị tên kho và số lượng tồn
                                'data-quantity': productWarehouse.available_qty
                            });

                        });

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
                    // $('#warehouse_1').select2({
                    //     placeholder: "Chọn kho chuyển",
                    //     allowClear: true,
                    //     data: IN
                    // });


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
                        alert("Số lượng vượt quá tồn kho. Vui lòng kiểm tra lại.");
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
                            '<button class="btn btn-warning btn-sm edit-product">Sửa</button> ' +
                            '<button class="btn btn-danger btn-sm remove-product">Xóa</button>' +
                            '</td>' +
                            '</tr>';
                        $('#table-result tbody').append(newRow);
                    }

                    reset_form();
                });

                // Sửa dòng trong bảng
                $(document).on('click', '.edit-product', function() {
                    event.preventDefault();
                    // Lấy `product_id` và `warehouse_id` từ thuộc tính của nút
                    let productId = $(this).closest('tr').find('td[data-product-id]').data('product-id');
                    let warehouseId = $(this).closest('tr').find('td[data-warehouse-id]').data('warehouse-id');

                    // Gửi yêu cầu lấy lịch sử
                    $.ajax({
                        url: "{{ route('warehouse.stock.data.history') }}",
                        method: 'get',
                        data: {
                            product_id: productId,
                            warehouse_id: warehouseId
                        },
                        success: function(data) {
                            // Xử lý dữ liệu và hiển thị trong modal
                            let historyRows = '';
                            data.forEach(function(history) {
                                historyRows += `
                    <tr>
                        <td>${new Date(history.created_at).toLocaleDateString()}</td>
                            <td>${history.type}</td>
                        <td>${history.ID_SP}</td>
                        <td>${history.product_name}</td>
                        <td>${history.from_warehouse_name || 'N/A'}</td>
                        <td>${history.to_warehouse_name || 'N/A'}</td>
                        <td>${history.quantity}</td>
                        <td>${history.remark || ''}</td>
                    </tr>`;
                            });

                            // Chèn dữ liệu vào bảng trong modal
                            $('#historyTableBody').html(historyRows);

                            // Hiển thị modal
                            $('#historyModal').modal('show');
                        },
                        error: function() {
                            alert('Không thể tải lịch sử, vui lòng thử lại.');
                        }
                    });
                });

                // $(document).on('click', '.edit-product', function(e) {
                //     event.preventDefault();
                //     var row = $(this).closest('tr');
                //     var product_id = row.find('td').eq(1).data('product-id'); // Lấy ID 
                //     var warehouse_1 = row.find('td').eq(3).data('warehouse-id'); // Lấy ID kho chuyển
                //     var warehouse_2 = row.find('td').eq(4).data('warehouse-id'); // Lấy ID kho nhận
                //     var quantity = row.find('td').eq(5).text();


                //     var selectedProduct = allProducts.find(product => product.id === product_id);
                //     // console.log(selectedProduct);

                //     if (selectedProduct) {
                //         // Điền dữ liệu vào form
                //         $('#ID_SP').val(product_id).trigger('change');
                //         $('#name').val(product_id).trigger('change');
                //         $('#Type').val(selectedProduct.Type).trigger(
                //             'change'); // Điền đúng Type vào trường #Type
                //         $('#warehouse_1').val(warehouse_1).trigger('change');
                //         $('#warehouse_2').val(warehouse_2).trigger('change');
                //         $('#quantity').val(quantity);
                //         $('#image_prod').attr('src', selectedProduct.Image ? "{{ asset('') }}/" +
                //             selectedProduct.Image :
                //             "{{ asset('checklist-ilsung/image/gallery.png') }}");
                //     }
                //     // Lưu dòng đang sửa
                //     editingRow = row;

                //     // Thay nút "Thêm sản phẩm" thành "Cập nhật"
                //     $('#add-product').text('Cập nhật');
                // });

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
                        if (action == 'import') {
                            warehouse_id = row.find('td:nth-child(5)').data('warehouse-id');
                            To = row.find('td:nth-child(4)').data('warehouse-id');
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
                            }
                        },
                        error: function() {
                            alert("Có lỗi xảy ra khi nhập kho.");
                        }
                    });
                });



                // loadInitialData(action, type);
            });
        </script>
    @endsection
