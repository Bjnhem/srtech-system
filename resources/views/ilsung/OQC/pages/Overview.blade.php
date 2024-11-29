@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
    {{-- <div class="container mt-4"> --}}
    <a href="{{ route('OQC.caculate.overview') }}"> tính toán data sum by model</a>

    <h2 class="text-center mb-4">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h2>

    <!-- Biểu đồ -->
    <div class="chart-container mb-5">
        <canvas id="oqcChart"></canvas>
    </div>
    <div class="mt-4 table-response">
        <h5 class="fw-bold table-title">BÁO CÁO TÌNH TRẠNG LỖI OQC THEO MODEL</h4>

            <!-- Bảng chính -->
            {{-- <table class="table table-bordered table-hover table-sm mt-4">
                <thead>
                    <tr>
                        <th rowspan="2">Model</th>
                        <th rowspan="2">Item</th>
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
                    <!-- All model -->
                    <tr class="bg-highlight">
                        <td rowspan="4" class="fw-bold">All model</td>
                        <td>Prod [ea]</td>
                        <td>4,805,717</td>
                        <td>911,730</td>
                        <td>1,050,581</td>
                        <td>795,059</td>
                        <td>213,098</td>
                        <td>236,393</td>
                        <td>54,755</td>
                        <td>-</td>
                        <td>35,312</td>
                        <td>19,443</td>
                    </tr>
                    <tr>
                        <td>Q'ty NG [ea]</td>
                        <td>123,418</td>
                        <td>-</td>
                        <td>67,511</td>
                        <td>55,907</td>
                        <td>13,143</td>
                        <td>20,873</td>
                        <td>5,826</td>
                        <td>-</td>
                        <td>3,997</td>
                        <td>1,829</td>
                    </tr>
                    <tr>
                        <td>Rate Target [%]</td>
                        <td>3.0%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                        <td>3%</td>
                    </tr>
                    <tr>
                        <td>Rate [%]</td>
                        <td>2.57%</td>
                        <td>0.00%</td>
                        <td>6.43%</td>
                        <td>7.03%</td>
                        <td>6.17%</td>
                        <td>8.83%</td>
                        <td>10.64%</td>
                        <td>-</td>
                        <td>11.32%</td>
                        <td>9.41%</td>
                    </tr>

                    <!-- Model S928 -->
                    <tr class="bg-highlight">
                        <td rowspan="4" class="fw-bold">S928</td>
                        <td>Prod [ea]</td>
                        <td>780,512</td>
                        <td>303,992</td>
                        <td>310,664</td>
                        <td>165,856</td>
                        <td>44,500</td>
                        <td>36,151</td>
                        <td>5,946</td>
                        <td>5,381</td>
                        <td>4,668</td>
                        <td>1,278</td>
                    </tr>
                    <tr>
                        <td>Q'ty NG [ea]</td>
                        <td>35,524</td>
                        <td>0</td>
                        <td>23,783</td>
                        <td>11,741</td>
                        <td>3,161</td>
                        <td>2,858</td>
                        <td>377</td>
                        <td>457</td>
                        <td>289</td>
                        <td>88</td>
                    </tr>
                    <tr>
                        <td>Rate [%]</td>
                        <td>4.55%</td>
                        <td>0.00%</td>
                        <td>7.66%</td>
                        <td>7.08%</td>
                        <td>7.10%</td>
                        <td>7.91%</td>
                        <td>6.34%</td>
                        <td>8.49%</td>
                        <td>6.19%</td>
                        <td>6.89%</td>
                    </tr>
                </tbody>
            </table> --}}

            {{-- <table class="table table-bordered table-hover table-sm mt-4">
                <thead>
                    <tr>
                        <th rowspan="2">Model</th>
                        <th rowspan="2">Item</th>
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
                    @foreach ($groupedData as $model => $items)
                        @foreach ($items as $item => $data)
                            <tr>
                                @if ($loop->first)
                                    <td rowspan="{{ count($items) }}" class="fw-bold">{{ $model }}</td>
                                @endif
                                <td>{{ $item }}</td>
            
                                <!-- Hiển thị dữ liệu theo năm -->
                                <td>{{ $data['year']['2024'] ?? '-' }}</td>
                                <td>{{ $data['month']['2024-09'] ?? '-' }}</td>
                                <td>{{ $data['month']['2024-10'] ?? '-' }}</td>
                                <td>{{ $data['month']['2024-11'] ?? '-' }}</td>
            
                                <!-- Hiển thị dữ liệu theo tuần -->
                                <td>{{ $data['week']['2024-W46'] ?? '-' }}</td>
                                <td>{{ $data['week']['2024-W47'] ?? '-' }}</td>
                                <td>{{ $data['week']['2024-W48'] ?? '-' }}</td>
            
                                <!-- Hiển thị dữ liệu theo ngày -->
                                <td>{{ $data['day']['2024-11-24'] ?? '-' }}</td>
                                <td>{{ $data['day']['2024-11-25'] ?? '-' }}</td>
                                <td>{{ $data['day']['2024-11-26'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table> --}}
            <table id="oqcTable" class="table table-bordered table-hover table-striped">
                <thead>
                    <tr id="dynamic-headers"></tr>
                </thead>
            </table>
            <table class="table table-bordered table-hover table-sm mt-4">
                <thead>
                    <tr>
                        <th rowspan="2">Model</th>
                        <th rowspan="2">Item</th>
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
                    @foreach ($groupedData as $model => $items)
                        @foreach ($items as $item => $data)
                            <tr>
                                @if ($loop->first)
                                    <td rowspan="{{ count($items) }}" class="fw-bold">{{ $model }}</td>
                                @endif
                                <td>{{ $item }}</td>

                                <!-- Hiển thị dữ liệu theo năm -->
                                <td>{{ is_array($data['year']['2024'] ?? null) ? implode(', ', $data['year']['2024']) : $data['year']['2024'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['month']['2024-09'] ?? null) ? implode(', ', $data['month']['2024-09']) : $data['month']['2024-09'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['month']['2024-10'] ?? null) ? implode(', ', $data['month']['2024-10']) : $data['month']['2024-10'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['month']['2024-11'] ?? null) ? implode(', ', $data['month']['2024-11']) : $data['month']['2024-11'] ?? '-' }}
                                </td>

                                <!-- Hiển thị dữ liệu theo tuần -->
                                <td>{{ is_array($data['week']['2024-W46'] ?? null) ? implode(', ', $data['week']['2024-W46']) : $data['week']['2024-W46'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['week']['2024-W47'] ?? null) ? implode(', ', $data['week']['2024-W47']) : $data['week']['2024-W47'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['week']['2024-W48'] ?? null) ? implode(', ', $data['week']['2024-W48']) : $data['week']['2024-W48'] ?? '-' }}
                                </td>

                                <!-- Hiển thị dữ liệu theo ngày -->
                                <td>{{ is_array($data['day']['2024-11-24'] ?? null) ? implode(', ', $data['day']['2024-11-24']) : $data['day']['2024-11-24'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['day']['2024-11-25'] ?? null) ? implode(', ', $data['day']['2024-11-25']) : $data['day']['2024-11-25'] ?? '-' }}
                                </td>
                                <td>{{ is_array($data['day']['2024-11-26'] ?? null) ? implode(', ', $data['day']['2024-11-26']) : $data['day']['2024-11-26'] ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>




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
                    console.log(response.headers);
                    console.log(response.data);
                    var columns = response.headers.map(function(header) {
                        return {
                            title: header.toString(),
                            data: header.toString()
                        };
                    });

                    // Khởi tạo DataTable
                    $('#oqcTable').DataTable({
                        columns: columns,
                        data: response.data
                    });
                    // Kiểm tra headers có phải là mảng chuỗi không
                    // if (!Array.isArray(response.headers) || !response.headers.every(h => typeof h ===
                    //         'string')) {
                    //     console.error("Headers are not valid:", response.headers);
                    //     return;
                    // }

                    // Tạo cấu hình columns cho DataTables
                    // const columns = response.headers.map(header => {
                    //     return {
                    //         data: header, // key tương ứng
                    //         title: header // tên cột hiển thị
                    //     };
                    // });

                    // Khởi tạo DataTables
                    // $('#oqcTable').DataTable({
                    //     processing: true,
                    //     serverSide: false,
                    //     data: response.data, // Dữ liệu từ server
                    //     columns: columns, // Cấu hình cột
                    //     responsive: true,
                    //     order: [
                    //         [0, 'asc']
                    //     ] // Sắp xếp theo cột đầu tiên
                    // });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        });
    </script>


    {{-- <script>
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
</script> --}}
@endsection
