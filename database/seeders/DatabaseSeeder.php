<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Empresas;
use App\Models\Liberacao;
use App\Models\TotalVendas;
use App\Models\Usuarios;
use App\Models\VendasVendedor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Empresas::factory(2)->create();
        Usuarios::factory(10)->create();

        TotalVendas::factory(10)->create();
        VendasVendedor::factory(10)->create();

        //Liberacao::factory(10)->create();
    }
}
