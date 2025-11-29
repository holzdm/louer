<?php

require_once "ConexaoBD.php";

function inserirSolicitacaoReserva($idUsuario, $idProduto, $valorReserva, $dataInicio, $dataFinal, $dataSolicitacao)
{
    $conexao = conectarBD();


    $status = 'Solicitada';


    $stmt = $conexao->prepare("INSERT INTO reserva (id_usuario, id_produto, data_reserva, data_final, valor_reserva, status, data_solicitado) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissdss", $idUsuario, $idProduto, $dataInicio, $dataFinal, $valorReserva, $status, $dataSolicitacao);
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

    $sql = "SELECT * FROM Reserva WHERE id = ?";

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