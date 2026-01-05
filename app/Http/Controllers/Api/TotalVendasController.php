<?php

namespace App\Http\Controllers\Api;

use App\Functions\TotalVendasFunction;
use App\Http\Controllers\Controller;
use App\Models\TotalVendas;
use Illuminate\Http\Request;



class TotalVendasController extends Controller
{
    /**
     *
     * @OA\Get(
     *     path="/api/total-vendas",
     *     summary="Retorna a lista de registro de vendas por periodo",
     *     description="Retorna a lista de registro de vendas por periodo, usando como parametro de pesquisa o cnpj_empresa / ano / mes / dia ",
     *     tags={"TotalVendas"},
     *     operationId="totVendIndex",
     * @OA\Parameter(
     *    name="cnpj_empresa",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Cnpj da empresa ao qual o registro pertence - orbigatorio",
     *    required=true,
     * ),
     * @OA\Parameter(
     *    name="ano",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="mes",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando o campo |Ano| tambem esta preenchido",
     *    required=false,
     * ),
     * @OA\Parameter(
     *    name="dia",
     *    in="query",
     *    @OA\Schema(
     *      type="string"
     *    ),
     *    description="Usado para pesquisa quando somente este campos esta preenchido",
     *    required=false,
     * ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna a lista de registros",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/TotalVendasWithDate"
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
            'cnpj_empresa'  => 'bail|numeric|required',
            'ano'           => 'bail|integer|min_digits:4|max_digits:4',
            'mes'           => 'bail|numeric|min_digits:1|max_digits:2',
            'dia'           => 'bail|date|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //***************************************************************************************


        $totVendaFunc = new TotalVendasFunction();

        $totalVendas = $totVendaFunc->GetTotalVendas($request);

        return fg_response(true, $totalVendas->toarray(), 'OK', 200);
    }


    /**
     *
     * @OA\Post(
     *     path="/api/total-vendas",
     *     summary="Insere o registro no sistema",
     *     description="",
     *     tags={"TotalVendas"},
     *     operationId="totVendStore",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Request Body Description",
     *         @OA\JsonContent(
     *              allOf={
     *                @OA\Schema(ref="#/components/schemas/TotalVendas"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *        response=200 ,
     *        description="Retorna registro inserido",
     *        @OA\JsonContent(
     *            ref="#/components/schemas/TotalVendasWithDate"
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
            'ano'            => 'bail|required|integer|min_digits:4|max_digits:4',
            'mes'            => 'bail|required|numeric|min_digits:1|max_digits:2',
            'data'           => 'bail|required|date_format:d/m/Y',
            'cnpj_empresa'   => 'bail|required|numeric',

            'vendas_quant'        => 'numeric',
            'vendas_bruto'        => 'numeric',
            'vendas_desconto'     => 'numeric',
            'vendas_liquido'      => 'numeric',
            'itens_por_venda'     => 'numeric',
            'itens_dif_venda'     => 'numeric',
            'itens_quant_vendas'  => 'numeric',
            'devolucoes_quant'    => 'numeric',
            'devolucoes_valor'    => 'numeric',
            'devolucoes_taxa'     => 'numeric',
            'faturado_produto'    => 'numeric',
            'faturado_servico'    => 'numeric',
            'faturado_total'      => 'numeric',
            'faturado_cmv'        => 'numeric',
            'desp_var'            => 'numeric',
            'desp_fixo'           => 'numeric',
            'margem_contrib'      => 'numeric',
            'margem_contrib_perc' => 'numeric',
            'lucro_bruto'         => 'numeric',
            'margem_bruta'        => 'numeric',
            'lucro_estimado'      => 'numeric',
            'lucro_pe'            => 'numeric',
            'ticket_medio'        => 'numeric',
            'tpag_dinh'           => 'numeric',
            'tpag_cheq'           => 'numeric',
            'tpag_boleto'         => 'numeric',
            'tpag_c_cred'         => 'numeric',
            'tpag_c_deb'          => 'numeric',
            'tpag_crediario'      => 'numeric',
            'tpag_vale'           => 'numeric',
            'tpag_depcc'          => 'numeric',
            'tpag_pix'            => 'numeric',
            'estoque_medio'       => 'numeric',
            'dav_incluidos'       => 'numeric',
            'dav_perdidos'        => 'numeric',
            'dav_perdidos_valor'  => 'numeric',
            'dav_faturados'       => 'numeric',
            'dav_faturados_valor' => 'numeric',
            'dav_taxa_conver'     => 'numeric',

        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        $totVendaFunc = new TotalVendasFunction();

        //verifica se o registro daquele dia ja existe
        if ($totVendaFunc->CheckRegExists($request)){
            return fg_response(false, [], 'Registro para esse dia ja existe. Use PUT para alterar', 400);
        }

        if ($ret = TotalVendas::create($request->all())) {
            return fg_response(true, $ret->toarray(), 'OK', 200);
        } else {
            return fg_response(false, [], 'Erro interno ao criar', 500);
        }

    }

    /**
     *
     * @OA\Get(
     *     path="/api/total-vendas/{id}",
     *     summary="Retorna o registro",
     *     description="Retorna o registro, usando como parametro o id",
     *     tags={"TotalVendas"},
     *     operationId="totVendShow",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *  ),
     * @OA\Response(
     *    response=200 ,
     *    description="Retorna o registro",
     *    @OA\JsonContent(
     *        ref="#/components/schemas/TotalVendasWithDate"
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
        $totVendaFunc = new TotalVendasFunction();

        if ( (is_numeric($id) == true) && ($totalVendas = $totVendaFunc->GetID($id)) ) {
            return fg_response(true, $totalVendas->toarray(), 'OK', 200);
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }

    }

    /**
     *
     * @OA\Put(
     *     path="/api/total-vendas/{id}",
     *     summary="Edita o registro",
     *     description="Edita o registro selecionado, usando como parametro o id",
     *     tags={"TotalVendas"},
     *     operationId="totVendUpdate",
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
     *                @OA\Schema(ref="#/components/schemas/TotalVendas"),
     *                },
     *         )
     *     ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Retorna o registro alterado",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/TotalVendasWithDate",
     *         )
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Registro nao encontrado"
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
            'cnpj_empresa'   => 'bail|numeric',
            'ano'            => 'bail|integer|min_digits:4|max_digits:4',
            'mes'            => 'bail|numeric|min_digits:1|max_digits:2',
            'data'           => 'bail|date_format:d/m/Y',

            'vendas_quant'        => 'numeric',
            'vendas_bruto'        => 'numeric',
            'vendas_desconto'     => 'numeric',
            'vendas_liquido'      => 'numeric',
            'itens_por_venda'     => 'numeric',
            'itens_dif_venda'     => 'numeric',
            'itens_quant_vendas'  => 'numeric',
            'devolucoes_quant'    => 'numeric',
            'devolucoes_valor'    => 'numeric',
            'devolucoes_taxa'     => 'numeric',
            'faturado_produto'    => 'numeric',
            'faturado_servico'    => 'numeric',
            'faturado_total'      => 'numeric',
            'faturado_cmv'        => 'numeric',
            'desp_var'            => 'numeric',
            'desp_fixo'           => 'numeric',
            'margem_contrib'      => 'numeric',
            'margem_contrib_perc' => 'numeric',
            'lucro_bruto'         => 'numeric',
            'margem_bruta'        => 'numeric',
            'lucro_estimado'      => 'numeric',
            'lucro_pe'            => 'numeric',
            'ticket_medio'        => 'numeric',
            'tpag_dinh'           => 'numeric',
            'tpag_cheq'           => 'numeric',
            'tpag_boleto'         => 'numeric',
            'tpag_c_cred'         => 'numeric',
            'tpag_c_deb'          => 'numeric',
            'tpag_crediario'      => 'numeric',
            'tpag_vale'           => 'numeric',
            'tpag_depcc'          => 'numeric',
            'tpag_pix'            => 'numeric',
            'estoque_medio'       => 'numeric',
            'dav_incluidos'       => 'numeric',
            'dav_perdidos'        => 'numeric',
            'dav_perdidos_valor'  => 'numeric',
            'dav_faturados'       => 'numeric',
            'dav_faturados_valor' => 'numeric',
            'dav_taxa_conver'     => 'numeric',

        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        if ( (is_numeric($id) == true) && ($totalVendas = TotalVendas::find($id)) ) {
            if ($totalVendas->update($request->all()) ) {
                return fg_response(true, $totalVendas->toarray(), 'OK', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }

    }

    /**
     *
     * @OA\Delete(
     *     path="/api/total-vendas/{id}",
     *     summary="Remove o registro",
     *     description="Remove o registro selecionado, usando como parametro o id",
     *     tags={"TotalVendas"},
     *     operationId="totVendDestroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Registro excluido com sucesso",
     *     ),
     *    @OA\Response(
     *         response=404 ,
     *         description="Registro nao encontrado"
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
        if ( (is_numeric($id) == true) && ($totalVendas = TotalVendas::find($id)) ) {
            if ($totalVendas->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
