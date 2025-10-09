<?php
session_start();

require_once "../model/ProdutoDao.php";

$idProduto = (int) $_GET['idProduto'];
$conexao = conectarBD();

$sql = "SELECT dados, tipo FROM imagem WHERE produto_id = ? LIMIT 1";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $idProduto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    header("Content-Type: " . $row['tipo']);
    echo $row['dados'];
} else {
    // imagem padrão
    header("Content-Type: image/png");
    readfile("../a-uploads/New-piskel.png");
}
