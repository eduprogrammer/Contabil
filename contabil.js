/*
    Important: For Brazilians only...

    Copyright 2021. Eduardo Programador
    www.eduardoprogramador.com
    consultoria@eduardoprogramador.com
    
    Todos os direitos reservados.


    >>>>>>>>>>>>>>>>>>>> Observação: Se for utilizar a bibioteca contabil.js,
                        inclua o cabeçalho de Copyright acima. O não atendimento 
                        do disposto acima acarretará nas medidas de proteção a 
                        direitos autorais / intelectuais.
    <<<<<<<<<<<<<<<<<<<<<                        


    Classe que contém funções de Contabilidade 
    para utilização em códigos Javascript.
    À medida em que novas funções forem criadas,
    o script seguirá sendo atualizado.

    Confira a lista de funções atualizada em 10/01/2021

    1) rpaCalculator: Calcula o valor líquido e as retenções tributárias 
        no RPA (Recibo de Pagamento de Autônomo), que é o documento tributário 
        para registro dos serviços prestados por pessoa física.

        Parâmetros:

            a) rpaData: as propriedas do RPA em formato JSON.
                Ex.: let pattern = {
                        prefeitura : "no",
                        iss : 5,
                        valor : 1000,
                        dependentes : 0,
                        rpa_received : 0
                    }

            b) resultCallback: Uma função que será executada ao término no cálculo,
                    tendo como parâmetro o cálculos retornados em JSON.
                
            c) Exemplo prático de uso da função:
                    const res = ct.rpaCalculator(pattern, function (obj) {
    
                        var iss = obj.iss_valor ;
                        var iss_p = obj.iss_perc;
                        var inss_b = obj.iss_legal;
                        var inss_v = obj.inss_valor;
                        var inss_p = obj.inss_perc;
                        var inss_l = obj.inss_legal;
                        var irrf_v = obj.irrf_valor;
                        var irrf_p = obj.irrf_perc;
                        var irrf_l = obj.irrf_legal;
                        var = irrf_b = obj.base_irrf;
                        var ali_rir = obj.aliquota_rir;
                        var ali_rir_v = obj.aliquota_rir_valor;
                        var ded_dep = obj.deducao_dependentes;
                        var ded_rir = obj.deducao_rir;
                        var imp_p = obj.impostos_perc;
                        var val = obj.valor_a_pagar;
                        var cpp = obj.cpp_inss;
                        var custo = obj.custo_pj;
                    }
                });

    Tutorial:

        a) Inclua o seguinte código HTML na sua página web entre as tags <head> e </head>:             
            <script type="text/javascript" src="js/contabil.js"></script>

        b) No seu código javascript da página, inicie a classe:
            Ex.: const contabilidade = new Contabil();

        c) Pronto, basta agora invocar as funções.
            Ex.: contabilidade.rpaCalculator();

*/

class Contabil {

    /*
        Construtor Vazio
    */
    constructor() {
        
    }
    
