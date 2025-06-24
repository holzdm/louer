<?php
session_start();
$email = $_SESSION['email'];
$senha = $_SESSION['senha'];



require_once "ConexaoBD.php";

function inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento) {    

    $conexao = conectarBD();

    $tipo = 'Fornecedor';


    // Montar SQL
    $sql = "UPDATE Usuario 
        SET tipo = ?, cep = ?, rua = ?, bairro = ?, numero = ?, complemento = ?
        WHERE email = ? AND senha = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssssss", $tipo, $cep, $rua, $bairro, $nEnd, $complemento, $email, $senha);
    $stmt->execute();
    return true;
    
}




?>