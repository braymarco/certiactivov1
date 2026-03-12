@extends('template')
@section('content')
    <div class="pt-3">
        <div class="card">
            <div class="card-body">
                <div class="text-center">
                    <h4>Solicitud Firma Electrónica <br> {{$solicitud->plan->name}}</h4>
                </div>
                <hr>
                <div>
                    <b>Estado: </b>{{$solicitud->estadoStr()}}
                </div>
                <div>
                    <b>Nombres: </b>{{$solicitud->fullName()}}
                </div>

                <div class="row pt-3">
                    @foreach($documentosActivos as $documento)
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h4> {{$documento->tipoStr()}}</h4>
                                    </div>
                                    <hr>
                                    <div>
                                        Estado: {{$documento->statusStr()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@endsection
