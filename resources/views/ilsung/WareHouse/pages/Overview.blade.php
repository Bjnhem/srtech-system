@extends('ilsung.WareHouse.layouts.WareHouse_layout')
@section('content')
    
    <style type="text/css">
        /* Chart.js */
        @keyframes chartjs-render-animation {
            from {
                opacity: .99
            }

            to {
                opacity: 1
            }
        }

        .chartjs-render-monitor {
            animation: chartjs-render-animation 1ms
        }

        .chartjs-size-monitor,
        .chartjs-size-monitor-expand,
        .chartjs-size-monitor-shrink {
            position: absolute;
            direction: ltr;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            visibility: hidden;
            z-index: -1
        }

        .chartjs-size-monitor-expand>div {
            position: absolute;
            width: 1000000px;
            height: 1000000px;
            left: 0;
            top: 0
        }

        .chartjs-size-monitor-shrink>div {
            position: absolute;
            width: 200%;
            height: 200%;
            left: 0;
            top: 0
        }
    </style>

 
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-th-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">PO Records</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-boxes"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Receiving Records</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-exchange-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">BO Records</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-undo"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Return Records</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file-invoice-dollar"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sales Records</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-truck-loading"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Suppliers</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-th-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Items</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box bg-light shadow">
                <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Users</span>
                    <span class="info-box-number text-right">

                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

    </div>
@endsection

@section('admin-js')
    <script>
        $(document).ready(function() {
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

            show_overview();


            // Gọi API để lấy dữ liệu
            function show_overview() {
                $('#progress-container-2').html("");
                var shift_search = $('#shift_search option:selected').text();
                var date_form = ($('#date_form').val());
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
                        var data_detail = data.progressData;
                        data_detail.forEach(item => {
                            // console.log(item.Locations);
                            // console.log(item.completion_percentage);
                            createProgressBar(item.Locations, item.completion_percentage);
                        });
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });

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
