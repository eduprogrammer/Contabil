<?php 

    include "contabil.php";

    if(isset($_GET['prefeitura']) && isset($_GET['iss']) && 
    isset($_GET['valor']) && isset($_GET['dependentes']) && isset($_GET['recebido'])) {
        
        $prefeitura = $_GET['prefeitura'];
        $iss = $_GET['iss'];
        $valor = $_GET['valor'];
        $dependentes = $_GET['dependentes'];
        $recebido = $_GET['recebido'];

        $pattern = array("prefeitura" => $prefeitura, "iss" => $iss, "valor" => $valor, 
        "dependentes" => $dependentes, "recebido" => $recebido);

        $cont = new Contabil();
        
        $cont->rpaCalculator($pattern);

    } else {
        
        $html = <<<EOD

        <!DOCTYPE html>

            <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width,initial-scale=1.0">
            <title>RPA - API</title>
            <script type="text/javascript" src="js/tasks.js"></script>
            <script type="text/javascript" src="js/duscript.js"></script>    
            </head>

            <style>
                * {
                text-align: center;
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;        
                }

            header {
                height: 100vh;
                background-image: linear-gradient(to bottom right, red,yellow,blue);
                background-size: cover;
                overflow-y: auto;
                }

            .presentation h1 {
                padding-top: 20px;
                font-size: 40px;        
                }

            .presentation p {
                background-color: rgba(192, 22, 22, 0.644);
                font-weight: bold;
                font-size: 14px;
                padding: 10px;
                margin-top: 20px;
            }

            .tutorial {
                margin-top: 20px;
                text-align: unset;
            }   

            .tutorial p, .tutorial h3 {
                margin-top: 10px;
            }

            .copyright {
                position: absolute;
                bottom: 2px;
                left: 0;
                right: 0;
                font-size: 12px;
                margin-left: auto;
                margin-right: auto;
        
            }

            </style>

            <header>

                <div class="presentation">
                    <h1>RPA - API</h1>
                    <p>Bem-vindo à página oficial da API para cálculo do RPA (Recibo de Pagamento de Autônomo). 
                        A API é um Webservice do tipo Rest-FULL, um tipo de aplicação backend que permite a sua integração 
                        a outros sistemas. Assim, a API foi desenvolvida para consumo de clientes. Você pode implementar 
                        o seu próprio software para consumir os dados por ela fornecidos.
                    </p>
                </div>

                <div class="tutorial">
                    <h2>Como usar a API?</h2>

                    <h3>Modo 1: URL do seu navegador</h3>

                    <p>
                        A API oficial possui o seguinte caminho: <strong>https://eduardoprogramador.com/php/rpa_api.php</strong>. <br>
                        Dessa forma, para utilizá-la em seu browser você deve adicionar a interrogração após a extensão php 
                        e adicionar a seguinte sequência:
                    </p>

                    <p>
                        iss=x&prefeitura=x&valor=x&recebido=x&dependentes=x
                    </p>

                    <p>
                        Onde: 

                            x = valor do parâmetro, de acordo com as instruções:<br><br>

                            para iss, x é um número de 2 a 5;<br>
                            para prefeitura, x é a palavra "sim" ou "não";<br>
                            para valor, x é o valor cheio do serviço;<br>
                            para recebido, x é o valor de RPA que o autônomo já recebeu no mês.<br>
                            para dependentes, x é o número de dependentes que o autônomo afirmou ter<br><br>

                            Veja o seguinte exemplo para um RPA em que o autônomo cobrou R$ 3.561,25, não possui
                            cadastro na Prefeitura e não recebeu nenhum valor de RPA no mês, com ISS de 4% e 2 dependentes.<br><br>

                            https://eduardoprogramador.com/php/rpa_api.php?<strong>iss=4&prefeitura=nao&valor=3561.25&recebido=0&dependentes=2</strong>

                    </p>

                    <h3>Modo 2: Por meio de Javascript</h3>

                        <p>
                            Para acessar a API via Javascript, você precisará da tecnologia Ajax para requisição GET. 
                            Uma biblioteca
                            bastante difundida entre os desenvolvedores é a JQuery. Alternativamente, 
                            Eduardo Programador desenvolveu sua própria tecnologia, a qual pode ser utilizada 
                            gratuitamente em <a href="https://github.com/eduprogrammer/Javascript-Box">https://github.com/eduprogrammer/Javascript-Box</a>.
                        </p>

                        <h3>Modo 3: Por meio de seu próprio Software</h3>

                        <p>
                            Se você já é um programador experiente, você pode livremente usar frameworks e linguagens
                            de programação como Java, Python, C++ e outras para fazer requisições em GET e ler o arquivo 
                            JSON no Android, IOS ou mesmo no WIndows e Linux.
                        </p>                        

                </div>

                <p class="copyright">Copyright 2021. Eduardo Programador</p>


            </header>

            <body>

                <script>

                </script>

            </body>

        </html>

        EOD;

        echo($html);
    }
    
    

?>