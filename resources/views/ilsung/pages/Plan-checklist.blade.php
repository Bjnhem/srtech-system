@extends('ilsung.layouts.layout')
@section('content')
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"> --}}
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card  ">
                            <div class="card-body">
                                <div id="calendar1" class="calendar-s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Day Actions -->
    <div class="modal fade" id="dayActionModal" tabindex="-1" role="dialog" aria-labelledby="dayActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dayActionModalLabel">Plan action</h5>
                    <button type="button" class="btn btn-warning close close-model-checklist"
                        id="close-model">Close</button>
                </div>
                <div class="modal-body">

                    <ul class="list-group">

                        <li class="list-group-item">
                            <button class="btn btn-primary" id="createPlanBtn">Tạo kế hoạch</button>
                        </li>
                        <li class="list-group-item">
                            <button class="btn btn-danger" id="deletePlanBtn">Xóa kế hoạch</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
