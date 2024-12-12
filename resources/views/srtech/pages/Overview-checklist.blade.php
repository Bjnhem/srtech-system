@extends('ilsung.layouts.layout')
@section('content')
    <div class="chart-container">

        <h2 class="text-center mb-4 chart-title">TỶ LỆ HOÀN THÀNH CHECK LIST EQM THEO LINE</h2>
        <div class="row my-4">
            <div class=" col-sm-6 col-xl-6 px-4">
                <label for="">Date Search</label>
                <div class="input-daterange component-datepicker input-group">
                    <input type="text" value="" class="form-control text-start" id="date_form"
                        placeholder="YYYY-MM-DD">
                </div>
            </div>

            <div class="col-sm-6 col-xl-6 px-4">
                <span>Shift:</span>
                <select name="shift" id="shift_search" class="form-select">
                    <option value="">All</option>
                    <option value="Ca ngày">Ca ngày</option>
                    <option value="Ca đêm">Ca đêm</option>

                </select>
            </div>

        </div>
        <div class="char-checklist">
            <canvas id="progressChart"></canvas>
        </div>
    </div>

@endsection

@section('admin-js')
    {{-- <script>
        $(document).ready(function() {
            Chart.register(ChartDataLabels);

            var labels = [];
            var completed = [];
            var remaining = [];
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            var tables;
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_form').val(date);


            $('#date_form').on('change', function(e) {
                e.preventDefault();
                console.log('OK')
                show_overview();

            });
            $('#shift_search').on('change', function(e) {
                e.preventDefault();
                show_overview();

            });



            const ctx = document.getElementById('progressChart').getContext('2d');
            const progressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Completed (%)',
                            data: completed,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)', // Màu phần hoàn thành
                            borderWidth: 1,
                            borderRadius: 10,
                            datalabels: {
                                display: true,
                                color: '#000',
                                anchor: 'end',
                                align: 'end',
                                font: {
                                    size: 16,
                                    weight: 'bold',
                                },
                                formatter: (value) => `${value}%`, // Thêm ký hiệu %
                            },
                        },
                        {
                            label: 'Pending (%)',
                            data: remaining,
                            backgroundColor: 'rgba(192, 192, 192, 0.5)', // Màu phần chưa hoàn thành
                            borderWidth: 1,
                            borderRadius: 10,
                            datalabels: {
                                display: false,
                            },
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: (tooltipItem) => {
                                    const datasetLabel = tooltipItem.dataset.label;
                                    const value = tooltipItem.raw;
                                    return `${datasetLabel}: ${value}%`;
                                },
                            },
                        }, // Ẩn chú thích nếu không cần
                    },
                    scales: {
                        x: {
                            stacked: true, // Xếp chồng các phần trong cột
                            title: {
                                display: false,
                                text: 'Lines'
                            },
                            grid: {
                                display: true
                            },
                        },
                        y: {
                            stacked: true, // Xếp chồng giá trị trong cột
                            beginAtZero: true,
                            max: 120,
                            Grid: false,
                            ticks: {
                                stepSize: 40
                            },
                            grid: {
                                display: true
                            },

                        },
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce', // Hiệu ứng chuyển động
                    },
                    hover: {
                        mode: 'dataset', // Làm nổi bật toàn bộ dataset khi hover
                        animationDuration: 400, // Thời gian chuyển đổi khi hover
                    },

                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index; // Lấy index của cột được click
                            const lineName = labels[index]; // Tên line dựa trên index
                            // Điều hướng đến URL tương ứng
                            const url = `{{ route('show.checklist', ':line') }}`.replace(
                                ':line', lineName);
                            window.location.href = url;
                        }
                    },
                },
            });

            show_overview();


            // Gọi API để lấy dữ liệu
            function show_overview() {

                // $('#progress-container-2').html("");
                var shift_search = $('#shift_search').val();
                var date_form = $('#date_form').val();
                var line = '';
                // console.log(shift_search);
                // console.log(date_form);
                $.ajax({
                    url: "{{ route('checklist.overview.data') }}",
                    method: 'GET',

                    dataType: "json",
                    data: {
                        shift: shift_search,
                        date_form: date_form,
                        line: line
                    },
                    success: function(data) {

                        // Chuẩn bị dữ liệu cho biểu đồ
                        labels = data.progressData.map(item => item.Locations);
                        completed = data.progressData.map(item => item
                            .completion_percentage);
                        remaining = completed.map(value => 100 - value);
                        console.log(completed);
                        const newData = {
                            labels: labels,
                            completed: completed,
                            remaining: remaining
                        };
                        updateChartData(newData);
                        // Vẽ biểu đồ



                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

            }

            function updateChartData(newData) {
                // Gán lại labels và datasets
                progressChart.data.labels = newData.labels;
                progressChart.data.datasets[0].data = newData.completed;
                progressChart.data.datasets[1].data = newData.remaining;

                // Cập nhật biểu đồ
                progressChart.update();
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });
        });
    </script> --}}

     {{-- <script>
        $(document).ready(function() {
            Chart.register(ChartDataLabels);

       
            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            var tables;
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_form').val(date);

            let labels = [];
            let completed = [];
            let remaining = [];
            let chartType = "bar"; // Mặc định là biểu đồ cột (bar)

            const ctx = document.getElementById("progressChart").getContext("2d");
            let progressChart;

            // Hàm khởi tạo hoặc cập nhật biểu đồ
            function initChart() {
                if (progressChart) {
                    progressChart.destroy(); // Hủy biểu đồ cũ nếu tồn tại
                }

                progressChart = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                                label: "Completed (%)",
                                data: completed,
                                backgroundColor: "rgba(75, 192, 192, 0.8)", // Màu phần hoàn thành
                                borderWidth: 1,
                                borderRadius: 10,
                                axis: 'y',
                                datalabels: {
                                    display: true,
                                    color: "#000",
                                    anchor: "end",
                                    align: "end",
                                    font: {
                                        size: 16,
                                        weight: "bold",
                                    },
                                    formatter: (value) => `${value}%`, // Thêm ký hiệu %
                                },
                            },
                            {
                                label: "Pending (%)",
                                axis: 'y',
                                data: remaining,
                                backgroundColor: "rgba(192, 192, 192, 0.5)", // Màu phần chưa hoàn thành
                                borderWidth: 1,
                                borderRadius: 10,
                                datalabels: {
                                    display: false,
                                },
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: (tooltipItem) => {
                                        const datasetLabel = tooltipItem.dataset.label;
                                        const value = tooltipItem.raw;
                                        return `${datasetLabel}: ${value}%`;
                                    },
                                },
                            },
                        },
                        indexAxis: 'x',

                        scales: {
                            x: {
                                stacked: true,
                                title: {
                                    display: false,
                                },
                                grid: {
                                    display: true,
                                },
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                max: 120,
                                ticks: {
                                    stepSize: 40,
                                },
                                grid: {
                                    display: true,
                                },
                            },
                        },
                        animation: {
                            duration: 2000,
                            easing: "easeOutBounce",
                        },
                        hover: {
                            mode: "dataset",
                            animationDuration: 400,
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const lineName = labels[index];
                                const url = `{{ route('show.checklist', ':line') }}`.replace(
                                    ":line",
                                    lineName
                                );
                                window.location.href = url;
                            }
                        },
                    },
                });
            }

            // Hàm xác định loại biểu đồ dựa trên kích thước màn hình
            function determineChartType() {
                const screenWidth = $(window).width();
                chartType = screenWidth < 768 ? "bar" : "bar"; // Dưới 768px dùng thanh ngang
            }

            // Hàm gọi API và cập nhật dữ liệu
            function show_overview() {
                const shift_search = $("#shift_search").val();
                const date_form = $("#date_form").val();
                const line = "";

                $.ajax({
                    url: "{{ route('checklist.overview.data') }}",
                    method: "GET",
                    dataType: "json",
                    data: {
                        shift: shift_search,
                        date_form: date_form,
                        line: line,
                    },
                    success: function(data) {
                        labels = data.progressData.map((item) => item.Locations);
                        completed = data.progressData.map(
                            (item) => item.completion_percentage
                        );
                        remaining = completed.map((value) => 100 - value);

                        initChart(); // Cập nhật lại biểu đồ khi có dữ liệu mới
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    },
                });
            }

            // Thay đổi biểu đồ khi thay đổi kích thước màn hình
            $(window).resize(function() {
                determineChartType();
                initChart(); // Cập nhật lại biểu đồ khi thay đổi loại
            });

            // Khởi tạo
            determineChartType();
            initChart();
            show_overview();

            $("#date_form, #shift_search").on("change", function(e) {
                e.preventDefault();
                show_overview();
            });

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            Chart.register(ChartDataLabels);

            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            var tables;
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_form').val(date);
            let labels = [];
            let completed = [];
            let remaining = [];
            let indexAxis = 'x'; // Mặc định là thanh dọc (bar)

            const ctx = document.getElementById("progressChart").getContext("2d");
            let progressChart;

            // Hàm khởi tạo hoặc cập nhật biểu đồ
            function initChart() {
                if (progressChart) {
                    progressChart.destroy(); // Hủy biểu đồ cũ nếu tồn tại
                }

                progressChart = new Chart(ctx, {
                    type: "bar", // Kiểu biểu đồ luôn là 'bar'
                    data: {
                        labels: labels,
                        datasets: [{
                                label: "Completed (%)",
                                data: completed,
                                backgroundColor: "rgba(75, 192, 192, 0.8)", // Màu phần hoàn thành
                                borderWidth: 1,
                                borderRadius: 10,
                                datalabels: {
                                    display: true,
                                    color: "#000",
                                    anchor: "end",
                                    align: "end",
                                    font: {
                                        size: 16,
                                        weight: "bold",
                                    },
                                    formatter: (value) => `${value}%`, // Thêm ký hiệu %
                                },
                            },
                            {
                                label: "Pending (%)",
                                data: remaining,
                                backgroundColor: "rgba(192, 192, 192, 0.5)", // Màu phần chưa hoàn thành
                                borderWidth: 1,
                                borderRadius: 10,
                                datalabels: {
                                    display: false,
                                },
                            },
                        ],
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: (tooltipItem) => {
                                        const datasetLabel = tooltipItem.dataset.label;
                                        const value = tooltipItem.raw;
                                        return `${datasetLabel}: ${value}%`;
                                    },
                                },
                            },
                        },
                        indexAxis: indexAxis, // Chuyển đổi giữa trục 'x' (dọc) và 'y' (ngang)
                        scales: {
                            x: {
                                stacked: true,
                                grid: {
                                    display: true,
                                },
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                max: 120,
                                ticks: {
                                    stepSize: 40,
                                },
                                grid: {
                                    display: true,
                                },
                            },
                        },
                        animation: {
                            duration: 2000,
                            easing: "easeOutBounce",
                        },
                        hover: {
                            mode: "dataset",
                            animationDuration: 400,
                        },
                        onClick: (event, elements) => {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const lineName = labels[index];
                                const url = `{{ route('show.checklist', ':line') }}`.replace(
                                    ":line",
                                    lineName
                                );
                                window.location.href = url;
                            }
                        },
                    },
                });
            }

            // Hàm xác định trục biểu đồ dựa trên kích thước màn hình
            function determineIndexAxis() {
                const screenWidth = $(window).width();
                indexAxis = screenWidth < 768 ? "y" : "x"; // Màn hình nhỏ: trục ngang, lớn: trục dọc

                if (screenWidth < 768) {
                    $('.char-checklist').css('height', '600px');
                    $('.chart-title').css('font-size', '20px');
                    
                } else {
                    $('.char-checklist').css('height', '400px');
                    $('.chart-title').css('font-size', '24px');

                }
            }

            // Hàm gọi API và cập nhật dữ liệu
            function show_overview() {
                const shift_search = $("#shift_search").val();
                const date_form = $("#date_form").val();
                const line = "";

                $.ajax({
                    url: "{{ route('checklist.overview.data') }}",
                    method: "GET",
                    dataType: "json",
                    data: {
                        shift: shift_search,
                        date_form: date_form,
                        line: line,
                    },
                    success: function(data) {
                        labels = data.progressData.map((item) => item.Locations);
                        completed = data.progressData.map((item) => item.completion_percentage);
                        remaining = completed.map((value) => 100 - value);

                        initChart(); // Cập nhật lại biểu đồ khi có dữ liệu mới
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    },
                });
            }

            // Thay đổi biểu đồ khi thay đổi kích thước màn hình
            $(window).resize(function() {
                determineIndexAxis();
                initChart(); // Cập nhật lại biểu đồ khi thay đổi trục
            });

            // Khởi tạo
            determineIndexAxis();
            // initChart();
            show_overview();

            $("#date_form, #shift_search").on("change", function(e) {
                e.preventDefault();
                show_overview();
            });

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
        });
    </script>
@endsection
