<?php

namespace App\Http\Controllers;

use App\Enums\SignatureRequestStatus;
use App\Models\SignatureRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function solicitudes()
    {
        $filtersIn = $this->request->validate([
            'page' => 'nullable|numeric',
            'estado' => 'nullable|numeric',
            'search' => 'nullable',
        ]);
        $this->request->flash();
        $solicitudes = SignatureRequest::query();

        if ($this->request->has('estado') && strlen($this->request->estado) >0)
            $solicitudes->where('estado', $this->request->estado);

        if ($this->request->has('search') && strlen($this->request->search)>0) {
            $query = $this->request->search;
            $initialKey = substr($query, 0, 1);
            $anotherText=substr($query, 1);
            switch ($initialKey) {
                case '#':
                    $solicitudes->where('nro_documento', $anotherText);
                    break;
                case '@':
                    $solicitudes->where('id', $anotherText);
                    break;
                default:
                    $solicitudes->where(function ($q)use ($query) {
                        $q->where('nombres', 'like', "%$query%")
                            ->orWhere('apellido1', 'like', "%$query%")
                            ->orWhere('nro_documento', 'like', "%$query%")
                            ->orWhere('celular', 'like', "%$query%")
                            ->orWhere('email', 'like', "%$query%")
                            ->orWhere('apellido2', 'like', "%$query%");
                    });
                    break;
            }


        }


        $solicitudes = $solicitudes->orderBy('estado','ASC')
            ->orderBy('id','DESC')->paginate(10);
        return view('dashboard.solicitudes', [
            'solicitudes' => $solicitudes,
            'estadosSolicitud'=>SignatureRequestStatus::$STR,
            'filters' => [
                'estado' => $filtersIn['estado'] ?? '',
                'search' => $filtersIn['search'] ?? '',
            ]
        ]);
    }

}
