<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Red;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class RedController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('RedController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $redes = Red::_getAllRedes($request['searchText'])->paginate(6);
        return view('admCentros.red.index',["redes"=>$redes,"searchText"=>$request->get('searchText')]);
    }

    public function create()
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/red/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        return view('admCentros.red.create');
    }

    public function store(Request $request)
    {
        Red::_insertarRed($request);
        return Redirect::to('adm/red')->with('msj','La Red: "'.$request['nombre'].'" se creo exitósamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/red/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
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
