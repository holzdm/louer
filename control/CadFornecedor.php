<?php
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
    $id = inserirFornecedor($cep, $rua, $bairro, $nEnd, $complemento);
        
        // Devolver a mensagem de sucesso

    header("Location:../view/fornecedor/pag-inicial-fornecedor.php?msg=Tudo pronto! Comece adicionando um produto ★");

} else {
    header("Location:../view/fornecedor/pag-cad-fornecedor.php?msg=$msgErro");
}
?>