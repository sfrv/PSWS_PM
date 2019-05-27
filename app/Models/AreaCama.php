<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaCama extends Model
{
	public $timestamps = false;

  	protected $table = 'area_cama';

  	protected $fillable = [
      	'descripcion','nombre', 'id_centro_medico','estado'
  	];

    public function scope_getAllAreasCamasPorIdCentro($query, $id_centro)
    {
        $result = $query->select('*')
            ->where('id_centro_medico', '=', $id_centro)
            ->orderBy("id", "asc")
            ->get();
        return $result;
    }

    public function scope_insertarAreaCama($query, $id_centro, $nombre, $descripcion)
	{
		if ($nombre == null) {
			$nombre = "";
		}
		if ($descripcion == null) {
			$descripcion = "";
		}
		$area_cama = new AreaCama;
		$area_cama->id_centro_medico = $id_centro;
		$area_cama->nombre = $nombre;
		$area_cama->descripcion = $descripcion;
		$area_cama->estado = 1;
		$area_cama->save();
	}

	public function scope_eliminarAreaCama($query, $id)
	{
		$area_cama = AreaCama::findOrFail($id);
		$area_cama->estado = 0;
		$area_cama->save();
	}

	public function scope_editarAreaCama($query, $id, $nombre, $descripcion)
	{
		if ($nombre == null) {
			$nombre = "";
		}
		if ($descripcion == null) {
			$descripcion = "";
		}
		$area_cama = AreaCama::findOrFail($id);
		$area_cama->nombre = $nombre;
		$area_cama->estado = 1;
		$area_cama->descripcion = $descripcion;
		$area_cama->save();
	}
}
