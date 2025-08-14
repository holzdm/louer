<?php
session_start();



require_once "../model/ProdutoDao.php";
require_once "FuncoesUteis.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        cadastrarProduto($_POST);
        break;
    
    case 'cadastrarEnd':
        cadastrarEnderecoProduto($_POST);
        break;

    case 'cadastrarImg':
        cadastrarImgProduto($_POST);
        break;

    case 'acessar':
        acessarProduto($_GET['id'] ?? null);
        break;

    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;

    default:
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view-bonitinha/pag-incial.php'));
        // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view-bonitinha/pag-incial-cliente.php') . "?msgErro=" . urlencode("Ação inválida!"));
        break;
}



function cadastrarProduto($dadosPOST)
{
    $tipoProduto = $dadosPOST['tipoProduto'] ?? [];
    $nomeProduto = $dadosPOST['nomeProduto'] ?? [];
    $valorProduto = $dadosPOST['valorProduto'] ?? [];
    $descricaoProduto = $dadosPOST['descricaoProduto'];
    $diasDisponiveis = $dadosPOST['diasDisponiveis'] ?? [];

    $msgErro = validarCamposProduto( $nomeProduto, $valorProduto, $diasDisponiveis);
        
    if ($msgErro) {
        $_SESSION['formData'] = $_POST;
        header("Location:../view-bonitinha/fornecedor/pag-novo-produto.php?msgErro=$msgErro");
        exit;
    }
        // Operação
    
    $idUsuario = $_SESSION['id'];

    if (isset($dadosPOST['arrayTags'])) {
        $tagsIds = array_map('intval', $dadosPOST['arrayTags']);  // Garante que são números inteiros
        $tagsIds = array_unique($tagsIds);               // Remove duplicatas (por segurança)
    }

    $np = inserirProduto($tipoProduto, $nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis);

    if ($np) {
        if ($tipoProduto == 'Equipamento') {
            // header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!"); adicionar essa depois de adicionar as fotos
            header("Location: ../view-bonitinha/fornecedor/pag-novo-produto-img.php");
            exit;
        } else {
            header("Location: ../view-bonitinha/fornecedor/pag-novo-produto-end.php");
        }
    } else {
        header("Location:../view-bonitinha/fornecedor/pag-novo-produto.php?msgErro=Erro ao adicionar produto. Tente novamente.");
        exit;
    }
}

function cadastrarEnderecoProduto(){

}

function cadastrarImgProduto($dadosPOST){

    header("Location: ../view/fornecedor/pag-inicial-fornecedor0.php");
    exit;
}

function acessarProduto($idProduto)
{
    if (!$idProduto) {
        header("Location: ../view-bonitinha/pag-inicial.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto);
    $_SESSION['Produto'] = $dadosProduto;


    if (isset($dadosProduto)) {
        header("Location: ../view/pag-produto.php");
        exit;
    } else {
        header("Location: ../view-bonitinha/pag-inicial.php");
        exit;
    }
}
