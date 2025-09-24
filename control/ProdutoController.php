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
        cadastrarImgProduto($_POST, $_FILES['imagens']);
        break;

    case 'cancelarCadastro':
        cancelarCadastro();
        break;

    case 'acessar':
        acessarProduto($_GET['id'] ?? null);
        break;

    case 'pesquisar':
        pesquisarProdutos($_POST);
        break;

    case 'alterar':
        alterarProduto($_POST);
        break;
    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;

    default:
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php'));
        // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php') . "?msgErro=" . urlencode("Ação inválida!"));
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
        header("Location:../view/produto/pag-novo-produto.php?msgErro=$msgErro");
        exit;
    }

    if ($tipoProduto == 'Equipamento') {
        // header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!"); adicionar essa depois de adicionar as fotos
        header("Location: ../view/produto/pag-novo-produto-img.php");
        exit;
    }
    header("Location: ../view/produto/pag-novo-produto-end.php");
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
        header("Location:../view/produto/pag-novo-produto-end.php?msgErro=$msgErro");
        exit;
    }

    header("Location: ../view/produto/pag-novo-produto-img.php");
}

function cadastrarImgProduto($dadosPOST, $arquivos)
{
    $arquivos = $_FILES['imagens'];
    $mensagensErro = [];
    $imagensValidadas = []; // aqui vamos armazenar apenas as válidas temporariamente

    // Loop de validação
    for ($i = 0; $i < count($arquivos['name']); $i++) {
        $imagem = [
            'name' => $arquivos['name'][$i],
            'type' => $arquivos['type'][$i],
            'tmp_name' => $arquivos['tmp_name'][$i],
            'error' => $arquivos['error'][$i],
            'size' => $arquivos['size'][$i]
        ];

        $msgErro = verificarImagem($imagem);
        if ($msgErro) {
            $mensagensErro[] = "Arquivo {$imagem['name']}: $msgErro";
        } else {
            // se válida, adiciona ao array temporário
            $imagensValidadas[] = $imagem;
        }
    }

    if (!empty($mensagensErro)) {
        // Tem erro: não salva nada, envia mensagens de erro e mantém seleção
        $_SESSION['imagensSelecionadas'] = $arquivos; // para manter as imagens selecionadas
        header("Location: ../view/cadastrar-imagens.php?msgErro=$mensagensErro");
        exit;
    }
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
        $numero = $formData['numero'] ?? [];
        $complemento = $formData['complemento'] ?? [];


        $np = inserirProduto($tipoProduto, $nomeProduto, $imagensValidadas, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento);
        if ($np) {
            header("Location: ../view/fornecedor/pag-inicial-fornecedor.php");
            exit;
        }
        header("Location: ../view/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao inserir produto.");
        exit;
    }
    header("Location: ../view/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao adicionar produto.");
    exit;
}


function acessarProduto($idProduto)
{
    if (!$idProduto) {
        header("Location: ../view/pag-inicial.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto);
    $_SESSION['Produto'] = $dadosProduto;


    if (isset($dadosProduto)) {
        header("Location: ../view/produto/pag-produto.php");
        exit;
    } else {
        header("Location: ../view/pag-inicial.php");
        exit;
    }
}

function cancelarCadastro()
{
    if (isset($_SESSION['formData'])) {
        unset($_SESSION['formData']);
    }
    header("Location: ../view/fornecedor/pag-inicial-fornecedor.php");
    exit;
}

function pesquisarProdutos($dadosPesquisa)
{

    $conteudoPesquisa = $dadosPesquisa['pesquisa'];

    $_SESSION['conteudoPesquisa'] = $conteudoPesquisa;
    header("Location: ../view/pag-inicial.php");
    exit;
}

function alterarProduto($idProduto)
{

    echo ("criar no controller o direcionamento para a pagina de alterar os produtos, assim como no acessarProduto");
}
