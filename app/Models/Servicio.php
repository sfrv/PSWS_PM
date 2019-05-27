<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public $timestamps = false;

  	protected $table = 'servicio';

	protected $fillable = [
	  	'nombre',
	  	'dias',
	  	'hora',
	  	'observacion',
	  	'id_cartera_servicio',
	  	'id_detalle_centro_especialidad',
	  	'estado'
	];

	public function scope_insertarServicio($query, $nombre, $dias, $hora, $observacion, $id_cartera_servicio, $id_detalle_centro_especialidad)
	{
		if ($dias == null) {
			$dias = "";
		}
		if ($hora == null) {
			$hora = "";
		}
		if ($observacion == null) {
			$observacion = "";
		}
	  	$servicio = new Servicio;
	  	$servicio->nombre = $nombre;
	  	$servicio->dias = $dias;
	  	$servicio->hora = $hora;
	  	$servicio->observacion = $observacion;
	  	$servicio->id_cartera_servicio = $id_cartera_servicio;
	  	$servicio->id_detalle_centro_especialidad = $id_detalle_centro_especialidad;
	  	$servicio->estado = 1;
	  	$servicio->save();
	}

	public function scope_editarServicio($query, $nombre, $dias, $hora, $observacion, $id)
	{
	  $servicio = Servicio::findOrFail($id);
	  $servicio->nombre = $nombre;
	  $servicio->dias = $dias;
	  $servicio->hora = $hora;
	  $servicio->observacion = $observacion;
	  $servicio->update();
	}
}
