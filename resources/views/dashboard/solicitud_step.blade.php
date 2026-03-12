@extends('template_admin')
@section('head')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"></link>
@endsection
@section('content')
    <div class="card" id="app">
        <div class="card-body">
            <div class="text-center">
                <h4> #{{$solicitud->id}} - {{$solicitud->nro_documento}}</h4>
            </div>
            <hr>
            <div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="pb-2 text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary"
                                        onclick="rotateLeft()"
                                >
            <span class="docs-tooltip" data-toggle="tooltip" title="">
              <span data-feather="rotate-ccw"></span>
            </span>
                                </button>
                                <button type="button" class="btn btn-primary"
                                        onclick="rotateRight()"
                                >
            <span class="docs-tooltip" data-toggle="tooltip" title="">
              <span data-feather="rotate-cw"></span>
            </span>
                                </button>
                            </div>
                        </div>
                        <div v-if="cedulaFrontal()">
                            <img id="image" src="{{route('requisito.descargar',[
    'documentoId'=>$requisitosPorTipo[$tiposRequisito::$CEDULA_FRONTAL]->id
    ])}}" alt="" class="img-fluid">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="py-2">
                            <button class="btn btn-info btn-sm" @click="regresar"
                                    :disabled="(step<1 || incorrecto_enable) ? '' : disabled">
                                <i data-feather="arrow-left"></i> Regresar
                            </button>
                        </div>

                        <div class="pb-2 text-center">
                            <b>La información es correcta?</b>
                        </div>
                        <div>


                            <div>
                                <div class="py-2">
                                    <b> Datos Personales</b>
                                </div>
                                <div>
                                    <div class="form-group" v-if="stepCheck('tipo_documento')">
                                        <label for="tipo_documento" class="label-required">Tipo de Documento</label>
                                        <select name="tipo_documento" class="form-select form-select-sm"
                                                aria-label="Tipo de Documento"
                                                id="tipo_documento"
                                                v-model="tipo_documento"
                                                disabled
                                                required>
                                            <option value="1">Cédula</option>
                                            <option value="2">Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="form-group" v-if="stepCheck('nro_documento')">
                                        <label for="nro_documento"
                                               class="label-required"
                                        >Nro. de Documento</label>
                                        <input id="nro_documento" type="text" name="nro_documento"
                                               class="form-control form-control-sm"
                                               v-model="nro_documento"
                                               disabled
                                               required>

                                    </div>
                                    <div class="form-group" v-if="stepCheck('codigo_dactilar')">
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
                                               disabled
                                               required>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
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
                    con_ruc: {{$solicitud->con_ruc??'false'}},
                    provincia: "{{$solicitud->provincia}}",
                    email: "{{$solicitud->email}}",
                    canton: "{{$solicitud->canton}}",
                    nro_ruc: "{{$solicitud->nro_ruc}}",
                    provincias: {!! json_encode($provincias) !!},
                    cantones: {!! json_encode($cantones) !!},
                    formato: "{{$solicitud->formato??1}}",
                    step: 0,
                    steps: {
                        'pnatural': [
                            'tipo_documento',
                            'nro_documento',
                            'codigo_dactilar',
                            'nombres',
                            'apellido1',
                            'apellido2',
                            'fecha_nacimiento',
                            'nacionalidad',
                            'sexo',
                            'celular',
                            'email',
                            'con_ruc',
                            'nro_ruc',
                        ],
                        'mempresa': [
                            'tipo_documento',
                            'nro_documento',
                            'codigo_dactilar',
                            'nombres',
                            'apellido1',
                            'apellido2',
                            'fecha_nacimiento',
                            'nacionalidad',
                            'sexo',
                            'celular',
                            'email',
                            'nro_ruc',
                            'nro_ruc',
                        ],

                    },
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
                    incorrecto_enable: false
                }
            },
            methods: {
                correcto() {
                    this.step++
                },
                incorrecto() {
                    this.incorrecto_enable = true;
                    $("#" + this.steps['{{$solicitud->tipo}}'][this.step]).prop("disabled", false)
                },
                actualizar() {
                    this.incorrecto_enable = false;
                    $("#" + this.steps['{{$solicitud->tipo}}'][this.step]).prop("disabled", true)
                    Swal.fire("", "Actualizado", "success");
                },
                regresar() {

                    this.step--;
                },
                stepCheck(variable) {
                    return this.steps['{{$solicitud->tipo}}'][this.step] === variable;
                },
                cedulaFrontal() {
                    let arr = ['tipo_documento',
                        'nro_documento',
                        'nombres',
                        'apellido1',
                        'apellido2',
                        'fecha_nacimiento',
                        'nacionalidad',
                        'sexo',
                        'sexo',
                    ];
                    let key = this.steps['{{$solicitud->tipo}}'][this.step];
                    return arr.includes(key);
                },
                cedulaReverso() {
                    let arr = [
                        'codigo_dactilar',];
                    let key = this.steps['{{$solicitud->tipo}}'][this.step];
                    return arr.includes(key);
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
    </script>
@endsection
