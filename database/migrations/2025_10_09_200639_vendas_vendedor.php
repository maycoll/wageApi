<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vendas_vendedor', function (Blueprint $table) {

            $table->id();

            $table->text('cnpj_empresa')->nullable(false);
            $table->integer('codigo_vendedor')->nullable(false);
            $table->timestamp('data')->nullable(true);
            $table->integer('mes')->nullable(false);
            $table->integer('ano')->nullable(false);

            $table->decimal('vendido_bruto')->nullable(true)->default(0);
            $table->decimal('desconto')->nullable(true)->default(0);
            $table->decimal('vendido_liquido')->nullable(true)->default(0);
            $table->decimal('devolucao')->nullable(true)->default(0);
            $table->decimal('lucro')->nullable(true)->default(0);
            $table->decimal('cmv')->nullable(true)->default(0);

            $table->integer('vendas_quant')->nullable(true)->default(0);
            $table->decimal('vendas_bruto')->nullable(true)->default(0);
            $table->decimal('vendas_desconto')->nullable(true)->default(0);
            $table->decimal('vendas_liquido')->nullable(true)->default(0);
            $table->integer('itens_por_venda')->nullable(true)->default(0);
            $table->integer('itens_dif_venda')->nullable(true)->default(0);
            $table->integer('itens_quant_vendas')->nullable(true)->default(0);
            $table->integer('devolucoes_quant')->nullable(true)->default(0);
            $table->decimal('devolucoes_valor')->nullable(true)->default(0);
            $table->decimal('devolucoes_taxa')->nullable(true)->default(0);
            $table->decimal('faturado_produto')->nullable(true)->default(0);
            $table->decimal('faturado_servico')->nullable(true)->default(0);
            $table->decimal('faturado_total')->nullable(true)->default(0);
            $table->decimal('faturado_cmv')->nullable(true)->default(0);
            $table->decimal('desp_var')->nullable(true)->default(0);
            $table->decimal('desp_fixo')->nullable(true)->default(0);
            $table->decimal('margem_contrib')->nullable(true)->default(0);
            $table->decimal('margem_contrib_perc')->nullable(true)->default(0);
            $table->decimal('lucro_bruto')->nullable(true)->default(0);
            $table->decimal('margem_bruta')->nullable(true)->default(0);
            $table->decimal('lucro_estimado')->nullable(true)->default(0);
            $table->decimal('lucro_pe')->nullable(true)->default(0);
            $table->decimal('ticket_medio')->nullable(true)->default(0);
            $table->decimal('tpag_dinh')->nullable(true)->default(0);
            $table->decimal('tpag_cheq')->nullable(true)->default(0);
            $table->decimal('tpag_boleto')->nullable(true)->default(0);
            $table->decimal('tpag_c_cred')->nullable(true)->default(0);
            $table->decimal('tpag_c_deb')->nullable(true)->default(0);
            $table->decimal('tpag_crediario')->nullable(true)->default(0);
            $table->decimal('tpag_vale')->nullable(true)->default(0);
            $table->decimal('tpag_depcc')->nullable(true)->default(0);
            $table->decimal('tpag_pix')->nullable(true)->default(0);
            $table->decimal('estoque_medio')->nullable(true)->default(0);
            $table->decimal('dav_incluidos')->nullable(true)->default(0);
            $table->decimal('dav_perdidos')->nullable(true)->default(0);
            $table->decimal('dav_perdidos_valor')->nullable(true)->default(0);
            $table->decimal('dav_faturados')->nullable(true)->default(0);
            $table->decimal('dav_faturados_valor')->nullable(true)->default(0);
            $table->decimal('dav_taxa_conver')->nullable(true)->default(0);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas_vendedor');
    }
};
