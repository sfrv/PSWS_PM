<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\Redirect;

class TipoServicioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

  	public function index(Request $request)
  	{
    	$servicios = TipoServicio::_getAllTipoServicios($request['searchText'])->paginate(6);
    	return view('admCentros.servicio.index',["servicios"=>$servicios,"searchText"=>$request->get('searchText')]);
  	}

  	public function create()
  	{
    	return view('admCentros.servicio.create');//,['trabajadores'=>$trabajadores,'alimentos'=>$alimentos]);
  	}

  	public function store(Request $request)
  	{
    	TipoServicio::_insertarTipoServicio($request);
    	return Redirect::to('adm/servicio')->with('msj','El tipo de Servicio: "'.$request['nombre'].'" se creo exitósamente.');
  	}

  	public function edit($id)
  	{
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
