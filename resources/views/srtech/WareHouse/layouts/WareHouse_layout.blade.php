{{-- @props(['dir']) --}}
<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}"> --}}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    {{-- <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">

    <link rel="stylesheet" href="{{ asset('checklist-ilsung/jquery-ui/auto.css') }}">
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/css/rowGroup.dataTables.min.css') }}" />
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
                        <svg width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z"
                                fill="currentColor"></path>
                        </svg>
                    </span> by <a href="{{ route('Home.checklist') }}">Prod.Inno G Design</a>.
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
