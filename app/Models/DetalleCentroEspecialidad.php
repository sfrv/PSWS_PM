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
}
