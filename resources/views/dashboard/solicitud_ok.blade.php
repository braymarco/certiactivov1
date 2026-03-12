@extends('template_admin')
@section('head')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"></link>
@endsection
@section('content')

    <div class="card" id="app">
        <div class="card-body">
            @include('commons.messages')
            <div class="text-center">
                <h4>{{$solicitud->estadoStr()}}</h4>
            </div>
            <div class="py-2">
                <div>
                    <b>Tipo de Solicitud: </b> {{$solicitud->tipoStr()}}
                </div>
                <div>
                    <b>Inicio de Solicitud: </b>{{$solicitud->created_at}}
                </div>
                <div>
                    <b>Requisitos Validados: </b>{{$solicitud->fecha_requisitos_validados}}
                </div>
                <div>
                    <b>Estado: </b>{{$solicitud->estadoLocalStr()}}
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <b>Tipo Documento: </b>
                    {{$tiposDocumentoID[$solicitud->tipo_documento]}}
                </div>
                <div class="col-6">
                    <b>Número Documento: </b>{{$solicitud->nro_documento}}
                </div>
                <div class="col-6">
                    <b>Código Dactilar: </b>{{$solicitud->codigo_dactilar}}
                </div>
                <div class="col-6">
                    <b>Nombres: </b>{{$solicitud->nombres}}
                </div>
                <div class="col-6">
                    <b>Apellido1: </b>{{$solicitud->apellido1}}
                </div>
                <div class="col-6">
                    <b>Apellido2: </b>{{$solicitud->apellido2}}
                </div>
                <div class="col-6">
                    <b>Fecha Nacimiento: </b>{{$solicitud->fecha_nacimiento}}
                </div>
                <div class="col-6">
                    <b>Nacionalidad: </b>{{$solicitud->nacionalidad}}
                </div>
                <div class="col-6">
                    <b>Sexo: </b>{{$solicitud->sexo}}
                </div>
                <div class="col-6">
                    <b>Celular: </b>{{$solicitud->celular}}
                </div>
                <div class="col-6">
                    <b>Email: </b>{{$solicitud->email}}
                </div>
                @if($solicitud->tipo=='pnatural' && $solicitud->con_ruc)
                    <div class="col-6">
                        <b>RUC: </b>{{$solicitud->nro_ruc}}
                    </div>
                @endif
            </div>
            @if($solicitud->tipo!='pnatural')
                <div class="py-2">
                    <b> Datos de la Empresa</b>
                </div>
                <div class="row">
                    <div class="col-6">
                        <b>RUC: </b>{{$solicitud->nro_ruc}}
                    </div>
                    <div class="col-6">
                        <b> Razón social: </b>{{$solicitud->empresa}}
                    </div>
                    @if($solicitud->tipo==='mempresa')
                        <div class="col-6">
                            <b> Area: </b>{{$solicitud->unidad}}
                        </div>

                    @endif
                    <div class="col-6">
                        <b>  @if($solicitud->tipo==='mempresa')
                                Cargo del Solicitante
                            @else
                                Cargo del representante
                            @endif: </b>{{$solicitud->cargo}}
                    </div>

                </div>
            @endif
            @if($solicitud->tipo=='mempresa')
                <div class="py-2">
                    <b> Datos del Representante Legal </b>
                </div>
                <div class="col-6">
                    <b>Tipo Documento: </b>
                    {{$tiposDocumentoID[$solicitud->tipo_documento_rl]}}
                </div>
                <div class="col-6">
                    <b>Número Documento: </b>{{$solicitud->nro_documento_rl}}
                </div>
                <div class="col-6">
                    <b>Número Documento: </b>{{$solicitud->nombres_rl}}
                </div>
                <div class="col-6">
                    <b>Número Documento: </b>{{$solicitud->apellido1_rl}}
                </div>
                <div class="col-6">
                    <b>Número Documento: </b>{{$solicitud->apellido2_rl}}
                </div>
            @endif
            <div class="py-2">
                @if($solicitud->tipo=='pnatural')

                    <b> Dirección Domicilio</b>
                @else
                    <b>Dirección de la Empresa</b> <small> (especificada en el ruc)</small>
                @endif
            </div>
            <div class="row">
                <div class="col-6">
                    <b>Provincia: </b>{{$solicitud->provincia->nombre}}
                </div>
                <div class="col-6">
                    <b>Cantón: </b>{{$solicitud->canton->nombre}}
                </div>
                <div class="col-6">
                    <b>Dirección: </b>{{$solicitud->direccion}}
                </div>
            </div>
            <div class="py-2">
                <b> Formato y tiempo de vigencia</b>
            </div>
            <div class="row">
                <div class="col-6">
                    <b>Formato: </b>{{$formatosFirma[$solicitud->formato]}}
                </div>
                <div class="col-6">
                    <b>Vigencia: </b>{{$solicitud->plan->name}}
                </div>
            </div>
            @if($solicitud->estado!=$estadosSolicitud::$ISSUED)
                <div class="py-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <form action="{{route('solicitud.firma_emitida',[
    'id'=> $solicitud->id
])}}" method="POST">
                                @csrf

                                <button class="btn btn-success">
                                    Firma Emitida
                                </button>
                            </form>
                        </div>
                        <div class="col-6">

                            <form action="{{route('solicitud.proveedor_cambio_doc',[
    'id'=> $solicitud->id
])}}" method="POST">
                                @csrf
                                <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                                <button class="btn btn-danger">
                                    Cambio de Documentación
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            @endif

            @if( $solicitud->uanatacaRequestFirst()==null )
                <div class="row">
                    <div class="col-auto">
                        <form action="{{route('solicitud.firma_enviar_proveedor',[
    'id'=>$solicitud->id
])}}"
                              method="POST">
                            @csrf
                            <button class="btn btn-warning">Envío a proveedor</button>
                        </form>
                    </div>
                    <div class="col-auto">
                        <form action="{{route('solicitud.check_status',[
    'id'=>$solicitud->id
])}}"
                              method="POST">
                            @csrf
                            <button class="btn btn-info">Buscar solicitud remota</button>
                        </form>
                    </div>


                </div>
            @else
                <div class="row">
                    <div class="col-auto">
                        <form action="{{route('solicitud.check_status',[
    'id'=>$solicitud->id
])}}"
                              method="POST">
                            @csrf
                            <button class="btn btn-info">Consultar Estado</button>
                        </form>
                    </div>
                </div>
            @endif
            <div>
                <div class="text-center">
                    <h5>Respuesta Proveedor</h5>
                </div>
                <b> Proceso Local</b>
                <div>
                    <textarea class="form-control" disabled>{{$internalResponse}}</textarea>
                </div>
                <b>Proceso Remoto</b>
                <div>
                    <textarea class="form-control" disabled>{{  $messageResponse }}</textarea>
                </div>
                <b>Información adicional</b>
                <div>
                    @foreach($solicitud->additionalInfo as $index => $additionalInfo)
                        <div class="my-1">
                            <textarea class="form-control" disabled>{{  $additionalInfo->content }}</textarea>
                            <div class="my-1">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalAdditionalInfo"
                                        data-content="{{ $additionalInfo->content }}" data-index="{{ $index + 1 }}">
                                    Abrir
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Modal dinámico para información adicional -->
            <div class="modal fade" id="modalAdditionalInfo" tabindex="-1" aria-labelledby="modalAdditionalInfoLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalAdditionalInfoLabel">Información Adicional</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" id="modalAdditionalInfoContent" rows="10"
                                      disabled></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
            </div>


            <div class="row pt-3">
                <div class="py-2 text-center">
                    <h4>Requisitos</h4>
                </div>
                @foreach($requisitosPorTipo as $tipo=> $requisitoPorTipo)
                    <div class="col-sm-4 pb-2">
                        @if(str_contains($requisitoPorTipo->path,'pdf'))

                            <embed src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" width="500" height="375"
                                   type="application/pdf">
                            <div class="py-2 text-center">
                                <a href="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" download="{{$tipo}}.pdf" class="btn btn-warning">Descargar</a>
                            </div>

                        @else
                            @if(str_contains($requisitoPorTipo->path,'mp4'))
                                <video src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" class="object-fit-contain" style="max-width: 100%" controls></video>
                                <div class="py-2 text-center">
                                    <a href="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" download="{{$tipo}}.mp4" class="btn btn-warning">Descargar</a>
                                </div>
                            @else
                                <img id="image" src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" alt="" class="img-fluid" style="max-height: 70vh">
                                <div class="py-2 text-center">
                                    <a href="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" download="{{$tipo}}.png" class="btn btn-warning">Descargar</a>
                                </div>
                            @endif

                        @endif
                        <div class="py-2">
                            <div>
                                <b>{{$documentosLabel[$requisitoPorTipo->type]}}</b>
                            </div>
                            <div class="py-2">
                                <b>Estado: </b> <span
                                    class="text-{{$requisitoPorTipo->classColor()}}">{{$requisitoPorTipo->statusStr()}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        function downloadFile(name, url) {

            var link = document.createElement('a');
            link.download = name;
            link.href = "file.png";
            link.click();

        }

        // Cargar contenido dinámico en el modal
        document.addEventListener('DOMContentLoaded', function () {
            var modalAdditionalInfo = document.getElementById('modalAdditionalInfo');
            modalAdditionalInfo.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var content = button.getAttribute('data-content');
                var index = button.getAttribute('data-index');

                var modalTitle = modalAdditionalInfo.querySelector('.modal-title');
                var modalContent = document.getElementById('modalAdditionalInfoContent');

                modalTitle.textContent = 'Información Adicional #' + index;
                modalContent.value = content;
            });
        });
    </script>
@endsection
