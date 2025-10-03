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
    
    case 'removerImg':
        removerImgProduto($_GET['nomeImg']);
        break;

    case 'cadastrarProdutoFinal':
        cadastrarProdutoFinal();
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

    case 'acessarMeuProduto':
        acessarProdutoPraAlterar($_GET['id'] ?? null);
        break;

    case 'alterarDatas':
        alterarDatasProduto($_POST);
        break;

    case 'alterar':
        alterarDadosProduto($_POST);
        break;
    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;
    case 'excluir':
        excluirProduto($_GET['id'] ?? null);
        break;


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
    $diasDisponiveisProduto = $dadosPOST['diasDisponiveis'] ?? [];

    $msgErro = validarCamposProduto($nomeProduto, $valorProduto, $diasDisponiveisProduto);

    // $dadosPOST['diasDisponiveis'] = $_POST['diasDisponiveis'] ?? [];
    $dadosPOST['tagsIds'] = isset($_POST['arrayTags'])
        ? array_unique(array_map('intval', $_POST['arrayTags']))
        : [];

    $_SESSION['novoProduto']['tipoProduto'] = $tipoProduto;
    $_SESSION['novoProduto']['nomeProduto'] = $nomeProduto;
    $_SESSION['novoProduto']['valorProduto'] = $valorProduto;
    $_SESSION['novoProduto']['diasDisponiveis'] = $diasDisponiveisProduto;


    if (!empty($msgErro)) {
        header("Location:/louer/view/produto/pag-novo-produto.php?msgErro=$msgErro");
        exit;
    }

    if ($tipoProduto == 'Equipamento') {
        // header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=Produto $np adicionado com sucesso!"); adicionar essa depois de adicionar as fotos
        header("Location: /louer/view/produto/pag-novo-produto-img.php");
        exit;
    }
    header("Location: /louer/view/produto/pag-novo-produto-end.php");
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

    $_SESSION['novoProduto']['cepProduto'] = $cepProduto;
    $_SESSION['novoProduto']['cidadeProduto'] = $cidadeProduto;
    $_SESSION['novoProduto']['bairroProduto'] = $bairroProduto;
    $_SESSION['novoProduto']['ruaProduto'] = $ruaProduto;
    $_SESSION['novoProduto']['numeroProduto'] = $numeroProduto;


    if (!empty($msgErro)) {
        header("Location:/louer/view/produto/pag-novo-produto-end.php?msgErro=$msgErro");
        exit;
    }

    header("Location: /louer/view/produto/pag-novo-produto-img.php");
}

function cadastrarImgProduto($arquivos)
{
    $arquivos = $_FILES['imagens'];
    $mensagensErro = [];
    if (!isset($_SESSION['novoProduto']['imagens'])) {
        $_SESSION['novoProduto']['imagens'] = [];
    }
    // Loop de validação
    for ($i = 0; $i < count($arquivos['name']); $i++) {
        $imagem = [
            'name' => sanitizeFilename($arquivos['name'][$i]),
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
            $_SESSION['novoProduto']['imagens'][] = $imagem;
        }
    }

    header("Location:/louer/view/produto/novo-produto-img.php?msgErro=$mensagensErro");
}

function removerImgProduto($dadosPOST){
    $nomeImg = $dadosPOST['nomeImg'];

    // verifica se o array existe e se o índice está definido
    if(isset($_SESSION['novoProduto']['imagens'][$nomeImg])){
        unset($_SESSION['novoProduto']['imagens'][$nomeImg]);
    }
}

