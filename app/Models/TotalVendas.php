<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalVendas extends Model
{
    protected $table = 'total_vendas';

    protected $fillable = [
        'id',
        'data',
        'mes',
        'ano',
        'vendido_bruto',
        'desconto',
        'vendido_liquido',
        'devolucao',
        'lucro',
        'cmv'
    ];

    use HasFactory;
}
