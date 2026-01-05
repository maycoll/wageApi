<?php

namespace App\Http\Controllers\api;

use App\Functions\EmpresasFunction;
use App\Http\Controllers\Controller;
use App\Models\Empresas;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     *
     * @OA\Get(
     *     path="/api/empresas",
     *     summary="Retorna a lista de empresas",
     *     description="Retorna a lista de empresas, usando como parametro de pesquisa o cnpj / razao / fantasia",
     *     tags={"Empresas"},
     *     operationId="empIndex",
     * @OA\Parameter(
     *    name="cnpj",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="razao",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="fantasia",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna a lista de empresas",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/EmpresasWithDate"
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
            'cnpj' => 'numeric',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        $empFunc = new EmpresasFunction();

        $emp = $empFunc->GetEmpresas($request);

        return fg_response(true, $emp->toarray(), 'OK', 200);

    }

    /**
     *
     * @OA\Post(
     *     path="/api/empresas",
     *     summary="Insere a empresa no sistema",
     *     description="",
     *     tags={"Empresas"},
     *     operationId="empStore",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *              allOf={
     *                @OA\Schema(ref="#/components/schemas/Empresas"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *        response=200 ,
     *        description="Retorna a empresas",
     *        @OA\JsonContent(
     *            ref="#/components/schemas/EmpresasWithDate"
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
            'cnpj'     => 'bail|required|numeric',
            'razao'    => 'bail|required|min:3',
            'fantasia' => 'bail|required|min:3',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }

        if(isset($request['id'])){
            return fg_response(false, [], 'O id nao deve ser informado no body', 400);
        }
        //*****************************************************************

        $empFunc = new EmpresasFunction();

        //verifica se o registro ja existe
        if($empFunc->CheckRegExists($request)){
            return fg_response(false, [], 'Dados da Empresa ja cadastrados', 400);
        }

        //cria a empresa
        if ($ret = Empresas::create($request->all())) {
            return fg_response(true, $ret->toarray(), '', 200);
        } else {
            return fg_response(false, [], 'Erro interno ao criar', 500);
        }
    }

    /**
     *
     * @OA\Get(
     *     path="/api/empresas/{id}",
     *     summary="Retorna a empresa",
     *     description="Retorna a empresa, usando como parametro o id",
     *     tags={"Empresas"},
     *     operationId="empShow",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *  ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna a empresas",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/EmpresasWithDate"
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

        if ( (is_numeric($id) == true) && ($empresa = Empresas::find($id)) ) {
            return fg_response(true, $empresa->toarray(), 'OK', 200);
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     *
     * @OA\Put(
     *     path="/api/empresas/{id}",
     *     summary="Edita a empresa",
     *     description="Edita e empresa selecionada, usando como parametro o id",
     *     tags={"Empresas"},
     *     operationId="empUpdate",
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
     *                @OA\Schema(ref="#/components/schemas/Empresas"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Retorna a empresa alterada",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/EmpresasWithDate",
     *         )
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Empresa nao encontrada"
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
            'cnpj'     => 'numeric',
            'razao'    => 'min:3',
            'fantasia' => 'min:3',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }

        if(isset($request['id'])){
            return fg_response(false, [], 'O id nao deve ser informado no body', 400);
        }

        //*****************************************************************

        if ( (is_numeric($id) == true) && ($empresa = Empresas::find($id)) ) {
            if ($empresa->update($request->all()) ) {
                return fg_response(true, $empresa->toarray(), 'OK', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }

    /**
     *
     * @OA\Delete(
     *     path="/api/empresas/{id}",
     *     summary="Remove a empresa",
     *     description="Remove e empresa selecionada, usando como parametro o id",
     *     tags={"Empresas"},
     *     operationId="empDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Empresa excluida com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Empresa nao encontrada"
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
        if ( (is_numeric($id) == true) && ($empresa = Empresas::find($id)) ) {
            if ($empresa->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
