<?php
require_once "ConexaoBD.php";

function inserirCliente($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha) {    

    $conexao = conectarBD();


    // Montar SQL
    $sql = "INSERT INTO Usuario (nome, tipo, cpf, cnpj, cidade, telefone, email, senha) 
            VALUES ('$nome' , 'Cliente', '$cpf', '$cnpj', '$cidade', 
                    '$telefone', '$email','$senha')"; 
    
    mysqli_query($conexao, $sql);

    // Pega o código inserido
    $id = mysqli_insert_id($conexao);  
    return $id;
    
}




?>