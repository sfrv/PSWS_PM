<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Previlegio;
use App\User;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Routing\Redirector;

class PrevilegioController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        // $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        // $result = ServicioMetodo::_verificarServicioMetodo('PrevilegioController',$acctionName);
        // if ($result->estado == 0) {
        //     $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        // }
        // $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $usuarios = User::_getAllUsuarios($request['searchText'])->paginate(7);
        return view('admCentros.previlegio.index', ["usuarios" => $usuarios, "searchText" => $request->get('searchText')]);
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/previlegio/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        $usuario = User::findOrFail($id);
    	$previlegios = Previlegio::_getAllPrevilegiosUsuario($id);
    	$modulos = Previlegio::_getAllModulos($id);
    	// dd($previlegios);
        return view("admCentros.previlegio.edit", compact('usuario','previlegios','modulos'));
    }

    public function update(Request $request, $id)
    {
    	// return $request->all();
        Previlegio::_editarPrevilegios($id, $request);
        $usuario = User::findOrFail($id);
        return Redirect::to('adm/previlegio')->with('msj', 'Los Previlegios de: "' . $usuario->email . '" se editaron exitosamente.');
    }
}
