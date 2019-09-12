<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\ServicioMetodo;
use App\Models\Previlegio;

class ServicioMetodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $servicios = ServicioMetodo::_getAllServiciosMetodos($request['searchText'])->paginate(15);
        return view('admCentros.servicio_metodo.index', ["servicios" => $servicios, "searchText" => $request->get('searchText')]);
    }

    public function edit($id)
    {
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/centro')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        return view("admCentros.servicio_metodo.edit",["servicio"=>ServicioMetodo::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        ServicioMetodo::_editarServicioMetodo($id, $request);
        return Redirect::to('adm/servicio_metodo')->with('msj','La ServicioMetodo: '.$request->nombre.' se edito exitosamente.');
    }

    public function destroy($id){
        ServicioMetodo::_cambiarEstadoServicioMetodo($id);
        return Redirect::to('adm/servicio_metodo')->with('msj','El Servicio-Metodo: '.$id.' se Cambio de Estado exitosamente.');
    }
}
