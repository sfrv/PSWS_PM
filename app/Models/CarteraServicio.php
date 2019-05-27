<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CarteraServicio extends Model
{
    public $timestamps = false;

  	protected $table = 'cartera_servicio';

	protected $fillable = [
	  	'titulo',
	  	'mes',
	  	'anio',
      	'id_centro_medico',
	  	'estado'
	];

	public function scope_insertarCarteraServicio($query, $titulo, $mes, $anio,$id_centro)
	{
	  	$cartera_servicio = new CarteraServicio;
	  	$cartera_servicio->titulo = $titulo;
	  	$cartera_servicio->mes = $mes;
	  	$cartera_servicio->anio = $anio;
      	$cartera_servicio->id_centro_medico = $id_centro;
	  	$cartera_servicio->estado = 1;
	  	$cartera_servicio->save();
	  	return $cartera_servicio->id;
	}

	public function scope_editarCarteraServicio($query, $titulo, $mes, $anio,$id)
	{
	  	$cartera_servicio = CarteraServicio::findOrFail($id);
	  	$cartera_servicio->titulo = $titulo;
	  	$cartera_servicio->mes = $mes;
	  	$cartera_servicio->anio = $anio;
	  	$cartera_servicio->update();
	}

	public function scope_getServiciosPorId($query, $id)
    {
        $servicios = DB::table('servicio as a')
        ->select('a.*')
        ->where('a.id_cartera_servicio','=', $id)
        ->orderBy('a.id_detalle_centro_especialidad', 'desc')
        ->get();

        return $servicios;
    }

    // //no borrar
    // public function scope_getEspecialidadesPorId($query, $id)
    // {
    //     $servicios = DB::table('servicio as a')
    //     ->join('detalle_centro_especialidad as b', 'a.id_detalle_centro_especialidad', '=', 'b.id')
    //     ->join('especialidad as c', 'b.id_especialidad', '=', 'c.id')
    //     ->select('c.nombre','b.id')
    //     ->where('a.id_cartera_servicio','=', $id)
    //     ->orderBy('c.id', 'ASC')
    //     ->distinct()
    //     ->get();

    //     return $servicios;
    // }

    //no borrar
    public function scope_getEspecialidadesPorId($query, $id)
    {
        $servicios = DB::table('servicio as a')
        ->join('detalle_centro_especialidad as b', 'a.id_detalle_centro_especialidad', '=', 'b.id')
        ->join('especialidad as c', 'b.id_especialidad', '=', 'c.id')
        ->select('c.nombre','b.id','c.id as idEspecialidad')
        ->where('a.id_cartera_servicio','=', $id)
        ->orderBy('b.id', 'asc')
        ->distinct()
        ->get();

        return $servicios;
    }

    public function scope_getServiciosPorIdCarteraAndEspecialidad($query, $id_c, $id_e)
    {
        $servicios = DB::table('servicio as a')
        ->join('detalle_centro_especialidad as b', 'a.id_detalle_centro_especialidad', '=', 'b.id')
        ->join('especialidad as c', 'b.id_especialidad', '=', 'c.id')
        ->select('a.*')
        ->where('a.id_cartera_servicio','=', $id_c)
        ->where('a.id_detalle_centro_especialidad','=', $id_e)
        ->orderBy('c.id', 'desc')
        ->get();

        return $servicios;
    }

    public function scope_getCarteraServicio($query, $id)
    {
        $servicio = DB::table('cartera_servicio as a')
        ->where('a.id','=', $id)
        ->get();
        return $servicio;
    }

    // public function scope_getEspecialidadesPorId($query, $id_centro)
    // {
    //     $servicios = DB::table('detalle_centro_especialidad as a')
    //     ->join('especialidad as b', 'a.id_especialidad', '=', 'b.id')
    //     ->select('b.nombre','a.id')
    //     ->where('a.id_centro_medico','=', $id_centro)
    //     ->orderBy('b.id', 'desc')
    //     ->get();

    //     return $servicios;
    // }

    //================================================
    public function scope_getServiciosPorIDCartera($query, $id)
	{
		$servicios = DB::table('servicio as s')
			->join('detalle_centro_especialidad as d', 's.id_detalle_centro_especialidad', '=', 'd.id')
			->select('s.*','d.id_especialidad')
			->where('s.id_cartera_servicio', '=', $id)
			->orderBy('s.id_detalle_centro_especialidad', 'desc');

		return $servicios;
	}
  //===obtener servicios meddiante el id de la cartera de servicio
	public function scope_getServiciosPorIDCarteraIDEspecialidad($query, $idCartera,$idEspecialidad)
	{
		$servicios = DB::table('servicio as s')
			->join('detalle_centro_especialidad as d', 's.id_detalle_centro_especialidad', '=', 'd.id')
			->select('s.*','d.id_especialidad')
			->where('s.id_cartera_servicio', '=', $idCartera)
			->where('d.id_especialidad','=',$idEspecialidad)
			->orderBy('s.id_detalle_centro_especialidad', 'desc');

		return $servicios;
	}
	
}
