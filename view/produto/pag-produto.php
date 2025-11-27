<?php
session_start();


$dadosProduto = $_SESSION['Produto'] ?? null;

if ($dadosProduto) {
    $idProduto = $dadosProduto['idProduto'];
    $nomeProduto = $dadosProduto['nome'];
    $tipo = $dadosProduto['tipo'];
    $descricaoProduto = $dadosProduto['descricao'];
    $valorProduto = $dadosProduto['valor'];
    $nomeFornecedor = $dadosProduto['nomeFornecedor'];
    $tagsArray = $dadosProduto['tagsArray'];
    $imgsArray = $dadosProduto['imgsArray'];
} else {
    // Redirecionar ou mostrar erro se não houver produto
    header("Location: ../pag-inicial.php?msg=Produto não encontrado.");
    exit;
}

// if (!empty($_SESSION['nome'])) {
//     $nome = $_SESSION['nome'];
//     $nomePrimeiraLetra = $nome['0'];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <?php include "../script-style.php"; ?>

</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">

        <!-- Navbar -->
        <?php $fonte = 'produto';
        include '../navbar.php'; ?>

        <!-- notificacao -->
        <?php include '../notificacao.php'; ?>

        <!-- //////////////////////////////////////////////////////////////////////// -->
        <!-- CONTEUDO -->
        <div class="mx-[3%] my-[2%]">

            <section class="flex items-center w-full max-w-5xl mx-auto">
                <!-- Botão esquerdo -->
                <button id="prev"
                    class="text-gray-700 text-2xl p-2 transition-transform duration-200 hover:scale-125 disabled:text-gray-400 disabled:cursor-not-allowed">
                    ◀
                </button>

                <!-- Container do carrossel -->
                <?php require_once "../../model/ProdutoDao.php";
                $imagens = buscarImgs($idProduto); ?>

                <div id="carousel" class="overflow-hidden flex-1 mx-2">
                    <div id="carousel-track" class="flex transition-transform duration-300">
                        <?php foreach ($imagens as $img): $src = "data:" . $img['tipo'] . ";base64," . $img['dados']; ?>
                            <div class="flex-shrink-0 mr-4 rounded-lg overflow-hidden">
                                <img src="<?php echo $src ?>" class="h-40 w-auto object-contain">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Botão direito -->
                <button id="next"
                    class="text-gray-700 text-2xl p-2 transition-transform duration-200 hover:scale-125 disabled:text-gray-400 disabled:cursor-not-allowed">
                    ▶
                </button>
            </section>

            <hr class="w-[100vw] border-t border-gray-300 -mx-4">

            <div class="flex justify-between w-full mt-6 px-6">
                <!-- descricao -->
                <div class="mr-20">

                    <section class="flex flex-wrap gap-2 mt-3">

                        <?php foreach ($tagsArray as $tag): ?>
                            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700 font-medium">
                                <?php echo htmlspecialchars($tag); ?>
                            </span>
                        <?php endforeach; ?>
                    </section>

                    <section class="my-6">
                        <h2 class="text-2xl text-gray-800 font-bold truncate"><?= htmlspecialchars($nomeProduto) ?></h2>
                        <p class="mt-2 text-gray-600"><?= nl2br(htmlspecialchars($descricaoProduto)) ?></p>
                        <p class="mt-1 font-semibold text-gray-600">R$ <?= htmlspecialchars($valorProduto) ?> / dia</p>
                        <p class="mt-1 text-gray-600 ">Publicado por: <?= htmlspecialchars($nomeFornecedor) ?></p>
                    </section>
                </div>
                <!-- compra -->
                <div class=" rounded-lg shadow px-4 py-6 bg-[rgba(22,69,100,0.15)] w-96 mr-20">

                    <!-- Formulario solicitacao de reserva -->
                    <section class="flex flex-col gap-2 items-center">

                        <p class="text-2xl md:text-3xl font-bold text-primary">R$ <?= htmlspecialchars($valorProduto) ?> / dia</p>
                        <form action="/louer/control/ReservaController.php" method="POST" class="flex flex-col items-center w-full gap-2">

                            <input type="hidden" name="acao" value="solicitar">
                            <input type="hidden" name="idProduto" value="<?php echo $idProduto ?>">
                            <input type="hidden" name="valorProduto" id="valorProduto" value="<?php echo $valorProduto ?>">


                            <!-- Selecao de intervalo -->

                            <label for="intervalo" class="text-lg font-semibold text-gray-600">Selecione o intervalo:</label>
                            <input id="intervalo" name="intervalo" type="text"
                                class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                                placeholder="Escolha as datas" readonly>


                            <!-- Botão para abrir o modal da solicitacao de Reserva -->
                            <?php if (empty($_SESSION['id'])): ?>
                                <button id="btnSolicitarSemLogin" type="button" class="px-4 py-2 bg-[rgba(22,69,100,0.40)] text-white rounded hover:bg-[rgba(22,69,100,0.80)] transition w-full">
                                    Solicitar
                                </button>
                            <?php else: ?>
                                <button id="btnSolicitar" type="button" class="px-4 py-2 bg-[rgba(22,69,100,0.40)] text-white rounded hover:bg-[rgba(22,69,100,0.80)] transition w-full">
                                    Solicitar
                                </button>

                            <?php endif; ?>

                            <!-- Modal solicitacao de Reserva -->
                            <div id="modalSolicitar" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                                <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-2/3 p-6 relative">

                                    <!-- Botão fechar no canto -->
                                    <button id="fecharModal" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

                                    <!-- Conteúdo do modal -->
                                    <!-- parte superior -->
                                    <div class="flex justify-between">
                                        <!-- fotos -->
                                        <div class="bg-gray-200 rounded-xl overflow-hidden shadow w-1/2 h-60">
                                            <div class="grid grid-cols-2 grid-rows-2 w-full h-full gap-0.5">

                                                <?php
                                                $imagens = buscarQuatroImgs($idProduto);

                                                foreach ($imagens as $img): $src = "data:" . $img['tipo'] . ";base64," . $img['dados']; ?>
                                                    <img src="<?php echo $src ?>" class="w-full h-full object-cover">
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="w-1/2">
                                            <!-- info -->
                                            <div class="border-b-1 border-[#b2d2df] shadow-[0_2px_3px_-2px_rgba(178,210,223,0.6)] flex justify-center pb-2">
                                                <h1 class="text-xl text-[#b2d2df] font-bold truncate"><?php echo $nomeProduto ?> </h1>
                                            </div>
                                            <div class="flex flex-col items-center p-6 gap-2">
                                                <p class="text-xl text-gray-600 font-semibold"> Total: R$ <span id="mostrarTotal"></span>
                                                </p>

                                                <p>
                                                    <span id="mostrarDataInicial"></span>
                                                    →
                                                    <span id="mostrarDataFinal"></span>
                                                </p>




                                                <button id="confirmarSolicitacao" type="submit" class="px-4 py-2 bg-[rgba(22,69,100,0.40)] text-white rounded hover:bg-[rgba(22,69,100,0.80)] transition w-full">
                                                    Confirmar Solicitação
                                                </button>
                                                <p class="mt-1 text-gray-500 text-sm">Você ainda não será cobrado.</p>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- ///////////////////////////////////////////////////////////////// -->
                                    <!-- parte inferior -->
                                    <div>

                                    </div>

                                </div>
                            </div>
                        </form>
                        <p class="mt-1 text-gray-500 text-sm">Você ainda não será cobrado.</p>
                    </section>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?php $fonte = 'produto';
        include '../footer.php'; ?>





        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Função utilitária para adicionar evento só se o elemento existir
                const on = (selector, event, handler) => {
                    const el = document.querySelector(selector);
                    if (el) el.addEventListener(event, handler);
                };


                // Flatpickr
                if (document.querySelector("#intervalo")) {
                    flatpickr("#intervalo", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disableMobile: true,
                        clickOpens: true,
                        allowInput: false
                    });
                }

