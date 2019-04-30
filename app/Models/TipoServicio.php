<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
  	public $timestamps = false;

  	protected $table = 'tipo_servicio';

  	protected $fillable = [
      	'nombre','descripcion'
  	];

  	public function scope_getAllTipoServicios($query, $searchText)
  	{
    	$text = trim($searchText);
    	if ($text == "") {
      		$result=$query->where('estado','=',1)
                    ->orderBy('id','desc');
    	}else{
      		$result=$query->where('estado','=',1)
                  ->where('nombre','LIKE','%'.$text.'%')
                    ->orWhere('id','LIKE','%'.$text.'%')
                    ->orderBy('id','desc');
    	}

    	return $result;
  	}

  	public function scope_insertarTipoServicio($query, $request)
  	{
    	$tipo_servicio = new TipoServicio;
    	$tipo_servicio->nombre = $request->get('nombre');
    	$tipo_servicio->descripcion = $request->get('descripcion');
    	$tipo_servicio->estado = 1;
    	$tipo_servicio->save();
  	}

  	public function scope_editarTipoServicio($query, $id, $request)
  	{
    	$tipo_servicio = TipoServicio::findOrFail($id);
    	$tipo_servicio->nombre = $request->get('nombre');
    	$tipo_servicio->descripcion = $request->get('descripcion');
    	$tipo_servicio->update();
  	}

  	public function scope_eliminarTipoServicio($query, $id)
  	{
    	$tipo_servicio = TipoServicio::findOrFail($id);
    	$tipo_servicio->estado = 0;
    	$tipo_servicio->update(); 
  	}

  	public function scope_getAllTipoServicio($query){
      	return $query;
  	}
}
