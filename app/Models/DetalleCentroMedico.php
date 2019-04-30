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
}