function formatarDataBR(dataISO) {
    const [ano, mes, dia] = dataISO.split("-");
    return `${dia}/${mes}/${ano}`;
}

                // Solicitar com login
                on("#btnSolicitar", "click", () => {
                    const intervalo = document.querySelector("#intervalo")?.value;
                    if (!intervalo) {
                        alert("Por favor, selecione um intervalo de datas antes.");
                        return;
                    }

                    document.querySelector("#modalSolicitar")?.classList.remove("hidden");

                    // Separar as datas
                    let [dataInicial, dataFinal] = intervalo.split(" to ");

                    // Se a segunda data não vier, puxar a mesma
                    if (!dataFinal || dataFinal.trim() === "") {
                        dataFinal = dataInicial;
                    }

                    document.querySelector("#mostrarDataInicial").textContent = formatarDataBR(dataInicial);
                    document.querySelector("#mostrarDataFinal").textContent = formatarDataBR(dataFinal);

                    // Calcular dias
                    const diaMs = 1000 * 60 * 60 * 24;
                    let qtdDias = Math.round(
                        (new Date(dataFinal) - new Date(dataInicial)) / diaMs
                    );

                    if (qtdDias === 0) qtdDias = 1; // mesma data = 1 diária

                    // Valor por dia
                    const valorDia = parseFloat(
                        document.querySelector("#valorProduto").value.replace(",", ".")
                    );

                    const total = qtdDias * valorDia;

                    document.querySelector("#mostrarTotal").textContent =
                        total.toFixed(2).replace(".", ",");
                });

                // Fechar modal
                on("#fecharModal", "click", () => {
                    document.querySelector("#modalSolicitar")?.classList.add("hidden");
                });

                // Fechar modal clicando fora
                window.addEventListener("click", (e) => {
                    const modal = document.querySelector("#modalSolicitar");
                    if (modal && e.target === modal) {
                        modal.classList.add("hidden");
                    }
                });

                // Solicitar sem login
                on("#btnSolicitarSemLogin", "click", () => {
                    window.location.assign(`../cliente/login-cliente.php`);
                });
            });

            // Carrosel de fotos ////////////////////////////////////////////////////

            const track = document.getElementById('carousel-track');
            const prev = document.getElementById('prev');
            const next = document.getElementById('next');
            const carousel = document.getElementById('carousel');

            let scrollAmount = 0;

            // Atualiza estado das setas
            function updateButtons() {
                const maxScroll = track.scrollWidth - carousel.offsetWidth;
                prev.disabled = scrollAmount <= 0;
                next.disabled = scrollAmount >= maxScroll;
            }

            // Calcula largura de cada item (incluindo margin)
            function getItemWidth() {
                const item = track.querySelector('div');
                return item.offsetWidth + parseInt(getComputedStyle(item).marginRight);
            }

            // Clique nas setas
            next.addEventListener('click', () => {
                const maxScroll = track.scrollWidth - carousel.offsetWidth;
                scrollAmount += getItemWidth();
                if (scrollAmount > maxScroll) scrollAmount = maxScroll;
                track.style.transform = `translateX(-${scrollAmount}px)`;
                updateButtons();
            });

            prev.addEventListener('click', () => {
                scrollAmount -= getItemWidth();
                if (scrollAmount < 0) scrollAmount = 0;
                track.style.transform = `translateX(-${scrollAmount}px)`;
                updateButtons();
            });

            // Drag com mouse/touch
            let isDragging = false;
            let startX;
            let currentTranslate = 0;

            carousel.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX + scrollAmount;
            });

            carousel.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                scrollAmount = startX - e.pageX;
                const maxScroll = track.scrollWidth - carousel.offsetWidth;
                if (scrollAmount < 0) scrollAmount = 0;
                if (scrollAmount > maxScroll) scrollAmount = maxScroll;
                track.style.transform = `translateX(-${scrollAmount}px)`;
                updateButtons();
            });

            carousel.addEventListener('mouseup', () => isDragging = false);
            carousel.addEventListener('mouseleave', () => isDragging = false);

            // Touch events
            carousel.addEventListener('touchstart', (e) => {
                isDragging = true;
                startX = e.touches[0].pageX + scrollAmount;
            });

            carousel.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                scrollAmount = startX - e.touches[0].pageX;
                const maxScroll = track.scrollWidth - carousel.offsetWidth;
                if (scrollAmount < 0) scrollAmount = 0;
                if (scrollAmount > maxScroll) scrollAmount = maxScroll;
                track.style.transform = `translateX(-${scrollAmount}px)`;
                updateButtons();
            });

            carousel.addEventListener('touchend', () => isDragging = false);

            // Inicial
            updateButtons();

            // ////////////////////////////////////////////////////////////////////////
        </script>




</body>

</html>