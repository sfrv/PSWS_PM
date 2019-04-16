<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class WelcomeController extends Controller
{
    public function index()
    {
    	$usuarios = User::_getAdministrador()->get();
    	return view('welcome',compact('usuarios'));
    }
}
