<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\CarteraServicio;
use App\Models\CentroMedico;
use App\Models\Servicio;
use Maatwebsite\Excel\Facades\Excel;
use Route;
use Illuminate\Routing\Redirector;
use App\Models\ServicioMetodo;
use App\Models\Previlegio;

class CarteraServicioController extends Controller
{
    public function __construct(Redirector $redirect)
    {
        $acctionName = explode('@', Route::getCurrentRoute()->getActionName())[1];
        $result = ServicioMetodo::_verificarServicioMetodo('CarteraServicioController',$acctionName);
        if ($result->estado == 0) {
            $redirect->to('dashboard')->with('msj_e_sm', 'La operacion a realizar: '. $acctionName . ' de '. $result->seccion . ' fue dada de baja por los administradores.')->send();
        }
        $this->middleware('auth');
    }
    
	public function index_cartera_servicio($id,Request $request)
    {
        $centro = CentroMedico::_obtenerCentro($id);
        $cartera_servicios = CentroMedico::_obtenerCarteraServicios($id,$request['searchText'])->paginate(6);
        $searchText = $request->get('searchText');
        return view('admCentros.centro.cartera_servicio.index',compact('cartera_servicios','centro','searchText'));
    }

    public function generar_excel_cartera_servicio($id_cart,$id_centro)
    {
        Excel::create('CarteraDeServicio', function($excel) use ($id_cart,$id_centro) {

            $excel->sheet('Sheetname', function($sheet) use ($id_cart,$id_centro) {
                
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->setWidth(array(
                    'A'     =>  33,
                    'B'     =>  33,
                    'C'     =>  33,
                    'D'     =>  33,
                    'E'     =>  45
                ));
                $sheet->setHeight(array(
                    1     =>  45,
                    2     =>  45,
                    3     =>  60
                ));
                // $sheet->setBorder('A3', 'solid');
                $sheet->cell('A3', function($cell){//BORDE
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('B3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('C3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('D3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('E3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                // $sheet->cell('A3:E3', function($cell){
                //     $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // });

                $sheet->cells('A1:E1', function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                    // $cells->setBorder('thin','thin','thin','thin');
                });
                $sheet->cells('A2:E2', function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A3:E3', function($cells) {
                    $cells->setFontSize(26);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });

                $cartera_servicio = CarteraServicio::findOrFail($id_cart);
                $centro = CentroMedico::findOrFail($id_centro);
                $sheet->row(1, ['FORMATO DE CARTERA DE SERVICIO DE ' . $cartera_servicio->mes . " " . $cartera_servicio->anio]);
                $sheet->row(2, ['CENTRO DE SALUD ' . $centro->nombre ]);
                $sheet->row(3, ['ESPECIALIDAD','SERVICIOS','DIAS','HORA','OBSERVACION']);

                $especialidades = CarteraServicio::_getEspecialidadesPorId($id_cart);
                // dd($especialidades);
                $data = [];
                $cont_filas = 4;
                foreach ($especialidades as $especialidad) {
                    $servicios_especialidad = CarteraServicio::_getServiciosPorIdCarteraAndEspecialidad($id_cart,$especialidad->id);
                    $celdas_ini = $cont_filas;
                    $sheet->setCellValue('A'.$celdas_ini, $especialidad->nombre);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cells('A'.$celdas_ini.':A'.$celdas_ini, function($cells) {
                            $cells->setFontSize(15);
                            $cells->setFontFamily('Arial');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFontWeight('bold');
                            $cells->setBackground('#D9D9D9');
                            // $cells->setBorder('thin','thin','thin','thin');
                    });

                    foreach ($servicios_especialidad as $servicio) {
                        $sheet->setCellValue('B'.$cont_filas, $servicio->nombre);
                        $sheet->setCellValue('C'.$cont_filas, $servicio->dias);
                        $sheet->setCellValue('D'.$cont_filas, $servicio->hora);
                        $sheet->setCellValue('E'.$cont_filas, $servicio->observacion);
                        
                        $sheet->setHeight($cont_filas, 40);
                        $sheet->cells('B'.$cont_filas.':E'.$cont_filas, function($cells) {
                            $cells->setFontSize(15);
                            $cells->setFontFamily('Arial');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setBorder('thin','thin','thin','thin');
                        });
                        // $row = [];
                        // // $row[0] = $especialidad->id;
                        // $row[1] = $servicio->nombre;
                        // $row[2] = $servicio->dias;
                        // $row[3] = $servicio->hora;
                        // $row[4] = $servicio->observacion;
                        // $data[] = $row;
                        // $sheet->appendRow($row);
                        $cont_filas++;
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                    // $sheet->mergeCells('A4:A4');
                }
                // $sheet->fromArray($data);
                // $sheet->setCellValue('A25', 'some value');

            });

        })->export('xlsx');
    }

    public function show_cartera_servicio($id,$id_centro)
    {
    	$cartera_servicio = CarteraServicio::findOrFail($id);
    	$servicios = CarteraServicio::_getServiciosPorId($id);
        $especialidades = CentroMedico::_obtenerDetalleCentro($id_centro);
    	$servicios_json = json_encode($servicios, JSON_UNESCAPED_SLASHES );
    	return view('admCentros.centro.cartera_servicio.show',compact('cartera_servicio','especialidades','servicios_json'));
    }

    public function create_cartera_servicio($id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_cartera_servicio/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anios = array("2018","2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");
        $nombres_servicios = array("Emergencia","Consulta Externa","Internacion","Quirofano");
        $anio_actual = date("Y");
        $mes_actual = $meses[date('n')-1];

        $detalle = CentroMedico::_obtenerDetalleCentro($id_centro);
        $detalle2 = json_encode($detalle, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.cartera_servicio.create',compact('id_centro','detalle','detalle2','meses','mes_actual','anios','anio_actual','nombres_servicios'));
    }

    public function edit_cartera_servicio($id,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_cartera_servicio/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $nombres_servicios = array("Emergencia","Consulta Externa","Internacion","Quirofano");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anios = array("2018","2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");

    	$cartera_servicio = CarteraServicio::findOrFail($id);
    	$servicios = CarteraServicio::_getServiciosPorId($id);
        $especialidades = CentroMedico::_obtenerDetalleCentro($id_centro);
        
    	$servicios_json = json_encode($servicios, JSON_UNESCAPED_SLASHES );
        $nombres_servicios_json = json_encode($nombres_servicios, JSON_UNESCAPED_SLASHES );
        
    	return view('admCentros.centro.cartera_servicio.edit',compact('id_centro','cartera_servicio','especialidades','servicios_json','meses','anios','nombres_servicios_json','nombres_servicios'));
    }

    public function store_cartera_servicio(Request $request,$id_centro)
    {
        // return $request->all();
        $titulo = $request->get('titulo');
        $mes = $request->get('mes');
        $anio = $request->get('anio');

        $id_cartera_servicio = CarteraServicio::_insertarCarteraServicio($titulo,$mes,$anio,$id_centro);

        if ($request->get('idservicios') != null) {
            $idservicios = $request->get('idservicios');
            $idespecialidades = $request->get('idespecialidad');
            $a = 0;
            while ($a < count($idservicios)) {
                $servicio = $request->get('text_s'.$idservicios[$a]);
                $dia = $request->get('text_d'.$idservicios[$a]);
                $hora = $request->get('text_h'.$idservicios[$a]);
                $observacion = $request->get('text_o'.$idservicios[$a]);
                $id_especialidad = $idespecialidades[$a];
                Servicio::_insertarServicio($servicio,$dia,$hora,$observacion,$id_cartera_servicio,$id_especialidad);
                $a++;
            }
        }
        return Redirect::to('adm/centro/index_cartera_servicio/'.$id_centro)->with('msj', 'Cartera de Servicio: "' . $mes . "/" . $anio . '" se creo exitosamente.');
    }

    public function update_cartera_servicio(Request $request,$id_cartera_servicio)
    {
        // return $request->all();
    	$titulo = $request->get('titulo');
        $mes = $request->get('mes');
        $anio = $request->get('anio');
        $id_centro = CarteraServicio::_editarCarteraServicio($titulo,$mes,$anio,$id_cartera_servicio);

        if ($request->get('id_detalle_servicios_nuevos') != null) {
            $id_detalle_servicios_nuevos = $request->get('id_detalle_servicios_nuevos');
            $a = 0;
            while ($a < count($id_detalle_servicios_nuevos)) {
                $nombre = $request->get('nuevo_nombre_servicio_'.$id_detalle_servicios_nuevos[$a]);
                $dias = $request->get('nuevo_dias_'.$id_detalle_servicios_nuevos[$a]);
                $hora = $request->get('nuevo_hora_'.$id_detalle_servicios_nuevos[$a]);
                $observacion = $request->get('nuevo_observacion_'.$id_detalle_servicios_nuevos[$a]);
                $id_especialidad = $request->get('nuevo_id_especialidad_'.$id_detalle_servicios_nuevos[$a]);
                Servicio::_insertarServicio($nombre,$dias,$hora,$observacion,$id_cartera_servicio,$id_especialidad);
                $a++;
            }
        }
        if ($request->get('id_servicios_eliminar') != null) {
            $id_servicios_eliminar = $request->get('id_servicios_eliminar');
            $a = 0;
            while ($a < count($id_servicios_eliminar)) {
                $id_detalle_servicio = $id_servicios_eliminar[$a];
                Servicio::destroy($id_detalle_servicio);
                $a++;
            }
        }
        
        if ($request->get('id_detalle_servicios_editar') != null) {
            $servicios_actualizar = $request->get('id_detalle_servicios_editar');
            $a = 0;
            while ($a < count($servicios_actualizar)) {
                $nombre = $request->get('nombre_servicio_'.$servicios_actualizar[$a]);
                $dias = $request->get('dias_'.$servicios_actualizar[$a]);
                $hora = $request->get('hora_'.$servicios_actualizar[$a]);
                $observacion = $request->get('observacion_'.$servicios_actualizar[$a]);
                $id_detalle_servicio = $servicios_actualizar[$a];
                Servicio::_editarServicio($nombre,$dias,$hora,$observacion,$id_detalle_servicio);
                $a++;
            }
        }
        return Redirect::to('adm/centro/index_cartera_servicio/'.$id_centro)->with('msj', 'Cartera de Servicio: "' . $mes . "/" . $anio . '" se edito exitosamente.');
    }

    public function renovate_cartera_servicio($id,$id_centro)
    {
        $w = Previlegio::_tienePermiso($id_centro);
        if ($w != -1)
            return Redirect::to('adm/centro/index_cartera_servicio/'.$w)->with('msj_e', 'Usted no tiene los previlegios necesarios.');
        
        $nombres_servicios = array("Emergencia","Consulta Externa","Internacion","Quirofano");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $anios = array("2018","2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");

        $cartera_servicio = CarteraServicio::findOrFail($id);
        $servicios = CarteraServicio::_getServiciosPorId($id);
        // $especialidades = CarteraServicio::_getEspecialidadesPorId($id);
        $especialidades = CentroMedico::_obtenerDetalleCentro($id_centro);

        $servicios_json = json_encode($servicios, JSON_UNESCAPED_SLASHES );
        $nombres_servicios_json = json_encode($nombres_servicios, JSON_UNESCAPED_SLASHES );
        // dd($cartera_servicio);
        return view('admCentros.centro.cartera_servicio.renovate',compact('id_centro','cartera_servicio','especialidades','servicios_json','anios','meses','nombres_servicios_json','nombres_servicios'));
    }

    //================================================

    // public function get_especialidadesPorId($id){
    //     return json_encode(array("especialidades" => CarteraServicio::_getEspecialidadesPorId($id)));
    // }

    // public function get_ServiciosPorIDCarteraIDEspecialidad($idCartera,$idEspecialidad){
    //     return json_encode(array("servicios" => CarteraServicio::_getServiciosPorIDCarteraIDEspecialidad($idCartera,$idEspecialidad)->get()));
    // }

    // public function get_ServiciosPorIDCartera($id){
    //     return json_encode(array("servicios" => CarteraServicio::_getServiciosPorIDCartera($id)->get()));
    // }
}
