<?php

namespace App;

use DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    protected $table = 'usuario';
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre','apellido' ,'email' ,'name', 'tipo', 'password', 'remember_token', 'estado' ,'id_centro_medico'
    ];

    public function scope_getAllUsuarios($query, $searchText)
    {
        $text = trim($searchText);
        if ($text == "") {
            $result = $query->orderBy('id', 'desc');
        } else {
            $result = $query->where('name', 'LIKE', '%' . $text . '%')
                ->orWhere('id', 'LIKE', '%' . $text . '%')
                ->orderBy('id', 'desc');
        }
        return $result;
    }

    public function scope_insertarUsuario($query, $request)
    {
        $result = DB::table('tipo_usuario as a')
                ->select('a.nombre','a.id')
                ->where('a.id','=',$request->get('tipo'))
                ->first();

        $user = new User;
        $user->nombre = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->name = $request->get('name');
        $user->tipo = $result->nombre;
        $user->password = Hash::make($request->get('password'));
        $user->email = $request->get('email');
        $user->id_centro_medico = $request->get('id_centro_medico');
        $user->estado = 1;
        $user->save();

        return $user->id;
    }

    public function scope_editarUsuario($query, $id, $request)
    {
        $result = DB::table('tipo_usuario as a')
                ->select('a.nombre','a.id')
                ->where('a.id','=',$request->get('tipo'))
                ->first();

        $user = User::findOrFail($id);

        $user->nombre = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->name = $request->get('name');
        $user->tipo = $result->nombre;
        if($request->get('password') != ""){
            $user->password = Hash::make($request->get('password'));
        }
        $user->email = $request->get('email');
        $user->id_centro_medico = $request->get('id_centro_medico');
        $user->update();
    }

    public function scope_getAdministrador($query)
    {
        $result = $query->where('tipo', '=', 'Administrador');
        return $result;
    }

    public function scope_getUsuario($query,$email)
    {
        $result = $query->where('email', '=', $email)->first();
        if ($result == null) {
            $result = '';
        }
        return $result;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
