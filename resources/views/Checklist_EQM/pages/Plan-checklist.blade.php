@extends('ilsung.layouts.layout')
@section('content')
    {{-- <div class="container-fluid" style="margin-top: 1px;">
        <!-- Content Row -->
        <div class="card mb-4">
            <div class="card-header py-3">
                <h5 class="text-primary mx-3"><b><i class="icon-line-check-square" style="padding-right: 5px"></i>PLAN CHECK
                        LIST
                        EQM</b>
                </h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" col-sm-2 col-md-2  bottommargin-sm">
                        <label for="">Date Search</label>
                        <div class="input-daterange component-datepicker multidate input-group">
                            <input type="text" value="" class="form-control text-start" id="date_form"
                                placeholder="MM/DD/YYYY">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <span>
                            <br>
                        </span>
                        <button id="add-plan-checklist" class="form-control btn-success"><i
                                class="icon-line-check"></i>Created plan
                        </button>
                    </div>


                </div>
                <br>
                <table id="table_check_list_search" class="table table-bordered table-hover"
                    style="width:100%;border-collapse:collapse;">
                </table>
            </div>
        </div>

    </div> --}}
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
    {{-- <script src="{{ asset('vendor/fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/list/main.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ asset('vendor/moment.min.js') }}"></script> --}}
    {{-- <script src="{{asset('js/plugins/calender.js')}}"></script> --}}

    <script>
        $(document).ready(function() {
            var colum_table = [];
            var tables;
            var currentDate = new Date();
            var date = currentDate.toISOString().split('T')[0];
            $('#date_form').val(date);

            localStorage.setItem('activeItem', 'Plan');
            var activeItem = localStorage.getItem('activeItem');
            let list = document.querySelectorAll(".sidebar-body-menu a");
            list.forEach((item) => item.addEventListener('click', activeLink));
            if (activeItem) {
                var selectedItem = document.getElementById(activeItem);
                if (selectedItem) {
                    selectedItem.classList.add('active');
                }
            }


            function activeLink() {
                var itemId = this.id;
                list.forEach((item) => {
                    item.classList.remove("active");
                });
                this.classList.add("active");
                localStorage.setItem('activeItem', itemId);
            }


            function Show_plan_checklist() {
                // document.addEventListener('DOMContentLoaded', function() {
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

                    // Sử dụng AJAX để lấy dữ liệu sự kiện
                    events: function(fetchInfo, successCallback, failureCallback) {
                        $.ajax({
                            url: "{{ route('show.plan') }}", // URL của API Laravel
                            method: 'GET',
                            success: function(data) {
                                // Dữ liệu trả về từ server
                                console.log(data);
                                const events = data.map(event => {
                                        const totalCount = event.total_count;
                                        const completedCount = event
                                            .completed_count;
                                        const pendingCount = event
                                            .pending_count;
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

                                // Gọi callback thành công và trả về các sự kiện
                                successCallback(events);
                            },
                            error: function(error) {
                                console.error('Có lỗi khi lấy dữ liệu sự kiện: ',
                                    error);
                                failureCallback(error);
                            }
                        });
                    },

                    dateClick: function(info) {
                        // Lấy ngày đã click
                        let selectedDate = info.dateStr;

                        // Hiển thị modal
                        $('#dayActionModal').modal('show');

                        // Gán sự kiện cho các button trong modal
                        $('#viewPlanBtn').off('click').on('click', function() {
                            viewPlan(selectedDate);
                        });

                        $('#createPlanBtn').off('click').on('click', function() {
                            createPlan(selectedDate);
                        });

                        $('#deletePlanBtn').off('click').on('click', function() {
                            deletePlan(selectedDate);
                        });
                    },

                    // Hàm để render ngày có sự kiện
                    dayRender: function(info) {
                        // Kiểm tra xem ngày này có dữ liệu không, nếu có thì tô màu xám
                        const today = new Date().toISOString().split('T')[0]; // Ngày hôm nay
                        const currentDate = info.dateStr;

                        // Kiểm tra ngày hôm nay
                        if (currentDate === today) {
                            // Tô màu xanh cho ngày hôm nay
                            info.el.style.backgroundColor = 'lightgreen';
                        } else {
                            $.ajax({
                                url: "{{ route('show.plan') }}", // URL của API Laravel
                                method: 'GET',
                                success: function(data) {
                                    // Kiểm tra nếu ngày có sự kiện trong dữ liệu trả về
                                    const hasEvent = data.some(event => event.Date_check ===
                                        currentDate);
                                    if (hasEvent) {
                                        // Tô màu xám cho ngày có sự kiện
                                        info.el.style.backgroundColor = 'lightgray';
                                    }
                                },
                                error: function(error) {
                                    console.error('Có lỗi khi lấy dữ liệu sự kiện: ',
                                        error);
                                }
                            });
                        }
                    }
                });

                calendar1.render();

            };
            Show_plan_checklist();
            $(document).on('click', '#add-plan-checklist', function(e) {
                e.preventDefault();
                var date_created = $('#date_form').val();
                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    var data = {
                        date: date_created,
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ route('add.plan.checklist') }}",
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 200) {
                                if (response.new_count == '0') {
                                    alert('PLan checklist đã được tạo');

                                } else {
                                    alert("Checklist đã tạo: " + response.new_count +
                                        " - Checklist đã tồn tại:" + response.existing_count
                                    )
                                }

                            } else {
                                alert("Tạo Checklist lỗi")
                            }
                            Show_plan_checklist();
                        }

                    });
                }
            });

            function createPlan(date) {
                var date_created = date;
                if ($('#date_form').val() == 0) {
                    alert('Bạn điền thiếu thông tin');
                } else {
                    var data = {
                        date: date_created,
                    }
                    $.ajax({
                        type: "POST",
                        url: "{{ route('add.plan.checklist') }}",
                        dataType: 'json',
                        data: data,
                        success: function(response) {
                            if (response.status == 200) {
                                if (response.new_count == '0') {
                                    alert('PLan checklist đã được tạo');

                                } else {
                                    alert("Checklist đã tạo: " + response.new_count +
                                        " - Checklist đã tồn tại:" + response.existing_count
                                    )
                                }

                            } else {
                                alert("Tạo Checklist lỗi")
                            }
                            Show_plan_checklist();
                            $('#dayActionModal').modal('hide');
                        }

                    });
                }
            }

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
                            // alert('Đã xoá checklist ngày : ' + date);
                        } else {
                            // alert("Xoá Checklist lỗi")
                            toastr.success(response.message);
                        }
                        Show_plan_checklist();
                        $('#dayActionModal').modal('hide');
                    }

                });

            }

            $(document).on('click', '.close', function(e) {
                e.preventDefault();
                $('#dayActionModal').modal('hide');

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content')
                }
            });

        });
    </script>
@endsection
