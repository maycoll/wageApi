<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class apiProtectedRoute extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $user = JWTAuth::parseToken()->authenticate();
        }catch (\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                //return response()->json(['status','Token inv�lido'], 401);
                return fg_response(false,[],'Token invalido',401);
            }else{
                if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    //return response()->json(['status','Token expirado'], 401);
                    return fg_response(false,[],'Token expirado',401);
                }else{
                    //return response()->json(['status','Token n�o encontrado'], 401);
                    return fg_response(false, [], 'Token nao encontrado',401);

                }
            }
        }

        return $next($request);
    }
}
