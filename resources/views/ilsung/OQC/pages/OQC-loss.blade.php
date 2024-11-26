@extends('ilsung.OQC.layouts.OQC_layout')
@section('content')
    <form action="{{ route('plans.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Upload file kế hoạch</label>
            <input type="file" class="form-control-file" id="file" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <form action="{{ route('plans.index') }}" method="GET">
        <div class="form-group">
            <label for="search">Tìm kiếm kế hoạch</label>
            <input type="text" class="form-control" id="search" name="search" value="{{ old('search', $search) }}">
        </div>
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Shift</th>
                <th>Line</th>
                <th>Model</th>
                <th>Sản phẩm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->date }}</td>
                    <td>{{ $plan->shift }}</td>
                    <td>{{ $plan->line }}</td>
                    <td>{{ $plan->model }}</td>
                    <td>{{ $plan->prod }}</td>
                    <td>
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-primary">Sửa</a>
                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $plans->links() }}
@endsection

@section('admin-js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // Khởi tạo phần tử DOM chứa lịch
            let calendarEl = document.getElementById('calendar1');

            // Khởi tạo FullCalendar
            let calendar1 = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                plugins: ["timeGrid", "dayGrid", "list", "interaction"],
                timeZone: "UTC",
                defaultView: "dayGridMonth",
                contentHeight: "auto",
                eventLimit: true,
                dayMaxEvents: 3, // Hiển thị tối đa 3 sự kiện mỗi ngày
                header: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Sử dụng AJAX để lấy dữ liệu sự kiện
                    $.ajax({
                        url: "{{ route('show.plan') }}", // URL của API Laravel
                        method: 'GET',
                        success: function(data) {
                            // Dữ liệu trả về từ server
                            console.log(data);
                            const events = data.map(event => {
                                    const totalCount = event.total_count;
                                    const completedCount = event.completed_count;
                                    const pendingCount = event.pending_count;
                                    const date = event.Date_check;

                                    return [
                                        // Sự kiện tổng số dòng
                                        {
                                            title: `Total: ${totalCount}`,
                                            start: date,
                                            backgroundColor: 'black',
                                            textColor: 'white',
                                            borderColor: 'black'
                                        },
                                        // Sự kiện số dòng hoàn thành
                                        {
                                            title: `Completed: ${completedCount}`,
                                            start: date,
                                            backgroundColor: 'green',
                                            textColor: 'white',
                                            borderColor: 'green'
                                        },
                                        // Sự kiện số dòng đang chờ
                                        {
                                            title: `Pending: ${pendingCount}`,
                                            start: date,
                                            backgroundColor: 'red',
                                            textColor: 'white',
                                            borderColor: 'red'
                                        }
                                    ];
                                })
                                .flat(); // Sử dụng flat() để làm phẳng mảng nếu cần

                            successCallback(events); // Thêm sự kiện vào lịch
                        },
                        error: function(error) {
                            console.error('Có lỗi khi lấy dữ liệu sự kiện: ', error);
                            failureCallback(error);
                        }
                    });
                },

                // Xử lý sự kiện click vào ngày
                dateClick: function(info) {
                    let selectedDate = info.dateStr;
                    $('#dayActionModal').modal('show');

                    $('#createPlanBtn').off('click').on('click', function() {
                        createPlan(selectedDate);
                    });

                    $('#deletePlanBtn').off('click').on('click', function() {
                        deletePlan(selectedDate);
                    });
                },
            });

            // Render lịch ban đầu
            calendar1.render();

            // Hàm tạo kế hoạch cho ngày đã chọn
            function createPlan(date) {
                var data = {
                    date: date,
                };
                $.ajax({
                    type: "POST",
                    url: "{{ route('add.plan.checklist') }}",
                    dataType: 'json',
                    data: data,
                    success: function(response) {
                        if (response.status == 200) {
                            if (response.new_count == '0') {
                                toastr.success('Plan checklist đã được tạo');
                                // alert('Plan checklist đã được tạo');
                            } else {
                                toastr.success("Checklist đã tạo: " + response.new_count +
                                    " - Checklist đã tồn tại:" + response.existing_count);
                            }
                        } else {
                            toastr.error('Tạo Checklist lỗi');

                        }

                        // Sau khi tạo kế hoạch, làm mới lịch
                        updateCalendarData();
                        $('#dayActionModal').modal('hide');
                    }
                });
            }

            // Hàm cập nhật dữ liệu lịch
            function updateCalendarData() {
                $.ajax({
                    url: "{{ route('show.plan') }}", // URL của API Laravel
                    method: 'GET',
                    success: function(data) {
                        const events = data.map(event => {
                            const totalCount = event.total_count;
                            const completedCount = event.completed_count;
                            const pendingCount = event.pending_count;
                            const date = event.Date_check;

                            return [{
                                    title: `Total: ${totalCount}`,
                                    start: date,
                                    backgroundColor: 'black',
                                    textColor: 'white',
                                    borderColor: 'black'
                                },
                                {
                                    title: `Completed: ${completedCount}`,
                                    start: date,
                                    backgroundColor: 'green',
                                    textColor: 'white',
                                    borderColor: 'green'
                                },
                                {
                                    title: `Pending: ${pendingCount}`,
                                    start: date,
                                    backgroundColor: 'red',
                                    textColor: 'white',
                                    borderColor: 'red'
                                }
                            ];
                        }).flat();
                        // Xóa tất cả sự kiện cũ và thêm sự kiện mới
                        calendar1.removeAllEvents();
                        calendar1.addEventSource(events);
                    },
                    error: function(error) {
                        console.error('Có lỗi khi lấy dữ liệu sự kiện: ', error);
                    }
                });
            }

            // Hàm xóa kế hoạch cho ngày đã chọn
            function deletePlan(date) {
                var data = date;
                $.ajax({
                    type: "POST",
                    url: "{{ route('delete.plan.checklist') }}",
                    dataType: 'json',
                    data: {
                        date: date
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            toastr.success(response.message);
                        } else {
                            toastr.error("Xóa Checklist lỗi");
                        }
                        // Sau khi xóa kế hoạch, làm mới lịch
                        updateCalendarData();
                        $('#dayActionModal').modal('hide');
                    }
                });
            }

            // Đóng modal khi nhấn nút đóng
            $(document).on('click', '.close', function(e) {
                e.preventDefault();
                $('#dayActionModal').modal('hide');
            });

            // Thiết lập CSRF token cho AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@endsection
