<?php
namespace App\Functions;

use App\Models\VendasClasse;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: maycoll
 * Date: 18/12/2025
 * Time: 17:20
 */
class VendasClasseFunc
{
    public function CheckRegExists(Request $request){
        return ($totVendaClasse = VendasClasse::where('codigo_classe', $request['codigo_classe'])
            ->where('cnpj_empresa',$request['cnpj_empresa'])
            ->where('data', $request['data'])
            ->first()) ;
    }


    public function GetAno(Request $request){

        $like = "'%%'";

        if(isset($request['codigo_classe'])){
            $like = "'".$request['codigo_classe']."'";
        }

        $sql  = 'sum(vendas_quant) as vendas_quant,';
        $sql .= 'sum(vendas_bruto) as vendas_bruto,';
        $sql .= 'sum(vendas_desconto) as vendas_desconto,';
        $sql .= 'sum(vendas_liquido) as vendas_liquido,';
        $sql .= 'sum(itens_por_venda) as itens_por_venda,';
        $sql .= 'sum(itens_dif_venda) as itens_dif_venda,';
        $sql .= 'sum(itens_quant_vendas) as itens_quant_vendas,';
        $sql .= 'sum(devolucoes_quant) as devolucoes_quant,';
        $sql .= 'sum(devolucoes_valor) as devolucoes_valor,';
        $sql .= 'sum(devolucoes_taxa) as devolucoes_taxa,';
        $sql .= 'sum(faturado_produto) as faturado_produto,';
        $sql .= 'sum(faturado_servico) as faturado_servico,';
        $sql .= 'sum(faturado_total) as faturado_total,';
        $sql .= 'sum(faturado_cmv) as faturado_cmv,';
        $sql .= 'sum(desp_var) as desp_var,';
        $sql .= 'sum(desp_fixo) as desp_fixo,';
        $sql .= 'sum(margem_contrib) as margem_contrib,';
        $sql .= 'sum(margem_contrib_perc) as margem_contrib_perc,';
        $sql .= 'sum(lucro_bruto) as lucro_bruto,';
        $sql .= 'sum(margem_bruta) as margem_bruta,';
        $sql .= 'sum(lucro_estimado) as lucro_estimado,';
        $sql .= 'sum(lucro_pe) as lucro_pe,';
        $sql .= 'sum(ticket_medio) as ticket_medio,';
        $sql .= 'sum(tpag_dinh) as tpag_dinh,';
        $sql .= 'sum(tpag_cheq) as tpag_cheq,';
        $sql .= 'sum(tpag_boleto) as tpag_boleto,';
        $sql .= 'sum(tpag_c_cred) as tpag_c_cred,';
        $sql .= 'sum(tpag_c_deb) as tpag_c_deb,';
        $sql .= 'sum(tpag_crediario) as tpag_crediario,';
        $sql .= 'sum(tpag_vale) as tpag_vale,';
        $sql .= 'sum(tpag_depcc) as tpag_depcc,';
        $sql .= 'sum(tpag_pix) as tpag_pix,';
        $sql .= 'sum(estoque_medio) as estoque_medio,';
        $sql .= 'sum(dav_incluidos) as dav_incluidos,';
        $sql .= 'sum(dav_perdidos) as dav_perdidos,';
        $sql .= 'sum(dav_perdidos_valor) as dav_perdidos_valor,';
        $sql .= 'sum(dav_faturados) as dav_faturados,';
        $sql .= 'sum(dav_faturados_valor) as dav_faturados_valor,';
        $sql .= 'sum(dav_taxa_conver) as dav_taxa_conver';


        $totVendaClasse = VendasClasse::selectRaw('cnpj_empresa, codigo_classe, ano,'.$sql)
                                        ->whereRaw('codigo_classe::text like '.$like)
                                        ->whereRaw('cnpj_empresa = '."'".$request['cnpj_empresa']."'")
                                        ->whereRaw('ano = '.$request['ano'])
                                        ->groupByRaw('cnpj_empresa, codigo_classe, ano')
                                        ->get();
        return $totVendaClasse;

    }

