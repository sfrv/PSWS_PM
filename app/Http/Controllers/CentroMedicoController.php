<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\CentroMedico;
use App\Models\Red;
use App\Models\TipoServicio;
use App\Models\Zona;
use App\Models\Nivel;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\AreaCama;
use Illuminate\Support\Facades\Auth;
use DB;


class CentroMedicoController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $centros = CentroMedico::_getAllCentrosMedicos($request['searchText'],$request['filtro'])->paginate(6);
        
        return view('admCentros.centro.index', ["centros" => $centros, "searchText" => $request->get('searchText')]);
    }


    public function create()
    {
        $redes = Red::_getAllRedes("")->get();
        $tiposervicios = TipoServicio::_getAllTipoServicios("")->get();
        $zonas = Zona::_getAllZonas("")->get();
        $niveles = Nivel::_getAllNiveles("")->get();
        $especialidades = Especialidad::_getAllEspecialidades("")->get();
        return view('admCentros.centro.create', compact('redes','tiposervicios','zonas','niveles','especialidades'));
    }

    public function store(Request $request)
    {
        CentroMedico::_insertarCentroMedico($request);
        return Redirect::to('adm/centro')->with('msj','El Centro Medico: "'.$request['nombre'].'" se creo exitósamente.');
    }

    public function show($id)
    {
        $centro = CentroMedico::_obtenerCentro($id);
        $detalle = CentroMedico::_obtenerDetalleCentro($id);
        $detalle_medicos = CentroMedico::_obtenerDetalleCentroMedicos($id);
  
        return view('admCentros.centro.show',compact('centro','detalle','detalle_medicos'));
    }

    public function edit($id)
    {
        if (Auth::user()->id_centro_medico != $id && Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/centro/'.Auth::user()->id_centro_medico.'/edit');
        }
        $centro = CentroMedico::_obtenerCentro($id);
        $detalle = CentroMedico::_obtenerDetalleCentro($id);
        $detalle_medicos = CentroMedico::_obtenerDetalleCentroMedicos($id);
        $areas_camas = AreaCama::_getAllAreasCamasPorIdCentro($id);
        $redes = Red::_getAllRedes("")->get();
        $tiposervicios = TipoServicio::_getAllTipoServicios("")->get();
        $zonas = Zona::_getAllZonas("")->get();
        $niveles = Nivel::_getAllNiveles("")->get();
        // $especialidades = Especialidad::_getAllEspecialidades("")->get();

        // $detalle_json = json_encode($detalle, JSON_UNESCAPED_SLASHES );
  
        return view('admCentros.centro.edit',compact('centro','redes','tiposervicios','zonas','niveles','detalle','detalle_medicos','areas_camas'));
    }

    public function update(Request $request, $id)
    {
        CentroMedico::_editarCentroMedico($request, $id);
        return Redirect::to('adm/centro')->with('msj', 'El Centro Medico: "' . $request->nombre  . '" se edito exitosamente.');
    }

    public function edit_especialidades($id)
    {
        if (Auth::user()->id_centro_medico != $id && Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/centro/'.Auth::user()->id_centro_medico.'/edit_especialidades');
        }
        
        $centro = CentroMedico::_obtenerCentro($id);
        $detalle = CentroMedico::_obtenerDetalleCentro($id);
        $especialidades = Especialidad::_getAllEspecialidades("")->get();
        $detalle_json = json_encode($detalle, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.edit_especialidades',compact('centro','detalle','especialidades','detalle_json'));   
    }

    public function update_especialidades(Request $request, $id)
    {
        CentroMedico::_editarCentroMedicoEspecialidades($request, $id);
        return Redirect::to('adm/centro/'.$id.'/edit')->with('msj', 'Especialidades del Centro: "' . $id  . '" se editaron exitosamente.');
    }

    public function edit_medicos($id)
    {
        if (Auth::user()->id_centro_medico != $id && Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/centro/'.Auth::user()->id_centro_medico.'/edit_medicos');
        }
        $centro = CentroMedico::_obtenerCentro($id);
        $medicos = Medico::_getAllMedicos("")->get();
        $detalle_medicos = CentroMedico::_obtenerDetalleCentroMedicos($id);
        $detalle_medicos_json = json_encode($detalle_medicos, JSON_UNESCAPED_SLASHES );
        // $especialidades = Especialidad::_getAllEspecialidades("")->get();
        // $detalle_json = json_encode($detalle, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.edit_medicos',compact('centro','medicos','detalle_medicos','detalle_medicos_json'));   
    }

    public function update_medicos(Request $request, $id)
    {
        // return $request->all();
        CentroMedico::_editarCentroMedicoMedicos($request, $id);
        return Redirect::to('adm/centro/'.$id.'/edit')->with('msj', 'Medicos del Centro: "' . $id  . '" se editaron exitosamente.');
    }

    public function edit_areas($id)
    {
        if (Auth::user()->id_centro_medico != $id && Auth::user()->tipo == 'Usuario') {
            return Redirect::to('adm/centro/'.Auth::user()->id_centro_medico.'/edit_areas');
        }
        $centro = CentroMedico::_obtenerCentro($id);
        $areas_camas = AreaCama::_getAllAreasCamasPorIdCentro($id);
        $areas_camas_json = json_encode($areas_camas, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.edit_areas',compact('centro','areas_camas','areas_camas_json'));   
    }

    public function update_areas(Request $request, $id_centro)
    {
        // return $request->all();
        if ($request->get('nombres_nuevos') != null) {
            $nombres_nuevos = $request->get('nombres_nuevos');
            $descripciones_nuevos = $request->get('descripciones_nuevos');
            $a = 0;
            while ($a < count($nombres_nuevos)) {
                $nombre = $nombres_nuevos[$a]; 
                $descripcion = $descripciones_nuevos[$a];
                AreaCama::_insertarAreaCama($id_centro,$nombre,$descripcion);
                $a++;
            }
        }

        if ($request->get('id_areas_editar') != null) {
            $nombres_editar = $request->get('nombres_editar');
            $descripciones_editar = $request->get('descripciones_editar');
            $id_areas_editar = $request->get('id_areas_editar');
            $a = 0;
            while ($a < count($nombres_editar)) {
                $nombre = $nombres_editar[$a]; 
                $descripcion = $descripciones_editar[$a];
                $id = $id_areas_editar[$a];
                AreaCama::_editarAreaCama($id,$nombre,$descripcion);
                $a++;
            }
        }

        if ($request->get('id_area_eliminar') != null) {
            $id_area_eliminar = $request->get('id_area_eliminar');
            $a = 0;
            while ($a < count($id_area_eliminar)) {
                $id = $id_area_eliminar[$a]; 
                AreaCama::_eliminarAreaCama($id);
                $a++;
            }
        }
        
        return Redirect::to('adm/centro/'.$id_centro.'/edit')->with('msj', 'Areas de Camas del Centro: "' . $id_centro  . '" se editaron exitosamente.');
    }

    public function destroy($id)
    {
        CentroMedico::_eliminarCentroMedico($id);
        return Redirect::to('adm/centro');
    }

 
    // public function getCentrosMedicos()
    // {
    //     return json_encode(array("centros" => CentroMedico::_getAllCentroMedico()->get()));
    // }

    // public function getCentrosMedicos_por_red_tipo_nivel($id_red, $id_tipo_servicio, $id_nivel)
    // {
    //     return json_encode(array("centros" => CentroMedico::_getCentrosMedicos_por_red_tipo_nivel($id_red, $id_tipo_servicio, $id_nivel)->get()));
    // }

    // public function getCentroMedico($id)
    // {
    //     return json_encode(array("centro" => CentroMedico::_getOneCentroMedico($id)->get()));
    // }

    //================================================

    // public function get_imagen($id)
    // {
    //     $centro = CentroMedico::findOrFail($id);
    //     return response()->file('../public/images/Centros/' . $centro->imagen);
    // }

    // public function get_lastCarteraServicio($id){
    //     return json_encode(array("carteras" => CentroMedico::_getLastCarteraServicio($id)->get()));
    // }

    // public function get_AllRolTurnos($id){
    //     return json_encode(array("roles" => CentroMedico::_getAllRolTurnos($id)->get()));
    // }
    // public function get_CentroMedico($id){
    //     return json_encode(array("centro" => CentroMedico::_obtenerCentro($id)));
    // }
    // public function get_CentrosMedicos_por_nombre_o_especialidad($searchText, $filtro){
    //     return json_encode(array("centros" => CentroMedico::_getAllCentrosMedicos($searchText, $filtro)->get()));
    // }

}
