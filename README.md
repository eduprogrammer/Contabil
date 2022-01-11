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