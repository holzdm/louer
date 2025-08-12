<?php
session_start();

require_once '../model/ClienteDao.php';
require_once "FuncoesUteis.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'cadastrar':
        cadastrarCliente($_POST);
        break;

    case 'logar':
        logarCliente($_POST);
        break;

    case 'sair':
        sairCliente();
        break;

    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;

    default:
        // volta para a pagina anterior (se existir) e entrega a msg de Erro
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view-bonitinha/pag-incial-cliente.php') . "?msgErro=" . urlencode("Ação inválida!"));
        break;
}

function cadastrarCliente($dadosPOST)
{
    // RECEBIMENTO DOS DADOS DA pag-cad-cliente

    $nome = $dadosPOST['nome'];
    $cpf = $dadosPOST['cpf'];
    $cnpj = $dadosPOST['cnpj'];
    $cidade = $dadosPOST['cidade'];
    $telefone = $dadosPOST['telefone'];
    $email = $dadosPOST['email'];
    $senha = $dadosPOST['senha'];

    // VERIFICACAO 

    $msgErro = validarCampos($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha);

    if (empty($msgErro)) {

        // Operação

        if (inserirCliente($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha)) {
            // Devolver a mensagem de sucesso

            header("Location:../view-bonitinha/pagCadastroLogin/login-cliente.php?msg=Tudo pronto, $nome! Faça seu login e aproveite nossos serviços.");
            exit;
        }
        header("Location:../view-bonitinha/pagCadastroLogin/cadastro-cliente.php?msgErro=Não foi possível inserir.");
        exit;
    }
    header("Location:../view-bonitinha/pagCadastroLogin/cadastro-cliente.php?msgErro=$msgErro");
    exit;
}


function LogarCliente($dadosPOST)
{

    $senha = $dadosPOST['senha'];
    $email = $dadosPOST['email'];


    $cliente = pesquisarCliente($senha, $email);

    if ($cliente) {
        // variaveis da sessao
        $_SESSION['id'] = $cliente['id'];
        $_SESSION['nome'] = $cliente['nome'];
        $_SESSION['tipo'] = $cliente['tipo'];
        $_SESSION['cpf'] = $cliente['cpf'];
        $_SESSION['cnpj'] = $cliente['cnpj'];
        $_SESSION['cidade'] = $cliente['cidade'];
        $_SESSION['telefone'] = $cliente['telefone'];
        $_SESSION['email'] = $cliente['email'];
        $_SESSION['senha'] = $cliente['senha']; // A SENHA NAO ESTA SEGURA DESSA FORMA, TROCAR EVENTUALMENTE
        $_SESSION['cep'] = $cliente['cep'];
        $_SESSION['bairro'] = $cliente['bairro'];
        $_SESSION['rua'] = $cliente['rua'];
        $_SESSION['numero'] = $cliente['numero'];
        $_SESSION['complemento'] = $cliente['complemento'];
        $_SESSION['conta_ativa'] = $cliente['conta_ativa'];

        header("Location:../view-bonitinha/pag-inicial-cliente.php");
        exit;
    } else {
        header("Location:../view-bonitinha/pagCadastroLogin/login-cliente.php?msgErro=Login Inválido!");
        exit;
    }
}

function sairCliente(){
    if (isset($_SESSION['id'])){
        session_unset();
        session_destroy();
        header("Location: ../view-bonitinha/pag-inicial.php");
        exit;
    }
    
}