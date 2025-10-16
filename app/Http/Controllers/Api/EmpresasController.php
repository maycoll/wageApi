<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(isset($request['cnpj'])){
            if($empresas = Empresas::where('cnpj',$request['cnpj'])->get()){
                return fg_response(true, $empresas->toarray(), 'OK', 200);
            }else{
                return fg_response(false, [], 'Registro nao encontrado', 400);
            }
        }else {
            $empresas = Empresas::all();
            return fg_response(true, $empresas->toarray(), 'OK', 200);

        }

        //return fg_response(false, [], 'ERRO', 403);
    }

    /**
     * Store a newly created resource in storage.
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
        //*****************************************************************

        //verifica se o registro ja existe
        if($empresa = Empresas::where('cnpj',$request['cnpj'])->first()){
            return fg_response(false, $empresa->toarray(), 'Cnpj de empresa ja cadastrado', 400);
        }

        //cria a empresa
        if ($ret = Empresas::create($request->all())) {
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
        //return fg_response(false, [], 'ERRO', 403);

        if ( (is_numeric($id) == true) && ($empresa = Empresas::find($id)) ) {
            return fg_response(true, $empresa->toarray(), 'OK', 200);
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
            'cnpj'     => 'numeric',
            'razao'    => 'min:3',
            'fantasia' => 'min:3',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
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
     * Remove the specified resource from storage.
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
