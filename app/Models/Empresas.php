<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *    schema="Empresas",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="ID da empresa",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="cnpj",
 *        type="string",
 *        description="Cnpj da empresa",
 *        nullable=false,
 *        example="39311444000183"
 *    ),
 *    @OA\Property(
 *        property="razao",
 *        type="string",
 *        description="Razao social da empresa",
 *        nullable=false,
 *        example="Wage Sistemas e Automacao"
 *    ),
 *    @OA\Property(
 *        property="fantasia",
 *        type="string",
 *        description="Nome fantasia da empresa",
 *        nullable=false,
 *        example="Wage Sistemas"
 *    ),
 * )
 *
 *
 *
 *  * @OA\Schema(
 *    schema="EmpresasWithDate",
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="ID da empresa",
 *        nullable=false,
 *        example="1"
 *    ),
 *    @OA\Property(
 *        property="cnpj",
 *        type="string",
 *        description="Cnpj da empresa",
 *        nullable=false,
 *        example="39311444000183"
 *    ),
 *    @OA\Property(
 *        property="razao",
 *        type="string",
 *        description="Razao social da empresa",
 *        nullable=false,
 *        example="Wage Sistemas e Automacao"
 *    ),
 *    @OA\Property(
 *        property="fantasia",
 *        type="string",
 *        description="Nome fantasia da empresa",
 *        nullable=false,
 *        example="Wage Sistemas"
 *    ),
 *    @OA\Property(
 *        property="created_at",
 *        type="string",
 *        description="Data da criacao da empresa",
 *        nullable=true,
 *        format="date-time"
 *    ),
 *    @OA\Property(
 *        property="updated_at",
 *        type="string",
 *        description="Data da ultima alteracao da empresa",
 *        nullable=true,
 *        format="date-time"
 *    ),
 * )
 */

class Empresas extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'id',
        'cnpj',
        'razao',
        'fantasia',
    ];

    use HasFactory;
}
