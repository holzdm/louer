<?php

require_once "conexaobd.php";

function listarTags() {
    $conexao = conectarBD();

    $sql = "SELECT * FROM tags";

    // Executa no banco de dados
    $res = mysqli_query( $conexao, $sql ) or die(  mysqli_error($conexao)   )  ;

    // Cria um array vazio
    $listTags = "";

    while ($registro = mysqli_fetch_assoc($res)) {
        $tag = htmlspecialchars($registro["nome"]);
        $listTags .= "<option value=\"$tag\">$tag</option>\n";
    }

    return $listTags;

}




?>