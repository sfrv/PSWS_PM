<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    public $timestamps = false;

  	protected $table = 'tipo_usuario';

  	protected $fillable = [
      	'nombre','descripcion','estado'
  	];

  	public function scope_getAllTipoUsuarios($query, $searchText){
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

  	public function scope_insertarTipoUsuario($query, $request)
  	{
    	$tipo_usuario = new TipoUsuario;
    	$tipo_usuario->nombre = $request->get('nombre');
    	$tipo_usuario->descripcion = $request->get('descripcion');
    	$tipo_usuario->estado = 1;
    	$tipo_usuario->save();
  	}

  	public function scope_editarTipoUsuario($query, $id, $request)
  	{
    	$tipo_usuario = TipoUsuario::findOrFail($id);
    	$tipo_usuario->nombre = $request->get('nombre');
    	$tipo_usuario->descripcion = $request->get('descripcion');
    	$tipo_usuario->update();
  	}

  	public function scope_eliminarTipoUsuario($query, $id)
  	{
    	$tipo_usuario = TipoUsuario::findOrFail($id);
    	$tipo_usuario->estado = 0;
    	$tipo_usuario->update(); 
  	}

}
