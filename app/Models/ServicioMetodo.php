<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioMetodo extends Model
{
    public $timestamps = false;

  	protected $table = 'servicio_metodo';

	protected $fillable = [
	  	'seccion',
	  	'controlador',
	  	'nombre',
	  	'descripcion',
	  	'tipo',
	  	'id_usuario',
	  	'estado'
	];

	public function scope_verificarServicioMetodo($query,$controlador, $nombre)
	{
	  	$result=$query->where('nombre','=',$nombre)
	  				  ->where('controlador','=',$controlador)
	  	              ->select('seccion','estado')
	                    ->first();
	    return $result;
	}
	public function scope_getAllServiciosMetodos($query, $searchText){
	    $text = trim($searchText);
	    if ($text == "") {
	      	$result=$query->orderBy('id','asc');
	    }else{
	      	$result=$query->where('nombre','LIKE','%'.$text.'%')
	                    ->orWhere('id','LIKE','%'.$text.'%')
	                    ->orderBy('id','asc');
	    }

    
    	return $result;
  	}

  	public function scope_editarServicioMetodo($query, $id, $request)
  	{
    	$servicio_metodo = ServicioMetodo::findOrFail($id);
    	$servicio_metodo->descripcion = $request->get('descripcion');
    	$servicio_metodo->update();
  	}

  	public function scope_cambiarEstadoServicioMetodo($query, $id)
  	{
    	$nuevo_estado = 1;
    	$servicio_metodo = ServicioMetodo::findOrFail($id);
    	$estado = $servicio_metodo->estado;
    	if ($estado == 1) {
    		$nuevo_estado = 0;
    	}else{
    		$nuevo_estado = 1;
    	}
    	$servicio_metodo->estado = $nuevo_estado;
    	$servicio_metodo->update();
  	}
}
