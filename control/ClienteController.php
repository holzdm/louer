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

    case 'acessar':
        acessarCliente($_GET['pagina'] ?? null);
        break;

    case 'alterar':
        alterarCliente($_POST);
        break;
     case 'excluir':
         excluirCliente();
         break;

    default:
        // volta para a pagina anterior (se existir) e entrega a msg de Erro
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php') . "?msg=" . urlencode("Ação inválida!"));
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

            header("Location:../view/cliente/login-cliente.php?msg=Tudo pronto, $nome! Faça seu login e aproveite nossos serviços.");
            exit;
        }
        header("Location:../view/cliente/cadastro-cliente.php?msgErro=Não foi possível inserir.");
        exit;
    }
    header("Location:../view/cliente/cadastro-cliente.php?msgErro=$msgErro");
    exit;
}


function logarCliente($dadosPOST)
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

        if(!empty($_SESSION['Produto'])){
            header("Location: ../view/produto/pag-produto.php");
            exit;
        }
        header("Location:../view/pag-inicial.php");
        exit;
    } else {
        header("Location:../view/cliente/login-cliente.php?msgErro=Login Inválido!");
        exit;
    }
}

function sairCliente()
{
    // Limpa todas as variáveis de sessão
    $_SESSION = [];

    // Destroi o cookie de sessão, se existir
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destroi a sessão
    session_destroy();

    // Redireciona para a página inicial
    header("Location: ../view/pag-inicial.php");
    exit;
}

function acessarCliente($pagina){
    if (!isset($_SESSION['id'])) {
        header("Location: ../view/pag-inicial.php?msg=Cliente inválido.");
        exit;
    }
    if ($pagina === 'favoritos') {
        $idUsuario = $_SESSION['id'];

        $dadosUsuario = consultarCliente($idUsuario);
        $_SESSION['Usuario'] = $dadosUsuario;

        header("Location: ../view/cliente/pag-ic.php?pagina=favoritos");
        exit;
    }

    $idUsuario = $_SESSION['id'];

    $dadosUsuario = consultarCliente($idUsuario);
    $_SESSION['Usuario'] = $dadosUsuario;

    header("Location: ../view/cliente/pag-ic.php");
    exit;

}
function alterarCliente($dadosPOST){
    // recebe os dados do formulario de alteracao 
    $nome = $dadosPOST['nome'];
    $cidade = $dadosPOST['cidade'];
    $telefone = $dadosPOST['telefone'];
    $email = $dadosPOST['email'];
    $senha = $dadosPOST['senha'];
    $id = $dadosPOST['id'];
    $emailAntigo = $dadosPOST['emailAntigo'];
    //validar sem o cpf e cnpj
    $msgErro = validarCamposAlteracao($nome, $cidade, $telefone, $email, $senha, $emailAntigo);
    //alterando
    if (empty($msgErro)) {
        if (alterarDadosCliente($nome, $cidade, $telefone, $email, $senha, $id)) {
            //atualizando as variaveis de sessao
            $_SESSION['nome'] = $nome;
            $_SESSION['cidade'] = $cidade;
            $_SESSION['telefone'] = $telefone;
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;

            header("Location:../view/cliente/pag-ic.php?msg=Dados alterados com sucesso!");
            exit;
        }
        header("Location:../view/cliente/pag-ic.php?msgErro=Não foi possível alterar.");
        exit;
    }
}

function excluirCliente(){
    $id = $_SESSION['id'];

    if(excluirDadosCliente($id)){
        // destruir a sessão e redirecionar para a página inicial
        session_destroy();


        header("Location: /louer/view/pag-inicial.php?msg=Sua conta foi excluída com sucesso.");
        exit;
    } else {
        header("Location: /louer/view/pag-inicial.php?msgErro=Não foi possível excluir sua conta.");
        exit;
    }
}
