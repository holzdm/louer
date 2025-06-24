<?php

session_start();


$email = $_POST['email'];
$senha = $_POST['senha'];



// CRIAR FUNCAO PARA CHECAR SE EXISTE NO BANCO
require_once "../model/ClienteDao.php";

$cliente = pesquisarCliente($email, $senha);

if ($cliente){
    // operacoes




    header("Location:../view/cliente/pag-inicial-cliente.php");
}else{
    header("Location:../view/pag-login.php?msgErro=Login Inválido!");
}






?>