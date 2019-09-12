<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Nivel;
use App\Models\Previlegio;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class NivelController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('NivelController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }
    
  	public function index(Request $request)
  	{
    	$niveles = Nivel::_getAllNiveles($request['searchText'])->paginate(6);
    	return view('admCentros.nivel.index',["niveles"=>$niveles,"searchText"=>$request->get('searchText')]);
  	}

  	public function create()
  	{
        if (!Previlegio::_esAdministrador())
          return Redirect::to('adm/nivel/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');

    	  return view('admCentros.nivel.create');//,['trabajadores'=>$trabajadores,'alimentos'=>$alimentos]);
  	}

  	public function store(Request $request)
  	{
    	Nivel::_insertarNivel($request);
    	return Redirect::to('adm/nivel')->with('msj','El nivel: "'.$request['nombre'].'" se creo exitósamente.');
  	}

  	public function edit($id)
  	{
        if (!Previlegio::_esAdministrador())
          return Redirect::to('adm/nivel/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');

    	  return view("admCentros.nivel.edit",["nivel"=>Nivel::findOrFail($id)]);
  	}

 	 public function update(Request $request, $id)
  	{
    	Nivel::_editarNivel($id, $request);
    	return Redirect::to('adm/nivel')->with('msj','El nivel: '.$request->nombre.' se edito exitosamente.');
  	}

  	public function destroy($id)
  	{
    	Nivel::_eliminarNivel($id);
    	return Redirect::to('adm/nivel')->with('msj','El Nivel: '.$id.' se Elimino exitosamente.');
	}

  // public function getNiveles(){
  //   return json_encode(array("niveles" => Nivel::_getAllNivel()->get()));
  // }

  // public function get_imagen($id)
  // {
  //   $nivel = Nivel::findOrFail($id);
  //   return response()->file('../public/images/' . $nivel->imagen);
  // }
}
