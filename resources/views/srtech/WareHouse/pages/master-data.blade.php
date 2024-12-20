@extends('srtech.WareHouse.layouts.WareHouse_layout')

@section('content')
<div class="card form-card">
    <div class="card-header">
        <h3 class="mb-0">QUẢN LÝ DATA BASE</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 master-data">
                    <a href="{{ route('Warehouse.update.data.model') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="bg-info text-white rounded p-3">
                                        <img class="icon" src="{{ asset('SR-TECH/icon/smartphone.png') }}" alt="Model"
                                            width="30" height="30">
                                    </div>
                                    <div class="text-end">
                                        Danh sách model
                                        <h2 class="counter" id="model-count" style="visibility: visible;">
                                            {{ $modelCount }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 master-data">
                    <a href="{{ route('Warehouse.update.data.kho') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="bg-warning text-white rounded p-3">
                                        <img class="icon" src="{{ asset('SR-TECH/icon/warehouse.png') }}" alt="Warehouse"
                                            width="30" height="30">
                                    </div>
                                    <div class="text-end">
                                        Danh sách kho
                                        <h2 class="counter" id="warehouse-count" style="visibility: visible;">
                                            {{ $warehouseCount }}
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 master-data">
                    <a href="{{ route('Warehouse.update.data.sanpham') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="bg-success text-white rounded p-3">
                                        <img class="icon" src="{{ asset('SR-TECH/icon/machine.png') }}" alt="Product"
                                            width="30" height="30">
                                    </div>
                                    <div class="text-end">
                                        Sản phẩm
                                        <h2 class="counter" id="product-count" style="visibility: visible;">
                                            {{ $productCount }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('admin-js')
    <script>
        window.onload = function() {
            // startCounting();
        };

        function startCounting() {
            // Lấy số lượng các phần tử counter
            var counters = document.querySelectorAll('.counter');

            counters.forEach(function(counter) {
                // Lấy giá trị của mỗi phần tử counter
                var target = parseInt(counter.innerText);

                // Biến đếm
                var count = 0;
                var speed = 100; // Tốc độ đếm (ms mỗi lần)

                // Hàm đếm
                function updateCounter() {
                    if (count < target) {
                        count++;
                        counter.innerText = count;
                        setTimeout(updateCounter, speed);
                    } else {
                        counter.innerText = target; // Đảm bảo giá trị cuối cùng là đúng
                    }
                }

                // Bắt đầu đếm
                updateCounter();
            });
        }
    </script>
@endsection
