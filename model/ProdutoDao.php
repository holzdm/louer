<?php
require_once "ConexaoBD.php";

function inserirProduto($nomeProduto, $tag, $idUsuario) {    

    $conexao = conectarBD();


     // Montar SQL
    $sql = "INSERT INTO Produto (nome, usuario_id) 
             VALUES ('$nomeProduto','$idUsuario');
            INSERT INTO tags_has_produto (tags_id, produto_id) 
             VALUES ('$tag', '$nomeProduto')"; 
    
    mysqli_query($conexao, $sql);
    
    $res = mysqli_query($conexao, $sql);
    if (!$res) {
        die('Erro no INSERT: '.mysqli_error($conexao));
    }else{
        // Pega o código inserido
        $id = mysqli_insert_id($conexao);  
        return $id;
    }    
    
}
//trocar para o stmt e prepare??
//ARQUIVO NAO ESTA PRONTO



?>