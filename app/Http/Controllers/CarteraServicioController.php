<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\CarteraServicio;
use App\Models\CentroMedico;
use App\Models\Servicio;
use Maatwebsite\Excel\Facades\Excel;

class CarteraServicioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
	public function index_cartera_servicio($id,Request $request)
    {
        $centro = CentroMedico::_obtenerCentro($id);
        $cartera_servicios = CentroMedico::_obtenerCarteraServicios($id,$request['searchText'])->paginate(6);
        // dd($request['searchText']);
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
    	// $especialidades = CarteraServicio::_getEspecialidadesPorId($id);
        $especialidades = CentroMedico::_obtenerDetalleCentro($id_centro);

    	$servicios_json = json_encode($servicios, JSON_UNESCAPED_SLASHES );
    	// dd($cartera_servicio);
    	return view('admCentros.centro.cartera_servicio.show',compact('cartera_servicio','especialidades','servicios_json'));
    }

    public function create_cartera_servicio($id_centro)
    {
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
        return Redirect::to('adm/centro/index_cartera_servicio/'.$id_centro);
    }

    public function actualizar_cartera_servicio()
    {
    	$my_json = $_REQUEST['my_json'];
        $titulo = $my_json['titulo'];
        $mes = $my_json['mes'];
        $anio = $my_json['anio'];
        $id = $my_json['id'];

        if ($my_json['datos_new'] != -1) {
            $datos_new = (array)$my_json['datos_new'];
            for ($i=0; $i < count($datos_new) ; $i++) { 
                Servicio::_insertarServicio($datos_new[$i][1],$datos_new[$i][2],$datos_new[$i][3],$datos_new[$i][4],$id,$datos_new[$i][0]);
            }
        }

        if ($my_json['datos_filas_delete'] != -1) {
            $datos_filas_delete = (array)$my_json['datos_filas_delete'];
            for ($i=0; $i < count($datos_filas_delete) ; $i++) { 
                Servicio::destroy($datos_filas_delete[$i]);
            }
        }
        
        CarteraServicio::_editarCarteraServicio($titulo,$mes,$anio,$id);
        $datos = (array)$my_json['datos'];
        for ($i=0; $i < count($datos) ; $i++) { 
            Servicio::_editarServicio($datos[$i][1],$datos[$i][2],$datos[$i][3],$datos[$i][4],$datos[$i][0]);
        }
    }

    public function renovate_cartera_servicio($id,$id_centro)
    {
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
