<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(request $request)
    {
        $user = User::_getUsuario($request->email);
        // dd($user);
        if ($user != '' && Hash::check($request->password, $user->password )) {
            Auth::login($user);
            // session()->put(['nombre' => $user->nombre]);
            // session()->put(['apellido' => $user->apellido]);
            // session()->put(['email' => $user->email]);
            // session()->put(['name' => $user->name]);
            // session()->put(['tipo' => $user->tipo]);
            // session()->put(['estado' => $user->estado]);
            // session()->put(['id_centro_medico' => $user->id_centro_medico]);

            return Redirect::to('dashboard');    
        }
        return back()->withErrors(['codigo' => Session::get('error-login')])
                ->withInput(request(['codigo']));
        // return $request->all();
        return Redirect::to('dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
