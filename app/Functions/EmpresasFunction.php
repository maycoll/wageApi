<?php
namespace App\Functions;

use App\Models\Empresas;
use App\Models\VendasClasse;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: maycoll
 * Date: 18/12/2025
 * Time: 17:20
 */
class EmpresasFunction
{
    public function CheckRegExists(Request $request){

       if ($emp = Empresas::where('cnpj', $request['cnpj'])->first()){
           return true; //caso ja exista
       }else{
           return ($emp = Empresas::whereRae("upper(cnpj) = '".$request['fantasia']."'")->first());
       }
    }

    public function GetEmpresas(Request $request){

        if(isset($request['cnpj'])){
            $emp = $this->getCnpj($request);
        }else {
            if(isset($request['razao'])){
                $emp = $this->getRazao($request);
            }else{
                if(isset($request['fantasia'])) {
                    $emp = $this->getFantasia($request);
                }else{
                    $emp = Empresas::all();
                }
            }
        }
    }


    public function GetCnpj(Request $request){

        $emp = Empresas::where('cnpj', $request['cnpj'])->get();

        return $emp;

    }

    public function GetRazao(Request $request){

        $like = "'%%'";

        if(isset($request['razao'])){
            $like = "upper('".$request['razao']."%')";
        }

        $emp = Empresas::whereRaw('upper(razao) like '.$like)->get();

        return $emp;

    }

    public function GetFantasia(Request $request){
        $like = "'%%'";

        if(isset($request['fantasia'])){
            $like = "upper('".$request['fantasia']."%')";
        }

        $emp = Empresas::whereRaw('upper(fantasia) like '.$like)->get();

        return $emp;

    }
}