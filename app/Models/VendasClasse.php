<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendasClasse extends Model
{
    protected $table = 'vendas_classe';

    protected $fillable = [
        'id',
        'data',
        'mes',
        'ano',

        'cnpj_empresa',        // cnpj da empresa que pertence o registro
        'codigo_classe',        // codigo classe alfa
        'nome_classe',        // codigo classe alfa

        'vendas_quant',        // numero de vendas ocorridas nesta data
        'vendas_bruto',        // (somente vendas)
        'vendas_desconto',     // (somente vendas)
        'vendas_liquido',      // (somente vendas - desconto)
        'itens_por_venda',     // unidades por transação (media de itens por venda) (upt)
        'itens_dif_venda',     // numero de produtos diferentes vendidos nesta data
        'itens_quant_vendas',  // soma de todas as quantidades vendidas nesta data
        'devolucoes_quant',    // numero de devoluções ocorridas nesta data
        'devolucoes_valor',    //
        'devolucoes_taxa',     // (%) - devoluções / total_faturado
        'faturado_produto',    //
        'faturado_servico',    //
        'faturado_total',      // (vendaliquida - descontos)
        'faturado_cmv',        // custo da mercadoria vendida (faturada)
        'desp_var',            // valor estimado das despesas variaveis das vendas desta data
        'desp_fixo',           // valor estimado das despesas fixas das vendas desta data
        'margem_contrib',      // margem de contribuição do dia = vendas do dia-(custos variáveis do dia+despesas variáveis do dia) - esse valor é quanto o dia contribuiu para cobrir fixos e lucro.
        'margem_contrib_perc', // (%) -> margem_contrib_per = (margem_contrib / total_faturado) x 100 - assim você enxerga, por exemplo, que “neste dia, 35% do que foi vendido ficou para cobrir fixos e gerar lucro
        'lucro_bruto',         //
        'margem_bruta',        // margem bruta = lucro bruto/total_faturado x 100
        'lucro_estimado',      // margem de lucro líquida
        'lucro_pe',            //
        'ticket_medio',        //
        'tpag_dinh',           //
        'tpag_cheq',           //
        'tpag_boleto',         //
        'tpag_c_cred',         //
        'tpag_c_deb',          //
        'tpag_crediario',      //
        'tpag_vale',           //
        'tpag_depcc',          //
        'tpag_pix',            //
        'estoque_medio',       // valor do custo do estoque físico total da loja (medir giro do estoque)
        'dav_incluidos',       // numero total de orçamentos incluidos nesta data
        'dav_perdidos',        // numero orçamentos perdidos nesta data
        'dav_perdidos_valor',  // valor total de dav perdidos nesta data
        'dav_faturados',       // numero orçamentos convertidos em venda nesta data
        'dav_faturados_valor', // valor total de dav faturados nesta data
        'dav_taxa_conver',     // % de atendimento convertido em vendas (dav_faturados + vendas que não foram originadas de davs) / (num_dav_faturados + num_dav_incluidos + num_dav_perdidos - num_vendas) (da mesma data)cientes_quant       //
    ];

    use HasFactory;
}
