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
                    <p>Bem-vindo ?? p??gina oficial da API para c??lculo do RPA (Recibo de Pagamento de Aut??nomo). 
                        A API ?? um Webservice do tipo Rest-FULL, um tipo de aplica????o backend que permite a sua integra????o 
                        a outros sistemas. Assim, a API foi desenvolvida para consumo de clientes. Voc?? pode implementar 
                        o seu pr??prio software para consumir os dados por ela fornecidos.
                    </p>
                </div>

                <div class="tutorial">
                    <h2>Como usar a API?</h2>

                    <h3>Modo 1: URL do seu navegador</h3>

                    <p>
                        A API oficial possui o seguinte caminho: <strong>https://eduardoprogramador.com/php/rpa_api.php</strong>. <br>
                        Dessa forma, para utiliz??-la em seu browser voc?? deve adicionar a interrogra????o ap??s a extens??o php 
                        e adicionar a seguinte sequ??ncia:
                    </p>

                    <p>
                        iss=x&prefeitura=x&valor=x&recebido=x&dependentes=x
                    </p>

                    <p>
                        Onde: 

                            x = valor do par??metro, de acordo com as instru????es:<br><br>

                            para iss, x ?? um n??mero de 2 a 5;<br>
                            para prefeitura, x ?? a palavra "sim" ou "n??o";<br>
                            para valor, x ?? o valor cheio do servi??o;<br>
                            para recebido, x ?? o valor de RPA que o aut??nomo j?? recebeu no m??s.<br>
                            para dependentes, x ?? o n??mero de dependentes que o aut??nomo afirmou ter<br><br>

                            Veja o seguinte exemplo para um RPA em que o aut??nomo cobrou R$ 3.561,25, n??o possui
                            cadastro na Prefeitura e n??o recebeu nenhum valor de RPA no m??s, com ISS de 4% e 2 dependentes.<br><br>

                            https://eduardoprogramador.com/php/rpa_api.php?<strong>iss=4&prefeitura=nao&valor=3561.25&recebido=0&dependentes=2</strong>

                    </p>

                    <h3>Modo 2: Por meio de Javascript</h3>

                        <p>
                            Para acessar a API via Javascript, voc?? precisar?? da tecnologia Ajax para requisi????o GET. 
                            Uma biblioteca
                            bastante difundida entre os desenvolvedores ?? a JQuery. Alternativamente, 
                            Eduardo Programador desenvolveu sua pr??pria tecnologia, a qual pode ser utilizada 
                            gratuitamente em <a href="https://github.com/eduprogrammer/Javascript-Box">https://github.com/eduprogrammer/Javascript-Box</a>.
                        </p>

                        <h3>Modo 3: Por meio de seu pr??prio Software</h3>

                        <p>
                            Se voc?? j?? ?? um programador experiente, voc?? pode livremente usar frameworks e linguagens
                            de programa????o como Java, Python, C++ e outras para fazer requisi????es em GET e ler o arquivo 
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