<?php
session_start();


$dadosProduto = $_SESSION['Produto'] ?? null;

if ($dadosProduto) {
    $idProduto = $dadosProduto['id'];
    $nomeProduto = $dadosProduto['nome'];
    $tipo = $dadosProduto['tipo'];
    $descricaoProduto = $dadosProduto['descricao'];
    $valorProduto = $dadosProduto['valor'];
    $nomeFornecedor = $dadosProduto['nomeFornecedor'];
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">


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

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
                <a href="../pag-inicial.php" class="text-primary font-bold text-3xl">LOUER</a>
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Navbar: CLIENTE LOGADO -->
                    <?php if (!empty($_SESSION['id'])):
                        $tipo = $_SESSION['tipo']; ?>
                        <div class="relative">
                            <!-- Botão de perfil -->
                            <button id="btnPerfil" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow hover:bg-gray-100 transition">
                                <img src="https://via.placeholder.com/40" alt="Foto de perfil" class="w-5 h-5 rounded-full">
                                <span class="font-medium"><?php echo $_SESSION['nome']['0'] ?></span>
                            </button>
                            <div id="cardPerfil" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-[0_-1px_6px_-1px_rgba(0,0,0,0.10),0_1px_3px_rgba(0,0,0,0.06)] z-50 hidden">
                                <style>
                                    #cardPerfil a {
                                        margin: 0;
                                    }
                                </style>
                                <a href="#" class="block px-5 py-1 mt-2 hover:bg-gray-100 ">Informações da Conta</a>
                                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Meus Aluguéis</a>
                                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Favoritos</a>
                                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Notificacões</a>
                                <a href="../../control/ClienteController.php?acao=sair" class="block px-5 py-1 hover:bg-gray-100 text-red-600 ">Sair</a>
                                <div class="border-t border-gray-200 my-2 mx-2"></div> <!-- Divisor sem hover -->
                                <?php if ($tipo == 'Fornecedor'): ?>
                                    <a href="../fornecedor/pag-inicial-fornecedor.php" class="block px-5 py-1 mb-2  hover:bg-gray-100 ">Página do Fornecedor</a>
                                <?php else: ?>
                                    <a href="../fornecedor/pag-cad-fornecedor.php" class="block px-5 py-1 mb-2 hover:bg-gray-100">Quero ser um fornecedor!</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="../cliente/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>


        <!-- notificacao -->
        <?php if (isset($_GET['msg'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <!-- <p class="font-medium text-sm">Erro no cadastro</p>  Tirei pra poder receber varias mensagens, n so as de erro de cadastro -->
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msg']) ?></p>
                    </div>
                </div>
            </div>

            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translate(-50%, -10px);
                    }

                    to {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }
                }

                @keyframes fadeOut {
                    from {
                        opacity: 1;
                        transform: translate(-50%, 0);
                    }

                    to {
                        opacity: 0;
                        transform: translate(-50%, -10px);
                    }
                }

                .fade-in {
                    animation: fadeIn 0.4s ease-out forwards;
                }

                .fade-out {
                    animation: fadeOut 0.4s ease-in forwards;
                }
            </style>

            <script>
                setTimeout(() => {
                    const notif = document.getElementById('notificacao');
                    if (notif) {
                        notif.classList.remove('fade-in');
                        notif.classList.add('fade-out');
                        setTimeout(() => notif.remove(), 500);
                    }
                }, 4000);
            </script>
        <?php endif; ?>


        <!-- //////////////////////////////////////////////////////////////////////// -->
        <!-- Informacoes do Produto -->

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
        </script>




</body>

</html>