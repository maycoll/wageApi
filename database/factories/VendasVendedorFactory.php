<?php

namespace Database\Factories;

use App\Models\VendasVendedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendasVendedor>
 */
class VendasVendedorFactory extends Factory
{
    protected $model = VendasVendedor::class;

    public function definition(): array
    {
        return [
            'data' => now(),
            'codigo_vendedor' => $this->faker->randomDigit(),
            'mes' => '09',
            'ano' => '2025',
            'vendido_bruto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'desconto' => $this->faker->randomFloat(2,1000.0,3000.0),
            'vendido_liquido' => $this->faker->randomFloat(2,70000.0,80000.0),
            'devolucao'  => $this->faker->randomFloat(2,1000.0,2000.0),
            'lucro' => $this->faker->randomFloat(2,1000.0,2000.0),
            'cmv' => $this->faker->randomFloat(2,2000.0,3000.0),
            'meta' => $this->faker->randomFloat(2,80000.0,90000.0),
        ];
    }
}
