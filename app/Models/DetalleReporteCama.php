<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleReporteCama extends Model
{
    public $timestamps = false;

  	protected $table = 'detalle_reporte_cama';

	protected $fillable = [
	  	'coc_m',
		'cof_m',
		'cdi_m',
		'coc_t',
		'cof_t',
		'cdi_t',
		'coc_n',
		'cof_n',
		'cdi_n',
		'id_reporte_cama',
		'id_area_cama',
	  	'estado'
	];

    public function scope_insertarDetalleReporteCama($query,$coc_m,$cof_m,$cdi_m,$coc_t,$cof_t,$cdi_t,$coc_n,$cof_n,$cdi_n,$id_area,$id_reporte_cama)
	{
		$detalle_reporte_cama = new DetalleReporteCama;
		$detalle_reporte_cama->coc_m = $coc_m;
		$detalle_reporte_cama->cof_m = $cof_m;
		$detalle_reporte_cama->cdi_m = $cdi_m;
		$detalle_reporte_cama->coc_t = $coc_t;
		$detalle_reporte_cama->cof_t = $cof_t;
		$detalle_reporte_cama->cdi_t = $cdi_t;
		$detalle_reporte_cama->coc_n = $coc_n;
		$detalle_reporte_cama->cof_n = $cof_n;
		$detalle_reporte_cama->cdi_n = $cdi_n;
		$detalle_reporte_cama->id_reporte_cama = $id_reporte_cama;
		$detalle_reporte_cama->id_area_cama = $id_area;
		$detalle_reporte_cama->estado = 1;
		$detalle_reporte_cama->save();
	}

	public function scope_editarDetalleReporteCama($query,$coc_m,$cof_m,$cdi_m,$coc_t,$cof_t,$cdi_t,$coc_n,$cof_n,$cdi_n,$id)
	{
		$detalle_reporte_cama = DetalleReporteCama::findOrFail($id);
		$detalle_reporte_cama->coc_m = $coc_m;
		$detalle_reporte_cama->cof_m = $cof_m;
		$detalle_reporte_cama->cdi_m = $cdi_m;
		$detalle_reporte_cama->coc_t = $coc_t;
		$detalle_reporte_cama->cof_t = $cof_t;
		$detalle_reporte_cama->cdi_t = $cdi_t;
		$detalle_reporte_cama->coc_n = $coc_n;
		$detalle_reporte_cama->cof_n = $cof_n;
		$detalle_reporte_cama->cdi_n = $cdi_n;
		$detalle_reporte_cama->save();
	}

	public function scope_getAllDetalleReporteCamaPorIdReporteCama($query, $id_reporte_cama)
    {
        $result = DB::table('detalle_reporte_cama as a')
            ->join('area_cama as b', 'b.id', '=', 'a.id_area_cama')
            ->select('b.nombre as nombre_area', 'a.*')
            ->where('a.id_reporte_cama', '=', $id_reporte_cama)
            ->orderBy("a.id", "asc")
            ->get();

        return $result;
    }
}
