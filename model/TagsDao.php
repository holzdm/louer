<?php

require_once "ConexaoBD.php";

function listarTags($conexao)
{
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

function listarTagsPorId($tagsId)
{
    $conexao = conectarBD();
    $arrayTags = [];

    if (empty($tagsId)) return $arrayTags;

    // Converte IDs para inteiros e monta lista segura
    $ids = implode(",", array_map("intval", $tagsId));

    $sql = "SELECT id, nome FROM tags WHERE id IN ($ids)";
    $res = mysqli_query($conexao, $sql);

    while ($row = mysqli_fetch_assoc($res)) {
        $arrayTags[$row['id']] = $row['nome'];
    }

    return $arrayTags;
}
