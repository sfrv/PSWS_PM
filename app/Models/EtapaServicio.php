<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EtapaServicio extends Model
{
    public $timestamps = false;

  	protected $table = 'etapa_servicio';

	protected $fillable = [
	  	'nombre',
	  	'id_rol_turno',
	  	'estado'
	];

	public function scope_insertarEtapaServicio($query, $nombre, $id_rol_turno)
	{
	  	$etapa_servicio = new EtapaServicio;
	  	$etapa_servicio->nombre = $nombre;
	  	$etapa_servicio->id_rol_turno = $id_rol_turno;
	  	$etapa_servicio->estado = 1;
	  	$etapa_servicio->save();

	  	return $etapa_servicio->id;
	}

	public function scope_obtejerEtapasPorIdRolTurno($query, $id_rol_turno)
	{
	  	$result = $query->where('id_rol_turno', '=', $id_rol_turno)
                ->orderBy('id', 'desc')
                ->get();

	  	return $result;
	}

}
