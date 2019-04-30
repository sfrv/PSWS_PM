<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
  	public $timestamps = false;

  	protected $table = 'nivel';

  	protected $fillable = [
      	'nombre','descripcion','estado'
  	];

  	public function scope_getAllNiveles($query, $searchText){
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

  	public function scope_insertarNivel($query, $request)
  	{
	    $nivel = new Nivel;
	    $nivel->nombre = $request->get('nombre');
	    $nivel->descripcion = $request->get('descripcion');
	    $nivel->estado = 1;
	    $nivel->save();
  	}

  	public function scope_editarNivel($query, $id, $request)
  	{
	    $nivel = Nivel::findOrFail($id);
	    $nivel->nombre = $request->get('nombre');
	    $nivel->descripcion = $request->get('descripcion');
	    $nivel->update();
  	}

  	public function scope_eliminarNivel($query, $id)
  	{
	    $nivel = Nivel::findOrFail($id);
	    $nivel->estado = 0;
	    $nivel->update(); 
  	}

  	public function scope_getAllNivel($query){
      	return $query;
  	}
}
