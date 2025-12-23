<?php

namespace App\Http\Controllers\api;

use App\Functions\UsuariosFunction;
use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;



class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //verifica a validação dos campos ******************************************
        $validator = \Validator::make($request->all(), [
            'cnpj_empresa' => 'numeric',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        $userFunc = new UsuariosFunction();

        $usuarios = $userFunc->AllUser($request);

        return fg_response(true, $usuarios, 'OK', 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'cnpj_empresa'       => 'bail|required|numeric',
            'codigo_usuario'     => 'bail|required|numeric',
            'codigo_vendedor'    => 'numeric',
            'nome'               => 'bail|required|min:3',
            'email'              => 'bail|required|email',
            'password'           => 'bail|required|min:4',
            'senha_transacao'    => 'bail|required|min:4',
            //'ultimo_login'       => 'bail|required',
            'gerente'            => ['bail','required','regex:/^(S|N)$/i'],
            'vendedor'           => ['bail','required','regex:/^(S|N)$/i'],
            'recebe_notificacao' => ['bail','required','regex:/^(S|N)$/i'],
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        $userFunc = new UsuariosFunction();

        //verifica se o usuario ja existe
        if($userFunc->CheckUserExists($request['email'])){
            return fg_response(false, [], 'Email de usuário ja cadastrado', 400);
        }

        $request['password'] = bcrypt($request['password']);

        //cria o usuario
        if ($ret = Usuarios::create($request->all())) {
            return fg_response(true, $ret->toarray(), '', 200);
        } else {
            return fg_response(false, [], 'Erro interno ao criar', 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ( (is_numeric($id) == true) && ($usuario = Usuarios::where('id',$id)->with('empresa')->get()) ) {
            return fg_response(true, $usuario->toarray(), 'OK', 200);
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'cnpj_empresa'       => 'numeric',
            'codigo_usuario'     => 'numeric',
            'codigo_vendedor'    => 'numeric',
            'nome'               => 'min:3',
            'email'              => 'email',
            'password'           => 'min:4',
            'senha_transacao'    => 'min:4',
            //'ultimo_login'       => 'bail|required',
            'gerente'            => ['regex:/^(S|N)$/i'],
            'vendedor'           => ['regex:/^(S|N)$/i'],
            'recebe_notificacao' => ['regex:/^(S|N)$/i'],
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        if ( (is_numeric($id) == true) && ($usuario = Usuarios::find($id)) ) {
            if ($usuario->update($request->all()) ) {
                return fg_response(true, $usuario->toarray(), 'OK', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ( (is_numeric($id) == true) && ($usuario = Usuarios::find($id)) ) {
            if ($usuario->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
