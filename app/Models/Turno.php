<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    public $timestamps = false;

  	protected $table = 'turno';

	protected $fillable = [
	  'nombre',
	  'hora_inicio',
	  'hora_fin',
	  'id_detalle_centro_especialidad',
	  'id_etapa_servicio',
	  'id_personal_area',
	  'estado'
	];

	public function scope_insertarTurno($query, $nombre, $hora_inicio, $hora_fin, $id_detalle_centro_especialidad, $id_etapa_servicio, $id_personal_area)
	{
		if ($nombre == null) {
			$nombre = "";
		}
		if ($hora_inicio == null) {
			$hora_inicio = "";
		}
		if ($hora_fin == null) {
			$hora_fin = "";
		}

	  	$turno = new Turno;
	  	$turno->nombre = $nombre;
	  	$turno->hora_inicio = $hora_inicio;
	  	$turno->hora_fin = $hora_fin;
	  	$turno->id_detalle_centro_especialidad = $id_detalle_centro_especialidad;
	  	$turno->id_etapa_servicio = $id_etapa_servicio;
	  	$turno->id_personal_area = $id_personal_area;
	  	$turno->estado = 1;
	  	$turno->save();

	  	return $turno->id;
	}

	public function scope_editarTurno($query, $nombre, $hora_inicio, $hora_fin, $id)
	{
		if ($nombre == null) {
			$nombre = "";
		}
		if ($hora_inicio == null) {
			$hora_inicio = "";
		}
		if ($hora_fin == null) {
			$hora_fin = "";
		}
	  $turno = Turno::findOrFail($id);
	  $turno->nombre = $nombre;
	  $turno->hora_inicio = $hora_inicio;
	  $turno->hora_fin = $hora_fin;
	  $turno->save();
	}
}
