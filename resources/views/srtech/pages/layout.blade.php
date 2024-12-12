<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check list EQM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('admin//img/svg/logo.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('smart-ver2/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">


    <link rel="stylesheet" href="{{ asset('jquery-ui/auto.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('smart-ver2/custom-2.css') }}" />

    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/css/rowGroup.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Select-1.7.0/css/select.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/components/datepicker.css') }}" type="text/css" />


    <link rel="stylesheet" href="{{ asset('vendor/laravel-filemanager/css/lfm.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/custom-admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/overview.css') }}" />



    <base href="{{ env('APP_URL') }}">
</head>

<body>
    <div class="layer"></div>
    <!-- ! Body -->
    <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
    <div class="page-flex">

        <aside class="sidebar">
            <div class="sidebar-start">
                <div class="sidebar-head">
                    <a href="{{ route('home') }}" class="logo-wrapper" title="Home">
                        <span class="sr-only">Home</span>
                        <div class="logo-text">
                            <span class="logo-title">ILSUNG-SYSTEM</span>
                        </div>

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

                <div class="sidebar-body">
                    <ul class="sidebar-body-menu">
                        <li>
                            <a class="show-cat-btn" href="{{ route('home') }}" id="Overview">
                                <span class="icon-home" style="padding-right:5px" aria-hidden="true"></span>
                                Overview

                            </a>
                        </li>
                        <li>
                            <a class="show-cat-btn" href="{{ route('Check.checklist') }}" id="Checklist">
                                <span class="icon-line-check-square" style="padding-right:5px"
                                    aria-hidden="true"></span>
                                Checklist

                            </a>
                        </li>

                        <li>
                            <a class="show-cat-btn" href="{{ route('Plan.checklist') }}" id="Plan">
                                <span class="icon-line-database" style="padding-right:5px" aria-hidden="true"></span>
                                Tạo Plan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu" role="button"
                                aria-expanded="false" aria-controls="horizontal-menu">
                                <i class="icon">
                                    <svg width="20" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.4"
                                            d="M10.0833 15.958H3.50777C2.67555 15.958 2 16.6217 2 17.4393C2 18.2559 2.67555 18.9207 3.50777 18.9207H10.0833C10.9155 18.9207 11.5911 18.2559 11.5911 17.4393C11.5911 16.6217 10.9155 15.958 10.0833 15.958Z"
                                            fill="currentColor"></path>
                                        <path opacity="0.4"
                                            d="M22.0001 6.37867C22.0001 5.56214 21.3246 4.89844 20.4934 4.89844H13.9179C13.0857 4.89844 12.4102 5.56214 12.4102 6.37867C12.4102 7.1963 13.0857 7.86 13.9179 7.86H20.4934C21.3246 7.86 22.0001 7.1963 22.0001 6.37867Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M8.87774 6.37856C8.87774 8.24523 7.33886 9.75821 5.43887 9.75821C3.53999 9.75821 2 8.24523 2 6.37856C2 4.51298 3.53999 3 5.43887 3C7.33886 3 8.87774 4.51298 8.87774 6.37856Z"
                                            fill="currentColor"></path>
                                        <path
                                            d="M21.9998 17.3992C21.9998 19.2648 20.4609 20.7777 18.5609 20.7777C16.6621 20.7777 15.1221 19.2648 15.1221 17.3992C15.1221 15.5325 16.6621 14.0195 18.5609 14.0195C20.4609 14.0195 21.9998 15.5325 21.9998 17.3992Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </i>
                                <span class="item-name">Master</span>
                                <i class="right-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </i>
                            </a>
                            <ul class="sub-nav collapse" id="horizontal-menu" data-bs-parent="#sidebar">
                                <li class="nav-item ">
                                    <a class="nav-link {{ route('update.data.checklist') }}"
                                        href="{{ route('update.data.checklist') }}">
                                        <i class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"></i>
                                        <span class="item-name"> Data checklist </span>
                                    </a>
                                </li>

                                <li class=" nav-item ">
                                    <a class="nav-link {{ route('update.data.line') }}"
                                        href="{{ route('update.data.line') }}">
                                        <i class="icon svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                viewBox="0 0 24 24" fill="currentColor">
                                                <g>
                                                    <circle cx="12" cy="12" r="8" fill="currentColor">
                                                    </circle>
                                                </g>
                                            </svg>
                                        </i>
                                        <i class="sidenav-mini-icon"></i>
                                        <span class="item-name">Data line</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li>
                            <a class="show-cat-btn" href="{{ route('user.checklist') }}" id="User">
                                <span class="icon-line-users" style="padding-right:5px" aria-hidden="true"></span>
                                User
                            </a>
                        </li>




                        {{--  <li>
                            <a class="show-cat-btn" href="{{ route('table.index') }}" id="update">
                                <span class="icon-line-database" style="padding-right:5px" aria-hidden="true"></span>
                                Update Data
                            </a>
                        </li> --}}
                        {{--  <li>
                            <a class="show-cat-btn" href="{{ route('user.index') }}" id="user">
                                <span class="icon user-3" aria-hidden="true"></span>Users
                            </a>
                        </li> --}}

                        {{--   <li>
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="show-cat-btn"
                                href="">
                                <span class="icon image" aria-hidden="true"></span>Media Image

                            </a>
                        </li> --}}
                        {{--  <li>
                            <a href="{{ route('table.index') }}">
                                <span class="icon message" aria-hidden="true"></span>
                                Update Data Table <table></table>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </aside>
        <div class="main-wrapper">

            <main class="main users chart-page" id="skip-target">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Chart library -->
    <script src="{{ asset('admin/plugins/chart.min.js') }}"></script>
    <!-- Icons library -->
    <script src="{{ asset('admin/plugins/feather.min.js') }}"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('admin/plugins/script.js') }}"></script>



    <script src="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('jquery-ui/auto.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/pdfmake-0.2.7/pdfmake.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/jszip-3.10.1/jszip.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/pdfmake-0.2.7/vfs_fonts.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/js/dataTables.rowGroup.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/DataTables/Select-1.7.0/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/jquery-tabledit/jquery.tabledit.js') }}"></script>


    <script src="{{ asset('smart-ver2/js/plugins.min.js') }}"></script>

    <!-- Footer Scripts============================================= -->
    {{--    <script src="{{ asset('smart-ver2/js/plugins.bootstrap.js') }}"></script> --}}

    <script src="{{ asset('smart-ver2/js/functions.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chart.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chartjs-plugin-datalabels-v1.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/select-boxes.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/selectsplitter.js') }}"></script>
    {{-- <script src="http://localhost/ilsung-system/public/js/hope-ui.js"></script> --}}

    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>





    @yield('admin-js')

    <script>
        $(document).ready(function() {


            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            var activeItem = localStorage.getItem('activeItem');

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

            let list = document.querySelectorAll(".sidebar-body-menu a");
            list.forEach((item) => item.addEventListener('click', activeLink));
        });
    </script>


</body>

</html>
