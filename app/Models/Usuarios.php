<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuarios extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios';

    protected $fillable = [
        'id',

        'cnpj_empresa',
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
    ];

    use HasFactory;

    protected $hidden = ['password' ];

    public function empresa(): HasOne{
        return $this->hasOne(Empresas::class, 'cnpj', 'cnpj_empresa');
    }

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