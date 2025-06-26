<?php
session_start();

$nomeProduto = $_POST['nomeProduto'];
$idUsuario = $_SESSION['id'];
if (isset($_POST['arrayTags'])) {
    $tagsIds = array_map('intval', $_POST['arrayTags']);  // Garante que são números inteiros
    $tagsIds = array_unique($tagsIds);               // Remove duplicatas (por segurança)
}

require_once "../model/ProdutoDao.php";
$np = inserirProduto($nomeProduto, $tagsIds, $idUsuario);

if ($np != null) {
    header("Location:../view/fornecedor/pag-inicial-fornecedor.php?msg=Produto $np adicionado com sucesso!");
}else{
    header("Location:../view/fornecedor/pag-novo-produto.php?msgErro=Erro ao adicionar produto. Tente novamente.");
}





?>