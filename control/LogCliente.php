<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
}

// CRIAR FUNCAO PARA CHECAR SE EXISTE NO BANCO
require_once "../model/ClienteDao.php";

$cliente = pesquisarCliente($email, $senha);

if ($cliente){
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
}else{
    header("Location:../view-bonitinha/pagCadastroLogin/login-cliente.php?msgErro=Login Inválido!");
}






?>