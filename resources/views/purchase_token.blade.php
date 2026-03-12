@extends('template')
@section('content')
<div>
    <form method="POST" action="{{route("purchase-token.verify", ['purchaseToken'=>1])}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-3 pb-2">
                <label for="identification">Nro. de cédula</label>
                <input id="identification" type="text" name="identification"
                       class="form-control form-control-sm"
                       required>
            </div>
            <div class="col-md-3 pb-2">
                <label for="phone">Celular</label>
                <input id="phone" type="text" name="phone"
                       class="form-control form-control-sm"
                       required>
            </div>
            <div class="col-md-3 pb-2">
                <label for="email">Correo</label>
                <input id="email" type="email" name="email"
                       class="form-control form-control-sm"
                       required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 pb-2">
                <label for="identification_front">Identificación - Frontal</label>
                <input id="identification_front" type="file" name="identification_front"
                       class="form-control form-control-sm"
                       required>
            </div>
            <div class="col-md-3 pb-2">
                <label for="identification_back">Identificación - Reverso</label>
                <input id="identification_back" type="file" name="identification_back"
                       class="form-control form-control-sm"
                       required>
            </div>
            <div class="col-md-3 pb-2">
                <label for="selfie">Selfie</label>
                <input id="selfie" type="file" name="selfie"
                       class="form-control form-control-sm"
                       required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mx-auto">
                <input class="btn btn-primary" type="submit" value="Enviar">
            </div>
        </div>

    </form>
</div>
@endsection
