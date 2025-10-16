<?php

namespace Database\Factories;

use App\Models\Liberacao;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Liberacao>
 */
class LiberacaoFactory extends Factory
{
    protected $model = Liberacao::class;

    public function definition(): array
    {

        return [
            'numero_venda'     => '101'.$this->faker->numerify('#'),
            'codigo_vendedor'  => $this->faker->numerify('##'),
            'cliente_numero'   => $this->faker->numerify('####'),
            'cliente_razao'    => 'Razao do Cliente'.Str::random(2),
            'cliente_fantasia' => 'Fantasia do Cliente'.Str::random(2),
            'venda_total'      => $this->faker->randomFloat(2,80000.0,90000.0),
            'motivo_liberacao' => 'Texto com o motivo de requisicao de liberacao de venda remota',
        ];
    }
}
