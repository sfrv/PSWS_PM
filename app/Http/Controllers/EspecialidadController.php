<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Especialidad;
use DB;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class EspecialidadController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('EspecialidadController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $especialidades = Especialidad::_getAllEspecialidades($request['searchText'])->paginate(7);
        return view('admCentros.especialidad.index',["especialidades"=>$especialidades,"searchText"=>$request->get('searchText')]);
    }

    public function create()
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/especialidad/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        return view('admCentros.especialidad.create');
    }

    public function store(Request $request)
    {
        Especialidad::_insertarEspecialidad($request);
        return Redirect::to('adm/especialidad')->with('msj','La especialidad: "'.$request['nombre'].'" se creo exitósamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/especialidad/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        return view("admCentros.especialidad.edit",["especialidad"=>Especialidad::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        Especialidad::_editarEspecialidad($id, $request);
        return Redirect::to('adm/especialidad')->with('msj','La Especialidad: '.$request->nombre.' se edito exitosamente.');
    }

    public function destroy($id)
    {
		    Especialidad::_eliminarEspecialidad($id);
        return Redirect::to('adm/especialidad');
	}

    public function getEspecialidades()
    {
        return json_encode(array("especialidades" => Especialidad::_getAllEspecialidad()->get()));
    }

    public function getEspecialidadPorLugar($id)
    {
        $detalle_especialidads = DB::table('detalle_especialidads')->get();
        $arr = array();
        foreach ($detalle_especialidads as $det_es) {
            if ($det_es->id_lugar == $id) {
                $arr[] = Especialidad::findOrfail($det_es->id_especialidad);
            }
        }
        return json_encode(array("especialidades" => $arr ));
    }
}
