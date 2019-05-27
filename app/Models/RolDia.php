<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolDia extends Model
{
    public $timestamps = false;

  	protected $table = 'rol_dia';

	protected $fillable = [
	  'dia',
	  'id_turno',
	  'id_medico',
	  'estado'
	];

	public function scope_insertarRolDia($query, $dia, $id_turno, $id_medico)
	{
		if ($id_medico == -1) {
			$id_medico = null;
		}
		$rol_dia = new RolDia;
		$rol_dia->dia = $dia;
		$rol_dia->id_turno = $id_turno;
		$rol_dia->id_medico = $id_medico;
		$rol_dia->estado = 1;
		$rol_dia->save();

		return $rol_dia->id;
	}

	public function scope_editarRolDia($query, $id_medico, $id)
	{
		if ($id_medico == -1) {
			$id_medico = null;
		}
		$rol_dia = RolDia::findOrFail($id);
		$rol_dia->id_medico = $id_medico;
		$rol_dia->save();
	}
}
