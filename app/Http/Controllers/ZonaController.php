<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Zona;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class ZonaController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('ZonaController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }
    
  	public function index(Request $request)
  	{
    	$zonas = Zona::_getAllZonas($request['searchText'])->paginate(6);
    	return view('admCentros.zona.index',["zonas"=>$zonas,"searchText"=>$request->get('searchText')]);
  	}

  	public function create()
  	{
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/zona/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
    	  return view('admCentros.zona.create');
  	}

  	public function store(Request $request){
    	Zona::_insertarZona($request);
    	return Redirect::to('adm/zona')->with('msj','La Zona: "'.$request['nombre'].'" se creo exitósamente.');
  	}

  	public function edit($id)
  	{
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/zona/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
    	  return view("admCentros.zona.edit",["zona"=>Zona::findOrFail($id)]);
  	}

  	public function update(Request $request, $id)
  	{
    	Zona::_editarZona($id, $request);
    	return Redirect::to('adm/zona')->with('msj','La Zona: '.$request->nombre.' se edito exitosamente.');
  	}

  	public function destroy($id){
		Zona::_eliminarZona($id);
		return Redirect::to('adm/zona')->with('msj','La Zona: '.$id.' se Elimino exitosamente.');
	}

  // public function getZonas(){
  //     return json_encode(array("zonas" => Zona::_getAllZona()->get()));
  // }
}
