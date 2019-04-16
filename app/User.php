<?php

namespace App;

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
        $user = new User;
        $user->nombre = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->name = $request->get('name');
        $user->tipo = $request->get('tipo');
        $user->password = Hash::make($request->get('password'));
        $user->email = $request->get('email');
        $user->id_centro_medico = $request->get('id_centro_medico');
        $user->estado = 1;
        $user->save();
    }

    public function scope_editarUsuario($query, $id, $request)
    {
        $user = User::findOrFail($id);

        $user->nombre = $request->get('nombre');
        $user->apellido = $request->get('apellido');
        $user->name = $request->get('name');
        $user->tipo = $request->get('tipo');
        if($request->get('password') != ""){
            $user->password = Hash::make($request->get('password'));
        }
        $user->email = $request->get('email');
        $user->id_centro_medico = $request->get('id_centro_medico');
        $user->update();
    }

    public function scope_getAdministrador($query)
    {
        $result = $query->where('tipo', '=', 'ADMINISTRADOR');
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