    /*
        Função que calcula o RPA.
        Documentação no cabeçalho do código.
    */
    rpaCalculator(rpaData, resultCallBack) {

        var iss_res, inss_res, irrf_res;
        var dependente_res, dependente_base;
        var iss_base, inss_base, irrf_base;
        var base_calc;
        var aliquota_irrf, aliquota_irrf_res,reduction;
        var p_inss, p_irrf, p_interest, liquido, cpp;
        var total_company, total_in_month, difference;
                
        let pattern = {
            prefeitura : "no",
            iss : 5,
            valor : 1000,
            dependentes : 0,
            rpa_received : 0
        }
                
        let data = (rpaData == null) ? pattern : rpaData;        

        let pref = data.prefeitura;
        let iss = data.iss;
        let price = data.valor;
        let child = data.dependentes;
        let money = data.rpa_received;

        if(pref.localeCompare("no") == 0) {
            iss_res = ((iss * price) / 100);
            iss_res = parseFloat(iss_res.toFixed(2));
            iss_base = "Art. 1, 'caput'; 8,II; 8-A, 'caput' da Lei 116/2003";
        } else if(pref.localeCompare("yes") == 0){
            iss_res = parseInt(0,10);
            iss_base = "Não há retenção do ISSQN, pois o prestador tem cadastro na prefeitura e efetua seu recolhimento anualmente.";
        }

        if(price < 1045) {
            p_inss = 11;
            inss_base = "Tabela de 2021 do INSS para contribuinte individual e facultativo. Alíquota de 11% valores abaixo de R$ 1.100,00";
            
        } else {
            p_inss = 20;
            inss_base = "Tabela de 2021 do INSS para contribuinte individual e facultativo. Alíquota de 20% de R$ 1.100,00 até R$ 6.433,57";
        }

        if(price > 6433.57) {
            p_inss = 20;
        }

        inss_res = (price <= 6433.57) ? parseFloat(((p_inss * price) / 100).toFixed(2)) : parseFloat(((p_inss * 6433.57) / 100).toFixed(2));
        inss_base = (price <= 6433.57) ? inss_base : "Quando o valor do serviço está acima do teto do INSS (R$ 6.433,57), o percentual de 20% aplica-se sobre o teto e não sobre o valor do serviço.";

        if(money > 0) {
            total_in_month = money + price;            
            if(total_in_month > 6433.57) {
                p_inss = 20;
                inss_res = parseFloat(((p_inss * 6433.57) / 100).toFixed(2));
                inss_base = "O valor do serviço somado aos valores que o autônomo recebeu está acima do teto do INSS (R$ 6.433,57), o percentual de 20% aplica-se sobre o teto e não sobre o valor do serviço."
            } else {
                difference = parseFloat(6433.57) - parseFloat(money);                                
                p_inss = 20;
                inss_res = parseFloat(((p_inss * difference) / 100).toFixed(2));
                inss_base = "Como o autônomo já recebeu valores no mês, a base de cálculo do INSS será a diferença do teto (R$ 6.433,57) pelo somatório dos valores já recebidos pelo profissional, com vistas à aplicação da alíquota de 20%";
            }
        }

        irrf_base = "Decreto 9.580/2018 - Arts. 38, I; 71, VI; 122, VI; 158, II; 681, 'caput'; 685, 'caput'; 710 em diante.";
        base_calc = price - inss_res;

        dependente_res = parseFloat((child * 189.59).toFixed(2));
        dependente_base = `${child} * R$ 189,59: ${dependente_res}`;

        base_calc -= dependente_res;
        base_calc = parseFloat(base_calc.toFixed(2));

        if(base_calc <= 1903.98) {
            aliquota_irrf = 0;
            reduction = 0;
        } else if(base_calc > 1903.98 && base_calc <= 2826.65) {
            aliquota_irrf = 7.5;
            reduction = 142.80;
        } else if(base_calc > 2826.65 && base_calc <= 3751.05 ) {
            aliquota_irrf = 15;
            reduction = 354.80;
        } else if(base_calc > 3751.05 && base_calc <= 4664.68) {
            aliquota_irrf = 22.5;
            reduction = 636.13;
        } else if(base_calc > 4664.68) {
            aliquota_irrf = 27.5;
            reduction = 869.36;
        }

        aliquota_irrf_res = parseFloat(((aliquota_irrf * base_calc) / 100).toFixed(2));

        irrf_res = parseFloat((aliquota_irrf_res - reduction).toFixed(2));

        p_irrf = parseFloat(((irrf_res / price) * 100).toFixed(2));       

        cpp = parseFloat((0.2 * price).toFixed(2));

        liquido = parseFloat((price - iss_res - inss_res - irrf_res).toFixed(2));

        total_company = parseFloat(cpp) + parseFloat(price);

        p_interest = parseFloat(iss) + parseFloat(p_inss) + parseFloat(p_irrf);


        let final_res = {
            iss_valor : iss_res,
            iss_perc : iss,
            iss_legal : iss_base,
            inss_valor : inss_res,
            inss_perc : p_inss,
            inss_legal : inss_base,
            irrf_valor : irrf_res,
            irrf_perc : p_irrf,
            irrf_legal : irrf_base,
            base_irrf : base_calc,
            aliquota_rir : aliquota_irrf,
            aliquota_rir_valor : aliquota_irrf_res,
            deducao_dependentes : dependente_res,
            deducao_rir : reduction,
            impostos_perc : p_interest,
            valor_a_pagar : liquido,
            cpp_inss : cpp,
            custo_pj : total_company
        }

        resultCallBack(final_res);        

    }

}