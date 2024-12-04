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
    <div class="char-checklist" style="height: 400px;">
        <canvas id="progressChart"></canvas>
    </div>


</div>

</div>
@endsection

@section('admin-js')
<script>
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
        $('.progress-item').on('mouseenter', function(e) {
            $('#tooltip')
                .css({
                    top: e.pageY + 10 + 'px', // Đặt tooltip bên dưới con trỏ chuột
                    left: e.pageX + 10 + 'px' // Đặt tooltip bên cạnh con trỏ chuột
                })
                .show(); // Hiển thị tooltip
        });

        $('.progress-item').on('mouseleave', function() {
            $('#tooltip').hide(); // Ẩn tooltip khi rời khỏi thẻ
        });

        $('.progress-item').on('mousemove', function(e) {
            $('#tooltip')
                .css({
                    top: e.pageY + 10 + 'px', // Cập nhật vị trí tooltip khi di chuột
                    left: e.pageX + 10 + 'px'
                });
        });

        function createProgressBar(line, completion) {
            const progressContainer = $('#progress-container-2');
            const progressCol = $('<div>').addClass('col-xl-6 col-sm-12 px-4');
            const progressDiv = $('<div>').addClass('progress').attr('data-line', line);
            const progress = $('<div>').addClass('progress-bar').css({
                width: `${completion}%`,
                background: '#25babc'
            });

            const progressValue = $('<div>').addClass('progress-value').html(`<span>${completion}</span>%`);
            const progressTitle = $('<div>').addClass('progressbar-title').html(line);

            progress.append(progressValue).append(progressTitle);
            progressDiv.append(progress);
            progressCol.append(progressDiv);
            progressContainer.append(progressCol);

            progressDiv.on('click', function() {
                const lineName = $(this).data('line');
                // Điều hướng đến router tương ứng
                var url = "{{ route('show.checklist', ':line') }}".replace(':line', lineName);
                window.location.href = url;
            });
        }

        function createProgressBar_2(line, completion) {

            const progressContainer = $('#progress-container-2');
            const progressCol = $('<div>').addClass('col-xl-6 col-sm-12 px-5');
            const progressDiv = $('<div>').addClass('progress blue progress-item').attr('data-line', line);
            const title = $('<h3>').addClass('progress-title').text(line);

            const progress = $('<div>').addClass('progress-bar').css({
                width: `${completion}%`,
                // background: '#2e9ce0' // Màu đỏ
            });
            // const button = $('<button>').addClass('progress-buttom').text("View");

            const progressValue = $('<div>').addClass('progress-value').text(`${completion}%`);
            // const progressValue = $('<div>').addClass('progress-value');

            progress.append(progressValue);
            progressDiv.append(title).append(progress);
            progressCol.append(progressDiv);
            progressContainer.append(progressCol);


            progressDiv.on('click', function() {
                const lineName = $(this).data('line');
                // Điều hướng đến router tương ứng
                var url = "{{ route('show.checklist', ':line') }}".replace(':line', lineName);
                window.location.href = url;
            });
        }

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
                        const url = `{{ route('show.checklist', ':line') }}`.replace(':line', lineName);
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
                    // var data_detail = data.progressData;
                    // data_detail.forEach(item => {
                    //     console.log(item.Locations);
                    //     console.log(item.completion_percentage);
                    //     createProgressBar(item.Locations, item.completion_percentage);
                    // });


                    // Chuẩn bị dữ liệu cho biểu đồ
                    labels = data.progressData.map(item => item.Locations);
                    completed = data.progressData.map(item => item.completion_percentage);
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
</script>
@endsection