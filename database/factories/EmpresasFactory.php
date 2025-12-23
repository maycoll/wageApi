<?php

namespace Database\Factories;

use App\Models\Empresas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresas>
 */
class EmpresasFactory extends Factory
{
    protected $model = Empresas::class;

    public function definition(): array
    {
        $razao = 'Empresa Razao '.Str::random(2);
        $fantasia = 'Empresa Fantasia'.Str::random(2);

        return [
            'cnpj' => '39311444000183', //$this->faker->numerify('##############'),
            'razao' => $razao,
            'fantasia' => $fantasia,

        ];
    }
}
