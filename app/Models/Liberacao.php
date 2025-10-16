<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liberacao extends Model
{
    protected $table = 'liberacao';

    protected $fillable = [
        'id',
        'numero_venda',
        'codigo_vendedor',
        'cliente_numero',
        'cliente_razao',
        'cliente_fantasia',
        'venda_total',
        'motivo_liberacao',
        'usuario_liberou',
        'obs_liberacao',


    ];

    use HasFactory;
}
