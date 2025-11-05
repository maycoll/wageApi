<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';

    protected $fillable = [
        'id',
        'codigo_usuario',
        'codigo_vendedor',
        'nome',
        'email',
        'password',
        'senha_transacao',
        'ultimo_login',
        'gerente',
        'vendedor',
        'recebe_notificacao',
        'ultima_notificaca'
    ];

    use HasFactory;

    protected $hidden = ['password' ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        $empresa = Empresas::find(1);
        return ["cnpj" => $empresa->cnpj ];
        //return [];
    }

    //--------------------------------------


}