<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Medico;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;

class MedicoController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('MedicoController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $medicos = Medico::_getAllMedicos($request['searchText'])->paginate(7);
        return view('admCentros.medico.index', ["medicos" => $medicos, "searchText" => $request->get('searchText')]);
    }

    public function create()
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/medico/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        return view('admCentros.medico.create');
    }

    public function store(Request $request)
    {
        Medico::_insertarMedico($request);
        return Redirect::to('adm/medico')->with('msj', 'El Medico: "' . $request['nombre'] . ' ' . $request['apellido'] . '" se creo exitósamente.');
    }

    public function edit($id)
    {
        if (Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/medico/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        }
        return view("admCentros.medico.edit", ["medico" => Medico::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        Medico::_editarMedico($id, $request);
        return Redirect::to('adm/medico')->with('msj', 'El Medico: "' . $request->nombre . ' ' . $request->apellido . '" se edito exitosamente.');
    }

    public function destroy($id)
    {
        Medico::_eliminarMedico($id);
        return Redirect::to('adm/medico')->with('msj','EL Medico: '.$id.' se Elimino exitosamente.');
    }

    public function getMedicos()
    {
        return json_encode(array("medicos" => Zona::_getAllMedico()->get()));
    }

    //para la aplicacion movil
    
    // public function get_AllMedicos(){
    //     return json_encode(array("medicos" => Medico::_getAllMedicos("")->get()));
    // }
}
