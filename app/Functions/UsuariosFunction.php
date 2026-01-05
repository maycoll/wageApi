<?php

namespace App\Functions;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

/**
 * Created by PhpStorm.
 * User: maycoll
 * Date: 18/12/2025
 * Time: 13:59
 */
class UsuariosFunction
{
    public function CheckUserExists(String $email){
        return ($usuario = Usuarios::where('email', $email)->first()) ;
    }

    public function GetUsuarios(Request $request){

        if(isset($request['email'])){
            $usuarios = $this->GetEmail($request);
        }else{
            if(isset($request['nome'])){
                $usuarios = $this->GetNome($request);
            }else{
                if(isset($request['codigo_usuario'])){
                    $usuarios = $this->GetCodigoUsuario($request);
                }else{
                    $usuarios = $this->AllUser($request);
                }
            }
        }
        return $usuarios;
    }

    public function GetID(string $id){

        $user = Usuarios::where('id', $id)
                        ->with('empresa')
                        ->get();

        return $user;

    }

    public function AllUser(Request $request){

        $usuarios = Usuarios::where('cnpj_empresa',$request['cnpj_empresa'])
                            ->with('empresa')
                            ->get();

        return $usuarios;
    }


    public function GetEmail(Request $request){

        $usuario = Usuarios::where('email', $request['email'])
                            ->where('cnpj_empresa',$request['cnpj_empresa'])
                            ->with('empresa')
                            ->get() ;

        return $usuario;
    }

    public function GetNome(Request $request){

        $like = "'%%'";

        if(isset($request['nome'])){
            $like = "upper('".$request['nome']."%')";
        }

        $user = Usuarios::where('cnpj_empresa',$request['cnpj_empresa'])
                        ->whereRaw('upper(nome) like '.$like)
                        ->with('empresa')
                        ->get() ;


        return $user;

    }

    public function GetCodigoUsuario(Request $request){

        $user = Usuarios::where('cnpj_empresa',$request['cnpj_empresa'])
                        ->where('codigo_usuario', $request['codigo_usuario'])
                        ->with('empresa')
                        ->get();

        return $user;

    }




}