<?php

require_once "ConexaoBD.php";

function listarTags($conexao){
    $conexao = conectarBD(); // conecta ao banco

    $sql = "SELECT * FROM tags"; // realiza comandos na database

    $res = mysqli_query($conexao, $sql); // armazena os dados se o comando $query resultar em dados

    $arrayTags = [];

    if ($res) {
        while ($row = mysqli_fetch_array($res)) {
            $idTag = $row['id'];
            $nomeTag = $row['nome'];
            $arrayTags[$idTag] = $nomeTag;

        }
    }
    return $arrayTags;
}




?>