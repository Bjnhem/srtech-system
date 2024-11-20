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
                <button type="button" class="btn btn-success" id="save">Save</button>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="">

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
                        <div class="col-sm-6 col-xl-4 mb-3 bottommargin-sm">
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
            // var product_JIG = [];
            // var product_MRO = [];
            // var product_SET = [];
            // var product_TSCD = [];
            // var product_Spartpart = [];
            var product = [];
            var IN = [];
            var OUT = [];

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
                        id: product.ID_SP,
                        text: product.name
                    }))
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
                        id: product.ID_SP,
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
                        $('#ID_SP').val(matchedProduct.ID_SP).trigger('change');
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                    }
                });

                // Khi chọn ID_SP, tự động điền name
                $('#ID_SP').on('select2:select', function(e) {
                    let selectedID = e.params.data.text;
                    let matchedProduct = filteredProducts.find(p => p.ID_SP === selectedID);
                    if (matchedProduct) {
                        $('#name').val(matchedProduct.ID_SP).trigger('change');
                        $('#Type').val(matchedProduct.Type).trigger('change'); // Điền Type
                    }
                });
            }



            // Xử lý dữ liệu kho (warehouse)
            function handleWarehouseData(warehouses) {
                let OUT = [];
                let IN = [];
                $('#warehouse_1, #warehouse_2').empty();

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
                    if (warehouse.status === "OUT") OUT.push(warehouse.name);
                    if (warehouse.status === "IN") IN.push(warehouse.name);
                });

                // Gắn autocomplete cho warehouse
                initAutocomplete('#warehouse_1', OUT);
                initAutocomplete('#warehouse_2', IN);
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
            let editingRow = null; // Biến lưu trữ dòng đang được chỉnh sửa

            $(document).on('click', '#add-product', function() {
                var ID_SP = $('#ID_SP').val();
                var name = $('#name option:selected').text();
                var Type = $('#Type').val();
                var warehouse_1 = $('#warehouse_1').val();
                var warehouse_2 = $('#warehouse_2').val();
                var quantity = $('#quantity').val();

                // Kiểm tra dữ liệu trước khi thêm vào bảng
                if (!ID_SP || !name || !Type || !warehouse_1 || !warehouse_2 || !quantity) {
                    alert("Vui lòng điền đầy đủ thông tin.");
                    return;
                }

                // Nếu đang chỉnh sửa, cập nhật dòng hiện tại
                if (editingRow) {
                    $(editingRow).find('td').eq(1).text(ID_SP);
                    $(editingRow).find('td').eq(2).text(name);
                    $(editingRow).find('td').eq(3).text(warehouse_1);
                    $(editingRow).find('td').eq(4).text(warehouse_2);
                    $(editingRow).find('td').eq(5).text(quantity);

                    // Đặt lại trạng thái "Sửa" và "Thêm sản phẩm"
                    $('#add-product').text('Thêm sản phẩm');
                    editingRow = null;
                } else {
                    // Thêm một hàng vào bảng
                    var newRow = '<tr>' +
                        '<td><img src="/path/to/image/' + ID_SP +
                        '.jpg" alt="Hình ảnh sản phẩm" width="50"></td>' +
                        '<td>' + ID_SP + '</td>' +
                        '<td>' + name + '</td>' +
                        '<td>' + warehouse_1 + '</td>' +
                        '<td>' + warehouse_2 + '</td>' +
                        '<td>' + quantity + '</td>' +
                        '<td>' +
                        '<button class="btn btn-warning btn-sm edit-product">Sửa</button> ' +
                        '<button class="btn btn-danger btn-sm remove-product">Xóa</button>' +
                        '</td>' +
                        '</tr>';
                    $('#table-result tbody').append(newRow);

                    // $('#name').empty();
                    // $('#name').append($('<option>', {
                    //     value: '',
                    //     text: '-- Chọn sản phẩm --'
                    // }));
                    // // Cập nhật dropdown cho ID_SP
                    // $('#ID_SP').empty();
                    // $('#ID_SP').append($('<option>', {
                    //     value: '',
                    //     text: '-- Chọn ID --'
                    // }));
                }

                // Reset form sau khi thêm hoặc cập nhật
                // $('#ID_SP').val('');
                // $('#name').val('');
                $('#ID_SP').val('').trigger('change');
                $('#name').val('').trigger('change');
                $('#Type').val('All');
                $('#warehouse_1').val('');
                $('#warehouse_2').val('');
                $('#quantity').val('');
            });

            $(document).on('click', '.edit-product', function(e) {
                event.preventDefault();
                var row = $(this).closest('tr');
                var ID_SP = row.find('td').eq(1).text();
                var name = row.find('td').eq(2).text();
                var warehouse_1 = row.find('td').eq(3).text();
                var warehouse_2 = row.find('td').eq(4).text();
                var quantity = row.find('td').eq(5).text();
                console.log(ID_SP);
                console.log(name);
                var selectedProduct = allProducts.find(product => product.ID_SP === ID_SP);

                if (selectedProduct) {
                    // Điền dữ liệu vào form
                    $('#ID_SP').val(selectedProduct.ID_SP).trigger('change');
                    $('#name').val(selectedProduct.ID_SP).trigger(
                    'change'); // Nếu bạn muốn điền tên sản phẩm vào name
                    $('#Type').val(selectedProduct.Type).trigger(
                    'change'); // Điền đúng Type vào trường #Type
                    $('#warehouse_1').val(warehouse_1).trigger('change');
                    $('#warehouse_2').val(warehouse_2).trigger('change');
                    $('#quantity').val(quantity);
                }


                // Điền dữ liệu vào form
                // $('#ID_SP').val(ID_SP).trigger('change');
                // $('#name').val(ID_SP).trigger('change');
                // $('#Type').val($('#ID_SP').find("option:selected").data('Type')).trigger('change');
                // $('#warehouse_1').val(warehouse_1).trigger('change');
                // $('#warehouse_2').val(warehouse_2).trigger('change');
                // $('#quantity').val(quantity);

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

                var products = [];
                $('#table-result tbody tr').each(function() {
                    var row = $(this);
                    products.push({
                        ID_SP: row.find('td:nth-child(2)').text(),
                        name: row.find('td:nth-child(3)').text(),
                        From: row.find('td:nth-child(4)').text(),
                        To: row.find('td:nth-child(5)').text(),
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
                        alert("Nhập kho thành công!");
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
