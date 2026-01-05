<?php

namespace App\Http\Controllers\api;

use App\Functions\UsuariosFunction;
use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;



class UsuariosController extends Controller
{
    /**
     *
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Retorna a lista de usuarios",
     *     description="Retorna a lista de usuarios, usando como parametro de pesquisa o cnpj_empresa / email / nome / codigo_usuario ",
     *     tags={"Usuarios"},
     *     operationId="userIndex",
     * @OA\Parameter(
     *    name="cnpj_empresa",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Cnpj da empresa ao qual o usuario pertence - orbigatorio",
     *    required=true,
     * ),
     * @OA\Parameter(
     *    name="email",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="nome",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="codigo_usuario",
     *    in="query",
     *    @OA\Schema(
     *      type="integer"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna a lista de empresas",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/UsuariosWithDate"
     *    )
     * ),
     * @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado"
     *     ),
     *   security={{ "bearer": {} }},
     * )
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

        $usuarios = $userFunc->GetUsuarios($request);

        return fg_response(true, $usuarios->toarray(), 'OK', 200);

    }

    /**
     *
     * @OA\Post(
     *     path="/api/usuarios",
     *     summary="Insere o usuario no sistema",
     *     description="",
     *     tags={"Usuarios"},
     *     operationId="userStore",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *              allOf={
     *                @OA\Schema(ref="#/components/schemas/Usuarios"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *        response=200 ,
     *        description="Retorna o usuario",
     *        @OA\JsonContent(
     *            ref="#/components/schemas/UsuariosWithDate"
     *        )
     *     ),
     *     @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado"
     *     ),
     * )
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

        if(isset($request['id'])){
            return fg_response(false, [], 'O id nao deve ser informado no body', 400);
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
     *
     * @OA\Get(
     *     path="/api/usuarios/{id}",
     *     summary="Retorna o usuario",
     *     description="Retorna ousuario, usando como parametro o id",
     *     tags={"Usuarios"},
     *     operationId="userShow",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *  ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna o usuario",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/UsuariosWithDate"
     *    )
     * ),
     * @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado"
     *     ),
     *   security={{ "bearer": {} }},
     * )
     */
    public function show(string $id)
    {
        $userFunc = new UsuariosFunction();

        if ( (is_numeric($id) == true) && ($usuario = $userFunc->GetID($id)) ) {
            return fg_response(true, $usuario->toarray(), 'OK', 200);
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     path="/api/usuario/{id}",
     *     summary="Edita o usuario",
     *     description="Edita o usuario selecionado, usando como parametro o id",
     *     tags={"Usuarios"},
     *     operationId="userUpdate",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *              allOf={
     *                @OA\Schema(ref="#/components/schemas/Usuarios"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Retorna o usuario alterado",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UsuariosWithDate",
     *         )
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Usuario nao encontrado"
     *     ),
     *     @OA\Response(
     *         response=500 ,
     *         description="Erro interno do servidor"
     *     ),
     *    security={{ "bearer": {} }},
     * )
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

        if(isset($request['id'])){
            return fg_response(false, [], 'O id nao deve ser informado no body', 400);
        }
        //*****************************************************************

        $userFunc = new UsuariosFunction();

        if ( (is_numeric($id) == true) && ($usuario = $userFunc->GetID($id)) ) {
            if ($usuario->update($request->all()) ) {
                return fg_response(true, $usuario->toarray(), 'OK', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     path="/api/usuarios/{id}",
     *     summary="Remove o usuario",
     *     description="Remove o usuario selecionado, usando como parametro o id",
     *     tags={"Usuarios"},
     *     operationId="userDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Usuario excluido com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Usuario nao encontrado"
     *     ),
     *     @OA\Response(
     *         response=500 ,
     *         description="Erro interno do servidor"
     *     ),
     *    security={{ "bearer": {} }},
     * )
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
