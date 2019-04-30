<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
  	public $timestamps = false;

  	protected $table = 'especialidad';

  	protected $fillable = [
      	'nombre','descripcion','estado'
  	];

  	public function scope_getAllEspecialidades($query, $searchText){
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

  	public function scope_insertarEspecialidad($query, $request)
  	{
	    $especialidad = new Especialidad;
	    $especialidad->nombre = $request->get('nombre');
	    $especialidad->descripcion = $request->get('descripcion');
	    $especialidad->estado = 1;
	    $especialidad->save();
  	}

  	public function scope_editarEspecialidad($query, $id, $request)
  	{
	    $especialidad = Especialidad::findOrFail($id);
	    $especialidad->nombre = $request->get('nombre');
	    $especialidad->descripcion = $request->get('descripcion');
	    $especialidad->update();
  	}

  	public function scope_eliminarEspecialidad($query, $id)
  	{
	    $especialidad = Especialidad::findOrFail($id);
	    $especialidad->estado = 0;
	    $especialidad->update(); 
  	}

  	public function scope_getAllEspecialidad($query){
      	return $query;
  	}
}
