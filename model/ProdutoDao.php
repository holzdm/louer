<?php
require_once "ConexaoBD.php";

function inserirProduto($nomeProduto, $tagsIds, $idUsuario) {
    $conexao = conectarBD();    

    $sql = "INSERT INTO Produto (nome, usuario_id) VALUES (?, ?)"; 
    
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "si", $nomeProduto, $idUsuario);
    
    mysqli_stmt_execute($stmt) or die('Erro no INSERT do Produto: '.mysqli_stmt_error($stmt));
    
    // Pega o código inserido
    $idProduto = mysqli_insert_id($conexao); 

    // Insere as tags relacionadas
    if (!inserirTagsHasProduto($tagsIds, $idProduto)) {
        die('Erro ao inserir na tabela relacional: '.mysqli_error($conexao));
    } // fazer essa forma ou com "or die"?

    return $idProduto;
}

// Função para inserir as tags relacionadas ao produto
function inserirTagsHasProduto($tagsIds, $idProduto) {
    $conexao = conectarBD();

    $sql = "INSERT INTO tags_has_produto (tags_id, produto_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    foreach ($tagsIds as $idTag) {
        mysqli_stmt_bind_param($stmt, "ii", $idTag, $idProduto);
        if (!mysqli_stmt_execute($stmt)) {
            return false;
        }
    }

    return true;
}



?>