    public function GetMes(Request $request){
        $like = "'%%'";

        if(isset($request['codigo_classe'])){
            $like = "'".$request['codigo_classe']."'";
        }

        $sql  = 'sum(vendas_quant) as vendas_quant,';
        $sql .= 'sum(vendas_bruto) as vendas_bruto,';
        $sql .= 'sum(vendas_desconto) as vendas_desconto,';
        $sql .= 'sum(vendas_liquido) as vendas_liquido,';
        $sql .= 'sum(itens_por_venda) as itens_por_venda,';
        $sql .= 'sum(itens_dif_venda) as itens_dif_venda,';
        $sql .= 'sum(itens_quant_vendas) as itens_quant_vendas,';
        $sql .= 'sum(devolucoes_quant) as devolucoes_quant,';
        $sql .= 'sum(devolucoes_valor) as devolucoes_valor,';
        $sql .= 'sum(devolucoes_taxa) as devolucoes_taxa,';
        $sql .= 'sum(faturado_produto) as faturado_produto,';
        $sql .= 'sum(faturado_servico) as faturado_servico,';
        $sql .= 'sum(faturado_total) as faturado_total,';
        $sql .= 'sum(faturado_cmv) as faturado_cmv,';
        $sql .= 'sum(desp_var) as desp_var,';
        $sql .= 'sum(desp_fixo) as desp_fixo,';
        $sql .= 'sum(margem_contrib) as margem_contrib,';
        $sql .= 'sum(margem_contrib_perc) as margem_contrib_perc,';
        $sql .= 'sum(lucro_bruto) as lucro_bruto,';
        $sql .= 'sum(margem_bruta) as margem_bruta,';
        $sql .= 'sum(lucro_estimado) as lucro_estimado,';
        $sql .= 'sum(lucro_pe) as lucro_pe,';
        $sql .= 'sum(ticket_medio) as ticket_medio,';
        $sql .= 'sum(tpag_dinh) as tpag_dinh,';
        $sql .= 'sum(tpag_cheq) as tpag_cheq,';
        $sql .= 'sum(tpag_boleto) as tpag_boleto,';
        $sql .= 'sum(tpag_c_cred) as tpag_c_cred,';
        $sql .= 'sum(tpag_c_deb) as tpag_c_deb,';
        $sql .= 'sum(tpag_crediario) as tpag_crediario,';
        $sql .= 'sum(tpag_vale) as tpag_vale,';
        $sql .= 'sum(tpag_depcc) as tpag_depcc,';
        $sql .= 'sum(tpag_pix) as tpag_pix,';
        $sql .= 'sum(estoque_medio) as estoque_medio,';
        $sql .= 'sum(dav_incluidos) as dav_incluidos,';
        $sql .= 'sum(dav_perdidos) as dav_perdidos,';
        $sql .= 'sum(dav_perdidos_valor) as dav_perdidos_valor,';
        $sql .= 'sum(dav_faturados) as dav_faturados,';
        $sql .= 'sum(dav_faturados_valor) as dav_faturados_valor,';
        $sql .= 'sum(dav_taxa_conver) as dav_taxa_conver';


        $totVendaClasse = VendasClasse::selectRaw('cnpj_empresa, codigo_classe, ano, mes, '.$sql)
                                        ->whereRaw('codigo_classe::text like '.$like)
                                        ->whereRaw('cnpj_empresa = '."'".$request['cnpj_empresa']."'")
                                        ->whereRaw('ano = '.$request['ano'])
                                        ->whereRaw('mes = '.$request['mes'])
                                        ->groupByRaw('cnpj_empresa, codigo_classe, ano, mes')
            ->get();

        return $totVendaClasse;

    }

    public function GetDia(Request $request){
        $like = "'%%'";

        if(isset($request['codigo_classe'])){
            $like = "'".$request['codigo_classe']."'";
        }

        $totVendaClasse = VendasClasse::whereRaw('codigo_classe like '.$like)
                                            ->where('cnpj_emprsa', $request['cnpj_empresa'])
                                            ->where('dia', $request['dia'])
                                            ->get();

        return $totVendaClasse;

    }
}