<?php
session_start();

require_once "../../model/ReservaDao.php";
require_once "../../model/ClienteDao.php";
require_once "../../model/ProdutoDao.php";

if (!isset($_GET['idReserva'])) {
    echo "ID da reserva não informado.";
    exit;
}

$idReserva = $_GET['idReserva'];
$dadosReserva = consultarReserva($idReserva);

// Dados do cliente (opcional — caso não venha no PDF)
$cliente = consultarCliente($dadosReserva['idUsuario']);
$produto = consultarProduto($dadosReserva['idProduto']);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Comprovante de Reserva</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <!-- Container -->
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-blue-200">

        <!-- Header -->
        <div class="text-center border-b pb-4 mb-6">
            <h1 class="text-3xl font-bold text-blue-600">Comprovante de Reserva</h1>
            <p class="text-gray-500 text-sm">Gerado automaticamente em <?= date("d/m/Y H:i") ?></p>
        </div>

        <!-- Secao: Informações Gerais -->
        <h2 class="text-xl font-semibold text-blue-700 mb-3">Informações da Reserva</h2>

        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Código:</span>
                <span class="text-gray-800"><?= $dadosReserva['idReserva'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Cliente:</span>
                <span class="text-gray-800"><?= $cliente['nomeUsuario'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Quadra / Produto:</span>
                <span class="text-gray-800"><?= $produto['nome'] ?></span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Data da Reserva:</span>
                <span class="text-gray-800"><?= $dados['dataInicial'] ?> até <?= $dados['dataFinal'] ?></span>
            </div>


            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Status:</span>
                <span class="text-gray-800"><?= $dadosReserva['status'] ?></span>
            </div>
        </div>

        <!-- Linha divisória -->
        <div class="my-6 border-t"></div>

        <!-- Aviso -->
        <p class="text-gray-500 text-sm text-center">
            Guarde este comprovante — ele garante sua reserva no sistema.
        </p>

        <!-- Botão de imprimir -->
        <div class="text-center mt-6">
            <button 
                onclick="window.print()"
                class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Imprimir / Salvar em PDF
            </button>
        </div>

    </div>

</body>
</html>
