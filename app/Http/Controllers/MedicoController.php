<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Medico;

class MedicoController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $medicos = Medico::_getAllMedicos($request['searchText'])->paginate(7);
        return view('admCentros.medico.index', ["medicos" => $medicos, "searchText" => $request->get('searchText')]);
    }

    public function create()
    {
        return view('admCentros.medico.create');
    }

    public function store(Request $request)
    {
        Medico::_insertarMedico($request);
        return Redirect::to('adm/medico')->with('msj', 'El Medico: "' . $request['nombre'] . ' ' . $request['apellido'] . '" se creo exitósamente.');
    }

    public function edit($id)
    {
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
