<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEVT PRO-3M</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('admin//img/svg/logo.svg') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('smart-ver2/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/magnific-popup.css') }}" type="text/css" />

   
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
                    <a href="{{ route('admin.checklist') }}" class="logo-wrapper" title="Home">
                        <span class="sr-only">Home</span>
                        <div class="logo-text">
                            <span class="logo-title">SEVT PRO-3M</span>
                        </div>

                    </a>
                </div>

                <div class="sidebar-body">
                    <ul class="sidebar-body-menu">
                        <li>
                            <a class="show-cat-btn" href="{{ route('admin.checklist') }}" id="Checklist">
                                <span class="icon-line-check-square" style="padding-right:5px"
                                    aria-hidden="true"></span>
                                Checklist

                            </a>
                        </li>
                        <li>
                            <a class="show-cat-btn" href="{{ route('admin.checklist.search') }}" id="Checklist-Result">
                                <span class="icon-line-check-square" style="padding-right:5px"
                                    aria-hidden="true"></span>
                                Checklist-Result

                            </a>
                        </li>

                        <li>
                            <a class="show-cat-btn" href="{{ route('admin.checklist.pending') }}" id="Checklist-Pending">
                                <span class="icon-line-check-square" style="padding-right:5px"
                                    aria-hidden="true"></span>
                                Checklist-Pending

                            </a>
                        </li>

                        <li>
                            <a class="show-cat-btn" href="{{ route('admin.checklist.edit') }}" id="Checklist-Edit">
                                <span class="icon-line-check-square" style="padding-right:5px"
                                    aria-hidden="true"></span>
                                Checklist-Edit

                            </a>
                        </li>
                        <li>
                            <a class="show-cat-btn" href="{{ route('master.index') }}" id="master">
                                <span class="icon-line-database" style="padding-right:5px" aria-hidden="true"></span>
                               Masster Data
                            </a>
                        </li>
                        <li>
                            <a class="show-cat-btn" href="{{ route('table.index') }}" id="update">
                                <span class="icon-line-database" style="padding-right:5px" aria-hidden="true"></span>
                                Update Data
                            </a>
                        </li>

                        <li>
                            <a class="show-cat-btn" href="{{ route('admin.checklist.historry') }}" id="historry">
                                <span class="icon-line-database" style="padding-right:5px" aria-hidden="true"></span>
                                historry
                            </a>
                        </li>
                        {{--  <li>
                            <a class="show-cat-btn" href="{{ route('user.index') }}" id="user">
                                <span class="icon user-3" aria-hidden="true"></span>Users
                            </a>
                        </li> --}}

                          <li>
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="show-cat-btn"
                                href="">
                                <span class="icon image" aria-hidden="true"></span>Media Image

                            </a>
                        </li>
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
            {{--  <nav class="main-nav--bg">
                <div class="container main-nav">
                    <div class="main-nav-start">
                        <div class="search-wrapper">
                            <i data-feather="search" aria-hidden="true"></i>
                            <input type="text" placeholder="Enter keywords ..." required>
                        </div>
                    </div>
                    <div class="main-nav-end">
                        <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                            <span class="sr-only">Toggle menu</span>
                            <span class="icon menu-toggle--gray" aria-hidden="true"></span>
                        </button>
                        <div class="lang-switcher-wrapper">
                            <button class="lang-switcher transparent-btn" type="button">
                                EN
                                <i data-feather="chevron-down" aria-hidden="true"></i>
                            </button>
                            <ul class="lang-menu dropdown">
                                <li><a href="##">English</a></li>
                                <li><a href="##">French</a></li>
                                <li><a href="##">Uzbek</a></li>
                            </ul>
                        </div>
                        <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
                            <span class="sr-only">Switch theme</span>
                            <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
                            <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
                        </button>
                        <div class="notification-wrapper">
                            <button class="gray-circle-btn dropdown-btn" title="To messages" type="button">
                                <span class="sr-only">To messages</span>
                                <span class="icon notification active" aria-hidden="true"></span>
                            </button>
                            <ul class="users-item-dropdown notification-dropdown dropdown">
                                <li>
                                    <a href="##">
                                        <div class="notification-dropdown-icon info">
                                            <i data-feather="check"></i>
                                        </div>
                                        <div class="notification-dropdown-text">
                                            <span class="notification-dropdown__title">System just updated</span>
                                            <span class="notification-dropdown__subtitle">The system has been
                                                successfully upgraded. Read more
                                                here.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="notification-dropdown-icon danger">
                                            <i data-feather="info" aria-hidden="true"></i>
                                        </div>
                                        <div class="notification-dropdown-text">
                                            <span class="notification-dropdown__title">The cache is full!</span>
                                            <span class="notification-dropdown__subtitle">Unnecessary caches take up a
                                                lot of memory space and
                                                interfere ...</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="##">
                                        <div class="notification-dropdown-icon info">
                                            <i data-feather="check" aria-hidden="true"></i>
                                        </div>
                                        <div class="notification-dropdown-text">
                                            <span class="notification-dropdown__title">New Subscriber here!</span>
                                            <span class="notification-dropdown__subtitle">A new subscriber has
                                                subscribed.</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="link-to-page" href="##">Go to Notifications page</a>
                                </li>
                            </ul>
                        </div>
                        <div class="nav-user-wrapper">
                            <button href="##" class="nav-user-btn dropdown-btn" title="My profile"
                                type="button">
                                <span class="sr-only">My profile</span>
                                <span class="nav-user-img">
                                    <picture>
                                        <source srcset="{{ asset('admin/img/avatar/avatar-illustrated-02.webp') }}"
                                            type="image/webp">
                                        <img src="{{ asset('admin/img/avatar/avatar-illustrated-02.png') }}"
                                            alt="User name">
                                    </picture>
                                </span>
                            </button>
                            <ul class="users-item-dropdown nav-user-dropdown dropdown">
                                <li><a href="##">
                                        <i data-feather="user" aria-hidden="true"></i>
                                        <span>Profile</span>
                                    </a></li>
                                <li><a href="##">
                                        <i data-feather="settings" aria-hidden="true"></i>
                                        <span>Account settings</span>
                                    </a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="danger"> <i data-feather="log-out"
                                                aria-hidden="true"></i>
                                            <span>Log out</span>
                                        </button>

                                    </form>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav> --}}
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
         {{-- <script src="{{ asset('smart-ver2/js/plugins.bootstrap.js') }}"></script> --}}
 
    <script src="{{ asset('smart-ver2/js/functions.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chart.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/chartjs-plugin-datalabels-v1.min.js') }}"></script>
    <script src="{{ asset('smart-ver2/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/datepicker.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/select-boxes.js') }}"></script>
    <script src="{{ asset('smart-ver2/js/components/selectsplitter.js') }}"></script>

    @yield('admin-js')

    <script>
        $(document).ready(function() {

            var route_prefix = "laravel-filemanager";
            $('#lfm').filemanager('image', {
                prefix: route_prefix
            });

            $('.component-datepicker.input-daterange').datepicker({
                autoclose: true
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
