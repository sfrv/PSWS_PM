<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\ReporteCama;
use App\Models\CentroMedico;
use App\Models\AreaCama;
use App\Models\DetalleReporteCama;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReporteCamaController extends Controller
{
    public function index_reporte_cama($id,Request $request)
    {
        $fecha_actual = Carbon::now()->toDateString();
        $centro = CentroMedico::_obtenerCentro($id);
        $reporte_camas = ReporteCama::_getAllRerporteCamasPorIdCentro($id,$request['fecha_desde'],$request['fecha_hasta'])->paginate(6);
        // dd($request['searchText']);
        $searchText = $request->get('searchText');
        return view('admCentros.centro.reporte_cama.index',compact('reporte_camas','centro','fecha_actual'));
    }

    public function create_reporte_cama($id_centro)
    {
        $fecha_actual = Carbon::now()->toDateString();
        $areas = AreaCama::_getAllAreasCamasPorIdCentro($id_centro);
        $areas_json = json_encode($areas, JSON_UNESCAPED_SLASHES );
        return view('admCentros.centro.reporte_cama.create',compact('id_centro','areas','areas_json','fecha_actual'));
    }

    public function store_reporte_cama(Request $request,$id_centro)
    {
        $titulo = $request->get('titulo');
        $fecha = $request->get('fecha');

        $id_reporte_cama = ReporteCama::_insertarReporteCama($titulo,$fecha,$id_centro);

        if ($request->get('id_areas') != null) {
            $id_areas = $request->get('id_areas');
            $a = 0;
            while ($a < count($id_areas)) {
                $coc_m = $request->get('cocm_'.$id_areas[$a]);
                $cof_m = $request->get('cofm_'.$id_areas[$a]);
                $cdi_m = $request->get('cdim_'.$id_areas[$a]);

                $coc_t = $request->get('coct_'.$id_areas[$a]);
                $cof_t = $request->get('coft_'.$id_areas[$a]);
                $cdi_t = $request->get('cdit_'.$id_areas[$a]);

                $coc_n = $request->get('cocn_'.$id_areas[$a]);
                $cof_n = $request->get('cofn_'.$id_areas[$a]);
                $cdi_n = $request->get('cdin_'.$id_areas[$a]);

                $id_area = $id_areas[$a];
                DetalleReporteCama::_insertarDetalleReporteCama($coc_m,$cof_m,$cdi_m,$coc_t,$cof_t,$cdi_t,$coc_n,$cof_n,$cdi_n,$id_area,$id_reporte_cama);
                $a++;
            }
        }
        return Redirect::to('adm/centro/index_reporte_cama/'.$id_centro)->with('msj', 'Reporte de Cama: "' . $fecha . '" se creo exitosamente.');
    }

    public function edit_reporte_cama($id,$id_centro)
    {
        $reporte_cama = ReporteCama::findOrFail($id);
        $detalle_reporte_cama = DetalleReporteCama::_getAllDetalleReporteCamaPorIdReporteCama($reporte_cama->id);
        // dd($detalle_reporte_cama);
        return view('admCentros.centro.reporte_cama.edit',compact('id_centro','reporte_cama','detalle_reporte_cama'));
    }

    public function show_reporte_cama($id,$id_centro)
    {
        $reporte_cama = ReporteCama::findOrFail($id);
        $detalle_reporte_cama = DetalleReporteCama::_getAllDetalleReporteCamaPorIdReporteCama($reporte_cama->id);
        // dd($detalle_reporte_cama);
        return view('admCentros.centro.reporte_cama.show',compact('id_centro','reporte_cama','detalle_reporte_cama'));
    }

    public function update_reporte_cama(Request $request,$id_reporte_cama)
    {
        $titulo = $request->get('titulo');
        $fecha = $request->get('fecha');
        $id_centro = ReporteCama::_editarReporteCama($titulo,$fecha,$id_reporte_cama);

        if ($request->get('id_detalle_areas_editar') != null) {
            $id_detalle_areas_editar = $request->get('id_detalle_areas_editar');
            $a = 0;
            while ($a < count($id_detalle_areas_editar)) {
                $coc_m = $request->get('cocm_'.$id_detalle_areas_editar[$a]);
                $cof_m = $request->get('cofm_'.$id_detalle_areas_editar[$a]);
                $cdi_m = $request->get('cdim_'.$id_detalle_areas_editar[$a]);

                $coc_t = $request->get('coct_'.$id_detalle_areas_editar[$a]);
                $cof_t = $request->get('coft_'.$id_detalle_areas_editar[$a]);
                $cdi_t = $request->get('cdit_'.$id_detalle_areas_editar[$a]);

                $coc_n = $request->get('cocn_'.$id_detalle_areas_editar[$a]);
                $cof_n = $request->get('cofn_'.$id_detalle_areas_editar[$a]);
                $cdi_n = $request->get('cdin_'.$id_detalle_areas_editar[$a]);

                $id_detalle_area = $id_detalle_areas_editar[$a];
                DetalleReporteCama::_editarDetalleReporteCama($coc_m,$cof_m,$cdi_m,$coc_t,$cof_t,$cdi_t,$coc_n,$cof_n,$cdi_n,$id_detalle_area);
                $a++;
            }
        }

        return Redirect::to('adm/centro/index_reporte_cama/'.$id_centro)->with('msj', 'Reporte de Cama: "' . $fecha . '" se edito exitosamente.');
    }

    public function generar_excel_reporte_cama($id_reporte_cama,$id_centro)
    {
        Excel::create('ReporteDeCama', function($excel) use ($id_reporte_cama,$id_centro) {

            $excel->sheet('Sheetname', function($sheet) use ($id_reporte_cama,$id_centro) {
                
                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');

                $sheet->mergeCells('A3:A4');//Area

                $sheet->mergeCells('B3:D3');
                $sheet->mergeCells('E3:G3');
                $sheet->mergeCells('H3:J3');

                $sheet->setWidth(array(
                    'A'     =>  33,
                    'B'     =>  20,
                    'C'     =>  20,
                    'D'     =>  20,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  20,
                    'H'     =>  20,
                    'I'     =>  20,
                    'J'     =>  20,
                ));
                $sheet->setHeight(array(
                    1     =>  45,
                    2     =>  45,
                    3     =>  30
                ));
                // $sheet->setBorder('A3', 'solid');
                $sheet->cell('A3', function($cell){//BORDE
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('B3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('E3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('H3', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('B4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('E4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('H4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('C4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('F4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('I4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('D4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('G4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                $sheet->cell('J4', function($cell){
                    $cell->setBorder('thin','thin','thin','thin');
                });
                // $sheet->cell('A3:E3', function($cell){
                //     $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // });

                $sheet->cells('A1:J1', function($cells) {
                    $cells->setFontSize(20);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#506228');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                    // $cells->setBorder('thin','thin','thin','thin');
                });
                $sheet->cells('A2:J2', function($cells) {
                    $cells->setFontSize(20);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('A3:J3', function($cells) {
                    $cells->setFontSize(20);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });
                $sheet->cells('B4:J4', function($cells) {
                    $cells->setFontSize(10);
                    $cells->setFontFamily('Calibri');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setValignment('center');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setBackground('#76923B');
                    $cells->setBorder('thin','thin','thin','thin');//BORDE
                });

                $reporte_cama = ReporteCama::findOrFail($id_reporte_cama);
                $centro = CentroMedico::findOrFail($id_centro);
                $sheet->row(1, ['Formato de Reporte de Cama / ' . $reporte_cama->fecha]);
                $sheet->row(2, ['Centro Medico: ' . $centro->nombre ]);
                // $sheet->row(3, ['Area','SERVICIOS','DIAS','HORA','OBSERVACION']);
                $sheet->setCellValue('A3', 'Area');
                $sheet->setCellValue('B3', 'Turno Mañana');
                $sheet->setCellValue('E3', 'Turno Tarde');
                $sheet->setCellValue('H3', 'Turno Noche');

                $sheet->setCellValue('B4', 'Camas Ocupadas');
                $sheet->setCellValue('C4', 'Camas Ofertadas');
                $sheet->setCellValue('D4', 'Camas Disponibles');
                $sheet->setCellValue('E4', 'Camas Ocupadas');
                $sheet->setCellValue('F4', 'Camas Ofertadas');
                $sheet->setCellValue('G4', 'Camas Disponibles');
                $sheet->setCellValue('H4', 'Camas Ocupadas');
                $sheet->setCellValue('I4', 'Camas Ofertadas');
                $sheet->setCellValue('J4', 'Camas Disponibles');

                $detalle_reporte_cama = DetalleReporteCama::_getAllDetalleReporteCamaPorIdReporteCama($reporte_cama->id);
                // dd($especialidades);
                $data = [];
                $cont_filas = 5;
                foreach ($detalle_reporte_cama as $area_cama) {//especialidad
                    // $servicios_especialidad = CarteraServicio::_getServiciosPorIdCarteraAndEspecialidad($id_cart,$especialidad->id);
                    $celdas_ini = $cont_filas;
                    $sheet->setHeight($cont_filas, 20);
                    $sheet->setCellValue('A'.$celdas_ini, $area_cama->nombre_area);
                    $sheet->cell('A'.$celdas_ini, function($cell){//BORDE
                        $cell->setBorder('thin','thin','thin','thin');
                    });
                    $sheet->cells('A'.$celdas_ini.':A'.$celdas_ini, function($cells) {
                            $cells->setFontSize(10);
                            $cells->setFontFamily('Arial');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFontWeight('bold');
                            $cells->setBackground('#D9D9D9');//fondo
                            // $cells->setBorder('thin','thin','thin','thin');
                    });

                    $sheet->setCellValue('B'.$celdas_ini, $area_cama->coc_m);
                    $sheet->setCellValue('C'.$celdas_ini, $area_cama->cof_m);
                    $sheet->setCellValue('D'.$celdas_ini, $area_cama->cdi_m);
                    $sheet->setCellValue('E'.$celdas_ini, $area_cama->coc_t);
                    $sheet->setCellValue('F'.$celdas_ini, $area_cama->cof_t);
                    $sheet->setCellValue('G'.$celdas_ini, $area_cama->cdi_t);
                    $sheet->setCellValue('H'.$celdas_ini, $area_cama->coc_n);
                    $sheet->setCellValue('I'.$celdas_ini, $area_cama->cof_n);
                    $sheet->setCellValue('J'.$celdas_ini, $area_cama->cdi_n);

                    $sheet->cells('B'.$celdas_ini.':J'.$celdas_ini, function($cells) {
                            $cells->setFontSize(10);
                            $cells->setFontFamily('Arial');
                            $cells->setAlignment('center');
                            $cells->setValignment('center');
                            $cells->setFontWeight('bold');
                            $cells->setBorder('thin','thin','thin','thin');
                    });
                    $cont_filas++;
                    // foreach ($servicios_especialidad as $servicio) {
                    //     $sheet->setCellValue('B'.$cont_filas, $servicio->nombre);
                    //     $sheet->setCellValue('C'.$cont_filas, $servicio->dias);
                    //     $sheet->setCellValue('D'.$cont_filas, $servicio->hora);
                    //     $sheet->setCellValue('E'.$cont_filas, $servicio->observacion);
                        
                    //     $sheet->setHeight($cont_filas, 40);
                    //     $sheet->cells('B'.$cont_filas.':E'.$cont_filas, function($cells) {
                    //         $cells->setFontSize(15);
                    //         $cells->setFontFamily('Arial');
                    //         $cells->setAlignment('center');
                    //         $cells->setValignment('center');
                    //         $cells->setBorder('thin','thin','thin','thin');
                    //     });
                    //     // $row = [];
                    //     // // $row[0] = $especialidad->id;
                    //     // $row[1] = $servicio->nombre;
                    //     // $row[2] = $servicio->dias;
                    //     // $row[3] = $servicio->hora;
                    //     // $row[4] = $servicio->observacion;
                    //     // $data[] = $row;
                    //     // $sheet->appendRow($row);
                    //     $cont_filas++;
                    // }
                    // $celdas_fin = $cont_filas -1;
                    // $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                    // $sheet->mergeCells('A4:A4');
                }

            });

        })->export('xlsx');
    }
}
