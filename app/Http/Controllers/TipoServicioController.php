<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\Redirect;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\Previlegio;
use App\Models\ServicioMetodo;

class TipoServicioController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('TipoServicioController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

  	public function index(Request $request)
  	{
    	$servicios = TipoServicio::_getAllTipoServicios($request['searchText'])->paginate(6);
    	return view('admCentros.servicio.index',["servicios"=>$servicios,"searchText"=>$request->get('searchText')]);
  	}

  	public function create()
  	{
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/servicio/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
    	  return view('admCentros.servicio.create');
  	}

  	public function store(Request $request)
  	{
    	TipoServicio::_insertarTipoServicio($request);
    	return Redirect::to('adm/servicio')->with('msj','El tipo de Servicio: "'.$request['nombre'].'" se creo exitósamente.');
  	}

  	public function edit($id)
  	{
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/servicio/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
    	  return view("admCentros.servicio.edit",["servicio"=>TipoServicio::findOrFail($id)]);
  	}

  	public function update(Request $request, $id)
  	{
    	TipoServicio::_editarTipoServicio($id, $request);
    	return Redirect::to('adm/servicio')->with('msj','El tipo de Servicio: '.$request->nombre.' se edito exitosamente.');
  	}

  	public function destroy($id)
  	{
    	TipoServicio::_eliminarTipoServicio($id);
    	return Redirect::to('adm/servicio')->with('msj','El tipo de Servicio: '.$id.' se Elimino exitosamente.');
	}

  	// public function getTipoServicios()
  	// {
  	//     return json_encode(array("tiposervicios" => TipoServicio::_getAllTipoServicio()->get()));
  	// }

  	// public function get_imagen($id)
  	// {
  	//   $servicio = TipoServicio::findOrFail($id);
  	//   return response()->file('../public/images/' . $servicio->imagen);
  	// }
}
