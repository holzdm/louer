<?php

require_once "ConexaoBD.php";

function inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha)
{

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

function pesquisarFornecedor($idFornecedor)
{

    $conexao = conectarBD();

    $sql = "SELECT nome FROM usuario WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idFornecedor);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        return $row['nome'];
    }
    return null;
}

function alterarDadosFornecedor($cep, $bairro, $rua, $nEnd, $complemento, $id)
{
    $conexao = conectarBD();

    // Montar SQL
    $sql = "UPDATE usuario 
            SET cep = ?, bairro = ?, rua = ?, numero = ?, complemento = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssisi", $cep, $bairro, $rua, $nEnd, $complemento, $id);
    $resultado = $stmt->execute();
    $stmt->close();
    $conexao->close();

    return $resultado;
}

function excluirDadosFornecedor($id)
{
    $conexao = conectarBD();

    // Montar SQL
    $sql = "UPDATE usuario 
            SET tipo = 'Cliente', cep = NULL, bairro = NULL, rua = NULL, numero = NULL, complemento = NULL
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $resultado = $stmt->execute();
    $stmt->close();
    $conexao->close();

    return $resultado;
}