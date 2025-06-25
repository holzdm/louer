<?php
require_once "ConexaoBD.php";

function inserirProduto($nomeProduto, $tag, $idUsuario) {    

     $conexao = conectarBD();


     // Montar SQL
     $sql = "INSERT INTO Produto (nome, tag, usuario_id) 
             VALUES ('$nomeProduto','$tag','$idUsuario')"; 
    
     mysqli_query($conexao, $sql);

     return $nomeProduto;
    
}
//trocar para o stmt e prepare??



?>