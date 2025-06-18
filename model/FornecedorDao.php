<?php
require_once "ConexaoBD.php";

function inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento) {    

    $conexao = conectarBD();


    // Montar SQL
    $sql = "INSERT INTO Usuario (tipo, nome, email, senha, cep, rua, bairro, numero, complemento) 
        VALUES ('Fornecedor','nome" . $cep . "','email" . $cep . "','senha" . $cep . "','$cep','$rua','$bairro','$nEnd','$complemento')";

    
    mysqli_query($conexao, $sql);

    // Pega o código inserido
    $id = mysqli_insert_id($conexao);  
    return $id;
    
}




?>