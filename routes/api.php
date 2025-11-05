<?php

use App\Http\Controllers\api\EmpresasController;
use App\Http\Controllers\api\LiberacaoController;
use App\Http\Controllers\Api\TotalVendasDiaController;
use App\Http\Controllers\api\UsuariosController;
use App\Http\Controllers\api\VendasVendedorController;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});





Route::post('auth/login', 'App\Http\Controllers\Api\AuthController@login');

Route::group(['middleware' =>['apiJwt']],
    function() {

        Route::post('auth/logout', 'App\Http\Controllers\Api\AuthController@logout');
        Route::get('auth/me', 'App\Http\Controllers\Api\AuthController@me');

        Route::apiResource('empresas', EmpresasController::class);
        Route::apiResource('usuarios', UsuariosController::class);
        Route::apiResource('total-vendas-dia', TotalVendasDiaController::class);
        Route::apiResource('vendas-vendedor', VendasVendedorController::class);
        Route::apiResource('liberacao', LiberacaoController::class);


    }
);


