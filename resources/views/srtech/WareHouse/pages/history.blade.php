@extends('srtech.WareHouse.layouts.WareHouse_layout')
@section('content')
    <div class="card form-card">
        <div class="card-header">
            <h3 class="mb-0">LỊCH SỬ NHẬP XUẤT</h3>
        </div>

        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-lg-4 mb-3">
                    <label for="">Date Search:</label>
                    <div class="input-daterange component-datepicker input-group">
                        <input type="text" value="" class="form-control text-start" id="date_from"
                            placeholder="YYYY-MM-DD" autocomplete="off">
                        <div class="input-group-text">To</div>
                        <input type="text" value="" class="form-control text-start" id="date_to"
                            placeholder="YYYY-MM-DD" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="Type" class="form-label">Phân loại:</label>
                    <select name="Type" id="Type" class="form-select">
                        <option value="All">All</option>
                        <option value="JIG">JIG</option>
                        <option value="MRO">MRO</option>
                        <option value="Spare part">Spare part</option>
                        <option value="SET">SET</option>
                        <option value="TSCD">TSCD</option>
                    </select>
                </div>

                <div class="col-lg-2 mb-3">
                    <label for="warehouse" class="form-label">Chọn kho:</label>
                    <select name="warehouse" id="warehouse" class="form-select">
                        {{-- <option value="">-- Chọn kho --</option> --}}
                    </select>
                </div>

                <div class="col-lg-2 mb-3">
                    <label for="ID_SP" class="form-label">Code ID:</label>
                    <select name="ID_SP" id="ID_SP" class="form-select">
                        <option value="">Chọn Code</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="name" class="form-label">Tên sản phẩm:</label>
                    <select name="name" id="name" class="form-select w-100">
                        <option value="">Chọn sản phẩm</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover" id="table-history-detail" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>Ngày</th>
                            <th>Type</th>
                            <th>Nhập/Xuất</th>
                            <th>Mã ID_SP</th>
                            <th>Sản Phẩm</th>
                            <th>Kho</th>
                            <th>Remark</th>
                            <th>Số Lượng</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin-js')
    <script src="{{ asset('checklist-ilsung/html5.min.js') }}"></script>
    <script src="{{ asset('SR-TECH/js/exceljs.min.js') }}"></script>>
    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>


    <script>
        $(document).ready(function() {
            let action = "Export";
            let product_id = '';
            let date_from;
            let date_to;
            let type;
            // Hàm tải dữ liệu từ server và hiển thị
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_from,#date_to').val(date);


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
                placeholder: "Chọn kho",
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
                show_historty();

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
                show_historty();

            });

            $('#warehouse').on('select2:select', function(e) {
                // updateWarehouseDropdown();
                show_historty();

            });

            // Khi xóa sản phẩm theo tên
            $('#name,#ID_SP').on('select2:unselect', function(e) {
                $('#ID_SP,#name').val(null).trigger('change');
                show_stock_by_product();
            });

            $('#warehouse').on('select2:unselect', function(e) {
                $('#warehouse').val(null).trigger('change');
                show_historty();
            });

            // Xử lý khi thay đổi bộ lọc
            $("#Type").on("change", function() {
                $('#ID_SP,#name,#warehouse').val(null).trigger('change');
                show_historty();

            });

            $("#date_from,#date_to").on("change", function() {
                show_historty();

            });

            // function updateWarehouseDropdown() {
            //     event.preventDefault();
            //     $('#warehouse').val(null).trigger('change');
            //     $('#warehouse').select2('data', null); // Clear dữ liệu hiện tại

            // }

            function show_historty() {
                var type = $('#Type').val();
                var product_id = $('#name').val();
                var warehouse_id = $('#warehouse').val();
                var date_from = $('#date_from').val();
                var date_to = $('#date_to').val();
                // Gửi yêu cầu lấy lịch sử
                $.ajax({
                    url: "{{ route('warehouse.data.history') }}",
                    method: 'get',
                    data: {
                        type: type,
                        product_id: product_id,
                        warehouse_id: warehouse_id,
                        date_from: date_from,
                        date_to: date_to
                    },
                    success: function(data) {
                        // if (data.history && data.history.length > 0) {
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
                                    typeCell = stock.type;
                            }
                            data_table.push([
                                stock.created_at,
                                stock.product_type,
                                typeCell,
                                stock.ID_SP,
                                stock.product_name,
                                stock.warehouse_name,
                                stock.Remark,
                                stock.quantity,
                            ]);
                        });

                        // Chèn dữ liệu vào bảng

                        $('#table-history-detail').DataTable({
                            data: data_table,
                            destroy: true,
                            ordering: false,
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'excelHtml5',
                                text: 'Tải Excel',
                                title: 'Lịch sử nhập xuất',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            }],
                            language: {
                                emptyTable: "Không có dữ liệu phù hợp" // Văn bản tùy chỉnh khi bảng không có dữ liệu
                            }
                        });
                        // } else {
                        //     alert('Không có lịch sử nhập xuất nào phù hợp.');
                        // }
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi tải lịch sử:', error);
                        alert('Không thể tải lịch sử, vui lòng thử lại.');
                    }
                });
            }


            show_historty();

        });
    </script>
@endsection
