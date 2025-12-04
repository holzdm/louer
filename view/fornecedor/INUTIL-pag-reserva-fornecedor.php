<?php
session_start();


$dadosReserva = $_SESSION['Reserva'] ?? null;

if ($dadosReserva) {
    $idReserva = $dadosReserva['idReserva'];
    $idCliente = $dadosReserva['idUsuario'];
    $idProduto = $dadosReserva['idProduto'];
    $dataInicial = $dadosReserva['dataInicial'];
    $dataFinal = $dadosReserva['dataFinal'];
    $valorReserva = $dadosReserva['valorReserva'];
    $status = $dadosReserva['status'];
    $nomeProduto = $dadosReserva['nomeProduto'];
    $descricao = $dadosReserva['descricaoProduto'];
    $tipo = $dadosReserva['tipoProduto'];
    $valorHora = $dadosReserva['valorDia'];
    $tagsArray = $dadosReserva['tagsArray'];
    $imgsArray = $dadosReserva['imgsArray'];
    $nomeCliente = $dadosReserva['nomeUsuario'];
    $cidadeCliente = $dadosReserva['cidade'];
    $telefoneCliente = $dadosReserva['telefone'];
    $emailCliente = $dadosReserva['email'];
} else {
    // Redirecionar ou mostrar erro se não houver produto
    header("Location: ../pag-inicial.php?msg=Reserva não encontrada.");
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

            <div class="flex items-center w-full max-w-5xl mx-auto">
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
            </div>

            <hr class="w-[100vw] border-t border-gray-300 -mx-4">

            <div class="flex flex-wrap gap-2 mt-3">

                <?php foreach ($tagsArray as $tag): ?>
                    <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700 font-medium">
                        <?php echo htmlspecialchars($tag); ?>
                    </span>
                <?php endforeach; ?>
            </div>


            <h2> Nome: <?php echo $nomeProduto ?> </h2>
            <br>
            <h3>Cliente: <?php echo $nomeCliente ?> </h3>
            <h3>Valor da Reserva: <?php echo $valorReserva ?> </h3>
            <h3>Status da Reserva: <?php echo $status ?> </h3>


        </div>

        <!-- footer -->
        <?php $fonte = 'produto';
        include '../footer.php'; ?>





        <script>
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