<?php

namespace App\Http\Controllers\api;

use App\Functions\VendasClasseFunc;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class VendasClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //verifica a validação dos campos ******************************************
        $validator = \Validator::make($request->all(), [
            'cnpj_empresa'    => 'bail|numeric|required',
            'codigo_classe'   => 'bail|numeric',
            'ano'             => 'bail|integer|min_digits:4|max_digits:4',
            'mes'             => 'bail|numeric|min_digits:1|max_digits:2',
            'dia'             => 'bail|date|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //***************************************************************************************

        $totVendaFunc = new VendasClasseFunc();

        if(isset($request['ano'])){
            if(isset($request['mes'])){
                //get ano mes
                $totalVendas = $totVendaFunc->GetMes($request);
            }else{
                //get ano
                $totalVendas = $totVendaFunc->GetAno($request);
            }
        }else{
            if(isset($request['dia'])){
                //get dia
                $totalVendas = $totVendaFunc->GetDia($request);
            }else{
                return fg_response(false, [], 'Nenhuma opção de data informada', 400);
            }
        }

        return fg_response(true, $totalVendas->toarray(), 'OK', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'codigo_classe'       => 'bail|required|numeric',
            'nome_classe'         => 'bail|required',
            'cnpj_empresa'        => 'bail|required|numeric',
            'ano'                 => 'bail|required|integer|min_digits:4|max_digits:4',
            'mes'                 => 'bail|required|numeric|min_digits:1|max_digits:2',
            'data'                => 'bail|required|date_format:d/m/Y',

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

        $totVendaFunc = new VendasClasseFunc();

        //verifica se o registro daquele dia ja existe
        if ($totVendaFunc->CheckRegExists($request)){
            return fg_response(false, [], 'Registro para esse dia ja existe. Use PUT para alterar', 400);
        }

        if ($ret = VendasClasse::create($request->all())) {
            return fg_response(true, $ret->toarray(), 'OK', 200);
        } else {
            return fg_response(false, [], 'Erro interno ao criar', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ( (is_numeric($id) == true) && ($venda = VendasClasse::find($id)) ) {
            return fg_response(true, $venda->toarray(), 'OK', 200);
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
            'codigo_classe'       => 'bail|numeric',
            'nome_classe'         => 'bail|required',
            'cnpj_empresa'        => 'bail|numeric',
            'ano'                 => 'bail|integer|min_digits:4|max_digits:4',
            'mes'                 => 'bail|numeric|min_digits:1|max_digits:2',
            'data'                => 'bail|date_format:d/m/Y',

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

        if ( (is_numeric($id) == true) && ($venda = VendasClasse::find($id)) ) {
            if ($venda->update($request->all()) ) {
                return fg_response(true, $venda->toarray(), 'OK', 200);
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
        if ( (is_numeric($id) == true) && ($venda = VendasClasse::find($id)) ) {
            if ($venda->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
