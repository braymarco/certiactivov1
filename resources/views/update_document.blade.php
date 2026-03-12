@extends('template')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="pt-4 text-center">
                <div>
                    <h3> Actualizar Documento</h3>
                </div> <div>
                    <h3> {{$label}}</h3>
                </div>

            </div>
            @include('commons.messages')
            @if(strlen($docUp->comentario)>0)
                <div class="my-2 alert alert-info">
                    {{$docUp->comentario}}
                </div>
            @endif

            <div class="py-2">
                Documento anterior enviado: <a target="_blank" href="{{route('document.descargar_documento_previo',[
    'token'=>$docUp->token
])}}">
                    {{route('document.descargar_documento_previo',[
    'token'=>$docUp->token
])}}
                </a>
            </div>
            <form action="{{route('document.view_post',[
    'token'=>$docUp->token
])}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="pt-2">
                    <div class="mb-3">
                        <label for="{{$docUp->type}}" class="form-label">Nuevo Documento - {{$label}}</label>
                        <input class="form-control" name="{{$docUp->type}}" type="file" id="{{$docUp->type}}"  >
                    </div>
                </div>
                <div class="pt-2 text-center">
                    <button class="btn btn-success">Enviar Requisito</button>
                </div>

            </form>
        </div>
    </div>

@endsection
