<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\TipoUsuario;
use App\Models\Previlegio;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class TipoUsuarioController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('TipoUsuarioController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tipos = TipoUsuario::_getAllTipoUsuarios($request['searchText'])->paginate(6);
        return view('admCentros.tipo_usuario.index',["tipos"=>$tipos,"searchText"=>$request->get('searchText')]);
    }

    public function create()
    {
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/tipo_usuario/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        return view('admCentros.tipo_usuario.create');
    }

    public function store(Request $request)
    {
        TipoUsuario::_insertarTipoUsuario($request);
        return Redirect::to('adm/tipo_usuario')->with('msj','El tipo de Usuario: "'.$request['nombre'].'" se creo exitósamente.');
    }

    public function edit($id)
    {
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/tipo_usuario/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        return view("admCentros.tipo_usuario.edit",["tipo"=>TipoUsuario::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        TipoUsuario::_editarTipoUsuario($id, $request);
        return Redirect::to('adm/tipo_usuario')->with('msj','El tipo de Usuario: '.$request->nombre.' se edito exitosamente.');
    }

    public function destroy($id){
        TipoUsuario::_eliminarTipoUsuario($id);
        return Redirect::to('adm/tipo_usuario')->with('msj','El tipo de Usuario: '.$id.' se Elimino exitosamente.');
    }
}
