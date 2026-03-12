@extends('template')
@section('style')
    <style>
        .label-required:before {
            content: "* ";
            color: #ff1f62;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')

    <div class="pt-4   text-center">
        <h3>INGRESE SUS DATOS </h3>
    </div>
    <div class="pb-3 text-center">
        Con esta información generaremos tu firma electrónica
    </div>
    <div class="card" id="app">
        <div class="card-body">
            <div v-if="step==2">
                <button class="btn btn-secondary" type="button"
                        @click="atras"
                >
                    <i data-feather="arrow-left"></i>Atrás
                </button>
            </div>
            <div class="py-2">
                <span class="label-required">Llene todos los campos requeridos</span>
            </div>
            <div>
                @include('commons.messages')
            </div>
            <form method="POST"
                  action="{{route("purchase-token.verify", ['purchaseToken'=>$purchaseToken->token,'type'=>$tipo])}}"
                  id="form"
                  enctype="multipart/form-data">
                @csrf
                <div v-show="step==1">
                    <div class="py-2">
                        <b> Datos Personales</b>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-3 pb-2  ">
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
                        <div class="col-sm-2 col-md-3 pb-2">
                            <label for="nro_documento"
                                   class="label-required"
                            >Nro. de Documento</label>
                            <input id="nro_documento" type="text" name="nro_documento"
                                   class="form-control form-control-sm"
                                   v-model="nro_documento"
                                   required>
                        </div>
                        <div class="col-sm-2 col-md-3 pb-2">
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
                        <div class="col-sm-4 pb-2">
                            <label for="nombres" class="label-required">Nombres</label>
                            <input id="nombres" type="text" name="nombres"
                                   placeholder="MARCO ANDRÉS"
                                   class="form-control form-control-sm"
                                   minlength="2" maxlength="60"
                                   v-model="nombres"
                                   required>
                        </div>
                        <div class="col-sm-3 pb-2">
                            <label for="apellido1" class="label-required">Primer Apellido</label>
                            <input id="apellido1" type="text" name="apellido1"
                                   class="form-control form-control-sm"
                                   placeholder="APELLIDO 1"
                                   v-model="apellido1"
                                   required>
                        </div>
                        <div class="col-sm-3 pb-2">
                            <label for="apellido2">Segundo Apellido</label>
                            <input id="apellido2" type="text" name="apellido2"
                                   class="form-control form-control-sm"
                                   placeholder="APELLIDO 2"
                                   v-model="apellido2"
                                   required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 pb-2">
                            <label for="fecha_nacimiento" class="label-required">Fecha de Nacimiento</label>
                            <input id="fecha_nacimiento"
                                   v-model="fecha_nacimiento"
                                   type="date" name="fecha_nacimiento"
                                   class="form-control form-control-sm"
                                   placeholder="04/10/1985"
                                   required>
                        </div>
                        <div class="col-sm-3 pb-2">
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
                        <div class="col-sm-3 pb-2">
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
                            El número de celular y correo deben ser correctos y pertenecer al solicitante(debe tener
                            acceso y poder recibir
                            mensajes), caso contrario no le permitirá descargar la firma electrónica.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 pb-2">
                            <label for="celular" class="label-required">Celular</label>
                            <input id="celular" type="text" name="celular"
                                   class="form-control form-control-sm"
                                   placeholder="0912345678"
                                   v-model="celular"
                                   @keypress="isNumberKey($event)"
                                   required>
                        </div>
                        <div class="col-sm-3 pb-2">
                            <label for="email" class="label-required">Email</label>
                            <input id="email" type="email" name="email" v-model="email"
                                   class="form-control form-control-sm"
                                   placeholder="sucorreo@gmail.com"
                                   v-model="email"
                                   required>
                        </div>
                    </div>
                    @if($tipo=='pnatural')
                        <div>
                            <div class="row">
                                <div class="col-12">
                                    <label class="label-required">Con RUC (Si desea su firma con RUC
                                        active esta
                                        opción, válido para facturación electrónica)</label>

                                    <div>

                                        <label class="form-check-label" for="con_ruc_si">
                                            <input v-model="con_ruc" class="form-check-input" type="radio"
                                                   name="con_ruc"
                                                   id="con_ruc_si" value="1" required> SI
                                        </label>


                                        <label class="form-check-label px-3" for="con_ruc_no">
                                            <input v-model="con_ruc" class="form-check-input" type="radio"
                                                   name="con_ruc"
                                                   id="con_ruc_no" value="2"> NO
                                        </label>
                                    </div>


                                </div>
                            </div>

                            <div class="row" v-show="con_ruc=='1'">
                                <div class="col-sm-3 pb-2">
                                    <label for="nro_ruc" class="label-required">Nro. de RUC</label>
                                    <input id="nro_ruc" type="text" name="nro_ruc"
                                           class="form-control form-control-sm"
                                           placeholder="1126487...001"
                                           v-model="nro_ruc"
                                           required>
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="con_ruc"
                               value="1">
                        <div class="py-2">
                            <b> Datos de la Empresa</b>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 pb-2">
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

                            @if($tipo==='mempresa')
                                <div class="col-sm-3 pb-2">
                                    <label for="unidad" class="label-required"> Area</label>
                                    <input id="unidad" type="text" name="unidad"
                                           class="form-control form-control-sm"
                                           v-model="unidad"
                                           placeholder="CONTABILIDAD"
                                           required>
                                </div>

                            @endif

                            <div class="col-sm-3 pb-2">
                                <label for="cargo" class="label-required">

                                    @if($tipo==='mempresa')
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
                    @if($tipo=='mempresa')
                        <div class="py-2">
                            <b> Datos del Representante Legal </b>
                        </div>
                        <div class="row">
                            <div class="col-sm-2 col-md-3 pb-2  ">
                                <div class="form-group">
                                    <label for="tipo_documento_rl" class="label-required">Tipo de Documento</label>
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
                            <div class="col-sm-2  pb-2  ">
                                <div class="form-group">
                                    <label for="nro_documento_rl" class="label-required">Nro. de Documento</label>
                                    <input id="nro_documento_rl" type="text" name="nro_documento_rl"
                                           class="form-control form-control-sm"
                                           placeholder="11164836..."
                                           v-model="nro_documento_rl"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-4  pb-2  ">
                                <div class="form-group">
                                    <label for="nombres_rl" class="label-required">Nombres</label>
                                    <input id="nombres_rl" type="text" name="nombres_rl"
                                           class="form-control form-control-sm"
                                           placeholder="ADRIÁN JOSSUE"
                                           v-model="nombres_rl"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-3  pb-2  ">
                                <div class="form-group">
                                    <label for="apellido1_rl" class="label-required">Primer apellido</label>
                                    <input id="apellido1_rl" type="text" name="apellido1_rl"
                                           class="form-control form-control-sm"
                                           placeholder="PRIMER APELLIDO"
                                           v-model="apellido1_rl"
                                           required>
                                </div>
                            </div>
                            <div class="col-sm-3  pb-2  ">
                                <div class="form-group">
                                    <label for="apellido2_rl" class="label-required">Segundo apellido</label>
                                    <input id="apellido2_rl" type="text" name="apellido2_rl"
                                           class="form-control form-control-sm"
                                           placeholder="SEGUNDO APELLIDO"
                                           v-model="apellido2_rl"
                                           required>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="py-2">
                        @if($tipo=='pnatural')

                            <b> Dirección Domicilio</b>
                        @else
                            <b>Dirección de la Empresa</b> <small> (especificada en el ruc)</small>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-sm-3 pb-2">
                            <div class="form-group">
                                <label for="provincia" class="label-required">Provincia</label>
                                <select v-model="provincia" name="provincia_id" class="form-select form-select-sm"
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
                        <div class="col-sm-3 pb-2">
                            <div class="form-group">
                                <label for="canton" class="label-required">Cantón</label>
                                <select name="canton_id" class="form-select form-select-sm"
                                        aria-label="Cantón" v-model="canton"
                                        required>
                                    <option value="" selected>Seleccione ...</option>
                                    <option v-for="canton  in cantones[provincia]" :value="canton.id">@{{ canton.nombre
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
                                       maxlength="100"
                                       minlength="10"
                                       placeholder="CALLE PRINCIPAL OE4-32 Y CALLE SECUNDARIA"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <b> Formato y tiempo de vigencia</b>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 pb-2">
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
                        <div class="col-sm-3 pb-2">
                            <div class="form-group">
                                <label for="plan_id" class="label-required">Tiempo de Vigencia</label>
                                <select name="plan_id" class="form-select form-select-sm"
                                        id="plan_id"
                                        v-model="plan_id"
                                        aria-label="Tiempo de Vigencia"
                                        required>
                                    <option value="" @disabled(count($planes)==1)>Seleccione...</option>
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
                    <div class="alert alert-info">
                        @{{messageFormat}}
                    </div>
                    <div class="py-3">
                        <div class="d-grid">
                            <button class="btn btn-success" type="button" @click="nextStep">
                                Siguiente <i data-feather="arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div v-show="step==2">
                    <div class="py-2">
                        <div class="alert alert-info">
                            Los requisitos deben ser legibles y la selfie debe permitir visualizar al solicitante con su
                            cédula.
                        </div>
                    </div>
                    <div class="row">
                        @foreach($documentosNecesarios as $documentoNecesario)
                            <div class="col-sm-4 p-4"
                                 v-show="'{{$documentoNecesario}}'!='RUC'   || tipo !== 'pnatural'">


                                <div class="image-upload">
                                    <label for="file-input-{{$documentoNecesario}}" class="pointer">
                                        <div
                                            style="height: 180px;width: 180px"
                                            class=" m-auto d-flex"
                                        >
                                            <img
                                                id="file-img-{{$documentoNecesario}}"
                                                src="{{asset('assets/img/documents/'.$documentoNecesario.'.png')}}"
                                                alt=""
                                                style="max-height: 100%"
                                                class="img-fluid align-self-center rounded">
                                        </div>
                                        <h6
                                            @if($documentoNecesario!=='DOCUMENTO_ADICIONAL')

                                                class="label-required"
                                            @endif


                                        >
                                            {{$documentosLabel[$documentoNecesario]}}
                                        </h6>
                                    </label>@if($documentoNecesario == $documentTypes::$SELFIE  )
                                        <div class="alert alert-info my-2">
                                            La foto tipo selfie debe estar: sin lentes, gafas, gorras, mascarillas etc,
                                            con la cédula de identidad de la parte frontal abajo de la barbilla.
                                        </div>
                                    @endif
                                    <input id="file-input-{{$documentoNecesario}}"
                                           onchange="previewPhoto('{{$documentoNecesario}}')"
                                           type="file" name="{{$documentoNecesario}}"
                                           required

                                           @if(in_array($documentoNecesario,[ $documentTypes::$CEDULA_FRONTAL,
                $documentTypes::$CEDULA_POSTERIOR,
                $documentTypes::$SELFIE,]))
                                               accept=".png, .jpg, .jpeg "
                                           @else
                                               accept=".pdf"
                                        @endif

                                    >
                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-4 p-4" v-show="edad>64">


                            <div class="image-upload">
                                <label for="file-input-VIDEO" class="pointer">
                                    <div
                                        style="height: 180px;width: 180px"
                                        class=" m-auto d-flex"
                                    >
                                        <img
                                            id="file-img-VIDEO"
                                            src="{{asset('assets/img/documents/VIDEO.png')}}"
                                            alt=""
                                            style="max-height: 100%"
                                            class="img-fluid align-self-center rounded">
                                    </div>
                                    <h6 class="label-required">
                                        VIDEO
                                    </h6>

                                </label>
                                <input id="file-input-VIDEO"
                                       onchange="previewPhoto('VIDEO')"
                                       type="file" name="VIDEO"
                                       required
                                       accept=".mp4">
                            </div>
                        </div>
                    </div>
                    <div v-show="edad>64">
                        <div class="alert alert-info">
                            <div>
                                <b>TEXTO PARA VIDEO, CLIENTES MAYORES A 64 AÑOS:</b>
                            </div>
                            <div>
                                @if($tipo!='rempresa')
                                    Hoy fecha actual (días, mes y año) Yo (nombres completos) con cédula de identidad XXXXXX autorizo a
                                    emitir
                                    mi firma electrónica a Uanataca sabiendo que tiene la misma validez
                                    legal
                                    que la firma manuscrita y que me la envíen a mi correo electrónico
                                    @{{ email }}
                                @else
                                    Hoy  fecha actual (días, mes y año) Yo (nombres completos) con cédula de identidad XXXXX
                                    representante
                                    legal
                                    de @{{ empresa }} con RUC. @{{ nro_ruc }}
                                    autorizo
                                    a emitir mi firma electronica a Uanataca sabiendo que tiene la misma
                                    validez
                                    legal que la firma manuscrita me envíen a mi correo electrónico @{{ email }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="d-grid">
                            <button class="btn btn-success" type="button" @click="enviar">
                                Enviar <i data-feather="arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
@endsection

@section('script')
    <script>
        const {createApp, getCurrentInstance} = Vue

        const app = createApp({
            data() {
                return {
                    tipo: '{{$tipo}}',
                    edad: null,
                    con_ruc: {{old('con_ruc')??'false'}},
                    provincia: "{{old('provincia_id')}}",
                    email: "{{old('email')}}",
                    canton: "{{old('canton_id')}}",
                    nro_ruc: "{{old('nro_ruc')}}",
                    provincias: {!! json_encode($provincias) !!},
                    cantones: {!! json_encode($cantones) !!},
                    formato: "{{old('formato')??1}}",
                    step: 1,
                    tipo_documento: "{{old('tipo_documento') }}",
                    nro_documento: "{{old('nro_documento') }}",
                    codigo_dactilar: "{{old('codigo_dactilar') }}",
                    nombres: "{{old('nombres') }}",
                    apellido1: "{{old('apellido1') }}",
                    apellido2: "{{old('apellido2') }}",
                    fecha_nacimiento: "{{old('fecha_nacimiento') }}",
                    nacionalidad: "ECUATORIANA",
                    sexo: "{{old('sexo') }}",
                    celular: "{{old('celular') }}",
                    empresa: "{{old('empresa') }}",
                    unidad: "{{old('unidad') }}",
                    cargo: "{{old('cargo') }}",
                    tipo_documento_rl: "{{old('tipo_documento_rl') }}",
                    nro_documento_rl: "{{old('nro_documento_rl') }}",
                    nombres_rl: "{{old('nombres_rl') }}",
                    apellido1_rl: "{{old('apellido1_rl') }}",
                    apellido2_rl: "{{old('apellido2_rl') }}",
                    direccion: "{{old('direccion') }}",
                    plan_id: @if(count($planes)==1) {{$planes[0]->id}} @else '' @endif,
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
                    documentosLabel: {!! json_encode($documentosLabel) !!}
                }
            },
            methods: {
                validarCedula(cedula) {
                    if (cedula.length !== 10)
                        return false;
                    //Obtenemos el digito de la region que son los dos primeros digitos
                    var digito_region = cedula.substring(0, 2);

                    //Pregunto si la region existe ecuador se divide en 24 regiones
                    if (digito_region >= 1 && digito_region <= 60) {

                        // Extraigo el ultimo digito
                        var ultimo_digito = cedula.substring(9, 10);

                        //Agrupo todos los pares y los sumo
                        var pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));

                        //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
                        var numero1 = cedula.substring(0, 1);
                        var numero1 = (numero1 * 2);
                        if (numero1 > 9) {
                            var numero1 = (numero1 - 9);
                        }

                        var numero3 = cedula.substring(2, 3);
                        var numero3 = (numero3 * 2);
                        if (numero3 > 9) {
                            var numero3 = (numero3 - 9);
                        }

                        var numero5 = cedula.substring(4, 5);
                        var numero5 = (numero5 * 2);
                        if (numero5 > 9) {
                            var numero5 = (numero5 - 9);
                        }

                        var numero7 = cedula.substring(6, 7);
                        var numero7 = (numero7 * 2);
                        if (numero7 > 9) {
                            var numero7 = (numero7 - 9);
                        }

                        var numero9 = cedula.substring(8, 9);
                        var numero9 = (numero9 * 2);
                        if (numero9 > 9) {
                            var numero9 = (numero9 - 9);
                        }

                        var impares = numero1 + numero3 + numero5 + numero7 + numero9;

                        //Suma total
                        var suma_total = (pares + impares);

                        //DiegoC:  Corregido esta sección estaba mal
                        var residuo = suma_total.toString().slice(-1);
                        if (residuo == 0) {
                            digito_validador = 0;
                        } else {
                            digito_validador = 10 - residuo;
                        }

                        //Si el digito validador es = a 10 toma el valor de 0
                        if (digito_validador == 10)
                            var digito_validador = 0;

                        //Validamos que el digito validador sea igual al de la cedula
                        return (digito_validador == ultimo_digito);

                    } else {
                        return false;
                    }
                },
                atras() {
                    this.step = 1;
                },
                nextStep() {
                    this.calcularEdad();
                    let checkProp = [
                        'tipo_documento',
                        'nro_documento',
                        'codigo_dactilar',
                        'nombres',
                        'apellido1',
                        'fecha_nacimiento',
                        'nacionalidad',
                        'sexo',
                        'celular',
                        'email',
                        'provincia',
                        'canton',
                        'direccion',
                        'plan_id',
                        'formato',
                    ];
                    for (let i = 0; i < checkProp.length; i++) {
                        let prop = checkProp[i];
                        if (this[prop].length === 0) {
                            $("#" + prop).focus();
                            Swal.fire("", "Campo " + this.etiquetas[prop] + " no llenado", "info")

                            return;
                        }

                    }
                    //valida dirección
                    if (this.direccion.length < 10) {
                        $("#direccion").focus();
                        Swal.fire("", "La dirección debe ser más detallada", "info")
                        return;
                    }
                    //valida cédula
                    if (this.tipo_documento == 1) {
                        if (!this.validarCedula(this.nro_documento)) {
                            $("#nro_documento").focus();
                            Swal.fire("", "Número de cédula incorrecta", "info")
                            return;
                        }
                    }

                    //nro celular
                    let ini_nro_celular = this.celular.substring(0, 2);
                    if (this.celular.length !== 10 || ini_nro_celular !== "09") {
                        $("#celular").focus();
                        Swal.fire("", "Número de celular inválido", "info")
                        return;
                    }
                    //
                    if (this.codigo_dactilar.length !== 10) {
                        $("#codigo_dactilar").focus();
                        Swal.fire("", "Código dactilar incorrecto", "info")
                        return;
                    }
                    //valida edad
                    if (this.edad < 18) {
                        Swal.fire("", "Eres menor de edad", "info")
                        return;
                    }
                    if (this.edad > 200) {
                        Swal.fire("", "Tu edad es real?", "info")
                        return;
                    }
                    //valida ruc
                    if ((this.con_ruc == '1' || this.tipo !== 'pnatural') && this.nro_ruc.length != 13) {
                        $("#ruc").focus();
                        Swal.fire("", "Debe ingresar el ruc", "info")
                        return;
                    }
                    //validar si es con ruc debe ser mayor a plan 1
                    if (this.con_ruc == '1' && this.plan_id == '1') {
                        Swal.fire("", "La firma con RUC solo puede ser emitida por al menos 1 mes", "info")
                        return;
                    }
                    //valida si es token
                    if (this.formato == 2 && this.sn_token.length == 0) {
                        $("#ruc").focus();
                        Swal.fire("", "Es necesario ingresar el nro. de serial del token.", "info")
                        return;
                    }

                    //valida  longitud de dirección
                    if (this.direccion.length > 100) {
                        $("#direccion").focus();
                        Swal.fire("", "La dirección debe contener como máximo 100 caracteres.", "info")
                        return;
                    }


                    this.step = 2;
                },
                isNumberKey(evt) {
                    let charCode = (evt.which) ? evt.which : evt.keyCode
                    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                        evt.preventDefault();
                    } else {
                        return true;
                    }

                },
                enviar() {
                    let docs = {!! json_encode($documentosNecesarios) !!};
                    let index = docs.indexOf('RUC');
                    if (index !== -1) {
                        docs.splice(index, 1);
                    }
                    index = docs.indexOf('DOCUMENTO_ADICIONAL');
                    if (index !== -1) {
                        docs.splice(index, 1);
                    }
                    for (let i = 0; i < docs.length; i++) {
                        let prop = docs[i];
                        const input = document.getElementById('file-input-' + prop);
                        const file = input.files;


                        if (!file || file.length === 0) {
                            $('#file-input-' + prop).focus();
                            Swal.fire("",
                                "Debe subir todos los documentos requeridos: " + this.documentosLabel[prop],
                                "info"
                            )
                            return;
                        }


                    }
                    let file = document.getElementById('file-input-RUC');
                    if (file !== undefined && file !== null) {
                        file = document.getElementById('file-input-RUC').files
                    } else {
                        file = document.getElementById('file-input-COPIA_RUC').files;
                    }
                    if ((this.tipo !== 'pnatural') && (!file || file.length === 0)) {
                        $('#file-input-RUC').focus();
                        Swal.fire("", "Debe subir todos los documentos requeridos: RUC", "info")
                        return;
                    }
                    file = document.getElementById('file-input-VIDEO').files;
                    if (this.edad > 64 && (!file || file.length === 0)) {
                        $('#file-input-VIDEO').focus();
                        Swal.fire("", "Debe subir el video", "info")
                        return;
                    }
                    $("#form").submit();
                },
                calcularEdad() {
                    let fechaNacimientoObj = new Date(this.fecha_nacimiento);
                    let ageDifMs = Date.now() - fechaNacimientoObj;
                    let ageDate = new Date(ageDifMs);
                    this.edad = Math.abs(ageDate.getUTCFullYear() - 1970);
                }
            },
            watch: {
                provincia() {
                    this.canton = "";
                },
                fecha_nacimiento() {
                    this.calcularEdad();

                },
                con_ruc(new_val) {
                    if (new_val && this.tipo_documento == 1) {
                        this.nro_ruc = this.nro_documento + "001";
                    }
                },
                nro_documento(new_val) {


                    let idLength = new_val.length;
                    if (idLength === 10) {
                        Swal.fire({
                            title: 'Cargando Datos...',
                            text: 'Espera un momento',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        const controller = new AbortController();
                        const id = setTimeout(() => controller.abort(), 8000);
                        fetch('{{route('identification.name')}}?identification=' + new_val, {
                            signal: controller.signal
                        })
                            .then(res => res.json())
                            .then(res => {
                                if (res.status === 'not_found') {
                                    Swal.fire("", "Verifique el número de cédula", "error");
                                    return;
                                }
                                if (res.status === 'success') {
                                    let data=res.data;
                                    this.nombres = data.name;
                                    this.apellido1 = data.firstSurname;
                                    this.apellido2 = data.secondSurname;
                                    this.direccion = data.address;
                                }
                                Swal.close();
                            }).catch(err => {
                            Swal.close();
                        }).finally(() => clearTimeout(id));
                    }

                }
            },
            computed: {
                messageFormat() {
                    switch (parseInt(this.formato)) {
                        case 1:
                            return "Su firma .P12 es un archivo con extención .p12 que sirve para ser instalado en una PC desde la cual podrá firmar sus documentos."
                        case 2:
                            return "El Token es un dispositivo USB Seguro con el cual podrá firmar sus documentos desde una computadora.";
                        default:
                            return "";
                    }
                }
            }
        });
        const root = app.mount('#app');
        let img = '{{asset('assets/img/documents/')}}';

        function previewPhoto(code) {
            const input = document.getElementById('file-input-' + code);
            const file = input.files;
            if (file) {
                if (file[0].type.includes('image')) {
                    const fileReader = new FileReader();
                    const preview = document.getElementById('file-img-' + code);
                    fileReader.onload = function (event) {
                        preview.setAttribute('src', event.target.result);
                    }
                    fileReader.readAsDataURL(file[0]);
                } else {
                    const preview = document.getElementById('file-img-' + code);
                    console.log(img + "/" + code + "_CHECK.png")
                    preview.setAttribute('src', img + "/" + code + "_CHECK.png");
                }

            }
        }
    </script>
@endsection
