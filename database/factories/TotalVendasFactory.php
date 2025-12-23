<?php

namespace Database\Factories;

use App\Models\TotalVendas;
use function Faker\Core\randomFloat;
use Illuminate\Database\Eloquent\Factories\Factory;


class TotalVendasFactory extends Factory
{

    protected $model = TotalVendas::class;

    public function definition(): array
    {
        return [

            'cnpj_empresa' => '39311444000183',

            'data' => now(),
            'mes' => '12',
            'ano' => '2025',

            'vendido_bruto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'desconto' => $this->faker->randomFloat(2,1000.0,3000.0),
            'vendido_liquido' => $this->faker->randomFloat(2,70000.0,80000.0),
            'devolucao'  => $this->faker->randomFloat(2,1000.0,2000.0),
            'lucro' => $this->faker->randomFloat(2,1000.0,2000.0),
            'cmv' => $this->faker->randomFloat(2,2000.0,3000.0),

            'vendas_quant' => $this->faker->randomDigit(),
            'vendas_bruto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'vendas_desconto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'vendas_liquido' => $this->faker->randomFloat(2,80000.0,90000.0),
            'itens_por_venda' => $this->faker->randomDigit(),
            'itens_dif_venda' => $this->faker->randomDigit(),
            'itens_quant_vendas' => $this->faker->randomDigit(),
            'devolucoes_quant' => $this->faker->randomDigit(),
            'devolucoes_valor' => $this->faker->randomFloat(2,80000.0,90000.0),
            'devolucoes_taxa' => $this->faker->randomFloat(2,80000.0,90000.0),
            'faturado_produto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'faturado_servico' => $this->faker->randomFloat(2,80000.0,90000.0),
            'faturado_total' => $this->faker->randomFloat(2,80000.0,90000.0),
            'faturado_cmv' => $this->faker->randomFloat(2,80000.0,90000.0),
            'desp_var' => $this->faker->randomFloat(2,80000.0,90000.0),
            'desp_fixo' => $this->faker->randomFloat(2,80000.0,90000.0),
            'margem_contrib' => $this->faker->randomFloat(2,80000.0,90000.0),
            'margem_contrib_perc' => $this->faker->randomFloat(2,80000.0,90000.0),
            'lucro_bruto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'margem_bruta' => $this->faker->randomFloat(2,80000.0,90000.0),
            'lucro_estimado' => $this->faker->randomFloat(2,80000.0,90000.0),
            'lucro_pe' => $this->faker->randomFloat(2,80000.0,90000.0),
            'ticket_medio' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_dinh' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_cheq' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_boleto' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_c_cred' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_c_deb' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_crediario' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_vale' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_depcc' => $this->faker->randomFloat(2,80000.0,90000.0),
            'tpag_pix' => $this->faker->randomFloat(2,80000.0,90000.0),
            'estoque_medio' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_incluidos' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_perdidos' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_perdidos_valor' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_faturados' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_faturados_valor' => $this->faker->randomFloat(2,80000.0,90000.0),
            'dav_taxa_conver' => $this->faker->randomFloat(2,80000.0,90000.0),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */

}
