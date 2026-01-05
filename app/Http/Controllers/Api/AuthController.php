<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Empresas;
use App\Models\Usuarios;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


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
     *
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     operationId="login",
     * @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="senha",
     *         required=true,
     *      ),
     * @OA\Parameter(
     *         name="cnpj",
     *         in="query",
     *         description="cnpj",
     *         required=true,
     *      ),
     *     @OA\Response(
     *         response=200 ,
     *         description="Retorna o usuarios logado encapsulado no payload do JWT",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Usuarios"
     *         )
     *     ),
     * *     @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado"
     *     ),
     * )
     */
    public function login(Request $request)
    {

        //verifica a validação dos campos ******************************************
        $validator = \Validator::make($request->all(), [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:4',
            'cnpj' => 'bail|required',
        ]);

        if ($validator->fails()) {
            return fg_response(false, $validator->errors()->toarray(), 'Dados invalidos', 400);
        }
        //*****************************************************************

        $schemaName = $request['cnpj'];

        DB::statement('SET search_path TO '.$schemaName);

        $schemaExists = DB::selectOne("SELECT EXISTS(SELECT 1 FROM pg_namespace WHERE nspname = ?)", [$schemaName])->exists;

        if ( (!$schemaExists) || ($schemaName == 'public')) {
            return fg_response(false, [], 'Login nao autorizado', 401);
        }



        $credentials = $request->only('email', 'password');
        $md5 = md5($credentials['password']);
        $credentials['password'] = $md5;

        //$usuario = Usuarios::where('email', $credentials['email'])->first();
        //dd($usuario);


        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return fg_response(false, [], 'Login nao autorizado', 401);

    }

    /**
     *
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Auth"},
     *     operationId="me",
     *     @OA\Response(
     *         response=200 ,
     *         description="Retorna o usuarios logado",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Usuarios"
     *         )
     *     ),
     * *     @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado",
     *     ),
     *   security={{ "bearer": {} }},
     * )
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
     *
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     operationId="logout",
     *     @OA\Response(
     *         response=200 ,
     *         description="Realiza ou logout do usuario",
     *     ),
     *     @OA\Response(
     *         response=401 ,
     *         description="login nao autorizado"
     *     ),
     *   security={{ "bearer": {} }},
     * )
     *
     */
    public function logout()
    {

        $guard = $this->guard();

        if ( isset($guard)) {
            auth()->logout();

            return fg_response(true, [], 'Logout realizado com sucesso', 200);
        }
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
        $userLogado = Usuarios::where('id', Auth::id())->first(['id', 'nome', 'email','codigo_usuario','codigo_vendedor']);

//        return response()->json([
//            'access_token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60,
//            'usuario' => $userLogado
//        ]);

        return fg_response(true,
            [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'usuario' => $userLogado
            ],
            'Usuario logado', 200);

    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
