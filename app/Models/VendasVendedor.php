<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendasVendedor extends Model
{
    protected $table = 'vendas_vendedor';

    protected $fillable = [
        'id',
        'codigo_vendedor',
        'data',
        'mes',
        'ano',
        'vendido_bruto',
        'desconto',
        'vendido_liquido',
        'devolucao',
        'lucro',
        'cmv',
        'meta',
    ];

    use HasFactory;
}
