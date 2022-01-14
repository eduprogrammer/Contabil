<?php 

    /*
    Copyright 2021. Eduardo Programador
    www.eduardoprogramador.com
    consultoria@eduardoprogramador.com
    
    Todos os direitos reservados.
    */

    class Contabil {        
        
        function __construct() {
            
        }
        
        function __destruct() {
            
        }
        
        public function rpaCalculator($pattern) : void {
            
        $iss_res = 0; 
        $inss_res = 0;
        $irrf_res = 0;
        $dependente_res = 0; 
        $dependente_base = "";
        $iss_base = ""; 
        $inss_base = "";
        $irrf_base = "";
        $base_calc = 0;
        $aliquota_irrf = 0; 
        $aliquota_irrf_res = 0; 
        $reduction = 0;
        $p_inss = 0; 
        $p_irrf = 0;
        $p_interest = 0;
        $liquido = 0;
        $cpp = 0;
        $total_company = 0;
        $total_in_month = 0;
        $difference = 0;                                                 

        $pref = $pattern['prefeitura'];
        $iss = $pattern['iss'];
        $price = $pattern['valor'];
        $child = $pattern['dependentes'];
        $money = $pattern['recebido'];        

        if(strcmp($pref,"no") == 0) {
            $iss_res = (($iss * $price) / 100);
            $iss_res = number_format((float)$iss_res, 2, '.','');
            $iss_base = "Art. 1, 'caput'; 8,II; 8-A, 'caput' da Lei 116/2003";
        } elseif(strcmp($pref,"yes") == 0){
            $iss_res = (int) 0;
            $iss_base = "Não há retenção do ISSQN, pois o prestador tem cadastro na prefeitura e efetua seu recolhimento anualmente.";
        }

        if($price < 1045) {
            $p_inss = 11;
            $inss_base = "Tabela de 2021 do INSS para contribuinte individual e facultativo. Alíquota de 11% valores abaixo de R$ 1.100,00";
            
        } else {
            $p_inss = 20;
            $inss_base = "Tabela de 2021 do INSS para contribuinte individual e facultativo. Alíquota de 20% de R$ 1.100,00 até R$ 6.433,57";
        }

        if($price > 6433.57) {
            $p_inss = 20;
        }

        $inss_res = ($price <= 6433.57) ? number_format((($p_inss * $price) / 100),2,'.','') : number_format((($p_inss * 6433.57) / 100),2,'.','');
        $inss_base = ($price <= 6433.57) ? $inss_base : "Quando o valor do serviço está acima do teto do INSS (R$ 6.433,57), o percentual de 20% aplica-se sobre o teto e não sobre o valor do serviço.";

        if($money > 0) {
            $total_in_month = $money + $price;            
            if($total_in_month > 6433.57) {
                $p_inss = 20;
                $inss_res = number_format(((p_inss * 6433.57) / 100),2,'.','');
                $inss_base = "O valor do serviço somado aos valores que o autônomo recebeu está acima do teto do INSS (R$ 6.433,57), o percentual de 20% aplica-se sobre o teto e não sobre o valor do serviço.";
            } else {
                $difference = (float) 6433.57 - (float) money;                                
                $p_inss = 20;
                $inss_res = number_format(((p_inss * difference) / 100),2,'.','');
                $inss_base = "Como o autônomo já recebeu valores no mês, a base de cálculo do INSS será a diferença do teto (R$ 6.433,57) pelo somatório dos valores já recebidos pelo profissional, com vistas à aplicação da alíquota de 20%";
            }
        }

        $irrf_base = "Decreto 9.580/2018 - Arts. 38, I; 71, VI; 122, VI; 158, II; 681, 'caput'; 685, 'caput'; 710 em diante.";
        $base_calc = $price - $inss_res;

        $dependente_res = number_format(($child * 189.59),2,'.','');        
        $dependente_base = "$child * R$ 189,59: $dependente_res";

        $base_calc -= $dependente_res;
        $base_calc = number_format($base_calc,2,'.','');

        if($base_calc <= 1903.98) {
            $aliquota_irrf = 0;
            $reduction = 0;
        } elseif($base_calc > 1903.98 && $base_calc <= 2826.65) {
            $aliquota_irrf = 7.5;
            $reduction = 142.80;
        } elseif($base_calc > 2826.65 && $base_calc <= 3751.05 ) {
            $aliquota_irrf = 15;
            $reduction = 354.80;
        } elseif($base_calc > 3751.05 && $base_calc <= 4664.68) {
            $aliquota_irrf = 22.5;
            $reduction = 636.13;
        } elseif($base_calc > 4664.68) {
            $aliquota_irrf = 27.5;
            $reduction = 869.36;
        }

        $aliquota_irrf_res = number_format((($aliquota_irrf * $base_calc) / 100),2,'.','');

        $irrf_res = number_format(($aliquota_irrf_res - $reduction),2,'.','');

        $p_irrf = number_format((($irrf_res / $price) * 100),2,'.','');       

        $cpp = number_format((0.2 * $price),2,'.','');

        $liquido = number_format(($price - $iss_res - $inss_res - $irrf_res),2,'.','');

        $total_company = (float) $cpp + (float) $price;

        $p_interest = (float) $iss + (float) $p_inss + (float) $p_irrf;


        $final_res = array(
            "iss_valor" => $iss_res,
            "iss_perc" => $iss,
            "iss_legal" => $iss_base,
            "inss_valor" => $inss_res,
            "inss_perc" => $p_inss,
            "inss_legal" => $inss_base,
            "irrf_valor" => $irrf_res,
            "irrf_perc" => $p_irrf,
            "irrf_legal" => $irrf_base,
            "base_irrf" => $base_calc,
            "aliquota_rir" => $aliquota_irrf,
            "aliquota_rir_valor" => $aliquota_irrf_res,
            "deducao_dependentes" => $dependente_res,
            "deducao_rir" => $reduction,
            "impostos_perc" => $p_interest,
            "valor_a_pagar" => $liquido,
            "cpp_inss" => $cpp,
            "custo_pj" => number_format($total_company,2,'.','')
        );

        echo(json_encode($final_res,JSON_UNESCAPED_UNICODE));
        
        }
    }

?>