@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
{{-- <a href="{{ route('OQC.caculate.overview') }}"> tính toán data sum by model</a> --}}


<h2 class="text-center mb-4">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h2>

<!-- Biểu đồ -->
<div class="chart-container mb-2">
    <canvas id="oqcChart"></canvas>
</div>
<div class="mt-4 ">
    {{-- <h5 class="fw-bold table-title mb-3">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h4> --}}
        <div class="table-sumary table-response">
            <table id="oqcTable" class="table table-bordered table-hover">
                <thead>
                    <tr id="dynamic-headers"></tr>
                </thead>
            </table>
        </div>


        <!-- Bảng Top Worst -->
        <!-- <h5 class="fw-bold table-title">Top Worst Defects</h5>
        <table class="table table-bordered table-hover table-sm">
            <table id="defect_table" class="table table-bordered table-hover">
                <thead>

                </thead>
            </table>
         
        </table> -->

</div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function () {
        Chart.register(ChartDataLabels);

        function show_defect() {

            $.ajax({
                url: "{{ route('oqc.data.defect') }}",
                method: "GET",
                success: function (response) {
                    console.log(response.headers);
                    // console.log(response.data2);
                    console.log(response.data);
                    var columns = response.headers.map(function (header) {
                        return {
                            title: header.toString(),
                            data: header.toString()
                        };
                    });

                    var data = [];
                    var modelData = {}; // Để nhóm dữ liệu theo Model
                    var rateData = [];
                    var targetRateData = [];
                    var labels = [];
                    // Lặp qua các dữ liệu và nhóm theo Model
                    // $.each(response.data, function (model, stats) {
                    //     if (model == 'All Models') {
                    //         // Lọc các mục Rate [%] và Target Rate [%]
                    //         $.each(stats, function (category, categoryData) {
                    //             if (category == 'Rate [%]' || category ==
                    //                 'Target Rate [%]') {

                    //                 $.each(categoryData, function (period, value) {

                    //                     if (category === 'Rate [%]') {
                    //                         rateData.push(value);
                    //                     } else if (category ===
                    //                         'Target Rate [%]') {
                    //                         targetRateData.push(value);
                    //                         labels.push(period);
                    //                     }
                    //                 });
                    //             }
                    //         });
                    //     }
                    //     $.each(stats, function (category, categoryData) {
                    //         var row = [model, category];
                    //         // row.push(model, category);
                    //         $.each(categoryData, function (period, value) {
                    //             row.push(value.toLocaleString() ||
                    //                 '-'); // Format giá trị với dấu phẩy
                    //         });

                    //         // Kiểm tra nếu model đã có trong modelData, nếu chưa thì khởi tạo
                    //         if (!modelData[model]) {
                    //             modelData[model] = [];
                    //         }
                    //         modelData[model].push(row);
                    //     });
                    // });

                    // Chuyển đổi dữ liệu nhóm lại thành dạng mà DataTable yêu cầu
                    // var data2 = [];
                    // $.each(modelData, function (model, rows) {
                    //     rows.forEach(function (row) {
                    //         const rowData = {};
                    //         response.headers.forEach((header, index) => {
                    //             rowData[header] = row[
                    //                 index]; // Map từng giá trị theo header
                    //         });
                    //         data2.push(rowData);
                    //     });
                    // });

                    // Khởi tạo DataTable với dữ liệu đã chuẩn bị
                    if ($.fn.DataTable.isDataTable("#defect_table")) {
                        $("#defect_table").DataTable().clear().destroy();
                    }

                    var tables = $('#defect_table').DataTable({
                        columns: columns, // Cấu hình cột
                        data: data, // Dữ liệu đã chuẩn bị
                        responsive: true, // Làm bảng responsive
                        order: false, // Tắt sắp xếp tự động
                        ordering: false, // Tắt tính năng sorting
                        initComplete: function () {
                            // Căn giữa các tiêu đề cột
                            $('#defect_table thead th').css('text-align', 'center');
                        },
                        searching: false, // Tắt tính năng tìm kiếm
                        lengthChange: false, // Tắt lựa chọn số lượng hàng hiển thị
                        pageLength: -1, // Hiển thị tất cả các dòng dữ liệu
                        paging: false, // Tắt phân trang
                        info: false, // Tắt thông tin số lượng bản ghi
                    });

                    var current_data = null; // Khởi tạo giá trị ban đầu cho model
                    var rowcount = 1; // Khởi tạo số lượng dòng cho mỗi nhóm

                    tables.rows().every(function (rowIdx) {
                        var rowdata = this.data();
                        var modelData = rowdata['Model']; // Dữ liệu trong cột "Model"

                        // Nếu giá trị "Model" giống dòng trước, gộp rowspan
                        if (current_data == modelData) {
                            var prevRow = tables.row(rowIdx - rowcount)
                                .node(); // Lấy dòng trước đó
                            rowcount++; // Tăng số dòng cùng giá trị model
                            $(prevRow).find('td:first()').attr('rowspan',
                                rowcount); // Tăng rowspan cho dòng trước
                            $(this.node()).find('td:first()').remove();

                        } else {
                            // Cập nhật lại current_data khi gặp model mới
                            current_data = modelData; // Cập nhật modelData mới
                            rowcount = 1; // Đặt lại rowcount cho nhóm mới
                            $(this.node()).find('td:nth-child(1)').attr('rowspan',
                                1); // Đặt rowspan cho dòng đầu tiên
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
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        // show_defect();

        function show_chart() {
            $.ajax({
                url: "{{ route('oqc.data') }}",
                method: "GET",
                success: function (response) {
                    // console.log(response.headers);
                    // console.log(response.data2);
                    console.log(response.data);
                    var data = [];
                    var modelData = {}; // Để nhóm dữ liệu theo Model
                    var rateData = [];
                    var targetRateData = [];
                    var labels = [];
                    // Lặp qua các dữ liệu và nhóm theo Model
                    $.each(response.data, function (model, stats) {
                        if (model == 'All Models') {
                            // Lọc các mục Rate [%] và Target Rate [%]
                            $.each(stats, function (category, categoryData) {
                                if (category == 'Rate [%]' || category ==
                                    'Target Rate [%]') {
                                    $.each(categoryData, function (period, value) {

                                        if (category === 'Rate [%]') {
                                            rateData.push(value);
                                        } else if (category ===
                                            'Target Rate [%]') {
                                            targetRateData.push(value);
                                            labels.push(period);
                                        }
                                    });
                                }
                            });
                        }


                    });

                    var ctx = document.getElementById('oqcChart').getContext('2d'); // Canvas ID của biểu đồ
                    var chart = new Chart(ctx, {
                        type: 'bar', // Biểu đồ cột (bar)
                        data: {
                            labels: labels, // Các khoảng thời gian là labels
                            datasets: [
                                {
                                    label: 'Target Rate [%]',
                                    data: targetRateData, // Dữ liệu Target Rate [%]
                                    type: 'line', // Biểu đồ đường (line)
                                    fill: false,
                                    borderColor: 'red',
                                    tension: 0.1,
                                    borderWidth: 3,
                                    datalabels: {
                                        align: 'top', // Đặt vị trí giá trị trên cột
                                        anchor: 'end', // Đưa giá trị vào cuối của cột
                                        color: '#ff0000', // Màu của giá trị
                                        font: {
                                            weight: 'bold',
                                            size: 12,

                                        }
                                    }
                                }, {
                                    label: 'Rate [%]',
                                    data: rateData, // Dữ liệu Rate [%]
                                    backgroundColor: 'rgba(75, 192, 192, 1)', // Màu nền cột
                                    // borderColor: 'rgba(75, 192, 192, 1)', // Màu viền cột
                                    // borderWidth: 1,
                                    barThickness: 40,
                                    // borderRadius: [10, 10, 0, 0],
                                    borderRadius: 10,
                                    datalabels: {
                                        align: 'top', // Đặt vị trí giá trị trên cột
                                        anchor: 'end', // Đưa giá trị vào cuối của cột
                                        color: '#ff0000', // Màu của giá trị
                                        font: {
                                            weight: 'bold',
                                            size: 12,

                                        }
                                    }
                                }

                            ]
                        },
                        options: {
                            plugins: {
                                datalabels: {
                                    display: true, // Hiển thị dữ liệu trên biểu đồ
                                    color: '#000', // Màu chữ chung cho dữ liệu
                                    font: {
                                        weight: 'bold',
                                        size: 12
                                    }
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true, // Đảm bảo trục Y bắt đầu từ 0
                                    ticks: {
                                        stepSize: 2 // Thiết lập bước nhảy cho trục Y
                                    },
                                    min: 0, // Giá trị min của trục Y
                                    max: 10,

                                },

                            },
                            legend: {
                                display: false
                            }
                        }
                    });

                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        function show_table_loss_model() {
            $.ajax({
                url: "{{ route('oqc.data') }}",
                method: "GET",
                success: function (response) {
                    // console.log(response.headers);
                    // console.log(response.data2);
                    console.log(response.data);
                    var columns = response.headers.map(function (header) {
                        return {
                            title: header.toString(),
                            data: header.toString()
                        };
                    });

                    var data = [];
                    var modelData = {}; // Để nhóm dữ liệu theo Model
                    var rateData = [];
                    var targetRateData = [];
                    var labels = [];
                    // Lặp qua các dữ liệu và nhóm theo Model
                    $.each(response.data, function (model, stats) {
                        if (model == 'All Models') {
                            var categoriesOrder = ["Prod [ea]", "Q'ty NG [ea]", "Target Rate [%]", "Rate [%]"];
                        } else {
                            var categoriesOrder = ["Prod [ea]", "Q'ty NG [ea]", "Rate [%]"];
                        }
                        // $.each(stats, function (category, categoryData) {
                        categoriesOrder.forEach(function (category, categoryData) {
                            var row = [model, category];
                            // $.each(categoryData, function (period, value) {
                                $.each(stats[category], function (period, value) {
// 
                                const formattedValue = (typeof value === "number" || !isNaN(value))
                                    ? parseFloat(value).toLocaleString()
                                    : value || "-";

                                row.push(formattedValue);
                                // row.push(value.toLocaleString() || '-');
                            });

                            // Kiểm tra nếu model đã có trong modelData, nếu chưa thì khởi tạo
                            if (!modelData[model]) {
                                modelData[model] = [];
                            }
                            modelData[model].push(row);
                            console.log(row);
                        });
                    });

                    // Chuyển đổi dữ liệu nhóm lại thành dạng mà DataTable yêu cầu
                    var data2 = [];
                    $.each(modelData, function (model, rows) {
                        rows.forEach(function (row) {
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
                        initComplete: function () {
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

                    tables.rows().every(function (rowIdx) {
                        var rowdata = this.data();
                        var modelData2 = rowdata['Model']; // Dữ liệu trong cột "Model"

                        // Nếu giá trị "Model" giống dòng trước, gộp rowspan
                        if (current_data == modelData2) {
                            var prevRow = tables.row(rowIdx - rowcount).node(); // Lấy dòng trước đó
                            rowcount++; // Tăng số dòng cùng giá trị model
                            $(prevRow).find('td:nth-child(1)').attr('rowspan', rowcount); // Tăng rowspan cho dòng trước
                            $(this.node()).find('td:nth-child(1)').remove();

                        } else {
                            // Cập nhật lại current_data khi gặp model mới
                            current_data = modelData2; // Cập nhật modelData mới
                            rowcount = 1; // Đặt lại rowcount cho nhóm mới
                            $(this.node()).find('td:nth-child(1)').attr('rowspan',
                                1); // Đặt rowspan cho dòng đầu tiên
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
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }
        show_chart();
        show_table_loss_model();

    });
</script>
@endsection