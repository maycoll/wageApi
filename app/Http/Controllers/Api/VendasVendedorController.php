<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\VendasVendedor;
use Illuminate\Http\Request;

class VendasVendedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'codigo_vendedor' => 'bail|required|numeric',
            'mes' => 'bail|required|numeric|min_digits:1|max_digits:2',
            'ano' => 'bail|required|integer|min_digits:4|max_digits:4',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //***************************************************************************************

        $vendas = VendasVendedor::where('ano',$request['ano'])
                                ->where('mes',$request['mes'])
                                ->where('codigo_vendedor',$request['codigo_vendedor'])
                                ->get();

        return fg_response(true, $vendas->toarray(), 'OK', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'codigo_vendedor' => 'bail|required|numeric',
            'mes'             => 'bail|required|numeric|min_digits:1|max_digits:2',
            'ano'             => 'bail|required|integer|min_digits:4|max_digits:4',
            'data'            => 'bail|required|date_format:d/m/Y',
            'vendido_bruto'   => 'bail|required|numeric',
            'desconto'        => 'bail|required|numeric',
            'vendido_liquido' => 'bail|required|numeric',
            'devolucao'       => 'bail|required|numeric',
            'lucro'           => 'bail|required|numeric',
            'cmv'             => 'bail|required|numeric',
            'meta'            => 'numeric',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        //verifica se o registro daquele dia ja existe
        if ($venda = VendasVendedor::whereRaw("date(data) = '".$request['data']."' and codigo_vendedor = ".$request['codigo_vendedor'])->first()){
            return fg_response(false, $venda->toarray(), 'Registro para esse dia ja existe. Use PUT para alterar', 400);
        }

        if ($ret = VendasVendedor::create($request->all())) {
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
        if ( (is_numeric($id) == true) && ($venda = VendasVendedor::find($id)) ) {
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
            'codigo_vendedor' => 'numeric',
            'mes'             => 'numeric|min_digits:1|max_digits:2',
            'ano'             => 'integer|min_digits:4|max_digits:4',
            'data'            => 'date_format:d/m/Y',
            'vendido_bruto'   => 'numeric',
            'desconto'        => 'numeric',
            'vendido_liquido' => 'numeric',
            'devolucao'       => 'numeric',
            'lucro'           => 'numeric',
            'cmv'             => 'numeric',
            'meta'            => 'numeric',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        if ( (is_numeric($id) == true) && ($venda = VendasVendedor::find($id)) ) {
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
        if ( (is_numeric($id) == true) && ($venda = VendasVendedor::find($id)) ) {
            if ($venda->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
