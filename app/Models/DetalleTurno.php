<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class DetalleTurno extends Model
{
	public $timestamps = false;

  	protected $table = 'detalle_turno';

	protected $fillable = [
	  'observacion',
	  'id_turno',
	  'estado'
	];

    public function scope_insertarDetalleTurno($query, $observacion, $id_turno)
	{
		if ($observacion == null) {
			$observacion = "";
		}
		
		$detalle_turno = new DetalleTurno;
		$detalle_turno->observacion = $observacion;
		$detalle_turno->id_turno = $id_turno;
		$detalle_turno->estado = 1;
		$detalle_turno->save();

		return $detalle_turno->id;
	}

	public function scope_editarDetalleTurno($query, $id, $observacion)
	{
	  	$detalle_turno = DetalleTurno::findOrFail($id);
	  	$detalle_turno->observacion = $observacion;
	  	$detalle_turno->save();
	}

	public function scope_getDetalleTurnoPorIdTurno($query, $id)
    {
        $result = DB::table('detalle_turno as a')
        ->select('a.*')
        ->where('a.id_turno','=', $id)
        ->get();

        return $result;
    }
}
