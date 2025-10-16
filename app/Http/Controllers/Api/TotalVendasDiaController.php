<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TotalVendas;
use Illuminate\Http\Request;


class TotalVendasDiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'mes' => 'bail|required|numeric|min_digits:1|max_digits:2',
            'ano' => 'bail|required|integer|min_digits:4|max_digits:4',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //***************************************************************************************

        $totalVendas = TotalVendas::where('ano',$request['ano'])->where('mes',$request['mes'])->get();

        return fg_response(true, $totalVendas->toarray(), 'OK', 200);
    }


    public function store(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'mes'            => 'bail|required|numeric|min_digits:1|max_digits:2',
            'ano'            => 'bail|required|integer|min_digits:4|max_digits:4',
            'data'           => 'bail|required|date_format:d/m/Y',
            'vendido_bruto'  => 'bail|required|numeric',
            'desconto'       => 'bail|required|numeric',
            'vendido_liquido'=> 'bail|required|numeric',
            'devolucao'      => 'bail|required|numeric',
            'lucro'          => 'bail|required|numeric',
            'cmv'            => 'bail|required|numeric',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        //verifica se o registro daquele dia ja existe
        if ($totVendas = TotalVendas::whereRaw("date(data) = '".$request['data']."'")->first()){
            return fg_response(false, $totVendas->toarray(), 'Registro para esse dia ja existe. Use PUT para alterar', 400);
        }

        if ($ret = TotalVendas::create($request->all())) {
            return fg_response(true, $ret->toarray(), 'OK', 200);
        } else {
            return fg_response(false, [], 'Erro interno ao criar', 500);
        }

    }


    public function show(string $id)
    {
        if ( (is_numeric($id) == true) && ($totalVendas = TotalVendas::find($id)) ) {
            return fg_response(true, $totalVendas->toarray(), 'OK', 200);
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
            'mes'            => 'integer|min_digits:1|max_digits:2',
            'ano'            => 'integer|min_digits:4|max_digits:4',
            'data'           => 'date_format:d/m/Y',
            'vendido_bruto'  => 'numeric',
            'desconto'       => 'numeric',
            'vendido_liquido'=> 'numeric',
            'devolucao'      => 'numeric',
            'lucro'          => 'numeric',
            'cmv'            => 'numeric',
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
     * Remove the specified resource from storage.
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
