@props(['dir'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $dir ? 'rtl' : 'ltr' }}">

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

    <style>
        th.hide-search input {
            display: none;
        }
    </style>


    {{-- @include('partials.dashboard._head') --}}
</head>

<body class="">
    @include('partials.dashboard._body')
</body>

</html>
