<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotizacionServicioController extends Controller
{
    public function store(Request $request,$id)
    {
                        
            $url = env('URL_SERVER_API', 'http://127.0.0.1:8000');
            $response = Http::post($url.'/cotizacion_servicio', [
                
                'cotizacion' => $request->input('cotizacion'),
                'servicio' => $request->input('servicio'),
                
            ]);
            $result = $response->json();
            
            if ($result && $result['status']) {
                //alert()->success('¡Guardado!','Ahora a registrar los datos.');
                
                return redirect()->route('cotizacion.create',compact('id'));
            } else {
                alert()->error('Oops...','Ha ocurrido un error. Por favor, intenta nuevamente.');
                return redirect()->route('cotizacion.create',compact('id'));
            }
    }
}