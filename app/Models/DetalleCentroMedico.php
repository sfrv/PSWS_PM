<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCentroMedico extends Model
{
    public $timestamps = false;

  	protected $table = 'detalle_medico_centro_medico';

	protected $fillable = [
	  'id_centro_medico',
	  'id_medico',
	  'estado'
	];

	public function scope_insertarDetalle($query, $id_centro, $id_medico)
    {
    	$detalle_medico = new DetalleCentroMedico();
        $detalle_medico->id_centro_medico = $id_centro;
        $detalle_medico->id_medico = $id_medico;
        $detalle_medico->estado = 1;
        $detalle_medico->save();
    }

    public function scope_eliminarDetalle($query, $id)
    {
    	$detalle_medico = DetalleCentroMedico::findOrFail($id);
        $detalle_medico->estado = 0;
        $detalle_medico->update();
    }

    public function scope_habilitarDetalle($query, $id)
    {
    	$detalle_medico = DetalleCentroMedico::findOrFail($id);
        $detalle_medico->estado = 1;
        $detalle_medico->update();
    }
}
