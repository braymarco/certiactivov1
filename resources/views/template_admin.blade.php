<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Certiactivo | {{$title??'Firma Electrónica'}}</title>
    <link rel="icon" type="image/png" href="{{asset('logo.png')}}">

    <link href="
https://cdn.jsdelivr.net/npm/roboto-font@0.1.0/css/fonts.min.css
" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/bootstrap.min.css')}}">
    <style>
        .pointer {
            cursor: pointer;
        }
        .image-upload>input {
            display: none;
        }
    </style>
    @yield('head')
    @yield('style')
</head>
<body>
@include('commons.navbar')
<div class="container">
    @yield('content')
</div>
<script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/popper.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://unpkg.com/vue@3.4.11/dist/vue.global.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('script')
</body>
</html>
