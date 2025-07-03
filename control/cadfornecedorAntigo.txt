<?php
session_start();
$email = $_SESSION['email'];
$senha = $_SESSION['senha'];
// RECEBIMENTO DOS DADOS DA pag-cad-fornecedor

$cep = $_POST['cep'];
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$nEnd = $_POST['nEnd'];
$complemento = $_POST['complemento'];

// VERIFICACAO 

require_once "FuncoesUteis.php";
$msgErro = validarCamposFornecedor($cep, $rua, $bairro, $nEnd);

if ( empty($msgErro) ) {
        
        // Operação

    require_once "../model/FornecedorDao.php";

    if (inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha)) {
        inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento, $email, $senha);

    // Devolver a mensagem de sucesso
        header("Location:../view/fornecedor/pag-inicial-fornecedor.php?msg=Tudo pronto! Comece adicionando um produto ★");

    }else{
        header("Location:../view/fornecedor/pag-cad-fornecedor.php?msg=$msgErro");
    }
        // ta bem baguncado, com mais tempo eu organizo da melhor forma pra n ter q ter esses dois elses
} else {
    header("Location:../view/fornecedor/pag-cad-fornecedor.php?msg=$msgErro");
}
?>