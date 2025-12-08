<?php

require_once "ConexaoBD.php";

function inserirSolicitacaoReserva($idUsuario, $idProduto, $valorReserva, $dataInicio, $dataFinal, $dataSolicitacao)
{
    $conexao = conectarBD();


    $status = 'Solicitada';


    $stmt = $conexao->prepare("INSERT INTO reserva (id_usuario, id_produto, data_reserva, data_final, valor_reserva, status, data_solicitado) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iissds", $idUsuario, $idProduto, $dataInicio, $dataFinal, $valorReserva, $status);
    if (!mysqli_stmt_execute($stmt)) {
        return false;
    }

    return true;
}

function listarReservas($idUsuario)
{
    $conexao = conectarBD();
    $sql = "SELECT * FROM reserva WHERE id_usuario = $idUsuario";
    return mysqli_query($conexao, $sql);
}

function consultarReserva($idReserva)
{
    $conexao = conectarBD();

    $sql = "SELECT * FROM reserva WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idReserva);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {

        return [
            "idReserva" => $idReserva,
            "idUsuario" => $row['id_usuario'],
            "idProduto" => $row['id_produto'],
            "dataInicial" => $row['data_reserva'],
            "dataFinal" => $row['data_final'],
            "dataSolicitada"  => $row['data_solicitado'],
            "valorReserva" => $row['valor_reserva'],
            "status" => $row['status']
        ];
    }
    return null;
}

function listarReservasFornecedor($idFornecedor)
{
    $conexao = conectarBD();

    $sql = "SELECT r.* 
            FROM reserva r
            INNER JOIN produto p ON r.id_produto = p.id
            WHERE p.id_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idFornecedor);
    $stmt->execute();
    $res = $stmt->get_result();


    return $res; 
}

function mudarStatusReserva($status, $idReserva){
    $conexao = conectarBD();

    $sql = "UPDATE reserva 
            SET status = ?
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("si", $status, $idReserva);

    if (!$stmt->execute()) {
        
        return false;
    }

    // retorna true SE realmente alterou a linha
    return $stmt->affected_rows > 0;
}

function PagamentoReserva($idReserva, $formaPagamento, $nomePagador, $cpfPagador, $valorPago, $status){
    $conexao = conectarBD();

    $sql = "INSERT INTO pagamento (reserva_id, forma_pagamento_id, nome_pagador, cpf_pagador, valor_pago, status_pagamento, data_pagamento) VALUES
    (?,?,?,?,?,?,NOW())";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("iissds", $idReserva, $formaPagamento, $nomePagador, $cpfPagador, $valorPago, $status);

    return $stmt->execute();

}

function consultarPagamentoPorReserva($idReserva)
{
    $conexao = conectarBD();

    $sql = "SELECT * FROM pagamento WHERE reserva_id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idReserva);
    $stmt->execute();
    $res = $stmt->get_result();


    if ($row = $res->fetch_assoc()) {
        $formaPagamento = formaPagamentoPorID($row['forma_pagamento_id']);

        return [
            "idPagamento" => $row['id'],
            "formaPagamento" => $formaPagamento,
            "nomePagador" => $row['nome_pagador'],
            "cpfPagador" => $row['cpf_pagador'],
            "valorPago" => $row['valor_pago'],
            "valorEstornado" => $row['valor_estornado'],
            "statusPagamento" => $row['status_pagamento'],
            "dataPagamento" => $row['data_pagamento'],
            "dataEstorno" => $row['data_estorno']
        ];
    }
    return null;
}

function formaPagamentoPorID($idFormaPagamento){
    $conexao = conectarBD();
    $sql = "SELECT forma FROM formapagamento WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $idFormaPagamento);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        // Retorna apenas a string contida na coluna 'forma'
        return $row['forma']; 
    } else {
        // Retorna null ou uma string vazia se nenhum resultado for encontrado
        return null; 
    }
}

function removerDisponibilidades($idProduto, $datas)
{
    $con = conectarBD();

    $sql = "DELETE FROM disponibilidades WHERE id_produto = ? AND data_disponivel = ?";
    $stmt = $con->prepare($sql);

    foreach ($datas as $data) {
        $stmt->bind_param("is", $idProduto, $data);
        $stmt->execute();
    }

    return true;
}

