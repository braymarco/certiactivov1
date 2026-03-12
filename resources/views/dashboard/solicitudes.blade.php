@extends('template_admin')
@section('style')

@endsection
@section('content')
    <div class="pt-2">
        <div class="text-center">
            <h4>Solicitudes</h4>
        </div>
        <div class="pt-2">
            <form action="{{route('dashboard')}}">
                <div class="row">
                    <div class="col col-auto">
                        <div class="form-group">
                            <label for="search">Buscar</label>
                            <input id="search" name="search" type="text" class="form-control-sm form-control"
                                  value="{{$filters['search']??''}}"
                                   placeholder="nombres, celular,email">
                        </div>
                    </div>
                    <div class="col col-auto">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class='form-select form-select-sm'>
                                <option value="">TODOS</option>
                                @foreach($estadosSolicitud as $key=> $estadoSolicitud)
                                    <option value="{{$key}}">{{$estadoSolicitud}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col col-auto">
                        <div class="d-flex align-items-end h-100 ">
                            <div class="pb-1">
                                <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="pt-2">
            <table class="table  table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nro. Documento</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Plan</th>
                    <th>Estado</th>
                </tr>
                </thead>
                <tbody>
                @foreach($solicitudes as $solicitud)

                    <tr class="pointer table-{{$solicitud->classColor()}}"
                        onclick="document.location='{{route('solicitud',['id'=>$solicitud->id])}}'">
                        <td>{{$solicitud->id}}</td>
                        <td>{{$solicitud->nro_documento}}</td>
                        <td>{{$solicitud->nombres}}</td>
                        <td>{{$solicitud->apellido1}} {{$solicitud->apellido2}}</td>
                        <td>{{$solicitud->plan}}</td>
                        <td>{{$solicitud->estadoStr()}}</td>
                        <td></td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            <div class="text-center">
                {{$solicitudes->appends($filters)->links()}}
            </div>
        </div>
    </div>
@endsection
