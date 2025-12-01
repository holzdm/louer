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
    include "../navbar.php";
    include "../notificacao.php";
    include "../notificacao-erro.php" ?>

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
            <?php if ($dadosReserva['status'] === "Aprovada"): ?>
                <form action="/louer/control/ReservaController.php" method="POST" class="mt-8">

                    <input type="hidden" name="acao" value="confirmarPagamento">
                    <input type="hidden" name="idReserva" value="<?= $idReserva ?>">

                    <h3 class="text-xl font-semibold text-[#164564] mb-4">Escolha a forma de pagamento</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                            <input type="radio" name="pagamento" value="1" required>
                            <span>PIX</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                            <input type="radio" name="pagamento" value="2">
                            <span>Cartão de Crédito</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border rounded-lg bg-[#f0fbfe] hover:bg-[#c6e9f5] cursor-pointer">
                            <input type="radio" name="pagamento" value="3">
                            <span>Cartão de Débito</span>
                        </label>

                    </div>

                    <button
                        type="submit"
                        class="w-full mt-8 py-3 bg-[#164564] text-white rounded-lg hover:bg-[#0f3148] transition">
                        Confirmar Pagamento
                    </button>
                </form>
            <?php endif;
            if ($dadosReserva['status'] === "Confirmada"): ?>
                <div class="mt-10 border-t border-[#c6e9f5] pt-8">

                    <h3 class="text-xl font-semibold text-primary mb-6">
                        Documentos da Reserva
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- COMPROVANTE DE RESERVA -->
                        <a
                            href="/louer/control/ReservaController.php?acao=gerarComprovanteReserva&idReserva=<?= $idReserva ?>"
                            class="flex items-center justify-between p-5 bg-secondary border border-[#c6e9f5] rounded-xl shadow hover:bg-[#c6e9f5] transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 3h10a2 2 0 012 2v4H5V5a2 2 0 012-2zm0 8h12m-12 4h8M7 21h10a2 2 0 002-2v-5H5v5a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-lg font-semibold text-primary">Comprovante da Reserva</p>
                                    <p class="text-gray-600 text-sm">Visualize ou baixe o comprovante da sua reserva.</p>
                                </div>
                            </div>
                        </a>

                        <!-- COMPROVANTE DE PAGAMENTO -->
                        <a
                            href="/louer/control/ReservaController.php?acao=gerarComprovantePagamento&idReserva=<?= $idReserva ?>"
                            class="flex items-center justify-between p-5 bg-secondary border border-[#c6e9f5] rounded-xl shadow hover:bg-[#c6e9f5] transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2v0c0 1.105 1.343 2 3 2s3 .895 3 2v0c0 1.105-1.343 2-3 2m0-8v8m0 4h.01M5 12a7 7 0 1114 0 7 7 0 01-14 0z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-lg font-semibold text-primary">Comprovante de Pagamento</p>
                                    <p class="text-gray-600 text-sm">Acesse o recibo oficial do pagamento realizado.</p>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>


            <?php endif; ?>

        </div>
    </div>
</body>

</html>