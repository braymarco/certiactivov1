@extends('template')
@section('style')
    <style>
        .card{
            height: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="d-none d-md-block" style="padding-top: 40px">

    </div>
    <div class="py-2 text-center">
        <h3>Seleccione la persona a utilizar la firma electrónica</h3>
    </div>

    <div class="row">
        <div class="col-md-4 py-2">
            <div class="card pointer" onclick="window.location.href='{{$linkPnatural}}'">

                <div class="card-body d-flex flex-column">
                    <div class="text-center ">
                        <img src="{{asset('assets/img/pnatural.png')}}"
                             style="max-height: 239px"
                             class="img-fluid rounded" alt="Persona Natural">
                    </div>
                    <h2 class="card-title text-center">Persona Natural</h2>
                    <p class="card-text">Para firmar documentos o facturas personales, con RUC o sin RUC</p>
                    <div class="d-grid gap-2 mt-auto">
                        <a href="{{$linkPnatural}}" class="btn btn-primary">Solicitar</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2">
            <div class="card pointer" onclick="window.location.href='{{$linkRempresa}}'">
                <div class="card-body  d-flex flex-column">
                    <div class="text-center ">
                        <img
                            style="max-height: 239px"
                            src="{{asset('assets/img/rempresa.png')}}" class="img-fluid rounded"
                            alt="Representante legal">
                    </div>
                    <h2 class="card-title text-center">Representante legal</h2>
                    <p class="card-text">Para firmar documentos corporativos o facturas</p>
                    <div class="d-grid gap-2 mt-auto">

                        <a href="{{$linkRempresa}}" class="btn btn-primary">Solicitar</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 py-2">
            <div class="card pointer" onclick="window.location.href='{{$linkMempresa}}'">
                <div class="card-body d-flex flex-column">
                    <div class="text-center ">
                        <img
                            style="max-height: 239px"
                            src="{{asset('assets/img/mempresa.png')}}" class="img-fluid rounded"
                            alt="Miembro de empresa">
                    </div>
                    <h2 class="card-title text-center">Miembro de empresa</h2>
                    <p class="card-text">Para firmar documentos o trámites empresariales</p>
                    <div class="d-grid gap-2 mt-auto">

                        <a href="{{$linkMempresa}}" class="btn btn-primary">Solicitar</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
