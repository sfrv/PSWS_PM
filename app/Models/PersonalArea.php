<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalArea extends Model
{
    public $timestamps = false;

  	protected $table = 'personal_area';

	protected $fillable = [
	  	'nombre',
	  	'id_etapa_servicio',
	  	'estado'
	];

	public function scope_insertarPersonalArea($query, $nombre, $id_etapa_servicio)
	{
	  	$personal_area = new PersonalArea;
	  	$personal_area->nombre = $nombre;
	  	$personal_area->id_etapa_servicio = $id_etapa_servicio;
	  	$personal_area->estado = 1;
	  	$personal_area->save();

	  	return $personal_area->id;
	}

	public function scope_editarPersonal($query, $id, $nombre)
	{
	  	$personal_area = PersonalArea::findOrFail($id);
	  	$personal_area->nombre = $nombre;
	  	$personal_area->save();
	}

	public function scope_obtenerPersonalEtapaPersonalArea($query, $id_etapa_servicio)
    {
    	$result = $query->where('id_etapa_servicio', '=', $id_etapa_servicio)
                ->where('estado', '=' , '1')
                ->orderBy('id', 'asc')
                ->get();
        return $result;
    }
}
