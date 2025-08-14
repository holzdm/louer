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
