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
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="tab-pane fade show active " id="check-list" role="tabpanel" aria-labelledby="check-list-1" tabindex="0">
        <div class="card table-responsive" style="border: none">
            <div class="card-header">
                <h2>Nhập Kho</h2>
                <button type="button" class="btn btn-success" id="save">Save</button>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">

                    <div class="row">
                        <div class="col-2">

                            <div class="form-group col-6 d-flex justify-content-center" style="width: 40vh">
                                {{-- <label for="name">Hình ảnh:</label> --}}
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
            var table_name = 'Product';
            var table = '#table-result';
            let title_add = "Add sản phẩm";
            let title_edit = "Edit sản phẩm";
            var tables;
            let id;

            // Biến toàn cục lưu dữ liệu sản phẩm ban đầu
            let allProducts = [];
            let productByType = {};

            function show_data_check() {
                var type = $('#Type').val();
                var ID_SP = $('#ID_SP').val();

                // Nếu dữ liệu đã được tải trước đó, chỉ cần lọc lại
                if (allProducts.length > 0) {
                    updateProductDropdown(type);
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('WareHouse.show.master') }}",
                    dataType: "json",
                    data: {
                        Type: type,
                        ID_SP: ID_SP
                    },
                    success: function(response) {
                        // Lưu trữ toàn bộ dữ liệu sản phẩm vào biến toàn cục
                        allProducts = response.product;

                        // Chia nhóm sản phẩm theo loại (Type)
                        productByType = groupProductsByType(allProducts);

                        // Cập nhật danh sách sản phẩm dựa trên type hiện tại
                        updateProductDropdown(type);

                        // Các xử lý khác (như autocomplete kho)
                        handleWarehouseData(response.warehouse);
                    }
                });
            }

            // Hàm chia nhóm sản phẩm theo type
            function groupProductsByType(products) {
                let grouped = {};
                products.forEach(product => {
                    if (!grouped[product.Type]) {
                        grouped[product.Type] = [];
                    }
                    grouped[product.Type].push(product);
                });
                return grouped;
            }

            // Hàm cập nhật Select2 dựa trên type
            function updateProductDropdown(type) {
                let filteredProducts = type && productByType[type] ? productByType[type] : allProducts;

                // Cập nhật dropdown cho name
                $('#name').empty();
                $('#name').append($('<option>', {
                    value: '',
                    text: '-- Chọn sản phẩm --'
                }));
                $('#name').select2({
                    placeholder: "Tìm kiếm sản phẩm",
                    allowClear: true,
                    data: filteredProducts.map(product => ({
                        id: product.id,
                        text: product.name,

                    })),

                });

                // Cập nhật dropdown cho ID_SP
                $('#ID_SP').empty();
                $('#ID_SP').append($('<option>', {
                    value: '',
                    text: '-- Chọn ID --'
                }));
                $('#ID_SP').select2({
                    placeholder: "Tìm kiếm ID",
                    allowClear: true,
                    data: filteredProducts.map(product => ({
                        id: product.id,
                        text: product.ID_SP


                    }))
                });

                // Gắn sự kiện thay đổi giá trị
                setupSelect2Events(filteredProducts);


            }

            // Hàm thiết lập sự kiện đồng bộ giữa name và ID_SP
            function setupSelect2Events(filteredProducts) {

                // Khi chọn name, tự động điền ID_SP
                $('#name').on('select2:select', function(e) {
                    let selectedName = e.params.data.text;
                    let matchedProduct = filteredProducts.find(p => p.name === selectedName);
                    if (matchedProduct) {
                        $('#ID_SP').val(matchedProduct.id).trigger('change');
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type

                        $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                            matchedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                    }
                });

                // Khi chọn ID_SP, tự động điền name
                $('#ID_SP').on('select2:select', function(e) {
                    let selectedID = e.params.data.text;
                    let matchedProduct = filteredProducts.find(p => p.ID_SP === selectedID);
                    if (matchedProduct) {
                        $('#name').val(matchedProduct.id).trigger('change');
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                        $('#image_prod').attr('src', matchedProduct.Image ? "{{ asset('') }}/" +
                            matchedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}");
                    }
                });

                let forceFocusFn = function() {
                    // Gets the search input of the opened select2
                    var searchInput = document.querySelector('.select2-container--open .select2-search__field');
                    // If exists
                    if (searchInput)
                        searchInput.focus(); // focus
                };

                // Every time a select2 is opened
                $(document).on('select2:open', () => {
                    // We use a timeout because when a select2 is already opened and you open a new one, it has to wait to find the appropiate
                    setTimeout(() => forceFocusFn(), 200);
                });

            }

            // Xử lý dữ liệu kho (warehouse)
            function handleWarehouseData(warehouses) {
                let OUT = [];
                let IN = [];
                $('#warehouse_1, #warehouse_2').empty(); // Xóa dữ liệu cũ

                // Thêm tùy chọn mặc định
                $('#warehouse_1').append($('<option>', {
                    value: "",
                    text: "Chọn kho chuyển"
                }));
                $('#warehouse_2').append($('<option>', {
                    value: "",
                    text: "Chọn kho nhận"
                }));

                // Phân loại kho
                warehouses.forEach(warehouse => {
                    if (warehouse.status === "OUT") OUT.push({
                        id: warehouse.id,
                        text: warehouse.name
                    });
                    if (warehouse.status === "IN") IN.push({
                        id: warehouse.id,
                        text: warehouse.name
                    });
                });

                // Cập nhật select2 cho warehouse_1 và warehouse_2
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
            }

            // Hàm gắn autocomplete
            function initAutocomplete(selector, data) {
                $(selector).autocomplete({
                    source: function(request, response) {
                        var term = request.term.toLowerCase();
                        var filtered = data.filter(item => item.toLowerCase().indexOf(term) !== -1);
                        response(filtered.slice(0, 10));
                    },
                    minLength: 1,
                    focus: function(event, ui) {
                        event.preventDefault();
                    },
                    select: function(event, ui) {
                        $(selector).val(ui.item.value);
                        return false;
                    }
                });
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

            show_data_check();
            let editingRow = null; // Biến lưu trữ dòng đang được chỉnh sửa

            $(document).on('click', '#add-product', function() {
                var product_id = $('#ID_SP').val();
                var selectedProduct = allProducts.find(p => p.id == product_id);
                if (!selectedProduct) {
                    alert("Không tìm thấy sản phẩm. Vui lòng kiểm tra lại!");
                    return;
                }

                var ID_SP = $('#ID_SP option:selected').text();
                var name = $('#name option:selected').text();
                var Type = $('#Type').val();
                var warehouse_1 = $('#warehouse_1 option:selected').text();
                var warehouse_1_id = $('#warehouse_1').val();
                var warehouse_2 = $('#warehouse_2 option:selected').text();
                var warehouse_2_id = $('#warehouse_2').val();
                var quantity = $('#quantity').val();

                // Kiểm tra dữ liệu trước khi thêm vào bảng
                if (!ID_SP || !name || !Type || !warehouse_1 || !warehouse_2 || !quantity) {
                    alert("Vui lòng điền đầy đủ thông tin.");
                    return;
                }

                var imageUrl = selectedProduct.Image ? "{{ asset('') }}/" +
                    selectedProduct.Image : "{{ asset('checklist-ilsung/image/gallery.png') }}";


                // Nếu đang chỉnh sửa, cập nhật dòng hiện tại
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
                    // Thêm một hàng vào bảng
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

            $(document).on('click', '.edit-product', function(e) {
                event.preventDefault();
                var row = $(this).closest('tr');
                var product_id = row.find('td').eq(1).data('product-id'); // Lấy ID 
                var warehouse_1 = row.find('td').eq(3).data('warehouse-id'); // Lấy ID kho chuyển
                var warehouse_2 = row.find('td').eq(4).data('warehouse-id'); // Lấy ID kho nhận
                var quantity = row.find('td').eq(5).text();


                var selectedProduct = allProducts.find(product => product.id === product_id);

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

            $(document).on('click', '.remove-product', function() {
                // Xóa dòng khỏi bảng
                $(this).closest('tr').remove();
            });

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
                        From: row.find('td:nth-child(4)').text(),
                        warehouse_id: row.find('td:nth-child(5)').data('warehouse-id'),
                        quantity: row.find('td:nth-child(6)').text(),
                    });
                });

                // Gửi dữ liệu qua AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('warehouse.import') }}",
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

                        }
                    },
                    error: function() {
                        alert("Có lỗi xảy ra khi nhập kho.");
                    }
                });
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
