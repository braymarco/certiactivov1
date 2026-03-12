@extends('template')
@section('content')
   <div class="card">
       <div class="card-body">
           <div class="pt-4 text-center">
               <h3> Proceso iniciado</h3>
           </div>
           <div class="pt-3">
               Su solicitud ha sido iniciada, se realizará la revisión de la documentación, una vez se complete la revisión, recibirá
               un correo para la descarga de su firma. Para revisar el estado de su proceso puede consultarlo desde el siguiente link (no lo comparta con nadie):
               <a target="_blank" href="{{$proceso->linkCliente()}}">{{$proceso->linkCliente()}}</a>
           </div>
       </div>
   </div>
@endsection
