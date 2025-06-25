<?php
session_start();

$nomeProduto = $_POST['nomeProduto'];
$tag = $_POST['tag'];
$idUsuario = $_SESSION['id'];

require_once "../model/ProdutoDao.php";

if (null !== inserirProduto($nomeProduto, $tag, $idCliente)){
    $np = inserirProduto($nomeProduto, $tag, $idCliente);
    header("Location:../view/fornecedor/pag-inicial-fornecedor.php?msg=Produto $np adicionado com sucesso!");
}else{
    header("Location:../view/fornecedor/pag-novo-produto.php?msgErro=Erro ao adicionar produto. Tente novamente.");
}





?>