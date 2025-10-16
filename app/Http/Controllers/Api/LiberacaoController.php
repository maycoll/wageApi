<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Liberacao;
use Illuminate\Http\Request;

class LiberacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'pendentes' => ['regex:/^(S|N)$/i'],
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        if(isset($request['pendentes'])){
            if($request['pendentes'] == 'S'){
                $libera = Liberacao::whereRaw('usuario_liberou is null')->get();
            }else{
                $libera = Liberacao::whereRaw('usuario_liberou is not null')->get();
            }
        }else {
            $libera = Liberacao::all();
        }

        return fg_response(true, $libera->toarray(), 'OK', 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //verifica a validação dos campos ******************************************

        $validator = \Validator::make($request->all(), [
            'numero_venda'     => 'bail|required|numeric',
            'codigo_vendedor'  => 'bail|required|numeric',
            'cliente_numero'   => 'bail|required|numeric',
            'cliente_razao'    => 'bail|required|min:3',
            'cliente_fantasia' => 'bail|required|min:3',
            'venda_total'      => 'bail|required|numeric',
            'motivo_liberacao' => 'bail|required|min:3',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        //cria o registro
        if ($ret = Liberacao::create($request->all())) {
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
        if ( (is_numeric($id) == true) && ($libera = Liberacao::find($id)) ) {
            return fg_response(true, $libera->toarray(), 'OK', 200);
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
            'numero_venda'     => 'numeric',
            'codigo_vendedor'  => 'numeric',
            'cliente_numero'   => 'numeric',
            'cliente_razao'    => 'min:3',
            'cliente_fantasia' => 'min:3',
            'venda_total'      => 'numeric',
            'motivo_liberacao' => 'min:3',
            'usuario_liberou'  => 'numeric',
            //'obs_liberacao'    => 'min:3',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        if ( (is_numeric($id) == true) && ($libera = Liberacao::find($id)) ) {
            if ($libera->update($request->all()) ) {
                return fg_response(true, $libera->toarray(), 'OK', 200);
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
        if ( (is_numeric($id) == true) && ($libera = Liberacao::find($id)) ) {
            if ($libera->delete() ) {
                return fg_response(true, [], 'Registro * '.$id.' * removido', 200);
            }
        }else{
            return fg_response(false, [], 'Registro nao encontrado', 400);
        }
    }
}
