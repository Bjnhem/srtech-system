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
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Buttons-2.4.2/css/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('smart-ver2/DataTables/RowGroup-1.4.1/css/rowGroup.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/jQuery-3.7.0/jquery-3.7.0.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/Select-1.7.0/css/select.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('smart-ver2/css/components/datepicker.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('checklist-ilsung/css/toastr.min.css') }}" type="text/css" />


    <style>
        th.hide-search input {
            display: none;
        }
    </style>

</head>

<body class="">
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>

    </div>

    <main class="main-content">

        <div class="conatiner-fluid content-inner mt-4 py-0">
            @yield('content')

        </div>

        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item"><a href="{{ route('pages.privacy-policy') }}">Privacy Policy</a></li>
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
                    </span> by <a href="{{ route('Home.index') }}">Prod.Inno G Design</a>.
                </div>
            </div>
        </footer>
    </main>

    @include('ilsung.layouts._scripts')
    @include('ilsung.partials.dashboard._app_toast')
    @yield('admin-js')

</body>

</html>
