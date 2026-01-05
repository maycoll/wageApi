<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *    schema="Usuarios",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="ID do usuario",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="codigo_usuario",
 *        type="integer",
 *        description="Codigo do usuario no alfa",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="codigo_vendedor",
 *        type="integer",
 *        description="Codigo do vendedor no alfa",
 *        nullable=true,
 *        example="2"
 *    ),
 *    @OA\Property(
 *        property="nome",
 *        type="string",
 *        description="Nome usuario no alfa",
 *        nullable=false,
 *        example="Usuario Teste"
 *    ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Email usado para realizar login",
 *        nullable=false,
 *        example="teste@teste.com"
 *    ),
 *    @OA\Property(
 *        property="password",
 *        type="string",
 *        description="Senha de acesso a api",
 *        nullable=false,
 *        example="123456"
 *    ),
 *    @OA\Property(
 *        property="senha_transacao",
 *        type="string",
 *        description="Senha usada para transacoes na api, como liberacao remota",
 *        nullable=true,
 *        example="654321"
 *    ),
 *    @OA\Property(
 *        property="ultimo_login",
 *        type="string",
 *        description="Data do ultimo login no sistema",
 *        nullable=true,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="gerente",
 *        type="string",
 *        description="Indica se o usuario e gerente",
 *        nullable=true,
 *        example="N"
 *    ),
 *    @OA\Property(
 *        property="vendedor",
 *        type="string",
 *        description="Indica se o usuario e vendedor",
 *        nullable=true,
 *        example="S"
 *    ),
 *    @OA\Property(
 *        property="recebe_notificacao",
 *        type="string",
 *        description="Indica se o usuario ira receber notificacao",
 *        nullable=true,
 *        example="N"
 *    ),
 * )
 *
 *
 * * @OA\Schema(
 *    schema="UsuariosWithDate",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="ID do usuario",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="codigo_usuario",
 *        type="integer",
 *        description="Codigo do usuario no alfa",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="codigo_vendedor",
 *        type="integer",
 *        description="Codigo do vendedor no alfa",
 *        nullable=true,
 *        example="2"
 *    ),
 *    @OA\Property(
 *        property="nome",
 *        type="string",
 *        description="Nome usuario no alfa",
 *        nullable=false,
 *        example="Usuario Teste"
 *    ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Email usado para realizar login",
 *        nullable=false,
 *        example="teste@teste.com"
 *    ),
 *    @OA\Property(
 *        property="password",
 *        type="string",
 *        description="Senha de acesso a api",
 *        nullable=false,
 *        example="123456"
 *    ),
 *    @OA\Property(
 *        property="senha_transacao",
 *        type="string",
 *        description="Senha usada para transacoes na api, como liberacao remota",
 *        nullable=true,
 *        example="654321"
 *    ),
 *    @OA\Property(
 *        property="ultimo_login",
 *        type="string",
 *        description="Data do ultimo login no sistema",
 *        nullable=true,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="gerente",
 *        type="string",
 *        description="Indica se o usuario e gerente",
 *        nullable=true,
 *        example="N"
 *    ),
 *    @OA\Property(
 *        property="vendedor",
 *        type="string",
 *        description="Indica se o usuario e vendedor",
 *        nullable=true,
 *        example="S"
 *    ),
 *    @OA\Property(
 *        property="recebe_notificacao",
 *        type="string",
 *        description="Indica se o usuario ira receber notificacao",
 *        nullable=true,
 *        example="N"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Data da criacao da empresa",
 *        nullable=false,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Data da ultima alteracao da empresa",
 *        nullable=false,
 *        format="date-time"
 *    ),
 * )
 *
 */

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

    protected $hidden = [
        'password',
        'senha_transacao',
    ];



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