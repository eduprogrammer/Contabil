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
        //show default api page
        echo("default api page");
    }
    
    

?>