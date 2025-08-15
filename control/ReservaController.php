<?php
session_start();



require_once "../model/ReservaDao.php";
require_once "FuncoesUteis.php";

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'solicitar':
        solicitarReserva($_POST);
        break;

    case 'cadastrarEnd':
        cadastrarEnderecoProduto($_POST);
        break;

    case 'cadastrarImg':
        cadastrarImgProduto($_POST);
        break;

    case 'acessar':
        acessarProduto($_GET['id'] ?? null);
        break;

    // case 'excluir':
    //     excluirCliente($_GET['id'] ?? null);
    //     break;

    default:
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php'));
        // header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../view/pag-incial.php') . "?msgErro=" . urlencode("Ação inválida!"));
        break;
}


function solicitarReserva($dadosPOST)
{

    $idUsuario = $_SESSION['id'];
    $idProduto = $dadosPOST['idProduto'];
    $intervalo = $dadosPOST['intervalo'] ?? '';

    date_default_timezone_set('America/Sao_Paulo'); // seu timezone local
    $dataSolicitacao = date('Y-m-d');
    
    $valorProduto = $dadosPOST['valorProduto'];

    if (!empty($intervalo)) {
        list($dataInicio, $dataFinal) = array_map('trim', explode('to', $intervalo));
    } else {
        // Se estiver vazio, usar a data de hoje como padrão
        $dataHoje = date('Y-m-d');
        $dataInicio = $dataHoje;
        $dataFinal = $dataHoje;
    }

    // calculo valor da reserva

    if (strtotime($dataFinal) < strtotime($dataInicio)) {
        $temp = $dataFinal;
        $dataFinal = $dataInicio;
        $dataInicio = $temp;
    }


    $Inicio = new DateTime($dataInicio);
    $Final = new DateTime($dataFinal);

    $dias = $Inicio->diff($Final)->days + 1;

    $valorReserva = $dias*$valorProduto;


    if (inserirSolicitacaoReserva($idUsuario, $idProduto, $valorReserva, $dataInicio, $dataFinal, $dataSolicitacao)) {
        header("Location: ../view/produto/pag-produto.php?msg=Solicitação de reserva enviada!");
        exit;
    }
    header("Location: ../view/produto/pag-produto.php?msg=Não foi possivel realizar a solicitação.");


    
}
