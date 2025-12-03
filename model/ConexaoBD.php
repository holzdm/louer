<?php

static $conexao;

function conectarBD(){
    $conexao = mysqli_connect($_ENV["MYSQL_HOST"],
    'loueruser','kivicaLOUER','louerbd');

    //Se falhar:
	
	if (!$conexao) {
        die("Falha na conexão: " . mysqli_connect_error());
    }
    
    // PARA RESOLVER PROBLEMAS DE ACENTUAÇÃO 
    // Converte CODIFICAÇÃO para UTF-8
    mysqli_query($conexao, "SET NAMES 'utf8'");
    mysqli_query($conexao, "SET character_set_connection=utf8");
    mysqli_query($conexao, "SET character_set_client=utf8");
    mysqli_query($conexao, "SET character_set_results=utf8");

    return $conexao;
}



?>