<?php

namespace App\Http\Controllers;

use App\Models\Red;
use App\Models\TipoServicio;
use App\Models\Nivel;
use App\Models\CentroMedico;
use App\Models\Zona;
use App\Models\CarteraServicio;
use App\Models\Medico;
use App\Models\RolTurno;
use App\Models\PersonalArea;
use App\Models\DetalleTurno;
use App\Models\ReporteCama;
use App\Models\DetalleReporteCama;
use Maatwebsite\Excel\Facades\Excel;


class WebServiceController extends Controller
{
    public function get_imagen_Red($id)
    {
        $red = Red::findOrFail($id);
        return response()->file('../public/images/' . $red->imagen);
    }

    public function get_imagen_TipoServicio($id)
    {
        $servicio = TipoServicio::findOrFail($id);
        return response()->file('../public/images/' . $servicio->imagen);
    }

    public function get_imagen_Nivel($id)
    {
        $nivel = Nivel::findOrFail($id);
        return response()->file('../public/images/' . $nivel->imagen);
    }

    public function get_imagen_CentroMedico($id)
    {
        $centro = CentroMedico::findOrFail($id);
        return response()->file('../public/images/Centros/' . $centro->imagen);
    }

    public function getRedes()
    {
        return json_encode(array("redes" => Red::_getAllRed()->get()));
    }

    public function getTipoServicios()
    {
        return json_encode(array("tiposervicios" => TipoServicio::_getAllTipoServicio()->get()));
    }

    public function getZonas()
    {
        return json_encode(array("zonas" => Zona::_getAllZona()->get()));
    }

    public function getNiveles()
    {
        return json_encode(array("niveles" => Nivel::_getAllNivel()->get()));
    }

    public function getCentroMedico($id)
    {
        return json_encode(array("centro" => CentroMedico::_getOneCentroMedico($id)->get()));
    }

    public function getCentrosMedicos()
    {
        return json_encode(array("centros" => CentroMedico::_getAllCentroMedico()->get()));
    }

    public function getCentrosMedicosPorDistancia($distancia,$lat,$lon)
    {
        return json_encode(array("centros" => CentroMedico::_getAllCentroMedicoPorDistancia($distancia,$lat,$lon)));
    }

    public function getCentrosMedicosPorNivel($nivel)
    {
        return json_encode(array("centros" => CentroMedico::_getAllCentroMedicoPorNivel($nivel)->get()));
    }

    public function getCentrosMedicos_por_red_tipo_nivel($id_red, $id_tipo_servicio, $id_nivel)
    {
        return json_encode(array("centros" => CentroMedico::_getCentrosMedicos_por_red_tipo_nivel($id_red, $id_tipo_servicio, $id_nivel)->get()));
    }

    public function get_lastCarteraServicio($id){
        return json_encode(array("carteras" => CentroMedico::_getLastCarteraServicio($id)->get()));
    }

    public function get_allCartertaServicio($id){//mb1
        return json_encode(array("especialidades" => CarteraServicio::_getEspecialidadesPorId($id),
                                 "servicios" => CarteraServicio::_getServiciosPorIDCartera($id)->get()));
    }

    public function get_allRolTurno($id,$nom){//mb2
        if ($nom == 'Etapa de Personal Encargado'){
            return json_encode(array(
                "cargosPersonal" => PersonalArea::_obtenerPersonalEtapaPersonalArea($id),
                "turnos" => RolTurno::_getTurnosPorIdEtapaServicio($id),
                "rolesDia" => RolTurno::_getRolDiasPorIdEtapaServicio($id),
                "medicos" => Medico::_getAllMedicos("")->get(),
                "observaciones" => RolTurno::_getDetalleTurnosPorIdEtapaServicio($id)
                            ));
        }else{
            return json_encode(array(
                "especialidades" => RolTurno::_getEspecialidadesPorIdEtapaServicio($id),
                "turnos" => RolTurno::_getTurnosPorIdEtapaServicio($id),
                "rolesDia" => RolTurno::_getRolDiasPorIdEtapaServicio($id),
                "medicos" => Medico::_getAllMedicos("")->get(),
                "observaciones" => RolTurno::_getDetalleTurnosPorIdEtapaServicio($id)
                            ));
        }
    }

    public function get_especialidadesPorId($id){
        return json_encode(array("especialidades" => CarteraServicio::_getEspecialidadesPorId($id)));
    }

    public function get_ServiciosPorIDCarteraIDEspecialidad($idCartera,$idEspecialidad){
        return json_encode(array("servicios" => CarteraServicio::_getServiciosPorIDCarteraIDEspecialidad($idCartera,$idEspecialidad)->get()));
    }

    public function get_ServiciosPorIDCartera($id){
        return json_encode(array("servicios" => CarteraServicio::_getServiciosPorIDCartera($id)->get()));
    }

    public function generar_excel_reporte_cama($id_centro)
    {
        Excel::create('ReporteDeCamaApp', function($excel) use ($id_centro) {

            $excel->sheet('Sheetname', function($sheet) use ($id_centro) {
                
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

                $reporte_cama = ReporteCama::orderBy('fecha', 'desc')
                                ->where('id_centro_medico','=',$id_centro)
                                ->first();

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
                        $cont_filas++;
                    }
                    $celdas_fin = $cont_filas -1;
                    $sheet->mergeCells('A'.$celdas_ini.':A'.$celdas_fin);
                }
            });

        })->export('xlsx');
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
                $sheet->row($cont_filas, ['Etapa de Personal Encargado']);
                $etapa_servicio_cuatro = RolTurno::_getEtapaServicio($id_rol_turno,'Etapa de Personal Encargado');
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

    public function get_AllRolTurnos($id){
        return json_encode(array("roles" => CentroMedico::_getAllRolTurnos($id)->get()));
    }

    public function get_DetalleTurnosPorIdEtapaServicio($id){
        return json_encode(array("observaciones" => RolTurno::_getDetalleTurnosPorIdEtapaServicio($id)));
    }

    public function get_EtapasServicios($id){
        return json_encode(array("etapas" => RolTurno::_getEtapasServicios($id)->get()));
    }

    public function get_EspecialidadesPorIdEtapa($id){
        return json_encode(array("especialidades" => RolTurno::_getEspecialidadesPorIdEtapaServicio($id)));
    }
    
    public function get_TurnosPorIdEtapaServicio($id){
        return json_encode(array("turnos" => RolTurno::_getTurnosPorIdEtapaServicio($id)));
    }

    public function get_RolDiasPorIdEtapaServicio($id){
        return json_encode(array("rolesDia" => RolTurno::_getRolDiasPorIdEtapaServicio($id)));
    }

    public function get_obtenerPersonalEtapaPersonalArea($id){
        return json_encode(array("cargosPersonal" => PersonalArea::_obtenerPersonalEtapaPersonalArea($id)));
    }

    public function get_AllMedicos(){
        return json_encode(array("medicos" => Medico::_getAllMedicos("")->get()));
    }

    public function get_CentroMedico($id){
        return json_encode(array("centro" => CentroMedico::_obtenerCentro($id)));
    }

    public function get_CentrosMedicos_por_nombre_o_especialidad($searchText, $filtro){
        return json_encode(array("centros" => CentroMedico::_getAllCentrosMedicos($searchText, $filtro)->get()));
    }
}
