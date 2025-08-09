<?php




require_once "ConexaoBD.php";

function inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha) {    

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

function pesquisarFornecedor($idFornecedor){

    $conexao = conectarBD();

    $sql = "SELECT nome FROM usuario WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idFornecedor);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()){
        return $row['nome'];
    }
    return null;
}




?>