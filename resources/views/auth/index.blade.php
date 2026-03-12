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

        .image-upload > input {
            display: none;
        }
    </style>
    @yield('style')
</head>
<body>
<div class="container">
    <div class="row col-md-4 mx-auto pt-4">
        <form action="{{route('login.post')}}" method="POST">
            @csrf
            <div class="text-cente py-2">
                <h3>Ingresar</h3>
            </div>
            @include('commons.messages')
            <div class="form-group">

                <label for="email">Correo</label>
                <input type="text" id="email" name="email" class="form-control form-control-sm"
                       placeholder="Correo">

            </div>
            <div class="form-group">

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control form-control-sm"
                       placeholder="Contraseña">

            </div>
            <div class="py-2 text-center">
                <button class="btn btn-primary">Ingresar</button>
            </div>
        </form>
    </div>
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
