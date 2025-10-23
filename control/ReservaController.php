<?php
session_start();



require_once "../model/ReservaDao.php";
require_once "FuncoesUteis.php";


$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

switch ($acao) {
    case 'solicitar':
        solicitarReserva($_POST);
        break;

    case 'acessar':
        acessarReserva($_GET['id'] ?? null);
        break;

    case 'acessarFornecedor':
        acessarReservaComoFornecedor($_GET['id'] ?? null);
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

    $valorReserva = $dias * $valorProduto;


    if (inserirSolicitacaoReserva($idUsuario, $idProduto, $valorReserva, $dataInicio, $dataFinal, $dataSolicitacao)) {
        header("Location: ../view/produto/pag-produto.php?msg=Solicitação de reserva enviada!");
        exit;
    }
    header("Location: ../view/produto/pag-produto.php?msg=Não foi possivel realizar a solicitação.");
}
function acessarReserva($idReserva)
{

    if (!$idReserva) {
        header("Location: ../view/cliente/pag-ic.php?msg=Reserva inválida.");
        exit;
    }
    require_once "../model/ProdutoDao.php";

    $dadosReserva = consultarReserva($idReserva);
    $IdProduto = $dadosReserva['idProduto'];
    $dadosProduto = consultarProduto($IdProduto);


    $_SESSION['Reserva'] = array_merge($dadosProduto, $dadosReserva);


    if (isset($dadosProduto)) {
        header("Location: ../view/cliente/pag-reserva.php");
        exit;
    } else {
        header("Location: ../view/cliente/pag-ic.php");
        exit;
    }
}

function acessarReservaComoFornecedor($idReserva)
{
    header('Content-Type: application/json');

    if (!$idReserva) {
        echo json_encode(['erro' => 'Reserva inválida']);
        exit;
    }

    require_once "../model/ProdutoDao.php";
    require_once "../model/ClienteDao.php";

    $dadosReserva = consultarReserva($idReserva);

    if (!$dadosReserva) {
        echo json_encode(['erro' => 'Reserva não encontrada']);
        exit;
    }

    $idProduto = $dadosReserva['idProduto'];
    $idCliente = $dadosReserva['idUsuario'];

    $dadosProduto = consultarProduto($idProduto);
    $dadosCliente = consultarCliente($idCliente);

    // Monta resposta com os campos que você precisa no modal
    $resposta = [
        'nomeUsuario'   => $dadosCliente['nomeUsuario'],
        'emailUsuario'  => $dadosCliente['email'],
        'nome'          => $dadosProduto['nome'],
        'descricao'     => $dadosProduto['descricao'] ?? '',
        'dataInicial'   => $dadosReserva['dataInicial'],
        'dataFinal'     => $dadosReserva['dataFinal'],
        'valorReserva'  => $dadosReserva['valorReserva'],
        'status'        => $dadosReserva['status']
    ];

    echo json_encode($resposta);
    exit;
}
