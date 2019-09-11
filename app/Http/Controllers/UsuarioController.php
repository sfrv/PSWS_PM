<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\CentroMedico;
use App\Models\ServicioMetodo;
use App\Models\Previlegio;
use App\User;
use Illuminate\Support\Facades\Auth;
use Route;
use Illuminate\Routing\Redirector;

class UsuarioController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('UsuarioController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $usuarios = User::_getAllUsuarios($request['searchText'])->paginate(7);
        return view('admCentros.usuario.index', ["usuarios" => $usuarios, "searchText" => $request->get('searchText')]);
    }

    public function create()
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/usuario/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
    	$centros = CentroMedico::all();
        return view('admCentros.usuario.create', compact('centros'));
    }

    public function store(Request $request)
    {
        $id_user = User::_insertarUsuario($request);
        Previlegio::_insertarPrevilegioUsuario($id_user);
        return Redirect::to('adm/usuario')->with('msj', 'El Usuario: "' . $request['name'] . '" se creo exitósamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/usuario/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
    	$tipos_usuario = array("Usuario","Administrador");
    	$centros = CentroMedico::_getAllCentrosMedicos("","")->get();
    	$usuario = User::findOrFail($id);
        return view("admCentros.usuario.edit", compact('centros','usuario','tipos_usuario'));
    }

    public function update(Request $request, $id)
    {
        User::_editarUsuario($id, $request);
        return Redirect::to('adm/usuario')->with('msj', 'El Usuario: "' . $request->name . '" se edito exitosamente.');
    }
}
