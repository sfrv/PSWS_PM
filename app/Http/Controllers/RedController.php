<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Red;

class RedController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $redes = Red::_getAllRedes($request['searchText'])->paginate(6);
        return view('admCentros.red.index',["redes"=>$redes,"searchText"=>$request->get('searchText')]);
    }

    public function create()
    {
        return view('admCentros.red.create');
    }

    public function store(Request $request)
    {
        Red::_insertarRed($request);
        return Redirect::to('adm/red')->with('msj','La Red: "'.$request['nombre'].'" se creo exitósamente.');
    }

    public function edit($id)
    {
        return view("admCentros.red.edit",["red"=>Red::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        Red::_editarRed($id, $request);
        return Redirect::to('adm/red')->with('msj','La Red: '.$request->nombre.' se edito exitosamente.');
    }

    public function destroy($id){
        Red::_eliminarRed($id);
        return Redirect::to('adm/red')->with('msj','La Red: '.$id.' se Elimino exitosamente.');
    }
}
