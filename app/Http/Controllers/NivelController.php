<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Nivel;

class NivelController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
  	public function index(Request $request)
  	{
    	$niveles = Nivel::_getAllNiveles($request['searchText'])->paginate(6);
    	return view('admCentros.nivel.index',["niveles"=>$niveles,"searchText"=>$request->get('searchText')]);
  	}

  	public function create()
  	{
    	return view('admCentros.nivel.create');//,['trabajadores'=>$trabajadores,'alimentos'=>$alimentos]);
  	}

  	public function store(Request $request)
  	{
    	Nivel::_insertarNivel($request);
    	return Redirect::to('adm/nivel')->with('msj','El nivel: "'.$request['nombre'].'" se creo exitósamente.');
  	}

  	public function edit($id)
  	{
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
