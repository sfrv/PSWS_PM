<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCentroEspecialidad extends Model
{
	public $timestamps = false;

  	protected $table = 'detalle_centro_especialidad';

	protected $fillable = [
	  'id_especialidad',
	  'id_centro_medico',
	  'etapa_emergencia',
	  'etapa_consulta',
	  'etapa_hospitalizacion',
	  'estado'
	];

	public function scope_editarDetalle($query, $id, $emergencia, $consulta, $hospitalizacion)
    {
    	$cant_aux = 0;
    	$detalleEspecialidad = DetalleCentroEspecialidad::findOrFail($id);
        if($emergencia != null ){
            $detalleEspecialidad->etapa_emergencia = 1;
        }else{
            $detalleEspecialidad->etapa_emergencia = 0;
            $cant_aux++;
        }
        if($consulta != null ){
            $detalleEspecialidad->etapa_consulta = 1;
        }else{
            $detalleEspecialidad->etapa_consulta = 0;
            $cant_aux++;
        }
        if($hospitalizacion != null ){
            $detalleEspecialidad->etapa_hospitalizacion = 1;
        }else{
            $detalleEspecialidad->etapa_hospitalizacion = 0;
            $cant_aux++;
        }
        if ($cant_aux == 3) {
            $detalleEspecialidad->estado = 0;
        }else{
            $detalleEspecialidad->estado = 1;
        }
        $detalleEspecialidad->update();
    }

    public function scope_insertarDetalle($query, $id_centro, $id_especialidad, $emergencia, $consulta, $hospitalizacion)
    {
    	$cant_aux = 0;
    	$detalleEspecialidad = new DetalleCentroEspecialidad();
        $detalleEspecialidad->id_centro_medico = $id_centro;
        $detalleEspecialidad->id_especialidad = $id_especialidad;
        if($emergencia != null ){
            $detalleEspecialidad->etapa_emergencia = 1;
        }else{
            $detalleEspecialidad->etapa_emergencia = 0;
            $cant_aux++;
        }
        if($consulta != null ){
            $detalleEspecialidad->etapa_consulta = 1;
        }else{
            $detalleEspecialidad->etapa_consulta = 0;
            $cant_aux++;
        }
        if($hospitalizacion != null ){
            $detalleEspecialidad->etapa_hospitalizacion = 1;
        }else{
            $detalleEspecialidad->etapa_hospitalizacion = 0;
            $cant_aux++;
        }
        if ($cant_aux == 3) {
            $detalleEspecialidad->estado = 0;
        }else{
            $detalleEspecialidad->estado = 1;
        }
        $detalleEspecialidad->save();
    }
}
