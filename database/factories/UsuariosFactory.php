<?php

namespace Database\Factories;

use App\Models\Usuarios;
use function Faker\Core\randomFloat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class UsuariosFactory extends Factory
{

    protected $model = Usuarios::class;

    public function definition(): array
    {
        $usuario = 'usuario'.Str::random(2);

        return [
            'codigo_usuario' => $this->faker->randomDigit(),
            'codigo_vendedor' => $this->faker->randomDigit(),
            'nome' => $usuario,
            'email'=> $usuario.'@example.com',
            'password' => bcrypt('81dc9bdb52d04dc20036dbd8313ed055'),
            'senha_transacao' => '81dc9bdb52d04dc20036dbd8313ed055',
            'ultimo_login' => now(),
            'gerente' => 'S',
            'vendedor' => 'S',
            'recebe_notificacao' => 'S',
            //'ultima_notificacao' => '1',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

}
