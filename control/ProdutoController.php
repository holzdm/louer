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

    case 'cancelarCadastro':
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
    $tipoProduto = $dadosPOST['tipoProduto'];
    $nomeProduto = $dadosPOST['nomeProduto'] ?? [];
    $valorProduto = $dadosPOST['valorProduto'] ?? [];
    $diasDisponiveis = $dadosPOST['diasDisponiveis'] ?? [];

    $msgErro = validarCamposProduto($nomeProduto, $valorProduto, $diasDisponiveis);

    // $dadosPOST['diasDisponiveis'] = $_POST['diasDisponiveis'] ?? [];
    $dadosPOST['tagsIds'] = isset($_POST['arrayTags'])
        ? array_unique(array_map('intval', $_POST['arrayTags']))
        : [];

    $_SESSION['formData'] = $dadosPOST;


    if (!empty($msgErro)) {
        header("Location:../view-bonitinha/fornecedor/pag-novo-produto.php?msgErro=$msgErro");
        exit;
    }

    if ($tipoProduto == 'Equipamento') {
        // header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!"); adicionar essa depois de adicionar as fotos
        header("Location: ../view-bonitinha/fornecedor/pag-novo-produto-img.php");
        exit;
    }
    header("Location: ../view-bonitinha/fornecedor/pag-novo-produto-end.php");
    exit;
}


function cadastrarEnderecoProduto($dadosPOST)
{
    $cepProduto = $dadosPOST['cep'] ?? [];
    $cidadeProduto = $dadosPOST['cidade'] ?? [];
    $bairroProduto = $dadosPOST['bairro'] ?? [];
    $ruaProduto = $dadosPOST['rua'] ?? [];
    $numeroProduto = $dadosPOST['numero'] ?? [];



    $msgErro = validarCamposProduto($cepProduto, $cidadeProduto, $bairroProduto, $ruaProduto, $numeroProduto);

    $_SESSION['formData'] = array_merge($_SESSION['formData'], $dadosPOST);

    if (!empty($msgErro)) {
        header("Location:../view-bonitinha/fornecedor/pag-novo-produto-end.php?msgErro=$msgErro");
        exit;
    }

    header("Location: ../view-bonitinha/fornecedor/pag-novo-produto-img.php");
}

function cadastrarImgProduto($dadosPOST)
{

    // verificacao da imagem


    // Operação

    $idUsuario = $_SESSION['id'];

    $formData = $_SESSION['formData'] = array_merge($_SESSION['formData'], $dadosPOST);

    if (!empty($formData)) {
        $tipoProduto = $formData['tipoProduto'];
        $nomeProduto = $formData['nomeProduto'];
        $valorProduto = $formData['valorProduto'];
        $descricaoProduto = $formData['descricaoProduto'] ?? [];
        $tagsIds = $formData['tagsIds'] ?? [];
        $diasDisponiveis = $formData['diasDisponiveis'];
        $cep = $formData['cep'] ?? [];
        $cidade = $formData['cidade'] ?? [];
        $bairro = $formData['bairro'] ?? [];
        $rua = $formData['rua'] ?? [];
        $numero = $formData['numero'];
        $complemento = $formData['complemento'] ?? [];



        $np = inserirProduto($tipoProduto, $nomeProduto, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento);
        if ($np) {
            header("Location: ../view-bonitinha/fornecedor/pag-inicial-fornecedor.php");
            exit;
        }
        header("Location: ../view-bonitinha/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao inserir produto.");
        exit;
    }
    header("Location: ../view-bonitinha/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao adicionar produto.");
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

function cancelarCadastroProduto()
{
    if (isset($_SESSION['formData'])) {
        unset($_SESSION['formData']);
    }
    header("Location: ../view-bonitinha/fornecedor/pag-inicial-fornecedor.php");
    exit;
}
