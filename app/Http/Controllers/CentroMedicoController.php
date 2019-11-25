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
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;
use App\Models\Previlegio;
use DB;


class CentroMedicoController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('CentroMedicoController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $centros = CentroMedico::_getAllCentrosMedicos($request['searchText'],$request['filtro'])->paginate(6);
        
        return view('admCentros.centro.index', ["centros" => $centros, "searchText" => $request->get('searchText')]);
    }


    public function create()
    {
        if (!Previlegio::_esAdministrador())
            return Redirect::to('adm/centro/')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $redes = Red::_getAllRedes("")->get();
        $tiposervicios = TipoServicio::_getAllTipoServicios("")->get();
        $zonas = Zona::_getAllZonas("")->get();
        $niveles = Nivel::_getAllNiveles("")->get();
        // $especialidades = Especialidad::_getAllEspecialidades("")->get();
        return view('admCentros.centro.create', compact('redes','tiposervicios','zonas','niveles'));
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
        $w = Previlegio::_tienePermiso($id);
        if ($w != -1)
            return Redirect::to('adm/centro/'.$w.'/edit')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $centro = CentroMedico::_obtenerCentro($id);
        $detalle = CentroMedico::_obtenerDetalleCentro($id);
        $detalle_medicos = CentroMedico::_obtenerDetalleCentroMedicos($id);
        $areas_camas = AreaCama::_getAllAreasCamasPorIdCentro($id);
        $redes = Red::_getAllRedes("")->get();
        $tiposervicios = TipoServicio::_getAllTipoServicios("")->get();
        $zonas = Zona::_getAllZonas("")->get();
        $niveles = Nivel::_getAllNiveles("")->get();
  
        return view('admCentros.centro.edit',compact('centro','redes','tiposervicios','zonas','niveles','detalle','detalle_medicos','areas_camas'));
    }

    public function update(Request $request, $id)
    {
        CentroMedico::_editarCentroMedico($request, $id);
        return Redirect::to('adm/centro')->with('msj', 'El Centro Medico: "' . $request->nombre  . '" se edito exitosamente.');
    }

    public function edit_especialidades($id)
    {
        $w = Previlegio::_tienePermiso($id);
        if ($w != -1)
            return Redirect::to('adm/centro/'.$w.'/edit_especialidades')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        
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
        $w = Previlegio::_tienePermiso($id);
        if ($w != -1)
            return Redirect::to('adm/centro/'.$w.'/edit_medicos')->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
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
        $w = Previlegio::_tienePermiso($id);
        if ($w != -1)
            return Redirect::to('adm/centro/'.$w.'/edit_areas')->with('msj_e', 'Usted no tiene los previlegios necesarios.');

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
