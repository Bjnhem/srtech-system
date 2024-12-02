@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
{{-- <div class="container mt-4"> --}}
<!-- <a href="{{ route('OQC.caculate.overview') }}"> tính toán data sum by model</a> -->

<h2 class="text-center mb-4">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h2>

<!-- Biểu đồ -->
<div class="chart-container mb-5">
    <canvas id="oqcChart"></canvas>
</div>
<div class="mt-4 ">
    <h5 class="fw-bold table-title mb-3">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h4>
        <div class="table-sumary table-response">
            <table id="oqcTable" class="table table-bordered table-hover">
                <thead>
                    <tr id="dynamic-headers"></tr>
                </thead>
            </table>
        </div>






        <!-- Bảng Top Worst -->
        <h5 class="fw-bold table-title">Top Worst Defects</h5>
        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Worst defect</th>
                    <th>2024</th>
                    <th>M9</th>
                    <th>M10</th>
                    <th>M11</th>
                    <th>W46</th>
                    <th>W47</th>
                    <th>W48</th>
                    <th>24-Nov</th>
                    <th>25-Nov</th>
                    <th>26-Nov</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Lệch Vinyl</td>
                    <td>1,253</td>
                    <td>-</td>
                    <td>713</td>
                    <td>4,608</td>
                    <td>6,643</td>
                    <td>6,043</td>
                    <td>4,342</td>
                    <td>1,080</td>
                    <td>9,305</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Dị Vật Vinyl</td>
                    <td>2,027</td>
                    <td>-</td>
                    <td>3,264</td>
                    <td>4,111</td>
                    <td>3,820</td>
                    <td>5,329</td>
                    <td>6,730</td>
                    <td>6,117</td>
                    <td>7,663</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Lệch VT cam</td>
                    <td>1,211</td>
                    <td>-</td>
                    <td>1,758</td>
                    <td>2,762</td>
                    <td>3,778</td>
                    <td>3,602</td>
                    <td>651</td>
                    <td>360</td>
                    <td>1,095</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>



</div>
@endsection

@section('admin-js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('oqcChart').getContext('2d');
    const oqcChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['M9', 'M10', 'M11', 'W46', 'W47', 'W48', '23-Nov', '24-Nov', '25-Nov', '26-Nov'],
            datasets: [{
                label: 'Rate [%]',
                data: [0, 6.43, 7.03, 6.17, 8.83, 10.64, 10, 11.32, 9.41, 0],
                borderColor: 'blue',
                fill: false
            }, {
                label: 'Rate Target [%]',
                data: [3, 3, 3, 3, 3, 3, 3, 3, 3, 3],
                borderColor: 'red',
                borderDash: [5, 5],
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 14
                }
            }
        }
    });
</script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('oqc.data') }}",
            method: "GET",
            success: function(response) {
                // console.log(response.headers);
                console.log(response.data2);
                console.log(response.data);
                var columns = response.headers.map(function(header) {
                    return {
                        title: header.toString(),
                        data: header.toString()
                    };
                });

                var data = [];
                var modelData = {}; // Để nhóm dữ liệu theo Model

                // Lặp qua các dữ liệu và nhóm theo Model
                $.each(response.data, function(model, stats) {
                    var timePeriods = response.headers;

                    // Nhóm từng loại sản phẩm vào một mảng modelData
                    ['Prod [ea]', "Q'ty NG [ea]", 'Rate [%]'].forEach(function(category) {
                        var row = [];
                        var categoryData = stats[category];

                        // Duyệt qua các cột thời gian
                        timePeriods.forEach(function(period) {
                            if (period == 'Model') {
                                // Thêm tên Model vào cột Model
                                row.push(model);
                            } else if (period == 'Item') {
                                // Thêm tên item vào cột Item
                                row.push(category);
                            } else {
                                // Lấy giá trị dữ liệu từ stats và thêm dấu phẩy cho hàng nghìn
                                var value = categoryData[period] || '-';
                                row.push(value.toLocaleString()); // Format giá trị với dấu phẩy
                            }
                        });

                        // Kiểm tra nếu model đã có trong modelData, nếu chưa thì khởi tạo
                        if (!modelData[model]) {
                            modelData[model] = [];
                        }
                        modelData[model].push(row);
                    });
                });

                // Chuyển đổi dữ liệu nhóm lại thành dạng mà DataTable yêu cầu
                var data2 = [];
                $.each(modelData, function(model, rows) {
                    rows.forEach(function(row) {
                        const rowData = {};
                        response.headers.forEach((header, index) => {
                            rowData[header] = row[index]; // Map từng giá trị theo header
                        });
                        data2.push(rowData);
                    });
                });

                // Khởi tạo DataTable với dữ liệu đã chuẩn bị
                if ($.fn.DataTable.isDataTable("#oqcTable")) {
                    $("#oqcTable").DataTable().clear().destroy();
                }

                var tables = $('#oqcTable').DataTable({
                    columns: columns, // Cấu hình cột
                    data: data2, // Dữ liệu đã chuẩn bị
                    responsive: true, // Làm bảng responsive
                    order: false, // Tắt sắp xếp tự động
                    ordering: false, // Tắt tính năng sorting
                    initComplete: function() {
                        // Căn giữa các tiêu đề cột
                        $('#oqcTable thead th').css('text-align', 'center');
                    },
                    searching: false, // Tắt tính năng tìm kiếm
                    lengthChange: false, // Tắt lựa chọn số lượng hàng hiển thị
                    pageLength: -1, // Hiển thị tất cả các dòng dữ liệu
                    paging: false, // Tắt phân trang
                    info: false, // Tắt thông tin số lượng bản ghi
                });

                var current_data = null; // Khởi tạo giá trị ban đầu cho model
                var rowcount = 1; // Khởi tạo số lượng dòng cho mỗi nhóm

                tables.rows().every(function(rowIdx) {
                    var rowdata = this.data();
                    var modelData = rowdata['Model']; // Dữ liệu trong cột "Model"


                    // Nếu giá trị "Model" giống dòng trước, gộp rowspan
                    if (current_data == modelData) {
                        var prevRow = tables.row(rowIdx - rowcount).node(); // Lấy dòng trước đó
                        rowcount++; // Tăng số dòng cùng giá trị model
                        $(prevRow).find('td:first()').attr('rowspan', rowcount); // Tăng rowspan cho dòng trước
                        $(this.node()).find('td:first()').remove(); // Ẩn ô model của dòng sau

                    } else {
                        // Cập nhật lại current_data khi gặp model mới
                        current_data = modelData; // Cập nhật modelData mới
                        rowcount = 1; // Đặt lại rowcount cho nhóm mới
                        $(this.node()).find('td:nth-child(1)').attr('rowspan', 1); // Đặt rowspan cho dòng đầu tiên
                    }
                    if (rowdata['Item'] == 'Rate [%]') {
                        $(this.node()).find('td').css({
                            'background-color': '#f3f3f3',
                            'color': 'red',
                            'font-weight': '600'

                        })
                    }
                });

            },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
            }
        });
    });
</script>


@endsection