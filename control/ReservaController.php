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
        acessarReserva($_GET['idReserva'] ?? null);
        break;

    case 'acessarFornecedor':
        acessarReservaComoFornecedor($_GET['idReserva'] ?? null);
        break;

    case 'aceitar':
        aceitarSolicitacao($_POST['idReserva'] ?? null);
        break;

    case 'recusar':
        recusarSolicitacao($_POST['idReserva'] ?? null);
        break;

    case 'cancelar':
        cancelarReserva($_POST['idReserva'] ?? null);
        break;

    case 'confirmarPagamento':
        confirmarPagamentoReserva($_POST);
        break;

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

    date_default_timezone_set('America/Sao_Paulo');
    $dataSolicitacao = date('Y-m-d');

    $valorProduto = $dadosPOST['valorProduto'];

    // ========================
    // TRATAR INTERVALO
    // ========================
    if (!empty($intervalo)) {

        // Se veio intervalo completo "YYYY-MM-DD to YYYY-MM-DD"
        if (strpos($intervalo, ' to ') !== false) {
            list($dataInicio, $dataFinal) = array_map('trim', explode(' to ', $intervalo));
        } else {
            // apenas 1 data selecionada → 1 diária
            $dataInicio = trim($intervalo);
            $dataFinal  = trim($intervalo);
        }
    } else {
        // Se estiver vazio, usar a data de hoje
        $dataHoje = date('Y-m-d');
        $dataInicio = $dataHoje;
        $dataFinal = $dataHoje;
    }

    // ========================
    // CORRIGIR ORDEM SE NECESSÁRIO
    // ========================
    if (strtotime($dataFinal) < strtotime($dataInicio)) {
        $temp = $dataFinal;
        $dataFinal = $dataInicio;
        $dataInicio = $temp;
    }

    // ========================
    // CALCULAR DIAS
    // ========================
    $Inicio = new DateTime($dataInicio);
    $Final = new DateTime($dataFinal);

    $dias = $Inicio->diff($Final)->days + 1;

    // ========================
    // CALCULAR VALOR
    // ========================
    $valorReserva = $dias * floatval(str_replace(',', '.', $valorProduto));

    // ========================
    // INSERIR NO BANCO
    // ========================
    if (inserirSolicitacaoReserva($idUsuario, $idProduto, $valorReserva, $dataInicio, $dataFinal, $dataSolicitacao)) {
        header("Location: ../view/produto/pag-produto.php?msg=Solicitação de reserva enviada!");
        exit;
    }

    header("Location: ../view/produto/pag-produto.php?msg=Não foi possivel realizar a solicitação.");
}


function acessarReserva($idReserva)
{

    header('Content-Type: application/json');

    if (!$idReserva) {
        echo json_encode(['erro' => 'Reserva inválida']);
        exit;
    }

    require_once "../model/ProdutoDao.php";

    $dadosReserva = consultarReserva($idReserva);

    if (!$dadosReserva) {
        echo json_encode(['erro' => 'Reserva não encontrada']);
        exit;
    }

    $idProduto = $dadosReserva['idProduto'];
    $dadosProduto = consultarProduto($idProduto);

    $quantDias = $dadosReserva['valorReserva'] / $dadosProduto['valorDia'];


    // Monta resposta com os campos que você precisa no modal
    $resposta = [
        'idReserva'   => $dadosReserva['idReserva'],
        'idProduto'   => $dadosProduto['idProduto'],
        'nomeProduto'   => $dadosProduto['nomeProduto'],
        'valorDiaria'  => $dadosProduto['valorDia'],
        'nomeFornecedor' => $dadosProduto['nomeFornecedor'],
        'dataInicial'   => $dadosReserva['dataInicial'],
        'dataFinal'     => $dadosReserva['dataFinal'],
        'dataSolicitada' => $dadosReserva['dataSolicitada'],
        'valorReserva'  => $dadosReserva['valorReserva'],
        'status'        => $dadosReserva['status'],
        'quantDias'     => $quantDias
    ];

    echo json_encode($resposta);
    exit;
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
    $dadosPagamento = consultarPagamentoPorReserva($idReserva);

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
        'idReserva'     => $dadosReserva['idReserva'],
        'nomeUsuario'   => $dadosCliente['nomeUsuario'],
        'emailUsuario'  => $dadosCliente['email'],
        'nome'          => $dadosProduto['nomeProduto'],
        'descricao'     => $dadosProduto['descricaoProduto'] ?? '',
        'dataInicial'   => $dadosReserva['dataInicial'],
        'dataFinal'     => $dadosReserva['dataFinal'],
        'dataSolicitada' => $dadosReserva['dataSolicitada'],
        'dataPagamento'  => $dadosPagamento['dataPagamento'] ?? '',
        'valorReserva'  => $dadosReserva['valorReserva'],
        'status'        => $dadosReserva['status']
    ];

    echo json_encode($resposta);
    exit;
}

