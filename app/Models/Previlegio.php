<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Previlegio extends Model
{
    public $timestamps = false;

  	protected $table = 'previlegio';

  	protected $fillable = [
      	'id_modulo','id_caso_uso','id_usuario','estado','cambio'
  	];

  	public function scope_getAllPrevilegiosUsuario($query, $id)
  	{
  		$result = DB::table('previlegio as a')
  				->join('modulo as b', 'b.id', '=', 'a.id_modulo')
  				->join('caso_uso as c', 'c.id', '=', 'a.id_caso_uso')
            	->select('a.*','b.nombre as nombre_modulo', 'c.nombre as nombre_caso_uso')
                ->where('a.id_usuario','=',$id)
                ->get();

    	return $result;
  	}

    public function scope_esAdministrador($query)
    {
      $result = DB::table('tipo_usuario as a')
                ->select('a.nombre','a.id')
                ->where('a.id','=',2)
                ->first();

      if (Auth::user()->tipo == $result->nombre) {
        return true;
      }
      return false;
    }

    public function scope_tienePermiso($query,$id)
    {
      $result = DB::table('tipo_usuario as a')
                ->select('a.nombre','a.id')
                ->where('a.id','=',1)
                ->first();

      if (Auth::user()->id_centro_medico != $id && Auth::user()->tipo == $result->nombre) {
        return Auth::user()->id_centro_medico;
      }
      return -1;
    }

  	public function scope_getAllModulos($query, $id)
  	{
  		$result = DB::table('modulo as a')->get();

    	return $result;
  	}

  	public function scope_editarPrevilegios($query, $id, $request)
  	{
    	if ($request->get('id_previlegios') != null) {
            $id_previlegios = $request->get('id_previlegios');
            $cont = 0;
            while ($cont < count($id_previlegios)) {
            	$previlegio = Previlegio::findOrFail($id_previlegios[$cont]);
            	if ( $request->get($id_previlegios[$cont].'_cu') != null) {
            		$previlegio->estado = 1;
            	}else{
            		$previlegio->estado = 0;
            	}
            	$previlegio->update();
            	$cont++;
            }
        }
  	}

  	public function scope_getAllPrevilegioUsuario($query, $id)
  	{
  		if (Auth::user() == null) {
  			return[[''],['']];
  		}

  		$result = DB::table('previlegio as a')
	    ->groupBy('a.id_modulo')
	    ->select('a.id_modulo',DB::raw('SUM(a.estado) as cant'))
	    ->where('a.id_usuario','=',Auth::user()->id)
	    ->get();

	    $result2 = DB::table('previlegio as a')
	    ->select('a.id_caso_uso','a.estado')//DB::raw("'/u0001' as estado"))
	    ->where('a.id_usuario','=',Auth::user()->id)
	    ->get();

	    return [$result,$result2];
  	}

  	public function scope_getAllPrevilegioUsuarioOpciones($query, $id)
  	{
  		// $result = DB::table('previlegio as a')
	   //  ->select('a.id_caso_uso','a.estado')
	   //  ->where('a.id_usuario','=',Auth::user()->id)
	   //  ->get();

	    return $result;
  	}

  	public function scope_insertarPrevilegioUsuario($query, $id)
  	{
    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 1;
    	$previlegio->id_caso_uso = 1;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 1;
    	$previlegio->id_caso_uso = 2;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 1;
    	$previlegio->id_caso_uso = 3;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 1;
    	$previlegio->id_caso_uso = 4;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 2;
    	$previlegio->id_caso_uso = 5;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 2;
    	$previlegio->id_caso_uso = 6;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 2;
    	$previlegio->id_caso_uso = 7;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 3;
    	$previlegio->id_caso_uso = 8;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 3;
    	$previlegio->id_caso_uso = 9;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 3;
    	$previlegio->id_caso_uso = 10;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();

    	$previlegio = new Previlegio;
    	$previlegio->id_modulo = 4;
    	$previlegio->id_caso_uso = 11;
    	$previlegio->id_usuario = $id;
    	$previlegio->estado = 0;
    	$previlegio->cambio = 1;
    	$previlegio->save();
  	}
}
