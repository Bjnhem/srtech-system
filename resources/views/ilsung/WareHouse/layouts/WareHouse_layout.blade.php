{{-- @props(['dir']) --}}
<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}"> --}}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ILSUNG SYSTEM</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.1.0') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css?v=1.1.0') }}">
    <link rel="stylesheet" href="{{ asset('css/dark.css?v=1.1.0') }}">
    <link rel="stylesheet" href="{{ asset('css/rtl.css?v=1.1.0') }}">
    <link rel="stylesheet" href="{{ asset('css/customizer.css?v=1.1.0') }}">


    <!-- Fullcalender CSS -->
    <link rel='stylesheet' href="{{ asset('vendor/fullcalendar/core/main.css') }}" />
    <link rel='stylesheet' href="{{ asset('vendor/fullcalendar/daygrid/main.css') }}" />
    <link rel='stylesheet' href="{{ asset('vendor/fullcalendar/timegrid/main.css') }}" />
    <link rel='stylesheet' href="{{ asset('vendor/fullcalendar/list/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/Leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/vanillajs-datepicker/dist/css/datepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />





    {{-- <link rel="stylesheet" href="{{asset('vendor/aos/dist/aos.css')}}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('laravel-filemanager/css/lfm.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="{{ asset('smart-ver2/custom-admin.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/overview.css') }}" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/icon.css') }}" />

    {{-- <link rel="stylesheet" href="{{ asset('smart-ver2/css/bootstrap.css') }}" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/magnific-popup.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('checklist-ilsung/jquery-ui/auto.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/font_awesome.min.css') }}"> --}}
    <!-- Font Awesome CDN -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/css/rowGroup.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Select-1.7.0/css/select.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/components/datepicker.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/toastr.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/select-boxes.css') }}" type="text/css" />


    <style>
        th.hide-search input {
            display: none;
        }
    </style>

</head>

<body class="">
    {{-- @include('partials.dashboard._body') --}}
    <div id="loading">
        {{-- @include('partials.dashboard._body_loader') --}}
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>

    </div>
    {{-- @include('partials.dashboard._body_sidebar') --}}
    <aside class="sidebar sidebar-default navs-rounded-all">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ route('Home.index') }}" class="navbar-brand">
                <img src="{{ asset('checklist-ilsung/icon/logo_ilsung.png') }}" style="height: 30px">
                <h4 class="logo-title">ILSUNG</h4>
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
                @include('ilsung.WareHouse.layouts.menu')

                {{-- @include('partials.dashboard.sub-header') --}}
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <div class="position-relative">
            @include('ilsung.WareHouse.layouts._body_header')
            {{-- @include('partials.dashboard.sub-header') --}}
        </div>

        <div class="conatiner-fluid content-inner mt-4 py-0">
            @yield('content')

            {{-- {{ $slot }} --}}
        </div>

        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item"><a href="{{ route('pages.privacy-policy') }}">Privacy Policy</a>
                    </li>
                    <li class="list-inline-item"><a href="{{ route('pages.term-of-use') }}">Terms of Use</a></li>
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
    <a class="btn btn-fixed-end btn-warning btn-icon btn-setting" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <svg width="24" viewBox="0 0 24 24" class="animated-rotate" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M20.8064 7.62361L20.184 6.54352C19.6574 5.6296 18.4905 5.31432 17.5753 5.83872V5.83872C17.1397 6.09534 16.6198 6.16815 16.1305 6.04109C15.6411 5.91402 15.2224 5.59752 14.9666 5.16137C14.8021 4.88415 14.7137 4.56839 14.7103 4.24604V4.24604C14.7251 3.72922 14.5302 3.2284 14.1698 2.85767C13.8094 2.48694 13.3143 2.27786 12.7973 2.27808H11.5433C11.0367 2.27807 10.5511 2.47991 10.1938 2.83895C9.83644 3.19798 9.63693 3.68459 9.63937 4.19112V4.19112C9.62435 5.23693 8.77224 6.07681 7.72632 6.0767C7.40397 6.07336 7.08821 5.98494 6.81099 5.82041V5.82041C5.89582 5.29601 4.72887 5.61129 4.20229 6.52522L3.5341 7.62361C3.00817 8.53639 3.31916 9.70261 4.22975 10.2323V10.2323C4.82166 10.574 5.18629 11.2056 5.18629 11.8891C5.18629 12.5725 4.82166 13.2041 4.22975 13.5458V13.5458C3.32031 14.0719 3.00898 15.2353 3.5341 16.1454V16.1454L4.16568 17.2346C4.4124 17.6798 4.82636 18.0083 5.31595 18.1474C5.80554 18.2866 6.3304 18.2249 6.77438 17.976V17.976C7.21084 17.7213 7.73094 17.6516 8.2191 17.7822C8.70725 17.9128 9.12299 18.233 9.37392 18.6717C9.53845 18.9489 9.62686 19.2646 9.63021 19.587V19.587C9.63021 20.6435 10.4867 21.5 11.5433 21.5H12.7973C13.8502 21.5001 14.7053 20.6491 14.7103 19.5962V19.5962C14.7079 19.088 14.9086 18.6 15.2679 18.2407C15.6272 17.8814 16.1152 17.6807 16.6233 17.6831C16.9449 17.6917 17.2594 17.7798 17.5387 17.9394V17.9394C18.4515 18.4653 19.6177 18.1544 20.1474 17.2438V17.2438L20.8064 16.1454C21.0615 15.7075 21.1315 15.186 21.001 14.6964C20.8704 14.2067 20.55 13.7894 20.1108 13.5367V13.5367C19.6715 13.284 19.3511 12.8666 19.2206 12.3769C19.09 11.8873 19.16 11.3658 19.4151 10.928C19.581 10.6383 19.8211 10.3982 20.1108 10.2323V10.2323C21.0159 9.70289 21.3262 8.54349 20.8064 7.63277V7.63277V7.62361Z"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <circle cx="12.1747" cy="11.8891" r="2.63616" stroke="currentColor" stroke-width="1.5"
                stroke-linecap="round" stroke-linejoin="round"></circle>
        </svg>
    </a>

    @include('ilsung.partials.components.setting-offcanvas')
    @include('ilsung.layouts._scripts')
    @include('ilsung.partials.dashboard._app_toast')
    <!-- Backend Bundle JavaScript -->

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="main_form"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/datatables.min.js') }}"></script>

    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/pdfmake-0.2.7/pdfmake.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/jszip-3.10.1/jszip.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/pdfmake-0.2.7/vfs_fonts.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/js/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Select-1.7.0/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/jquery-tabledit/jquery.tabledit.js') }}"></script> --}}


    {{-- <script src="{{ asset('smart-ver2/js/plugins.min.js') }}"></script> --}}

    <!-- Footer Scripts============================================= -->
    {{--    <script src="{{ asset('smart-ver2/js/plugins.bootstrap.js') }}"></script> --}}

    {{-- <script src="{{ asset('smart-ver2/js/functions.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chart.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chartjs-plugin-datalabels-v1.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/tinymce/tinymce.min.js') }}"></script>

    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/select-boxes.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/selectsplitter.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/hope-ui.js') }}"></script> --}}
    <script src="{{ asset('checklist-ilsung/js/select-boxes.js') }}"></script>
    <script src="{{ asset('laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('jquery-ui/auto.js') }}"></script>

    @yield('admin-js')
</body>

</html>
