<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\CentroMedico;
use App\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $usuarios = User::_getAllUsuarios($request['searchText'])->paginate(7);
        return view('admCentros.usuario.index', ["usuarios" => $usuarios, "searchText" => $request->get('searchText')]);
    }

    public function create()
    {
    	$centros = CentroMedico::all();
        return view('admCentros.usuario.create', compact('centros'));
    }

    public function store(Request $request)
    {
        User::_insertarUsuario($request);
        return Redirect::to('adm/usuario')->with('msj', 'El Usuario: "' . $request['name'] . '" se creo exitósamente.');
    }

    public function edit($id)
    {
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