function aceitarSolicitacao($idReserva)
{

    if (empty($idReserva)) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?pagina=minhas-reservas&msgErro=Não foi possível localizar a reserva.");
        exit;
    }

    $status = "Aprovada";

    if (mudarStatusReserva($status, $idReserva)) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?pagina=minhas-reservas&msg=Solicitação aceita!");
        exit;
    } else {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?pagina=minhas-reservas&msg=nao deu certo!");
        exit;
    }
}

function recusarSolicitacao($idReserva)
{
    if (empty($idReserva)) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?pagina=minhas-reservas&msgErro=Não foi possível localizar a reserva.");
        exit;
    }
    $status = "Recusada";

    if (mudarStatusReserva($status, $idReserva)) {
        header("Location: /louer/view/fornecedor/pag-inicial-fornecedor.php?pagina=minhas-reservas&msg=Solicitação Recusada!");
        exit;
    }
}

function cancelarReserva($idReserva)
{
    if (empty($idReserva)) {
        header("Location: /louer/view/cliente/pag-ic.php?pagina=meus-alugueis&msgErro=Não foi possível localizar a reserva.");
        exit;
    }
    $status = "Cancelada";

    if (mudarStatusReserva($status, $idReserva)) {
        header("Location: /louer/view/cliente/pag-ic.php?pagina=meus-alugueis&msg=Reserva Cancelada!");
        exit;
    }
}

function confirmarPagamentoReserva($dadosPOST)
{
    require_once "../model/ClienteDao.php";

    $idReserva = $dadosPOST['idReserva'] ?? null;
    if (empty($idReserva)) {
        header("Location: /louer/view/cliente/pag-ic.php?msgErro=Reserva inválida!");
        exit;
    }

    $formaPagamento = $dadosPOST['pagamento'] ?? null;
    if (empty($formaPagamento)) {
        header("Location: /louer/view/cliente/pag-pagamento.php?idReserva={$idReserva}&msgErro=Forma de pagamento inválida!");
        exit;
    }

    // $dataPago = (new DateTime())->format('d/m/Y');
    $status = 'Confirmada';
    $idCliente = $_SESSION['id'];

    $cliente = consultarCliente($idCliente);
    $nomePagador = $cliente['nomeUsuario'] ?? '';
    if (empty($cliente['cpf'])) {
        $cpfPagador = $cliente['cnpj'];
    } else {
        $cpfPagador = $cliente['cpf'];
    }


    $reserva = consultarReserva($idReserva);
    $valorPago = $reserva['valorReserva'] ?? 0;
    $dataInicial = $reserva['dataInicial'];
    $dataFinal = $reserva['dataFinal'];
    $idProduto = $reserva['idProduto'];

    $datas = pegarIntervaloDatas($dataInicial, $dataFinal);

    if (PagamentoReserva($idReserva, $formaPagamento, $nomePagador, $cpfPagador, $valorPago, $status)) {
        if (mudarStatusReserva($status, $idReserva)) {
            if (removerDisponibilidades($idProduto, $datas)) {
                header("Location: /louer/view/cliente/pag-pagamento.php?idReserva={$idReserva}&msg=Pago");
                exit;
            } else {
                header("Location: /louer/view/cliente/pag-pagamento.php?idReserva={$idReserva}&msgErro=Não foi possível reservar");
            }
        } else {
            header("Location: /louer/view/cliente/pag-pagamento.php?idReserva={$idReserva}&msgErro=Não foi possível atualizar o status");
        }
    } else {
        header("Location: /louer/view/cliente/pag-pagamento.php?idReserva={$idReserva}&msgErro=Erro ao registrar pagamento");
    }
}
