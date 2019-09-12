<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\CentroMedico;
use App\Models\Medico;
use App\Models\RolTurno;
use App\Models\EtapaServicio;
use App\Models\RolDia;
use App\Models\Turno;
use App\Models\PersonalArea;
use App\Models\DetalleTurno;
use Maatwebsite\Excel\Facades\Excel;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;
use App\Models\Previlegio;

class RolTurnoController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('RolTurnoController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }

	public function index_rol_turno($id,Request $request)
	{
		$centro = CentroMedico::_obtenerCentro($id);
        $rol_turnos = CentroMedico::_obtenerRolTurnos($id,$request['searchText'])->paginate(7);
        $searchText = $request->get('searchText');
        return view('admCentros.centro.rol_turno.index',compact('centro','rol_turnos','searchText'));
	}

    public function edit_rol_turno($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anios = array("2018","2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");

    	$rol_turno = RolTurno::findOrFail($id_rol_turno);
    	return view('admCentros.centro.rol_turno.edit',compact('id_centro','rol_turno','meses','anios'));
    }

    public function edit_rol_turno_emergencia($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $etapa_servicio_uno = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Emergencia');
        $especialidades_etapa_emergencia = CentroMedico::_obtenerEspecialidadesEtapaEmergencia($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio_uno->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        $detalle2 = json_encode($especialidades_etapa_emergencia, JSON_UNESCAPED_SLASHES );
        // dd($rol_dias);
        return view('admCentros.centro.rol_turno.edit_emergencia',compact('id_centro','id_rol_turno','especialidades_etapa_emergencia','detalle_turnos_json','turnos_json','rol_dias_json','medicos_json','medicos','detalle2','etapa_servicio_uno'));
    }

    public function edit_rol_turno_consulta($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Consulta Externa');
        if (!isset($etapa_servicio->id)) {
            $aux = EtapaServicio::_insertarEtapaServicio('Etapa de Consulta Externa',$id_rol_turno);
            $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Consulta Externa');
        }
        $especialidades_etapa_consulta = CentroMedico::_obtenerEspecialidadesEtapaConsultaExt($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        $detalle2 = json_encode($especialidades_etapa_consulta, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.rol_turno.edit_consulta',compact('id_centro','id_rol_turno','especialidades_etapa_consulta','turnos_json','detalle_turnos_json','rol_dias_json','medicos_json','medicos','detalle2'));
    }

    public function edit_rol_turno_hospitalizacion($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');

        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Hospitalizacion');
        if (!isset($etapa_servicio->id)) {
            $aux = EtapaServicio::_insertarEtapaServicio('Etapa de Hospitalizacion',$id_rol_turno);
            $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Hospitalizacion');
        }
        $especialidades_etapa_hospitalizacion = CentroMedico::_obtenerEspecialidadesEtapaHospitalizacion($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        $detalle2 = json_encode($especialidades_etapa_hospitalizacion, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.rol_turno.edit_hospitalizacion',compact('id_centro','id_rol_turno','especialidades_etapa_hospitalizacion','turnos_json','detalle_turnos_json','rol_dias_json','medicos_json','medicos','detalle2'));
    }

    public function edit_rol_turno_personal_encargado($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'ETAPA DE PERSONAL ENCARGADO');
        if (!isset($etapa_servicio->id)) {
            $aux = EtapaServicio::_insertarEtapaServicio('ETAPA DE PERSONAL ENCARGADO',$id_rol_turno);
            $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'ETAPA DE PERSONAL ENCARGADO');
        }
        $personal_etapa_personal_area = PersonalArea::_obtenerPersonalEtapaPersonalArea($etapa_servicio->id);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );

        return view('admCentros.centro.rol_turno.edit_personal_encargado',compact('id_centro','id_rol_turno','personal_etapa_personal_area','detalle_turnos_json','turnos_json','rol_dias_json','medicos_json','medicos'));
    }

    public function show_rol_turno($id,$id_centro)
    {
    	$rol_turno = RolTurno::findOrFail($id);
    	return view('admCentros.centro.rol_turno.show',compact('id_centro','rol_turno'));
    }

    public function show_rol_turno_emergencia($id,$id_centro)
    {
        $rol_turno = RolTurno::findOrFail($id);
        $etapa_servicio_uno = RolTurno::_getEtapaServicio($id,'Etapa de Emergencia');
        $especialidades_etapa_emergencia = CentroMedico::_obtenerEspecialidadesEtapaEmergencia($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio_uno->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.rol_turno.show_emergencia',compact('detalle_turnos_json','id_centro','rol_turno','especialidades_etapa_emergencia','turnos_json','rol_dias_json','medicos_json'));
    }

    public function show_rol_turno_consulta($id,$id_centro)
    {
        $rol_turno = RolTurno::findOrFail($id);
        $etapa_servicio_uno = RolTurno::_getEtapaServicio($id,'Etapa de Consulta Externa');
        $especialidades_etapa_consulta = CentroMedico::_obtenerEspecialidadesEtapaConsultaExt($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio_uno->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.rol_turno.show_consulta',compact('detalle_turnos_json','id_centro','rol_turno','especialidades_etapa_consulta','turnos_json','rol_dias_json','medicos_json'));
    }

    public function show_rol_turno_hospitalizacion($id,$id_centro)
    {
        $rol_turno = RolTurno::findOrFail($id);
        $etapa_servicio_uno = RolTurno::_getEtapaServicio($id,'Etapa de Hospitalizacion');
        $especialidades_etapa_hospitalizacion = CentroMedico::_obtenerEspecialidadesEtapaHospitalizacion($id_centro);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio_uno->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.rol_turno.show_hospitalizacion',compact('detalle_turnos_json','id_centro','rol_turno','especialidades_etapa_hospitalizacion','turnos_json','rol_dias_json','medicos_json'));
    }

    public function show_rol_turno_personal_encargado($id,$id_centro)
    {
        $rol_turno = RolTurno::findOrFail($id);
        $etapa_servicio = RolTurno::_getEtapaServicio($id,'ETAPA DE PERSONAL ENCARGADO');
        $personal_etapa_personal_area = PersonalArea::_obtenerPersonalEtapaPersonalArea($etapa_servicio->id);
        $turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio->id);
        $detalle_turnos = RolTurno::_getDetalleTurnosPorIdEtapaServicio($etapa_servicio->id);
        $rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio->id);
        $medicos = Medico::_getAllMedicos("")->get();
        
        $turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
        $detalle_turnos_json = json_encode($detalle_turnos, JSON_UNESCAPED_SLASHES );
        $rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
        $medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.rol_turno.show_personal_encargado',compact('detalle_turnos_json','id_centro','rol_turno','personal_etapa_personal_area','turnos_json','rol_dias_json','medicos_json'));
    }

    public function update_rol_tuno(Request $request,$id_rol_turno)
    {
        $titulo = $request->get('titulo');
        $mes = $request->get('mes');
        $anio = $request->get('anio');
        $id_centro = RolTurno::_editarRolTurno($titulo,$mes,$anio,$id_rol_turno);

        return Redirect::to('adm/centro/index_rol_turno/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - se Edito exitósamente.');;
    }

    public function update_rol_tuno_emergencia(Request $request,$id_rol_turno,$id_centro)
    {
        // return $request->all();
        $etapa_servicio_uno = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Emergencia');
        $id_etapa_servicio = $etapa_servicio_uno->id;
        $this->update_rol_tuno_detalle($request,$id_etapa_servicio);
        
        return Redirect::to('adm/centro/edit_rol_turno/'.$id_rol_turno.'/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Emergencia se Edito exitósamente.');
    }

    public function update_rol_tuno_consulta(Request $request,$id_rol_turno,$id_centro)
    {
        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Consulta Externa');
        $id_etapa_servicio = $etapa_servicio->id;
        $this->update_rol_tuno_detalle($request,$id_etapa_servicio);
        
        return Redirect::to('adm/centro/edit_rol_turno/'.$id_rol_turno.'/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Consulta Externa se Edito exitósamente.');;
    }

    public function update_rol_tuno_hospitalizacion(Request $request,$id_rol_turno,$id_centro)
    {
        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Hospitalizacion');
        $id_etapa_servicio = $etapa_servicio->id;
        $this->update_rol_tuno_detalle($request,$id_etapa_servicio);
        
        return Redirect::to('adm/centro/edit_rol_turno/'.$id_rol_turno.'/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Hospitalizacion se Edito exitósamente.');
    }

    public function update_rol_tuno_personal_encargado(Request $request,$id_rol_turno,$id_centro)
    {
        $etapa_servicio = RolTurno::_getEtapaServicio($id_rol_turno,'ETAPA DE PERSONAL ENCARGADO');
        $id_etapa_servicio = $etapa_servicio->id;
        if($request->get('id_persona_actualizar') != null){
            $personal_actualizar = $request->get('id_persona_actualizar');
            $a = 0;
            while ($a < count($personal_actualizar)) {
                $id_personal = $personal_actualizar[$a];
                $nombre = $request->get('text_personal_'.$id_personal);
                PersonalArea::_editarPersonal($id_personal,$nombre);
                $a++;
            }
        }
        
        if ($request->get('id_turnos_actualizar') != null) {
            $turnos_actualizar = $request->get('id_turnos_actualizar');
            $a = 0;
            while ($a < count($turnos_actualizar)) {
                $titulo = $request->get('text_turno_actualizar'.$turnos_actualizar[$a]);
                $hora_inicio = $request->get('text_hora_inicio_actualizar'.$turnos_actualizar[$a]);
                $hora_fin = $request->get('text_hora_fin_actualizar'.$turnos_actualizar[$a]);
                $id_turno = $turnos_actualizar[$a];
                Turno::_editarTurno($titulo,$hora_inicio,$hora_fin,$id_turno);

                if ($request->get('id_filas_nuevos_turno'.$id_turno) != null) {
                    $idfilas = $request->get('id_filas_nuevos_turno'.$id_turno);
                    $b = 0; 
                    while ($b < count($idfilas)) {
                        $id_doctor_rol_dia = $request->get('selec_dia_lunes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_martes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_miercoles_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_jueves_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_viernes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_sabado_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_domingo_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);
                        $observacion = $request->get('text_observacion_nuevo'.$idfilas[$b]);
                        DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                        $b++;
                    }
                }
                $a++;
            }
        }
        if ($request->get('id_rol_dias_actualizar') != null) {
            $rol_dias_actualizar = $request->get('id_rol_dias_actualizar');
            $id_observaciones_actualizar = $request->get('observaciones_actualizar');
            $a = 0;
            while ($a < count($rol_dias_actualizar)) {
                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_lunes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_martes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_miercoles_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_jueves_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_viernes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_sabado_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_domingo_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_detalle_turno = $id_observaciones_actualizar[($a / 7)-1];
                $observacion = $request->get('observacion_actualizar_'.$id_detalle_turno);
                DetalleTurno::_editarDetalleTurno($id_detalle_turno,$observacion);
            }
        }
        if ($request->get('id_turnos_nuevos') != null) {
            $idturnos = $request->get('id_turnos_nuevos');
            $idpersonales = $request->get('idpersonal_crear');
            $a = 0;
            while ($a < count($idturnos)) {
                $titulo_turno = $request->get('text_turno'.$idturnos[$a]);
                $hora_inicio_turno = $request->get('text_hora_inicio'.$idturnos[$a]);
                $hora_fin_turno = $request->get('text_hora_fin'.$idturnos[$a]);
                $id_personal = $idpersonales[$a];
                $id_turno = Turno::_insertarTurno($titulo_turno,$hora_inicio_turno,$hora_fin_turno,null,$id_etapa_servicio,$id_personal);
                if ($request->get('id_filas_turno'.$idturnos[$a]) != null) {
                    $idfilas = $request->get('id_filas_turno'.$idturnos[$a]);
                    $b = 0; 
                    while ($b < count($idfilas)) {
                        $id_doctor_rol_dia = $request->get('selec_dia_lunes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_martes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_miercoles_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_jueves_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_viernes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_sabado_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_domingo_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);
                        $observacion = $request->get('text_observacion_nuevo'.$idfilas[$b]);
                        DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                        $b++;
                    }
                }
                $a++;
            }
        }
        if ($request->get('idpersonal') != null) {
            $idpersonal = $request->get('idpersonal');
            $a = 0;
            while ($a < count($idpersonal)) {
                $nombre = $request->get('text_personal'.$idpersonal[$a]);
                $id_personal = PersonalArea::_insertarPersonalArea($nombre,$id_etapa_servicio);
                if ($request->get('idturnos'.$idpersonal[$a]) != null) {
                    $idturnos = $request->get('idturnos'.$idpersonal[$a]);
                    $b = 0;
                    while ($b < count($idturnos)) {
                        $titulo_turno = $request->get('text_turno'.$idturnos[$b]);
                        $hora_inicio_turno = $request->get('text_hora_inicio'.$idturnos[$b]);
                        $hora_fin_turno = $request->get('text_hora_fin'.$idturnos[$b]);
                        $id_turno = Turno::_insertarTurno($titulo_turno,$hora_inicio_turno,$hora_fin_turno,null,$id_etapa_servicio,$id_personal);

                        if ($request->get('id_filas_turno'.$idturnos[$b]) != null) {
                            $idfilas = $request->get('id_filas_turno'.$idturnos[$b]);
                            $c = 0; 
                            while ($c < count($idfilas)) {
                                $id_doctor_rol_dia = $request->get('selec_dia_lunes_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_martes_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_miercoles_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_jueves_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_viernes_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_sabado_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_domingo_nuevo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);

                                $observacion = $request->get('text_observacion_nuevo'.$idfilas[$c]);
                                DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                                $c++;
                            }
                        }

                        $b++;
                    }
                }
                $a++;
            }
        }
        if ($request->get('id_detalle_turno_delete') != null) {
            $detalle_turnos_eliminar = $request->get('id_detalle_turno_delete');
            $a = 0;
            while ($a < count($detalle_turnos_eliminar)) {
                $id_detalle_turno = $detalle_turnos_eliminar[$a];
                DetalleTurno::destroy($id_detalle_turno);
                $a++;
            }
        }
        if($request->get('id_personal_delete') != null){
            $personal_eliminar = $request->get('id_personal_delete');
            $a = 0;
            while ($a < count($personal_eliminar)) {
                $id_personal = $personal_eliminar[$a];
                PersonalArea::destroy($id_personal);
                $a++;
            }
        }
        if ($request->get('id_turnos_delete') != null) {
            $turnos_eliminar = $request->get('id_turnos_delete');
            $a = 0;
            while ($a < count($turnos_eliminar)) {
                $id_turno = $turnos_eliminar[$a];
                Turno::destroy($id_turno);
                $a++;
            }
        }
        if ($request->get('id_rol_dias_delete') != null) {
            $rol_dias_eliminar = $request->get('id_rol_dias_delete');
            $a = 0;
            while ($a < count($rol_dias_eliminar)) {
                $id_rol_dia = $rol_dias_eliminar[$a];
                RolDia::destroy($id_rol_dia);
                $a++;
            }
        }
        // return $request->all();
        // $this->update_rol_tuno_detalle($request,$id_etapa_servicio);
        
        return Redirect::to('adm/centro/edit_rol_turno/'.$id_rol_turno.'/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Personal Encargado se Edito exitósamente.');;
    }

    public function update_rol_tuno_detalle($request,$id_etapa_servicio)
    {
        if ($request->get('id_turnos_actualizar') != null) {
            $turnos_actualizar = $request->get('id_turnos_actualizar');
            $a = 0;
            while ($a < count($turnos_actualizar)) {
                $titulo = $request->get('text_turno_actualizar'.$turnos_actualizar[$a]);
                $hora_inicio = $request->get('text_hora_inicio_actualizar'.$turnos_actualizar[$a]);
                $hora_fin = $request->get('text_hora_fin_actualizar'.$turnos_actualizar[$a]);
                $id_turno = $turnos_actualizar[$a];
                Turno::_editarTurno($titulo,$hora_inicio,$hora_fin,$id_turno);

                if ($request->get('id_filas_nuevos_turno'.$id_turno) != null) {
                    $idfilas = $request->get('id_filas_nuevos_turno'.$id_turno);
                    $b = 0; 
                    while ($b < count($idfilas)) {
                        $id_doctor_rol_dia = $request->get('selec_dia_lunes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_martes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_miercoles_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_jueves_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_viernes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_sabado_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_domingo_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);
                        $observacion = $request->get('text_observacion_nuevo'.$idfilas[$b]);
                        DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                        $b++;
                    }
                }
                $a++;
            }
        }

        if ($request->get('id_rol_dias_actualizar') != null) {
            $rol_dias_actualizar = $request->get('id_rol_dias_actualizar');
            $id_observaciones_actualizar = $request->get('observaciones_actualizar');
            $a = 0;
            while ($a < count($rol_dias_actualizar)) {
                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_lunes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_martes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_miercoles_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_jueves_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_viernes_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_sabado_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_rol_dia = $rol_dias_actualizar[$a];
                $id_doctor = $request->get('select_dia_domingo_actualizar_'.$id_rol_dia);
                RolDia::_editarRolDia($id_doctor,$id_rol_dia);
                $a++;

                $id_detalle_turno = $id_observaciones_actualizar[($a / 7)-1];
                $observacion = $request->get('observacion_actualizar_'.$id_detalle_turno);
                DetalleTurno::_editarDetalleTurno($id_detalle_turno,$observacion);
            }
            // dd("s");
        }
        
        if ($request->get('id_turnos_nuevos') != null) {
            $idturnos = $request->get('id_turnos_nuevos');
            $idespecialidades = $request->get('idespecialidad');
            $a = 0;
            while ($a < count($idturnos)) {
                $titulo_turno = $request->get('text_turno'.$idturnos[$a]);
                $hora_inicio_turno = $request->get('text_hora_inicio'.$idturnos[$a]);
                $hora_fin_turno = $request->get('text_hora_fin'.$idturnos[$a]);
                $id_especialidad = $idespecialidades[$a];
                $id_turno = Turno::_insertarTurno($titulo_turno,$hora_inicio_turno,$hora_fin_turno,$id_especialidad,$id_etapa_servicio,null);
                if ($request->get('id_filas_turno'.$idturnos[$a]) != null) {
                    $idfilas = $request->get('id_filas_turno'.$idturnos[$a]);
                    $b = 0; 
                    while ($b < count($idfilas)) {
                        $id_doctor_rol_dia = $request->get('selec_dia_lunes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_martes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_miercoles_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_jueves_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_viernes_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_sabado_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_domingo_nuevo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);

                        $observacion = $request->get('text_observacion_nuevo'.$idfilas[$b]);
                        DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                        $b++;
                    }
                }
                $a++;
            }
        }

        if ($request->get('id_rol_dias_delete') != null) {
            $rol_dias_eliminar = $request->get('id_rol_dias_delete');
            $a = 0;
            while ($a < count($rol_dias_eliminar)) {
                $id_rol_dia = $rol_dias_eliminar[$a];
                RolDia::destroy($id_rol_dia);
                $a++;
            }
        }

        if ($request->get('id_detalle_turno_delete') != null) {
            $detalle_turnos_eliminar = $request->get('id_detalle_turno_delete');
            $a = 0;
            while ($a < count($detalle_turnos_eliminar)) {
                $id_detalle_turno = $detalle_turnos_eliminar[$a];
                DetalleTurno::destroy($id_detalle_turno);
                $a++;
            }
        }

        if ($request->get('id_turnos_delete') != null) {
            $turnos_eliminar = $request->get('id_turnos_delete');
            $a = 0;
            while ($a < count($turnos_eliminar)) {
                $id_turno = $turnos_eliminar[$a];
                Turno::destroy($id_turno);
                $a++;
            }
        }
    }

    public function create_rol_turno_emergencia($id_centro)//id centro
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anios = array("2018","2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");
        $anio_actual = date("Y");
        $mes_actual = $meses[date('n')-1];

        // $detalle = CentroMedico::_obtenerDetalleCentro($id);
        $especialidades_etapa_emergencia = CentroMedico::_obtenerEspecialidadesEtapaEmergencia($id_centro);
        $medicos = Medico::_getAllMedicos("")->get();

        return view('admCentros.centro.rol_turno.create_emergencia',compact('id_centro','especialidades_etapa_emergencia','medicos','meses','mes_actual','anios','anio_actual'));
    }

    public function create_rol_turno_consulta($id_centro,$id_rol_turno)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $especialidades_etapa_consulta = CentroMedico::_obtenerEspecialidadesEtapaConsultaExt($id_centro);
        $medicos = Medico::_getAllMedicos("")->get();

        return view('admCentros.centro.rol_turno.create_consulta_ext',compact('id_centro','id_rol_turno','especialidades_etapa_consulta','medicos'));
    }

    public function create_rol_turno_hospitalizacion($id_centro,$id_rol_turno)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $especialidades_etapa_hospitalizacion = CentroMedico::_obtenerEspecialidadesEtapaHospitalizacion($id_centro);
        $medicos = Medico::_getAllMedicos("")->get();

        return view('admCentros.centro.rol_turno.create_hospitalizacion',compact('id_centro','id_rol_turno','especialidades_etapa_hospitalizacion','medicos'));
    }

    public function create_rol_turno_personal_encargado($id_centro,$id_rol_turno)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $especialidades_etapa_hospitalizacion = CentroMedico::_obtenerEspecialidadesEtapaHospitalizacion($id_centro);
        $medicos = Medico::_getAllMedicos("")->get();

        return view('admCentros.centro.rol_turno.create_personal_enc',compact('id_centro','id_rol_turno','especialidades_etapa_hospitalizacion','medicos'));
    }

    public function store_rol_turno_emergencia(Request $request,$id_centro)
    {
        $titulo = $request->get('titulo');
        $mes = $request->get('mes');
        $anio = $request->get('anio');
        $id_rol_turno = RolTurno::_insertarRolTurno($titulo,$mes,$anio,$id_centro);
        $id_etapa_servicio = EtapaServicio::_insertarEtapaServicio('Etapa de Emergencia',$id_rol_turno);

        $this->store_rol_turno_detalle($request,$id_etapa_servicio);
        return Redirect::to('adm/centro/create_rol_turno_consulta/'.$id_centro.'/'.$id_rol_turno)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Emergencia Creada exitósamente.');
    }

    public function store_rol_turno_consulta(Request $request,$id_centro,$id_rol_turno)
    {
        $id_etapa_servicio = EtapaServicio::_insertarEtapaServicio('Etapa de Consulta Externa',$id_rol_turno);
        $this->store_rol_turno_detalle($request,$id_etapa_servicio);
        return Redirect::to('adm/centro/create_rol_turno_hospitalizacion/'.$id_centro.'/'.$id_rol_turno)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Consulta Externa Creada exitósamente.');
    }

    public function store_rol_turno_hospitalizacion(Request $request,$id_centro,$id_rol_turno)
    {
        $id_etapa_servicio = EtapaServicio::_insertarEtapaServicio('Etapa de Hospitalizacion',$id_rol_turno);
        $this->store_rol_turno_detalle($request,$id_etapa_servicio);
        return Redirect::to('adm/centro/create_rol_turno_personal_encargado/'.$id_centro.'/'.$id_rol_turno)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Hospitalizacion Creada exitósamente.');
    }

    public function store_rol_turno_personal_encargado(Request $request,$id_centro,$id_rol_turno)
    {
        // return $request->all();
        $id_etapa_servicio = EtapaServicio::_insertarEtapaServicio('ETAPA DE PERSONAL ENCARGADO',$id_rol_turno);
        // $this->store_rol_turno_detalle($request,$id_etapa_servicio);
        if ($request->get('idpersonal') != null) {
            $idpersonal = $request->get('idpersonal');
            $a = 0;
            while ($a < count($idpersonal)) {
                $nombre = $request->get('text_personal'.$idpersonal[$a]);
                $id_personal = PersonalArea::_insertarPersonalArea($nombre,$id_etapa_servicio);
                if ($request->get('idturnos'.$idpersonal[$a]) != null) {
                    $idturnos = $request->get('idturnos'.$idpersonal[$a]);
                    $b = 0;
                    while ($b < count($idturnos)) {
                        $titulo_turno = $request->get('text_turno'.$idturnos[$b]);
                        $hora_inicio_turno = $request->get('text_hora_inicio'.$idturnos[$b]);
                        $hora_fin_turno = $request->get('text_hora_fin'.$idturnos[$b]);
                        $id_turno = Turno::_insertarTurno($titulo_turno,$hora_inicio_turno,$hora_fin_turno,null,$id_etapa_servicio,$id_personal);

                        if ($request->get('id_filas_turno'.$idturnos[$b]) != null) {
                            $idfilas = $request->get('id_filas_turno'.$idturnos[$b]);
                            $c = 0; 
                            while ($c < count($idfilas)) {
                                $id_doctor_rol_dia = $request->get('selec_dia_lunes'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_martes'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_miercoles'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_jueves'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_viernes'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_sabado'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                                //
                                $id_doctor_rol_dia = $request->get('selec_dia_domingo'.$idfilas[$c]);
                                $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);
                                //observacion
                                $observacion = $request->get('text_observacion'.$idfilas[$c]);
                                DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                                $c++;   
                            }
                        }

                        $b++;
                    }
                }
                $a++;
            }
        }
        return Redirect::to('adm/centro/index_rol_turno/'.$id_centro)->with('msj','Rol de Turno: "'.$id_rol_turno.'" - Etapa Personal Encargado Creada exitósamente.');
    }

    public function store_rol_turno_detalle($request,$id_etapa_servicio)
    {
        if ($request->get('idturnos') != null) {
            $idturnos = $request->get('idturnos');
            $idespecialidades = $request->get('idespecialidad');
            $a = 0;
            while ($a < count($idturnos)) {
                $titulo_turno = $request->get('text_turno'.$idturnos[$a]);
                $hora_inicio_turno = $request->get('text_hora_inicio'.$idturnos[$a]);
                $hora_fin_turno = $request->get('text_hora_fin'.$idturnos[$a]);
                $id_especialidad = $idespecialidades[$a];
                $id_turno = Turno::_insertarTurno($titulo_turno,$hora_inicio_turno,$hora_fin_turno,$id_especialidad,$id_etapa_servicio,null);
                if ($request->get('id_filas_turno'.$idturnos[$a]) != null) {
                    $idfilas = $request->get('id_filas_turno'.$idturnos[$a]);
                    $b = 0; 
                    while ($b < count($idfilas)) {
                        $id_doctor_rol_dia = $request->get('selec_dia_lunes'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('LUNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_martes'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MARTES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_miercoles'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('MIERCOLES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_jueves'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('JUEVES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_viernes'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('VIERNES',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_sabado'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('SABADO',$id_turno,$id_doctor_rol_dia);
                        //
                        $id_doctor_rol_dia = $request->get('selec_dia_domingo'.$idfilas[$b]);
                        $id_rol_dia = RolDia::_insertarRolDia('DOMINGO',$id_turno,$id_doctor_rol_dia);
                        //observacion
                        $observacion = $request->get('text_observacion'.$idfilas[$b]);
                        DetalleTurno::_insertarDetalleTurno($observacion,$id_turno);
                        $b++;
                    }
                }
                $a++;
            }
        }
    }

    public function renovate_rol_turno($id,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
    	$rol_turno = RolTurno::findOrFail($id);
    	$etapa_servicio_uno = RolTurno::_getEtapaServicio($id,'Etapa de Emergencia');
    	$especialidades = RolTurno::_getEspecialidadesPorIdEtapaServicio($etapa_servicio_uno->id);
    	$turnos = RolTurno::_getTurnosPorIdEtapaServicio($etapa_servicio_uno->id);
    	$rol_dias = RolTurno::_getRolDiasPorIdEtapaServicio($etapa_servicio_uno->id);
    	$medicos = Medico::_getAllMedicos("")->get();
    	
    	$turnos_json = json_encode($turnos, JSON_UNESCAPED_SLASHES );
    	$rol_dias_json = json_encode($rol_dias, JSON_UNESCAPED_SLASHES );
    	$medicos_json = json_encode($medicos, JSON_UNESCAPED_SLASHES );
    	$detalle2 = json_encode($especialidades, JSON_UNESCAPED_SLASHES );
    	
    	return view('admCentros.centro.rol_turno.renovate',compact('id_centro','rol_turno','especialidades','turnos_json','rol_dias_json','medicos_json','medicos','detalle2','etapa_servicio_uno'));
    }

    public function generar_excel_rol_turno($id_rol_turno,$id_centro)
    {
        Excel::create('RolDeTurno', function($excel) use ($id_rol_turno,$id_centro) {

            $excel->sheet('Sheetname', function($sheet) use ($id_rol_turno,$id_centro) {
                
                $sheet->mergeCells('A1:Q1');
                $sheet->mergeCells('A2:Q2');

                $sheet->mergeCells('A3:A4');//ESPECIALIDAD
                $sheet->mergeCells('B3:B4');//HORA

                $sheet->mergeCells('C3:D3');
                $sheet->mergeCells('E3:F3');
                $sheet->mergeCells('G3:H3');
                $sheet->mergeCells('I3:J3');
                $sheet->mergeCells('K3:L3');
                $sheet->mergeCells('M3:N3');
                $sheet->mergeCells('O3:P3');
                $sheet->setWidth(array(
                    'A'     =>  25,
                    'B'     =>  10,
                    'C'     =>  20,
                    'D'     =>  15,
                    'E'     =>  20,
                    'F'     =>  15,
                    'G'     =>  20,
                    'H'     =>  15,
                    'I'     =>  20,
                    'J'     =>  15,
                    'K'     =>  20,
                    'L'     =>  15,
                    'M'     =>  20,
                    'N'     =>  15,
                    'O'     =>  20,
                    'P'     =>  15,
                    'Q'     =>  35
                ));
                $sheet->setHeight(array(
                    1     =>  30,
                    2     =>  45
                ));
                $sheet->getStyle('C4')->getAlignment()->setWrapText(true);//PARA SALTAR LINEA
                $sheet->setCellValue('A3', 'ESPECIALIDAD');
                $sheet->setCellValue('B3', 'HORA');
                $sheet->setCellValue('C3', 'LUNES');
                $sheet->setCellValue('E3', 'MARTES');
                $sheet->setCellValue('G3', 'MIERCOLES');
                $sheet->setCellValue('I3', 'JUEVES');
                $sheet->setCellValue('K3', 'VIERNES');
                $sheet->setCellValue('M3', 'SABADO');
                $sheet->setCellValue('O3', 'DOMINGO');
                $sheet->setCellValue('Q3', 'OBSERVACION');
                $sheet->setCellValue('C4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('D4', 'N° CELULAR');
                $sheet->setCellValue('E4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('F4', 'N° CELULAR');
                $sheet->setCellValue('G4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('H4', 'N° CELULAR');
                $sheet->setCellValue('I4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('J4', 'N° CELULAR');
                $sheet->setCellValue('K4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('L4', 'N° CELULAR');
                $sheet->setCellValue('M4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('N4', 'N° CELULAR');
                $sheet->setCellValue('O4', 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('P4', 'N° CELULAR');

                $sheet->cells('A2:Q2', function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A3:Q3', function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('C4:Q4', function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });

                // $rol_turno = RolTurno::findOrFail($id_rol_turno);
                $etapa_servicio_uno = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Emergencia');
                // $centro = CentroMedico::findOrFail($id_centro);
                $sheet->row(2, ['Etapa de Emergencia']);
                $especialidades_etapa_emergencia = CentroMedico::_obtenerEspecialidadesEtapaEmergencia($id_centro);
                $cont_filas = 5;
                foreach ($especialidades_etapa_emergencia as $especialidad) {
                    $celdas_ini = $cont_filas;
                    $sheet->setCellValue('A'.$celdas_ini, $especialidad->nombre . " - " . $especialidad->id);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setFontSize(9);
                        $cell->setFontFamily('Arial');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setFontWeight('bold');
                        $cell->setBackground('#D9D9D9');
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $turnos = RolTurno::_getTurnosPorIdEtapaAndEspecialidad($etapa_servicio_uno->id,$especialidad->id);
                    if(count($turnos) == 0){
                        $sheet->setHeight(array(
                            $cont_filas     =>  45
                        ));
                        $cont_filas++;
                    }
                    foreach ($turnos as $turno) {
                        $celdas_ini_turno = $cont_filas;
                        $sheet->getStyle('B'.$cont_filas)->getAlignment()->setWrapText(true);//PARA SALTAR LINEA
                        $sheet->setCellValue('B'.$cont_filas, $turno->nombre . ": " . $turno->hora_inicio . " a " . $turno->hora_fin);
                        $rol_dias = RolTurno::_getRolDiasPorIdETurno($turno->id);
                        $detalle_turnos = DetalleTurno::_getDetalleTurnoPorIdTurno($turno->id);
                        // dd($detalle_turnos);
                        $i = 0;
                        while ($i < count($rol_dias)) {
                            $sheet->setHeight(array(
                                $cont_filas     =>  45
                            ));
                            $sheet->cells('B'.$cont_filas.':Q'.$cont_filas, function($cells) {
                                $cells->setFontSize(9);
                                $cells->setFontFamily('Arial');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBorder('thin','thin','thin','thin');
                            });
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//LUNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('C'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('C'.$cont_filas, $nombre);
                            $sheet->setCellValue('D'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MARTES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('E'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('E'.$cont_filas, $nombre);
                            $sheet->setCellValue('F'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MIERCOLES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('G'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('G'.$cont_filas, $nombre);
                            $sheet->setCellValue('H'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//JUEVES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('I'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('I'.$cont_filas, $nombre);
                            $sheet->setCellValue('J'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//VIERNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('K'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('K'.$cont_filas, $nombre);
                            $sheet->setCellValue('L'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//SABADO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('M'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('M'.$cont_filas, $nombre);
                            $sheet->setCellValue('N'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//DOMINGO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('O'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('O'.$cont_filas, $nombre);
                            $sheet->setCellValue('P'.$cont_filas, $telefono);
                            $i++;

                            $sheet->getStyle('Q'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('Q'.$cont_filas,$detalle_turnos[($i / 7)-1]->observacion);
                            $cont_filas++;
                        }
                        // $cont_filas++;
                        $celdas_fin = $cont_filas -1;
                        if($celdas_ini_turno - $celdas_fin != 0){
                            $sheet->mergeCells('B'.$celdas_ini_turno.':B'.$celdas_fin);
                            $sheet->cells('B'.$celdas_ini_turno.':B'.$celdas_fin, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                        }
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                }
                //EXCEL DE 2DA ETAPA
                $sheet->mergeCells('A'. $cont_filas .':Q' . $cont_filas);
                $sheet->mergeCells('A'. ($cont_filas + 1) .':A' . ($cont_filas + 2));//ESPECIALIDAD
                $sheet->mergeCells('B'. ($cont_filas + 1) .':B' . ($cont_filas + 2));//HORA

                $sheet->mergeCells('C'. ($cont_filas + 1) .':D' . ($cont_filas + 1));
                $sheet->mergeCells('E'. ($cont_filas + 1) .':F' . ($cont_filas + 1));
                $sheet->mergeCells('G'. ($cont_filas + 1) .':H' . ($cont_filas + 1));
                $sheet->mergeCells('I'. ($cont_filas + 1) .':J' . ($cont_filas + 1));
                $sheet->mergeCells('K'. ($cont_filas + 1) .':L' . ($cont_filas + 1));
                $sheet->mergeCells('M'. ($cont_filas + 1) .':N' . ($cont_filas + 1));
                $sheet->mergeCells('O'. ($cont_filas + 1) .':P' . ($cont_filas + 1));

                $sheet->setHeight(array(
                    $cont_filas     =>  45
                ));

                $sheet->setCellValue('A'. ($cont_filas + 1), 'ESPECIALIDAD');
                $sheet->setCellValue('B'. ($cont_filas + 1), 'HORA');
                $sheet->setCellValue('C'. ($cont_filas + 1), 'LUNES');
                $sheet->setCellValue('E'. ($cont_filas + 1), 'MARTES');
                $sheet->setCellValue('G'. ($cont_filas + 1), 'MIERCOLES');
                $sheet->setCellValue('I'. ($cont_filas + 1), 'JUEVES');
                $sheet->setCellValue('K'. ($cont_filas + 1), 'VIERNES');
                $sheet->setCellValue('M'. ($cont_filas + 1), 'SABADO');
                $sheet->setCellValue('O'. ($cont_filas + 1), 'DOMINGO');
                $sheet->setCellValue('Q'. ($cont_filas + 1), 'OBSERVACION');
                $sheet->setCellValue('C'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('D'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('E'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('F'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('G'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('H'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('I'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('J'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('K'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('L'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('M'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('N'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('O'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('P'. ($cont_filas + 2), 'N° CELULAR');
                
                $sheet->cells('A'. $cont_filas .':Q' . $cont_filas, function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A'. ($cont_filas + 1) .':Q' . ($cont_filas + 1), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('C'. ($cont_filas + 2) .':Q' . ($cont_filas + 2), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->row($cont_filas, ['Etapa de Consulta Externa']);
                $etapa_servicio_dos = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Consulta Externa');
                $especialidades_etapa_consulta = CentroMedico::_obtenerEspecialidadesEtapaConsultaExt($id_centro);
                $cont_filas = $cont_filas + 3;
                foreach ($especialidades_etapa_consulta as $especialidad) {
                    $celdas_ini = $cont_filas;
                    $sheet->setCellValue('A'.$celdas_ini, $especialidad->nombre . " - " . $especialidad->id);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setFontSize(9);
                        $cell->setFontFamily('Arial');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setFontWeight('bold');
                        $cell->setBackground('#D9D9D9');
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $turnos = RolTurno::_getTurnosPorIdEtapaAndEspecialidad($etapa_servicio_dos->id,$especialidad->id);
                    if(count($turnos) == 0){
                        $sheet->setHeight(array(
                            $cont_filas     =>  45
                        ));
                        $cont_filas++;
                    }
                    foreach ($turnos as $turno) {
                        $celdas_ini_turno = $cont_filas;
                        $sheet->getStyle('B'.$cont_filas)->getAlignment()->setWrapText(true);//PARA SALTAR LINEA
                        $sheet->setCellValue('B'.$cont_filas, $turno->nombre . ": " . $turno->hora_inicio . " a " . $turno->hora_fin);
                        $detalle_turnos = DetalleTurno::_getDetalleTurnoPorIdTurno($turno->id);
                        $rol_dias = RolTurno::_getRolDiasPorIdETurno($turno->id);
                        $i = 0;
                        while ($i < count($rol_dias)) {
                            $sheet->setHeight(array(
                                $cont_filas     =>  45
                            ));
                            $sheet->cells('B'.$cont_filas.':Q'.$cont_filas, function($cells) {
                                $cells->setFontSize(9);
                                $cells->setFontFamily('Arial');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBorder('thin','thin','thin','thin');
                            });
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//LUNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('C'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('C'.$cont_filas, $nombre);
                            $sheet->setCellValue('D'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MARTES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('E'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('E'.$cont_filas, $nombre);
                            $sheet->setCellValue('F'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MIERCOLES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('G'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('G'.$cont_filas, $nombre);
                            $sheet->setCellValue('H'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//JUEVES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('I'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('I'.$cont_filas, $nombre);
                            $sheet->setCellValue('J'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//VIERNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('K'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('K'.$cont_filas, $nombre);
                            $sheet->setCellValue('L'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//SABADO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('M'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('M'.$cont_filas, $nombre);
                            $sheet->setCellValue('N'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//DOMINGO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('O'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('O'.$cont_filas, $nombre);
                            $sheet->setCellValue('P'.$cont_filas, $telefono);
                            $i++;
                            $sheet->getStyle('Q'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('Q'.$cont_filas,$detalle_turnos[($i / 7)-1]->observacion);
                            $cont_filas++;
                        }
                        // $cont_filas++;
                        $celdas_fin = $cont_filas -1;
                        if($celdas_ini_turno - $celdas_fin != 0){
                            $sheet->mergeCells('B'.$celdas_ini_turno.':B'.$celdas_fin);
                            $sheet->cells('B'.$celdas_ini_turno.':B'.$celdas_fin, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                        }
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                }
                //EXCEL DE 3RA ETAPA
                $sheet->mergeCells('A'. $cont_filas .':Q' . $cont_filas);
                $sheet->mergeCells('A'. ($cont_filas + 1) .':A' . ($cont_filas + 2));//ESPECIALIDAD
                $sheet->mergeCells('B'. ($cont_filas + 1) .':B' . ($cont_filas + 2));//HORA

                $sheet->mergeCells('C'. ($cont_filas + 1) .':D' . ($cont_filas + 1));
                $sheet->mergeCells('E'. ($cont_filas + 1) .':F' . ($cont_filas + 1));
                $sheet->mergeCells('G'. ($cont_filas + 1) .':H' . ($cont_filas + 1));
                $sheet->mergeCells('I'. ($cont_filas + 1) .':J' . ($cont_filas + 1));
                $sheet->mergeCells('K'. ($cont_filas + 1) .':L' . ($cont_filas + 1));
                $sheet->mergeCells('M'. ($cont_filas + 1) .':N' . ($cont_filas + 1));
                $sheet->mergeCells('O'. ($cont_filas + 1) .':P' . ($cont_filas + 1));

                $sheet->setHeight(array(
                    $cont_filas     =>  45
                ));

                $sheet->setCellValue('A'. ($cont_filas + 1), 'ESPECIALIDAD');
                $sheet->setCellValue('B'. ($cont_filas + 1), 'HORA');
                $sheet->setCellValue('C'. ($cont_filas + 1), 'LUNES');
                $sheet->setCellValue('E'. ($cont_filas + 1), 'MARTES');
                $sheet->setCellValue('G'. ($cont_filas + 1), 'MIERCOLES');
                $sheet->setCellValue('I'. ($cont_filas + 1), 'JUEVES');
                $sheet->setCellValue('K'. ($cont_filas + 1), 'VIERNES');
                $sheet->setCellValue('M'. ($cont_filas + 1), 'SABADO');
                $sheet->setCellValue('O'. ($cont_filas + 1), 'DOMINGO');
                $sheet->setCellValue('Q'. ($cont_filas + 1), 'OBSERVACION');
                $sheet->setCellValue('C'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('D'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('E'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('F'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('G'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('H'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('I'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('J'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('K'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('L'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('M'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('N'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('O'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('P'. ($cont_filas + 2), 'N° CELULAR');
                
                $sheet->cells('A'. $cont_filas .':Q' . $cont_filas, function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A'. ($cont_filas + 1) .':Q' . ($cont_filas + 1), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('C'. ($cont_filas + 2) .':Q' . ($cont_filas + 2), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->row($cont_filas, ['Etapa de Hospitalizacion']);
                $etapa_servicio_tres = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Hospitalizacion');
                $especialidades_etapa_hospitalizacion = CentroMedico::_obtenerEspecialidadesEtapaHospitalizacion($id_centro);
                $cont_filas = $cont_filas + 3;
                foreach ($especialidades_etapa_hospitalizacion as $especialidad) {
                    $celdas_ini = $cont_filas;
                    $sheet->setCellValue('A'.$celdas_ini, $especialidad->nombre . " - " . $especialidad->id);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setFontSize(9);
                        $cell->setFontFamily('Arial');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setFontWeight('bold');
                        $cell->setBackground('#D9D9D9');
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $turnos = RolTurno::_getTurnosPorIdEtapaAndEspecialidad($etapa_servicio_tres->id,$especialidad->id);
                    if(count($turnos) == 0){
                        $sheet->setHeight(array(
                            $cont_filas     =>  45
                        ));
                        $cont_filas++;
                    }
                    foreach ($turnos as $turno) {
                        $celdas_ini_turno = $cont_filas;
                        $sheet->getStyle('B'.$cont_filas)->getAlignment()->setWrapText(true);//PARA SALTAR LINEA
                        $sheet->setCellValue('B'.$cont_filas, $turno->nombre . ": " . $turno->hora_inicio . " a " . $turno->hora_fin);
                        $rol_dias = RolTurno::_getRolDiasPorIdETurno($turno->id);
                        $detalle_turnos = DetalleTurno::_getDetalleTurnoPorIdTurno($turno->id);
                        $i = 0;
                        while ($i < count($rol_dias)) {
                            $sheet->setHeight(array(
                                $cont_filas     =>  45
                            ));
                            $sheet->cells('B'.$cont_filas.':Q'.$cont_filas, function($cells) {
                                $cells->setFontSize(9);
                                $cells->setFontFamily('Arial');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBorder('thin','thin','thin','thin');
                            });
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//LUNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('C'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('C'.$cont_filas, $nombre);
                            $sheet->setCellValue('D'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MARTES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('E'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('E'.$cont_filas, $nombre);
                            $sheet->setCellValue('F'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MIERCOLES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('G'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('G'.$cont_filas, $nombre);
                            $sheet->setCellValue('H'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//JUEVES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('I'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('I'.$cont_filas, $nombre);
                            $sheet->setCellValue('J'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//VIERNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('K'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('K'.$cont_filas, $nombre);
                            $sheet->setCellValue('L'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//SABADO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('M'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('M'.$cont_filas, $nombre);
                            $sheet->setCellValue('N'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//DOMINGO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('O'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('O'.$cont_filas, $nombre);
                            $sheet->setCellValue('P'.$cont_filas, $telefono);
                            $i++;
                            $sheet->getStyle('Q'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('Q'.$cont_filas,$detalle_turnos[($i / 7)-1]->observacion);
                            $cont_filas++;
                        }
                        // $cont_filas++;
                        $celdas_fin = $cont_filas -1;
                        if($celdas_ini_turno - $celdas_fin != 0){
                            $sheet->mergeCells('B'.$celdas_ini_turno.':B'.$celdas_fin);
                            $sheet->cells('B'.$celdas_ini_turno.':B'.$celdas_fin, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                        }
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                }
                //EXCEL DE 4TA ETAPA
                $sheet->mergeCells('A'. $cont_filas .':Q' . $cont_filas);
                $sheet->mergeCells('A'. ($cont_filas + 1) .':A' . ($cont_filas + 2));//ESPECIALIDAD
                $sheet->mergeCells('B'. ($cont_filas + 1) .':B' . ($cont_filas + 2));//HORA

                $sheet->mergeCells('C'. ($cont_filas + 1) .':D' . ($cont_filas + 1));
                $sheet->mergeCells('E'. ($cont_filas + 1) .':F' . ($cont_filas + 1));
                $sheet->mergeCells('G'. ($cont_filas + 1) .':H' . ($cont_filas + 1));
                $sheet->mergeCells('I'. ($cont_filas + 1) .':J' . ($cont_filas + 1));
                $sheet->mergeCells('K'. ($cont_filas + 1) .':L' . ($cont_filas + 1));
                $sheet->mergeCells('M'. ($cont_filas + 1) .':N' . ($cont_filas + 1));
                $sheet->mergeCells('O'. ($cont_filas + 1) .':P' . ($cont_filas + 1));

                $sheet->setHeight(array(
                    $cont_filas     =>  45
                ));

                $sheet->setCellValue('A'. ($cont_filas + 1), 'CARGO');
                $sheet->setCellValue('B'. ($cont_filas + 1), 'HORA');
                $sheet->setCellValue('C'. ($cont_filas + 1), 'LUNES');
                $sheet->setCellValue('E'. ($cont_filas + 1), 'MARTES');
                $sheet->setCellValue('G'. ($cont_filas + 1), 'MIERCOLES');
                $sheet->setCellValue('I'. ($cont_filas + 1), 'JUEVES');
                $sheet->setCellValue('K'. ($cont_filas + 1), 'VIERNES');
                $sheet->setCellValue('M'. ($cont_filas + 1), 'SABADO');
                $sheet->setCellValue('O'. ($cont_filas + 1), 'DOMINGO');
                $sheet->setCellValue('Q'. ($cont_filas + 1), 'OBSERVACION');
                $sheet->setCellValue('C'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('D'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('E'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('F'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('G'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('H'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('I'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('J'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('K'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('L'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('M'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('N'. ($cont_filas + 2), 'N° CELULAR');
                $sheet->setCellValue('O'. ($cont_filas + 2), 'NOMBRE DEL MEDICO');
                $sheet->setCellValue('P'. ($cont_filas + 2), 'N° CELULAR');
                
                $sheet->cells('A'. $cont_filas .':Q' . $cont_filas, function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A'. ($cont_filas + 1) .':Q' . ($cont_filas + 1), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('C'. ($cont_filas + 2) .':Q' . ($cont_filas + 2), function($cells) {
                    $cells->setFontSize(9);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->row($cont_filas, ['ETAPA DE PERSONAL ENCARGADO']);
                $etapa_servicio_cuatro = RolTurno::_getEtapaServicio($id_rol_turno,'ETAPA DE PERSONAL ENCARGADO');
                $personal_etapa_personal_area = PersonalArea::_obtenerPersonalEtapaPersonalArea($etapa_servicio_cuatro->id);
                $cont_filas = $cont_filas + 3;
                foreach ($personal_etapa_personal_area as $personal) {
                    $celdas_ini = $cont_filas;
                    $sheet->setCellValue('A'.$celdas_ini, $personal->nombre . " - " . $personal->id);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setFontSize(9);
                        $cell->setFontFamily('Arial');
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                        $cell->setFontWeight('bold');
                        $cell->setBackground('#D9D9D9');
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $turnos = RolTurno::_getTurnosPorIdEtapaAndPersonal($etapa_servicio_cuatro->id,$personal->id);
                    if(count($turnos) == 0){
                        $sheet->setHeight(array(
                            $cont_filas     =>  45
                        ));
                        $cont_filas++;
                    }
                    foreach ($turnos as $turno) {
                        $celdas_ini_turno = $cont_filas;
                        $sheet->getStyle('B'.$cont_filas)->getAlignment()->setWrapText(true);//PARA SALTAR LINEA
                        $sheet->setCellValue('B'.$cont_filas, $turno->nombre . ": " . $turno->hora_inicio . " a " . $turno->hora_fin);
                        $rol_dias = RolTurno::_getRolDiasPorIdETurno($turno->id);
                        $detalle_turnos = DetalleTurno::_getDetalleTurnoPorIdTurno($turno->id);
                        $i = 0;
                        while ($i < count($rol_dias)) {
                            $sheet->setHeight(array(
                                $cont_filas     =>  45
                            ));
                            $sheet->cells('B'.$cont_filas.':Q'.$cont_filas, function($cells) {
                                $cells->setFontSize(9);
                                $cells->setFontFamily('Arial');
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                                $cells->setBorder('thin','thin','thin','thin');
                            });
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//LUNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('C'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('C'.$cont_filas, $nombre);
                            $sheet->setCellValue('D'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MARTES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('E'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('E'.$cont_filas, $nombre);
                            $sheet->setCellValue('F'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//MIERCOLES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('G'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('G'.$cont_filas, $nombre);
                            $sheet->setCellValue('H'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//JUEVES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('I'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('I'.$cont_filas, $nombre);
                            $sheet->setCellValue('J'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//VIERNES
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('K'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('K'.$cont_filas, $nombre);
                            $sheet->setCellValue('L'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//SABADO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('M'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('M'.$cont_filas, $nombre);
                            $sheet->setCellValue('N'.$cont_filas, $telefono);
                            $i++;
                            $medico = Medico::_getMedico($rol_dias[$i]->id_medico);//DOMINGO
                            if(!isset($medico->nombre)){
                                $nombre = "Sin Asignar";
                                $telefono = "Sin Asignar";
                            }else{
                                $nombre = $medico->nombre . " " . $medico->apellido;
                                $telefono =  $medico->telefono;
                            }
                            $sheet->getStyle('O'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('O'.$cont_filas, $nombre);
                            $sheet->setCellValue('P'.$cont_filas, $telefono);
                            $i++;
                            $sheet->getStyle('Q'.$cont_filas)->getAlignment()->setWrapText(true);
                            $sheet->setCellValue('Q'.$cont_filas,$detalle_turnos[($i / 7)-1]->observacion);
                            $cont_filas++;
                        }
                        // $cont_filas++;
                        $celdas_fin = $cont_filas -1;
                        if($celdas_ini_turno - $celdas_fin != 0){
                            $sheet->mergeCells('B'.$celdas_ini_turno.':B'.$celdas_fin);
                            $sheet->cells('B'.$celdas_ini_turno.':B'.$celdas_fin, function($cells) {
                                $cells->setAlignment('center');
                                $cells->setValignment('center');
                            });
                        }
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                }
            });

        })->export('xlsx');
    }

    public function build_rol_turno($id_rol_turno,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_rol_turno/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $etapas_servicios = EtapaServicio::_obtejerEtapasPorIdRolTurno($id_rol_turno);
        
        if (count($etapas_servicios) == 1) {//le toca la etapa 2 CONSULTA
            return Redirect::to('adm/centro/create_rol_turno_consulta/'.$id_centro.'/'.$id_rol_turno);
        }else if (count($etapas_servicios) == 2) {//le toca la etapa 3 HOSPITALIZACION
            return Redirect::to('adm/centro/create_rol_turno_hospitalizacion/'.$id_centro.'/'.$id_rol_turno);
        }else if (count($etapas_servicios) == 3 ){//le toca la etapa 4 PERSONAL ENCARGADO
            return Redirect::to('adm/centro/create_rol_turno_personal_encargado/'.$id_centro.'/'.$id_rol_turno);
        }else {
            return Redirect::to('adm/centro/index_rol_turno/'.$id_centro)->with('msj','El Rol de Turno: "'.$id_rol_turno.'" Ya Contiene 4 Etapas.');
        }
    }

    //PARA LA APLICACION MOVIL
    // public function get_EtapasServicios($id){
    //     return json_encode(array("etapas" => RolTurno::_getEtapasServicios($id)->get()));
    // }
    
    // public function get_EspecialidadesPorIdEtapa($id){
    //     return json_encode(array("especialidades" => RolTurno::_getEspecialidadesPorIdEtapaServicio($id)));
    // }
    
    // public function get_TurnosPorIdEtapaServicio($id){
    //     return json_encode(array("turnos" => RolTurno::_getTurnosPorIdEtapaServicio($id)));
    // }

    // public function get_RolDiasPorIdEtapaServicio($id){
    //     return json_encode(array("rolesDia" => RolTurno::_getRolDiasPorIdEtapaServicio($id)));
    // }

    // public function get_obtenerPersonalEtapaPersonalArea($id){
    //     return json_encode(array("cargosPersonal" => PersonalArea::_obtenerPersonalEtapaPersonalArea($id)));
    // }

    // public function get_DetalleTurnosPorIdEtapaServicio($id){
    //     return json_encode(array("observaciones" => RolTurno::_getDetalleTurnosPorIdEtapaServicio($id)));
    // }
}
