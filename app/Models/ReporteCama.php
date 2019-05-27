<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteCama extends Model
{
    public $timestamps = false;

  	protected $table = 'reporte_cama';

  	protected $fillable = [
      	'fecha','titulo','estado'
  	];

    // public function scope_getAllRerporteCamas($query, $searchText){
    //     $text = trim($searchText);
    //     if ($text == "") {
    //         $result=$query->where('estado','=',1)
    //                   ->orderBy('id','desc');
    //     }else{
    //        $result=$query->where('estado','=',1)
    //                 ->where('titulo','LIKE','%'.$text.'%')
    //                   ->orWhere('id','LIKE','%'.$text.'%')
    //                   ->orderBy('id','desc');
    //     }

    
    //     return $result;
    // }

    public function scope_insertarReporteCama($query, $titulo, $fecha, $id_centro_medico)
    {
        $reporte_cama = new ReporteCama;
        $reporte_cama->titulo = $titulo;
        $reporte_cama->fecha = $fecha;
        $reporte_cama->estado = 1;
        $reporte_cama->id_centro_medico = $id_centro_medico;
        $reporte_cama->save();

        return $reporte_cama->id;
    }
  	
  	public function scope_getAllRerporteCamasPorIdCentro($query, $id, $fecha_desde, $fecha_hasta)
    {
        $fecha_d = trim($fecha_desde);
        $fecha_h = trim($fecha_hasta);

        if ($fecha_d == "" && $fecha_h == "") {
            $result = $query->select('*')
                ->where('id_centro_medico', '=', $id)
                ->orderBy("id", "DES");
        } else {
            // dd($fecha_d);
            $result =  $query->select('*')
                ->where('fecha', '>=', $fecha_d)
                ->where('fecha', '<=', $fecha_h)
                ->orderBy("id", "DES");
        }
        return $result;
    }

    public function scope_editarReporteCama($query, $titulo, $fecha, $id)
    {
        $reporte_cama = ReporteCama::findOrFail($id);
        $reporte_cama->titulo = $titulo;
        $reporte_cama->fecha = $fecha;
        $reporte_cama->save();

        return $reporte_cama->id_centro_medico;
    }
}
