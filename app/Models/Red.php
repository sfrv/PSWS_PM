<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Red extends Model
{
  	public $timestamps = false;

  	protected $table = 'red';

  	protected $fillable = [
      	'nombre','descripcion','estado'
  	];

  	public function scope_getAllRedes($query, $searchText){
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

  	public function scope_insertarRed($query, $request)
  	{
    	$red = new Red;
    	$red->nombre = $request->get('nombre');
    	$red->descripcion = $request->get('descripcion');
    	$red->estado = 1;
    	$red->save();
  	}

  	public function scope_editarRed($query, $id, $request)
  	{
    	$red = Red::findOrFail($id);
    	$red->nombre = $request->get('nombre');
    	$red->descripcion = $request->get('descripcion');
    	$red->update();
  	}

  	public function scope_eliminarRed($query, $id)
  	{
    	$red = Red::findOrFail($id);
    	$red->estado = 0;
    	$red->update(); 
  	}

  	public function scope_getAllRed($query){
    	return $query;
  	}
}
