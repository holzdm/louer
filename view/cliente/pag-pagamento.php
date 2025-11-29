<?php
session_start();

require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
require_once "../../model/ClienteDao.php";

// ID da reserva enviado por GET
$idReserva = $_GET['idReserva'] ?? null;

if (!$idReserva) {
    header("Location: /louer/view/cliente/pag-ic.php?msg=Reserva inválida!");
    exit;
}

// BUSCA A RESERVA
$dadosReserva = consultarReserva($idReserva);
$idProduto = $dadosReserva['idProduto'];

// BUSCA PRODUTO
$dadosProduto = consultarProduto($idProduto);

// BUSCA FORNECEDOR
$nomeFornecedor = consultarProduto($idProduto)['nomeFornecedor'];

// IMAGEM
$img = listarUmaImg($idProduto);
$srcImg = $img
    ? "data:" . $img['tipo'] . ";base64," . $img['dados']
    : "/louer/a-uploads/New-piskel.png";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamento da Reserva</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php $fonte = "";
    include "../script-style.php";
    include "../navbar.php" ?>

<div class="bg-[#e8f6fc] min-h-screen flex flex-col items-center p-6">


    <h1 class="text-3xl font-bold text-[#164564] mb-6">Pagamento da Reserva</h1>

    <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-4xl border border-[#c6e9f5]">

        <!-- GRID PRINCIPAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- IMAGEM -->
            <div class="rounded-xl overflow-hidden shadow">
                <img src="<?= $srcImg ?>" class="w-full h-64 object-cover">
            </div>

            <!-- INFORMAÇÕES -->
            <div class="flex flex-col gap-4">

                <div class="border-b-2 border-[#b2d2df] pb-2">
                    <h2 class="text-2xl font-bold text-[#164564]"><?= htmlspecialchars($dadosProduto['nome']) ?></h2>
                </div>

                <p class="text-gray-700">
                    <span class="font-semibold">Fornecedor:</span>
                    <span class="underline decoration-gray-500 underline-offset-2">
                        <?= htmlspecialchars($nomeFornecedor) ?>
                    </span>
                </p>

                <p class="text-gray-700">
                    <span class="font-semibold">Período:</span><br>
                    <?= date("d/m/Y", strtotime($dadosReserva['dataInicial'])) ?>
                    até
                    <?= date("d/m/Y", strtotime($dadosReserva['dataFinal'])) ?>
                </p>

                <p class="text-gray-700">
                    <span class="font-semibold">Status:</span>
                    <?= htmlspecialchars($dadosReserva['status']) ?>
                </p>

                <p class="text-xl font-bold text-[#164564] mt-3">
                    Total: R$ <?= number_format($dadosReserva['valorReserva'], 2, ',', '.') ?>
                </p>

            </div>
        </div>

        <!-- FORM PAGAMENTO -->
        <form action="/louer/control/ReservaController.php" method="POST" class="mt-8">

            <input type="hidden" name="acao" value="confirmarPagamento">
            <input type="hidden" name="idReserva" value="<?= $idReserva ?>">

            <h3 class="text-xl font-semibold text-[#164564] mb-4">Escolha a forma de pagamento</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                    <input type="radio" name="pagamento" value="pix" required>
                    <span>PIX</span>
                </label>

                <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                    <input type="radio" name="pagamento" value="credito">
                    <span>Cartão de Crédito</span>
                </label>

                <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                    <input type="radio" name="pagamento" value="debito">
                    <span>Cartão de Débito</span>
                </label>

            </div>

            <button 
                type="submit" 
                class="w-full mt-8 py-3 bg-[#164564] text-white rounded-lg hover:bg-[#0f3148] transition">
                Confirmar Pagamento
            </button>
        </form>
    </div>
</div>
</body>
</html>
