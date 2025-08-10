<?php
session_start();

require_once "../model/ProdutoDao.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        cadastrarProduto($_POST);
        break;

    case 'acessar':
        acessarProduto($_GET['id'] ?? null );
        break;

    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;

    default:
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view-bonitinha/pag-incial.php'));
        // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view-bonitinha/pag-incial-cliente.php') . "?msgErro=" . urlencode("Ação inválida!"));
        break;
}



function cadastrarProduto($dadosPOST){
    $nomeProduto = $dadosPOST['nomeProduto'];
    $valorProduto = $dadosPOST['valorProduto'];
    $descricaoProduto = $dadosPOST['descricaoProduto'];

    $idUsuario = $_SESSION['id'];

    if (isset($dadosPOST['arrayTags'])) {
        $tagsIds = array_map('intval', $dadosPOST['arrayTags']);  // Garante que são números inteiros
        $tagsIds = array_unique($tagsIds);               // Remove duplicatas (por segurança)
    }

    $np = inserirProduto($nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto);

    if ($np != null) {
        header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!");
        exit;
    }else{
       header("Location:../view-bonitinha/fornecedor/pag-novo-produto.php?msgErro=Erro ao adicionar produto. Tente novamente.");
       exit;
    }
}

function acessarProduto($idProduto){
    if (!$idProduto){
        header("Location: ../view-bonitinha/pag-inicial.php?msgErro=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto); 
    $_SESSION['Produto'] = $dadosProduto;


    if (isset($dadosProduto)){
        header("Location: ../view/pag-produto.php");
        exit;
    }else{
        header("Location: ../view-bonitinha/pag-inicial.php");
        exit;
    }

}





?>