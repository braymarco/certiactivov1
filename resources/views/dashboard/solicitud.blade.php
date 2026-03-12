@extends('template_admin')
@section('head')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"></link>
@endsection
@section('content')
    <div class="card" id="app">
        <div class="card-body">
            <div class="text-center">
                <h4> #{{$solicitud->id}} - {{$solicitud->nro_documento}} - {{$solicitud->tipoStr()}}</h4>
            </div>
            <hr>
            @include('commons.messages')

            <div>
                <form action="{{route('solicitud.actualizarDatos')}}" method="POST">
                    @csrf
                    <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                    <div class="row">
                        <div class="col-6" style="max-height: 80vh">
                            <div class="pb-2 text-center">
                                <div class="d-flex justify-content-around">
                                    <div>
                                        <button class="btn btn-primary" @click="previous" type="button">
                                            <span data-feather="arrow-left-circle"></span>
                                        </button>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary"
                                                onclick="rotateLeft()" type="button"
                                        >
            <span class="docs-tooltip" data-toggle="tooltip" title="">
              <span data-feather="rotate-ccw"></span>
            </span>
                                        </button>
                                        <button type="button" class="btn btn-primary"
                                                onclick="rotateRight()" type="button"
                                        >
            <span class="docs-tooltip" data-toggle="tooltip" title="">
              <span data-feather="rotate-cw"></span>
            </span>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary" @click="next" type="button">
                                            <span data-feather="arrow-right-circle"></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <img id="image" src="{{route('requisito.descargar',[
                                'documentoId'=>$requisitosPorTipo[$tiposRequisito::$CEDULA_FRONTAL]->id
                                ])}}" alt="" class="img-fluid" style="max-height: 70vh">
                            </div>
                        </div>

                        <div class="col-6 overflow-auto" style="max-height: 80vh">
                            <div class="py-2">
                                <b> Datos Personales</b>
                            </div>
                            <div class="row">
                                <div class="  pb-2  ">
                                    <label for="tipo_documento" class="label-required">Tipo de Documento</label>
                                    <select name="tipo_documento" class="form-select form-select-sm"
                                            aria-label="Tipo de Documento"
                                            id="tipo_documento"
                                            v-model="tipo_documento"
                                            required>
                                        <option value="" selected>Seleccione...</option>
                                        <option value="1">Cédula</option>
                                        <option value="2">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="  pb-2">
                                    <label for="nro_documento"
                                           class="label-required"
                                    >Nro. de Documento</label>
                                    <input id="nro_documento" type="text" name="nro_documento"
                                           class="form-control form-control-sm"
                                           v-model="nro_documento"
                                           required>
                                </div>
                                <div class="  pb-2">
                                    <label for="codigo_dactilar"
                                           class="label-required"

                                    >Código Dactilar

                                        <span
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="Se encuentra en la parte superior derecha de su cédula"
                                        >
                                <i data-feather="help-circle" class="pb-2" width="15px"></i></span>
                                    </label>
                                    <input id="codigo_dactilar" type="text" name="codigo_dactilar"
                                           class="form-control form-control-sm"
                                           placeholder="ExxxxIxxxx"
                                           v-model="codigo_dactilar"
                                           required>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" pb-2">
                                    <label for="nombres" class="label-required">Nombres</label>
                                    <input id="nombres" type="text" name="nombres"
                                           placeholder="MARCO ANDRÉS"
                                           class="form-control form-control-sm"
                                           minlength="2" maxlength="60"
                                           v-model="nombres"
                                           required>
                                </div>
                                <div class=" pb-2">
                                    <label for="apellido1" class="label-required">Primer Apellido</label>
                                    <input id="apellido1" type="text" name="apellido1"
                                           class="form-control form-control-sm"
                                           placeholder="APELLIDO 1"
                                           v-model="apellido1"
                                           required>
                                </div>
                                <div class=" pb-2">
                                    <label for="apellido2">Segundo Apellido</label>
                                    <input id="apellido2" type="text" name="apellido2"
                                           class="form-control form-control-sm"
                                           placeholder="APELLIDO 2"
                                           v-model="apellido2"
                                           >
                                </div>
                            </div>
                            <div class="row">
                                <div class=" pb-2">
                                    <label for="fecha_nacimiento" class="label-required">Fecha de Nacimiento</label>
                                    <input id="fecha_nacimiento"
                                           v-model="fecha_nacimiento"
                                           type="date" name="fecha_nacimiento"
                                           class="form-control form-control-sm"
                                           placeholder="04/10/1985"
                                           required>
                                </div>
                                <div class=" pb-2">
                                    <label for="nacionalidad" class="label-required">Nacionalidad</label>
                                    <select id="nacionalidad" name="nacionalidad" class="form-select form-select-sm"
                                            aria-label="Tipo de Documento"
                                            v-model="nacionalidad"
                                            required>
                                        @foreach($countries as $country)
                                            <option
                                                value="{{$country}}">{{$country}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" pb-2">
                                    <label for="sexo" class="label-required">Sexo</label>
                                    <select name="sexo" class="form-select form-select-sm"
                                            aria-label="Tipo de Documento"
                                            v-model="sexo"
                                            required>
                                        <option value="" selected>Seleccione...</option>
                                        <option value="HOMBRE">HOMBRE</option>
                                        <option value="MUJER">MUJER</option>
                                    </select>
                                </div>
                            </div>
                            <div class="py-2">
                                <div class="alert alert-info">
                                    El número de celular y correo deben ser correctos (debe tener acceso y poder recibir
                                    mensajes), caso contrario no le permitirá descargar la firma electrónica.
                                </div>
                            </div>
                            <div class="row">
                                <div class=" pb-2">
                                    <label for="celular" class="label-required">Celular</label>
                                    <input id="celular" type="text" name="celular"
                                           class="form-control form-control-sm"
                                           placeholder="0912345678"
                                           v-model="celular"
                                           @keypress="isNumberKey($event)"
                                           required>
                                </div>
                                <div class=" pb-2">
                                    <label for="email" class="label-required">Email</label>
                                    <input id="email" type="email" name="email" v-model="email"
                                           class="form-control form-control-sm"
                                           placeholder="sucorreo@gmail.com"
                                           v-model="email"
                                           required>
                                </div>
                            </div>
                            @if($solicitud->tipo=='pnatural')
                                <div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                       id="con_ruc"
                                                       name="con_ruc"
                                                       v-model="con_ruc">
                                                <label class="form-check-label" for="con_ruc">Con RUC (Si desea su firma
                                                    con
                                                    RUC
                                                    active esta
                                                    opción, válido para facturación electrónica)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" v-if="con_ruc">
                                        <div class=" pb-2">
                                            <label for="nro_ruc" class="label-required">Nro. de RUC</label>
                                            <input id="nro_ruc" type="text" name="nro_ruc"
                                                   class="form-control form-control-sm"
                                                   placeholder="1126487...001"
                                                   v-model="nro_ruc"
                                                   :required="con_ruc">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="py-2">
                                    <b> Datos de la Empresa</b>
                                </div>
                                <div class="row">
                                    <div class=" pb-2">
                                        <label for="nro_ruc" class="label-required"> RUC</label>
                                        <input id="nro_ruc" type="text" name="nro_ruc"
                                               class="form-control form-control-sm"
                                               v-model="nro_ruc"
                                               placeholder="1126487...001"
                                               required>
                                    </div>

                                    <div class="col-sm-6 pb-2">
                                        <label for="empresa" class="label-required"> Razón social</label>
                                        <input id="empresa" type="text" name="empresa"
                                               class="form-control form-control-sm"
                                               v-model="empresa"
                                               placeholder="RAZÓN SOCIAL"
                                               required>
                                    </div>

                                    @if($solicitud->tipo==='mempresa')
                                        <div class=" pb-2">
                                            <label for="unidad" class="label-required"> Area</label>
                                            <input id="unidad" type="text" name="unidad"
                                                   class="form-control form-control-sm"
                                                   v-model="unidad"
                                                   placeholder="CONTABILIDAD"
                                                   required>
                                        </div>

                                    @endif

                                    <div class=" pb-2">
                                        <label for="cargo" class="label-required">

                                            @if($solicitud->tipo==='mempresa')
                                                Cargo del Solicitante
                                            @else
                                                Cargo del representante
                                            @endif

                                        </label>
                                        <input id="cargo" type="text" name="cargo"
                                               class="form-control form-control-sm"
                                               placeholder="GERENTE GENERAL"
                                               v-model="cargo"
                                               required>
                                    </div>
                                </div>
                            @endif
                            @if($solicitud->tipo=='mempresa')
                                <div class="py-2">
                                    <b> Datos del Representante Legal </b>
                                </div>
                                <div class="row">
                                    <div class="  pb-2  ">
                                        <div class="form-group">
                                            <label for="tipo_documento_rl" class="label-required">Tipo de
                                                Documento</label>
                                            <select name="tipo_documento_rl" class="form-select form-select-sm"
                                                    aria-label="Tipo de Documento"
                                                    v-model="tipo_documento_rl"
                                                    required>
                                                <option value="" selected>Seleccione...</option>
                                                <option value="1">Cédula</option>
                                                <option value="2">Pasaporte</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="  pb-2  ">
                                        <div class="form-group">
                                            <label for="nro_documento_rl" class="label-required">Nro. de
                                                Documento</label>
                                            <input id="nro_documento_rl" type="text" name="nro_documento_rl"
                                                   class="form-control form-control-sm"
                                                   placeholder="11164836..."
                                                   v-model="nro_documento_rl"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="  pb-2  ">
                                        <div class="form-group">
                                            <label for="nombres_rl" class="label-required">Nombres</label>
                                            <input id="nombres_rl" type="text" name="nombres_rl"
                                                   class="form-control form-control-sm"
                                                   placeholder="ADRIÁN JOSSUE"
                                                   v-model="nombres_rl"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="  pb-2  ">
                                        <div class="form-group">
                                            <label for="apellido1_rl" class="label-required">Primer apellido</label>
                                            <input id="apellido1_rl" type="text" name="apellido1_rl"
                                                   class="form-control form-control-sm"
                                                   placeholder="PRIMER APELLIDO"
                                                   v-model="apellido1_rl"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="  pb-2  ">
                                        <div class="form-group">
                                            <label for="apellido2_rl" class="label-required">Segundo apellido</label>
                                            <input id="apellido2_rl" type="text" name="apellido2_rl"
                                                   class="form-control form-control-sm"
                                                   placeholder="SEGUNDO APELLIDO"
                                                   v-model="apellido2_rl"
                                                   >
                                        </div>
                                    </div>
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
                                <div class=" pb-2">
                                    <div class="form-group">
                                        <label for="provincia" class="label-required">Provincia</label>
                                        <select v-model="provincia" name="provincia_id"
                                                class="form-select form-select-sm"
                                                aria-label="Provincia"
                                                required>
                                            <option value="" selected>Seleccione...</option>
                                            <option v-for=" provinciaM  in provincias" :value="provinciaM.id">@{{
                                                provinciaM.nombre
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" pb-2">
                                    <div class="form-group">
                                        <label for="canton" class="label-required">Cantón</label>
                                        <select name="canton_id" class="form-select form-select-sm"
                                                aria-label="Cantón" v-model="canton"
                                                required>
                                            <option value="" selected>Seleccione ...</option>
                                            <option v-for="canton  in cantones[provincia]" :value="canton.id">@{{
                                                canton.nombre
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 pb-2">
                                    <div class="form-group">
                                        <label for="direccion" class="label-required">Dirección</label>
                                        <input id="direccion" type="text" name="direccion"
                                               class="form-control form-control-sm"
                                               v-model="direccion"
                                               placeholder="CALLE PRINCIPAL OE4-32 Y CALLE SECUNDARIA"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <b> Formato y tiempo de vigencia</b>
                            </div>
                            <div class="row">
                                <div class=" pb-2">
                                    <div class="form-group">
                                        <label for="formato" class="label-required">Formato</label>
                                        <select v-model="formato" name="formato" class="form-select form-select-sm"
                                                aria-label="Tipo de Documento"
                                                required>
                                            <option>Seleccione...</option>
                                            <option value="1">Archivo .P12</option>
                                            <option value="2">Token</option>
                                        </select>
                                    </div>
                                </div>
                                <div class=" pb-2">
                                    <div class="form-group">
                                        <label for="plan_id" class="label-required">Tiempo de Vigencia</label>
                                        <select name="plan_id" class="form-select form-select-sm"
                                                id="plan_id"
                                                v-model="plan_id"
                                                aria-label="Tiempo de Vigencia"
                                                required>
                                            @foreach($planes as $plan)
                                                <option value="{{$plan->id}}">{{$plan->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="formato==2">
                                <div class="col-sm-6 pb-2">
                                    <div class="form-group">
                                        <label for="sn_token" class="label-required">Nro. Serial del Token</label>
                                        <input id="sn_token" type="text" name="sn_token"
                                               class="form-control form-control-sm"
                                               v-model="sn_token"
                                               placeholder="Nro. Serial del Token"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2 pb-3 text-center">
                        <button class="btn btn-success">Actualizar</button>
                    </div>
                </form>
                <div class="col-auto">
                    <form action="{{route('solicitud.firma_enviar_proveedor',[
    'id'=>$solicitud->id
])}}"
                          method="POST">
                        @csrf
                        <button class="btn btn-warning">Envío a proveedor</button>
                    </form>
                </div>
                <div class="row pt-3">
                    <div class="py-2 text-center">
                        <h4>Requisitos</h4>
                    </div>
                    @foreach($requisitosPorTipo as $tipoRequisito=> $requisitoPorTipo)
                        <div class="col-sm-4 pb-2">
                            @if(str_contains($requisitoPorTipo->path,'pdf'))

                                <embed src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" style="width: 100%" height="375"
                                       type="application/pdf">

                            @else
                                @if(str_contains($requisitoPorTipo->path,'mp4'))
                                    <video src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" class="object-fit-contain" style="max-width: 100%" controls></video>

                                     @else
                                    <img id="image" src="{{route('requisito.descargar',[
    'documentoId'=>$requisitoPorTipo->id
    ])}}" alt="" class="img-fluid" style="max-height: 70vh">
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
                                @if($solicitud->estado == \App\Enums\SignatureRequestStatus::$CREATED)
                                    <div class="text-center py-2">
                                        <button class="btn btn-secondary" type="button"
                                                onclick="abrirModalCambiarArchivo({{$requisitoPorTipo->id}}, '{{$documentosLabel[$requisitoPorTipo->type]}}')">
                                            Cambiar Archivo
                                        </button>
                                    </div>
                                @endif
                                <form action="{{route('solicitud.pedir_cambio_requisito')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="documento_id" value="{{$requisitoPorTipo->id}}">
                                    <div class="form-group">
                                        <label for="comentario_{{$requisitoPorTipo->id}}">Comentario</label>
                                        <input class="form-control form-control-sm"
                                               id="comentario_{{$requisitoPorTipo->id}}" type="text"
                                               placeholder="Comentario" name="comentario">
                                    </div>
                                    <div class="text-center py-2">
                                        <button class="btn btn-danger">Pedir Corrección</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="py-3 text-center">
                <form action="{{route('solicitud.aprobar_requisito')}}" method="POST">
                    <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                    @csrf
                    <button class="btn btn-success">Aprobar Requisitos de Solicitud</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal único para cambiar archivos -->
    <div class="modal fade" id="modalCambiarArchivo" tabindex="-1"
         aria-labelledby="modalCambiarArchivoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCambiarArchivoLabel">
                        Cambiar Archivo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('solicitud.cambiar_archivo_requisito')}}" method="POST"
                      enctype="multipart/form-data" id="formCambiarArchivo">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="documento_id" id="documento_id_modal">
                        <div class="form-group">
                            <label for="archivo_modal" class="form-label">Seleccione el nuevo archivo</label>
                            <input type="file" class="form-control" id="archivo_modal"
                                   name="archivo" accept=".jpg,.jpeg,.png,.pdf,.mp4" required>
                            <small class="form-text text-muted">
                                Formatos permitidos: JPG, JPEG, PNG, PDF, MP4 (Máx. 10MB)
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cambiar Archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        const {createApp, getCurrentInstance} = Vue

        const app = createApp({
            data() {
                return {
                    tipo: '{{$solicitud->tipo}}',
                    edad: null,
                    con_ruc: {{$solicitud->con_ruc?'true':'false'}},
                    provincia: "{{$solicitud->provincia_id}}",
                    email: "{{$solicitud->email}}",
                    canton: "{{$solicitud->canton_id}}",
                    nro_ruc: "{{$solicitud->nro_ruc}}",
                    provincias: {!! json_encode($provincias) !!},
                    cantones: {!! json_encode($cantones) !!},
                    formato: "{{$solicitud->formato??1}}",
                    tipo_documento: "{{$solicitud->tipo_documento }}",
                    nro_documento: "{{$solicitud->nro_documento }}",
                    codigo_dactilar: "{{$solicitud->codigo_dactilar }}",
                    nombres: "{{$solicitud->nombres }}",
                    apellido1: "{{$solicitud->apellido1 }}",
                    apellido2: "{{$solicitud->apellido2 }}",
                    fecha_nacimiento: "{{$solicitud->fecha_nacimiento }}",
                    nacionalidad: "{{$solicitud->nacionalidad }}",
                    sexo: "{{$solicitud->sexo }}",
                    celular: "{{$solicitud->celular }}",
                    empresa: "{{$solicitud->empresa }}",
                    unidad: "{{$solicitud->unidad }}",
                    cargo: "{{$solicitud->cargo }}",
                    tipo_documento_rl: "{{$solicitud->tipo_documento_rl }}",
                    nro_documento_rl: "{{$solicitud->nro_documento_rl }}",
                    nombres_rl: "{{$solicitud->nombres_rl }}",
                    apellido1_rl: "{{$solicitud->apellido1_rl }}",
                    apellido2_rl: "{{$solicitud->apellido2_rl }}",
                    direccion: "{{$solicitud->direccion }}",
                    plan_id: {{$solicitud->plan_id}},
                    sn_token: "",
                    etiquetas: {
                        "tipo": "Tipo",
                        "edad": "Edad",
                        "con_ruc": "Con RUC",
                        "provincia": "Provincia",
                        "email": "Email",
                        "canton": "Cantón",
                        "nro_ruc": "Número de RUC",
                        "formato": "Formato",
                        "tipo_documento": "Tipo de Documento",
                        "nro_documento": "Número de Documento",
                        "codigo_dactilar": "Código Dactilar",
                        "nombres": "Nombres",
                        "apellido1": "Apellido 1",
                        "apellido2": "Apellido 2",
                        "fecha_nacimiento": "Fecha de Nacimiento",
                        "nacionalidad": "Nacionalidad",
                        "sexo": "Sexo",
                        "celular": "Celular",
                        "empresa": "Empresa",
                        "unidad": "Unidad",
                        "cargo": "Cargo",
                        "tipo_documento_rl": "Tipo de Documento (Representante Legal)",
                        "nro_documento_rl": "Número de Documento (Representante Legal)",
                        "nombres_rl": "Nombres (Representante Legal)",
                        "apellido1_rl": "Apellido 1 (Representante Legal)",
                        "apellido2_rl": "Apellido 2 (Representante Legal)",
                        "direccion": "Dirección",
                        "plan_id": "Plan",
                        "sn_token": "SN Token"
                    },
                    documentosLabel: {!! json_encode($documentosLabel) !!},
                    incorrecto_enable: false,
                    imgs: [
                        '{{route('requisito.descargar',[
    'documentoId'=>$requisitosPorTipo[$tiposRequisito::$CEDULA_FRONTAL]->id
    ])}}',
                        '{{route('requisito.descargar',[
    'documentoId'=>$requisitosPorTipo[$tiposRequisito::$CEDULA_POSTERIOR]->id
    ])}}',
                        '{{route('requisito.descargar',[
    'documentoId'=>$requisitosPorTipo[$tiposRequisito::$SELFIE]->id
    ])}}'
                    ],

                    img_nro: 0,
                }
            },
            methods: {
                previous() {
                    let max = this.imgs.length - 1;
                    if (this.img_nro === 0)
                        this.img_nro = max;
                    else
                        this.img_nro--;
                    cropper.replace(this.imgs[this.img_nro]);
                },
                next() {
                    let max = this.imgs.length - 1;
                    if (this.img_nro === max)
                        this.img_nro = 0;
                    else
                        this.img_nro++;
                    cropper.replace(this.imgs[this.img_nro]);
                }
            }
        });
        const root = app.mount('#app');

        const image = document.getElementById('image');
        const cropper = new Cropper(image, {
            background: false,
            crop(event) {
                console.log("X: " + event.detail.x);
                console.log("Y: " + event.detail.y);
                console.log(event.detail.width);
                console.log(event.detail.height);
                console.log(event.detail.rotate);
                console.log(event.detail.scaleX);
                console.log(event.detail.scaleY);
            },
            viewMode: 2,
            dragMode: 'move',
            autoCrop: false


        });


        function rotateRight() {
            cropper.rotate(90);
            cropper.zoomTo(0)
            cropper.moveTo(-100, -100)
        }

        function rotateLeft() {
            cropper.rotate(-90)
            cropper.zoomTo(0)
            cropper.moveTo(-100, -100)

        }

        function abrirModalCambiarArchivo(documentoId, nombreDocumento) {
            // Actualizar el título del modal
            document.getElementById('modalCambiarArchivoLabel').textContent = 'Cambiar Archivo: ' + nombreDocumento;

            // Establecer el ID del documento en el campo oculto
            document.getElementById('documento_id_modal').value = documentoId;

            // Limpiar el input de archivo
            document.getElementById('archivo_modal').value = '';

            // Abrir el modal
            var modal = new bootstrap.Modal(document.getElementById('modalCambiarArchivo'));
            modal.show();
        }
    </script>
@endsection