function cadastrarProdutoFinal()
{

    // Operação

    $idUsuario = $_SESSION['id'];
    $novoProduto = $_SESSION['novoProduto'];


    if (!empty($novoProduto)) {
        $tipoProduto = $novoProduto['tipoProduto'];
        $nomeProduto = $novoProduto['nomeProduto'];
        $valorProduto = $novoProduto['valorProduto'];
        $descricaoProduto = $novoProduto['descricaoProduto'] ?? [];
        $tagsIds = $novoProduto['tagsIds'] ?? [];
        $diasDisponiveis = $novoProduto['diasDisponiveisProduto'];
        $cep = $novoProduto['cepProduto'] ?? [];
        $cidade = $novoProduto['cidadeProduto'] ?? [];
        $bairro = $novoProduto['bairroProduto'] ?? [];
        $rua = $novoProduto['ruaProduto'] ?? [];
        $numero = $novoProduto['numeroProduto'] ?? [];
        $complemento = $novoProduto['complementoProduto'] ?? [];
        $imagensValidadas = $novoProduto['imagens'] ?? [];


        $np = inserirProduto($tipoProduto, $nomeProduto, $imagensValidadas, $tagsIds, $idUsuario, $valorProduto, $descricaoProduto, $diasDisponiveis, $cep, $cidade, $bairro, $rua, $numero, $complemento);
        if ($np) {
            header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
            exit;
        }
        header("Location: /louer/view/produto/novo-produto-img.php?msgErro=Erro ao inserir produto.");
        exit;
    }
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msgErro=Erro ao adicionar produto.");
    exit;
}


function acessarProduto($idProduto)
{
    if (!$idProduto) {
        header("Location: ../view/pag-inicial.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }
    $dadosProduto = consultarProduto($idProduto);
    if (isset($dadosProduto)) {

        $_SESSION['Produto'] = $dadosProduto;
        header("Location: /louer/view/produto/pag-produto.php");
        exit;
    } else {
        header("Location: /louer/view/pag-inicial.php");
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

function acessarProdutoPraAlterar($idProduto)
{
    if (!$idProduto) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto inválido. (ProdutoController)");
        exit;
    }

    $dadosProduto = consultarProduto($idProduto);
    $_SESSION['Produto'] = $dadosProduto;

    if (isset($dadosProduto)) {
        header("Location: /louer/view/produto/pag-produto-alterar.php");
        exit;
    } else {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
        exit;
    }
}

function alterarDatasProduto($dadosPOST)
{
    $idProduto = $dadosPOST['idProduto'] ?? null;
    /**
     * Verifica se o método é POST.
     * Caso contrário, manda um erro
     */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        die('Método não é POST.');
    }

    /**
     * Verifica se o parâmetro foi enviado
     * ou se está vazio
     */
    if (!isset($_POST["datas_selecionadas"]) || empty($_POST["datas_selecionadas"])) {
        http_response_code(400);
        die('Nenhuma data selecionada.');
    }

    /**
     * Seleciona a lista de datas como string
     */
    $datas_json = $_POST["datas_selecionadas"];
    /**
     * transformando a string
     * em lista normal de volta
     */
    $datas = json_decode($datas_json);

    /**
     * Verifica se a conversão aconteceu com sucesso
     */
    if ($datas === null || !is_array($datas)) {
        http_response_code(400);
        die('Formato de dados inválido.');
    }

    /**
     * Verifica se há pelo menos uma data
     */
    if (count($datas) === 0) {
        http_response_code(400);
        die('Nenhuma data válida foi encontrada.');
    }

    require_once "/louer/model/ProdutoDao.php";
    excluirDatasAntigas($idProduto);

    foreach ($datas as $data) {
        var_dump($idProduto);
        updateDatasProduto($idProduto, $data);
    }
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Produto alterado com sucesso!");
    exit;
}

function alterarDadosProduto($dadosPOST)
{
    // recebe os dados do formulario de alteracao 
    $idProduto = $dadosPOST['idProduto'];
    $nome = $dadosPOST['nome'];
    $valorHora = $dadosPOST['valorHora'];
    $descricaoProduto = $dadosPOST['descricaoProduto'] ?? null;
    $disponibilidadesFake = "aaa";
    //validar sem o cpf e cnpj
    $msgErro = validarCamposProduto($nome, $valorHora, $disponibilidadesFake);
    //alterando
    if (empty($msgErro)) {

        if (updateDadosProduto($nome, $valorHora, $descricaoProduto, $idProduto)) {
            //atualizando as variaveis de sessao
            $_SESSION['Produto']['nome'] = $nome;
            $_SESSION['Produto']['valorHora'] = $valorHora;
            $_SESSION['Produto']['descricao'] = $descricaoProduto;

            header("Location:/louer/view/produto/pag-produto-alterar.php?msg=Dados alterados com sucesso!");
            exit;
        }
        header("Location:/louer/view/produto/pag-produto-alterar.php?msgErro=Não foi possível alterar.");
        exit;
    }
}

function excluirProduto($idProduto)
{
    deleteProduto($idProduto);
    header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
}
