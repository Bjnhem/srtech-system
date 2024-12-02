@extends('ilsung.layouts.layout')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3" style="text-align: center">
            <h5 class="text-primary mx-3" style="color: white !important;"><b>
                    TỶ LỆ HOÀN THÀNH CHECK LIST EQM THEO LINE</b>
            </h5>

        </div>
        <div class="card-body">
            <div class="row">
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
            <br>
            <div class="demo">
                <div class="row" id="progress-container-2">

                </div>
            </div>

            <div id="tooltip"
                style="display:none; position:absolute; background-color:rgb(145, 145, 145); border:1px solid black; padding:5px;">
                Detail
            </div>

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
