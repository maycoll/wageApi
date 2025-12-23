<?php

namespace App\Functions;

use App\Models\Usuarios;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: maycoll
 * Date: 18/12/2025
 * Time: 13:59
 */
class UsuariosFunction
{
    public function AllUser(Request $request){
        $usuarios = Usuarios::with('empresa')->get();
        return $usuarios->toArray();
    }

    public function CheckUserExists(String $email){
        return ($usuario = Usuarios::where('email', $email)->first()) ;
    }

}