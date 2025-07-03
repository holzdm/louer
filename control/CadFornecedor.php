<?php
session_start();

// Verifica se o usuário está logado (precisa do email e senha da sessão)
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header("Location:../pagCadastroLogin/login-cliente.php?msgErro=É necessário estar logado para se cadastrar como fornecedor.");
    exit;
}

$email = $_SESSION['email'];
$senha = $_SESSION['senha'];

// Recebimento dos dados do formulário
$cep = $_POST['cep'] ?? '';
$rua = $_POST['rua'] ?? '';
$bairro = $_POST['bairro'] ?? '';
$nEnd = $_POST['nEnd'] ?? '';
$complemento = $_POST['complemento'] ?? '';

// Validação dos dados
require_once "FuncoesUteis.php";
$msgErro = validarCamposFornecedor($cep, $rua, $bairro, $nEnd);

if (empty($msgErro)) {

    require_once "../model/FornecedorDao.php";
    inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha);
    header("Location:../view/fornecedor/pag-inicial-fornecedor0.php?msg=" . urlencode("Tudo pronto! Comece adicionando um produto ★"));

} else {
    header("Location:../view-bonitinha/fornecedor/pag-cad-fornecedor.php?msg=" . urlencode($msgErro)); //urlencore é para evitar problemas com caracteres especiais na mensagem
}

?>