<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

//        //verifica a validação dos campos ******************************************
//        $validator = \Validator::make($request->all(), [
//            'email' => 'bail|required|email',
//            'password' => 'bail|required|min:4',
//        ]);
//
//        if ($validator->fails()) {
//            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
//        }
//        //*****************************************************************


        $credentials = $request->only('email', 'password');

        $md5 = md5($credentials['password']);

        $credentials['password'] = $md5;

        //$usuario = Usuarios::where('email', $credentials['email'])->where('password', $md5)->first();

        //dd($usuario);


        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return fg_response(false, [], 'Login nao autorizado', 401);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        if ($usuario = app(UsuariosController::class)->show($this->guard()->user()->id)) {
            return $usuario;
        }else{
            return fg_response(false,[],'Usuario nao encontrado', 404);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return fg_response(true,[],'Logout realizado com sucesso',200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
