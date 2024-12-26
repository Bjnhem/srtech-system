{{-- @props(['dir']) --}}
<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}"> --}}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('SR-TECH/icon/srtech.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">

    <link rel="stylesheet" href="{{ asset('checklist-ilsung/jquery-ui/auto.css') }}">
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/css/rowGroup.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Select-1.7.0/css/select.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/toastr.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/select-boxes.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/components/datepicker.css') }}" type="text/css" />
    {{-- <link rel="stylesheet" href="{{ asset('SR-TECH/css/warehouse.css') }}" /> --}}
    <link rel='stylesheet' href="{{ asset('SR-TECH/css/bootstrap-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/overview.css') }}" />

    <style>
        /* Đảm bảo body và html chiếm toàn bộ chiều cao */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Cố định header */
        .position-relative {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 10;
            background-color: #fff;
            /* Màu nền cho header */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Bóng nhẹ */
        }

        /* .content-inner {
            min-height: 100% !important;

        } */

        /* Nội dung chính */
        .main-content {
            /* flex: 1; */
            /* display: flex; */
            flex-direction: column;
            margin-top: 80px;
            /* Dành không gian cho header */
        }

        /* Footer luôn ở dưới cùng */
        .footer {
            background-color: #f8f9fa;
            /* Màu nền cho footer */
            /* padding: 10px 20px; */
            text-align: center;
            box-shadow: 0px -4px 6px rgba(0, 0, 0, 0.1);
            /* Bóng nhẹ */
        }
    </style>


</head>


<body class="">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <aside class="sidebar sidebar-default navs-rounded-all">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ route('Home.index') }}" class="navbar-brand">
                <img src="{{ asset('SR-TECH/icon/srtech.png') }}" style="height: 30px">
                <h4 class="logo-title">{{ env('APP_NAME') }}</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list" id="sidebar">
                @include('srtech.WareHouse.layouts.warehouse-menu')
            </div>
        </div>

    </aside>
    <main class="main-content">
        <div class="position-relative">
            @include('srtech.layouts._body_header')
        </div>

        <div class="conatiner-fluid content-inner py-0">
            @yield('content')

        </div>

        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item">Privacy Policy</a>
                    </li>
                    <li class="list-inline-item">Terms of Use</a></li>
                </ul>
                <div class="right-panel">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script> {{ env('APP_NAME') }}, Made with
                    <span class="text-gray">
                    </span> by <a href="{{ route('Home.index') }}">Prod.Inno G Design</a>.
                </div>
            </div>
        </footer>
    </main>


    @include('srtech.layouts._scripts')

    <script src="{{ asset('checklist-ilsung/js/select-boxes.js') }}"></script>
    <script src="{{ asset('laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('jquery-ui/auto.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const notificationList = document.getElementById("notification-list");
            const notificationBadge = document.querySelector("#notification-drop .dots");

            // Fetch pending users notifications
            fetch("{{ route('show.messing') }}")
                .then(response => response.json())
                .then(data => {
                    const {
                        notifications,
                        count
                    } = data;

                    // Update notification badge count
                    if (count > 0) {
                        notificationBadge.style.display = "inline-block"; // Hiển thị badge
                        notificationBadge.textContent = count; // Cập nhật số lượng
                    } else {
                        notificationBadge.style.display = "none"; // Ẩn badge nếu không có thông báo
                    }

                    // Update notification list
                    notificationList.innerHTML = ""; // Clear the current list
                    if (notifications.length > 0) {
                        notifications.forEach(user => {
                            const notificationItem = `
                        <a href="#" class="iq-sub-card">
                            <div class="d-flex align-items-center">
                                 <img class="avatar-40 rounded-pill bg-soft-primary p-1"
                                     src="{{ asset('images/avatars/01.png') }}" alt="Avatar">
                                <div class="ms-3 w-100">
                                    <h6 class="mb-0 ">${user.username}</h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0">Pending approval</p>
                                       
                                    </div>
                                </div>
                            </div>
                        </a>
                    `;
                            notificationList.innerHTML += notificationItem;
                        });
                    } else {
                        notificationList.innerHTML = `<p class="text-center my-3">No pending notifications</p>`;
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        });
    </script>

    @yield('admin-js')
</body>

</html>
