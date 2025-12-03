<?php
session_start();

require_once '../model/FornecedorDao.php';
require_once "FuncoesUteis.php";
require_once "../model/ClienteDao.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        cadastrarFornecedor($_POST);
        break;

    case 'alterar':
        alterarFornecedor($_POST);
        break;

    case 'acessar':
        acessarFornecedor();
        break;

        case 'excluir':
            excluirFornecedor();
            break;

    default:
        // volta para a pagina anterior (se existir) e entrega a msg de Erro
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php') . "?msg=" . urlencode("Ação inválida!"));
        break;
}

function cadastrarFornecedor($dadosPost)
{
    // Verifica se o usuário está logado (precisa do email e senha da sessão)
    if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
        header("Location:../view/cliente/login-cliente.php?msgErro=É necessário estar logado para se cadastrar como fornecedor.");
        exit;
    }

    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];

    // Recebimento dos dados do formulário
    $cep = $dadosPost['cep'] ?? '';
    $rua = $dadosPost['rua'] ?? '';
    $bairro = $dadosPost['bairro'] ?? '';
    $nEnd = $dadosPost['nEnd'] ?? '';
    $complemento = $dadosPost['complemento'] ?? '';

    // Validação dos dados
    require_once "FuncoesUteis.php";
    $msgErro = validarCamposFornecedor($cep, $rua, $bairro, $nEnd);

    if (empty($msgErro)) {

        inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha);
        $_SESSION['tipo'] = 'Fornecedor';
        $msg = urlencode("Comece adicionando um produto ★");
        header("Location:/louer/view/fornecedor/pag-inicial-fornecedor.php?msg=$msg");
    } else {
        header("Location:/louer/view/fornecedor/pag-cad-fornecedor.php?msg=" . urlencode($msgErro)); //urlencore é para evitar problemas com caracteres especiais na mensagem
    }
}

function acessarFornecedor()
{

    $id = $_SESSION['id'];

    $dadosUsuario = consultarCliente($id);

    if ($dadosUsuario) {
        $_SESSION['cep'] = $dadosUsuario['cep'];
        $_SESSION['bairro'] = $dadosUsuario['bairro'];
        $_SESSION['rua'] = $dadosUsuario['rua'];
        $_SESSION['nEnd'] = $dadosUsuario['numero'];
        $_SESSION['complemento'] = $dadosUsuario['complemento'];

        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php");
        exit;
    } else {
        header("Location: /louer/view/fornecedor/pag-inicial.php?msgErro=Não foi possível acessar seus dados de Fornecedor");
        exit;
    }
}

function alterarFornecedor($dadosPOST)
{
    // Recebimento dos dados do formulário
    $cep = $dadosPOST['cep'] ?? '';
    $rua = $dadosPOST['rua'] ?? '';
    $bairro = $dadosPOST['bairro'] ?? '';
    $nEnd = $dadosPOST['nEnd'] ?? '';
    $complemento = $dadosPOST['complemento'] ?? '';

    // Validação dos dados
    require_once "FuncoesUteis.php";
    $msgErro = validarCamposFornecedor($cep, $rua, $bairro, $nEnd);


    //alterando
    if (empty($msgErro)) {
        if (alterarDadosFornecedor($cep, $bairro, $rua, $nEnd, $complemento, $id)) {
            //atualizando as variaveis de sessao
            $_SESSION['cep'] = $cep;
            $_SESSION['bairro'] = $bairro;
            $_SESSION['rua'] = $rua;
            $_SESSION['nEnd'] = $nEnd;
            $_SESSION['complemento'] = $complemento;

            header("Location:/louer/view/fornecedor/pag-inicial-fornecedor.php?msg=Dados alterados com sucesso!");
            exit;
        }
        header("Location:/louer/view/fornecedor/pag-inicial-fornecedor.php?msgErro=Não foi possível alterar.");
        exit;
    }
    header("Location:/louer/view/fornecedor/pag-inicial-fornecedor.php?msgErro=$msgErro");
        exit;
}

function excluirFornecedor(){
    $id = $_SESSION['id'];



    if(excluirDadosFornecedor($id)){
        // destruir a sessão e redirecionar para a página inicial
        $_SESSION['tipo'] = 'Cliente';
        unset($_SESSION['cep']);
        unset($_SESSION['bairro']);
        unset($_SESSION['rua']);
        unset($_SESSION['numero']);
        unset($_SESSION['complemento']);


        header("Location: /louer/view/pag-inicial.php?msg=Sua conta de fornecedor foi excluída com sucesso.");
        exit;
    } else {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?msgErro=Não foi possível excluir sua conta de fornecedor.");
        exit;
    }
}