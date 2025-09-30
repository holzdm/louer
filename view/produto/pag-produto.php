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


    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#164564',
                        secondary: '#f0fbfe',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            background-color: #f0fbfe;
            font-family: 'Poppins', sans-serif;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #164564;
            box-shadow: 0 0 0 2px rgba(22, 69, 100, 0.2);
        }

        .btn-primary {
            background-color: #164564;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0d3854;
        }

        .toggle-button {
            transition: all 0.3s ease;
        }

        .toggle-button.active {
            background-color: #164564;
            color: white;
        }
    </style>
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
                <div id="carousel" class="overflow-hidden flex-1 mx-2">
                    <div id="carousel-track" class="flex transition-transform duration-300">
                        <?php foreach ($imgsArray as $img_url): ?>
                            <div class="flex-shrink-0 mr-4 rounded-lg overflow-hidden">
                                <img src="<?php echo $img_url ?>" class="h-40 w-auto object-contain">
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


            <h2> <?php echo $nomeProduto ?> </h2>
            <br>
            <h3> <?php echo $descricaoProduto ?> </h3>
            <h3> <?php echo $valorProduto ?> </h3>
            <h3> Puplicado por: <?php echo $nomeFornecedor ?> </h3>


            <!-- Formulario solicitacao de reserva -->
            <div class="flex flex-col gap-4 max-w-sm mx-auto mt-10">
                <form action="../../control/ReservaController.php" method="POST">

                    <input type="hidden" name="acao" value="solicitar">
                    <input type="hidden" name="idProduto" value="<?php echo $idProduto ?>">
                    <input type="hidden" name="valorProduto" value="<?php echo $valorProduto ?>">


                    <!-- Selecao de intervalo -->

                    <label for="intervalo" class="text-lg font-semibold">Selecione o intervalo</label>
                    <input id="intervalo" name="intervalo" type="text"
                        class="border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Escolha as datas" readonly>

                    <!-- Botão para abrir o modal da solicitacao de Reserva -->
                    <?php if (empty($_SESSION['id'])): ?>
                        <button id="btnSolicitarSemLogin" type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Solicitar
                        </button>
                    <?php else: ?>
                        <button id="btnSolicitar" type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Solicitar
                        </button>

                    <?php endif; ?>

                    <!-- Modal solicitacao de Reserva -->
                    <div id="modalSolicitar" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-2/3 p-6 relative">

                            <!-- Botão fechar no canto -->
                            <button id="fecharModal" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

                            <!-- Conteúdo do modal -->
                            <h2 class="text-2xl font-bold mb-4">Modal Grande</h2>
                            <p class="mb-4">Conteúdo do seu pop-up.</p>

                            <!-- Botão dentro do modal -->
                            <div class="flex justify-end">

                                <button id="confirmarSolicitacao" type="submit" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Confirmar Solicitacao</button>
                            </div>

                        </div>
                    </div>
                </form>
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

                // Perfil
                on("#btnPerfil", "click", () => {
                    const cardPerfil = document.querySelector("#cardPerfil");
                    cardPerfil?.classList.toggle("hidden");
                });

                document.addEventListener("click", (e) => {
                    const btnPerfil = document.querySelector("#btnPerfil");
                    const cardPerfil = document.querySelector("#cardPerfil");
                    if (btnPerfil && cardPerfil && !btnPerfil.contains(e.target) && !cardPerfil.contains(e.target)) {
                        cardPerfil.classList.add("hidden");
                    }
                });

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

                // Solicitar com login
                on("#btnSolicitar", "click", () => {
                    const intervalo = document.querySelector("#intervalo")?.value;
                    if (!intervalo) {
                        alert("Por favor, selecione um intervalo de datas antes.");
                        return;
                    }
                    document.querySelector("#modalSolicitar")?.classList.remove("hidden");
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