<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/libs.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hope-ui.css?v=1.0') }}">

    <link rel="stylesheet" href="{{ asset('vendor/aos/dist/aos.css') }}" />

    <style>
        th.hide-search input {
            display: none;
        }
    </style>


</head>

<body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    
    <div class="wrapper">
        @yield('content')
    </div>
    {{-- @include('srtech.layouts._scripts') --}}
    <script src="{{ asset('js/libs.min.js') }}"></script>
    <script src="{{ asset('js/hope-ui.js') }}"></script>
    <script src="{{ asset('checklist-ilsung/js/toastr.min.js') }}"></script>
    @yield('admin-js')
</body>

</html>
