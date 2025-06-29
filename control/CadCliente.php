<?php
// RECEBIMENTO DOS DADOS DA pag-cad-cliente

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$cnpj = $_POST['cnpj'];
$cidade = $_POST['cidade'];
$telefone = $_POST['telefone']; 
$email = $_POST['email'];
$senha = $_POST['senha'];

// VERIFICACAO 

require_once "FuncoesUteis.php";
$msgErro = validarCampos($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha);

if ( empty($msgErro) ) {
        
        // Operação

    require_once "../model/ClienteDao.php";
    $id = inserirCliente($nome, $cpf, $cnpj, $cidade, $telefone, $email, $senha);
        
        // Devolver a mensagem de sucesso

    header("Location:../view-bonitinha/pagCadastroLogin/login-cliente.php?msg=Tudo pronto, $nome! Faça seu login e aproveite nossos serviços.");

} else {
    header("Location:../view/cliente/pag-cad-cliente.php?msg=$msgErro");
}



?>