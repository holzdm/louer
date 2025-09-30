<?php
session_start();

if (empty($_SESSION['id'])) {
    header("Location: ../pag-inicial.php");
    exit;
}

$formData = $_SESSION['formData'] ?? [];


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOUER | Novo produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
            user-select: none;
        }


        .toggle-button.active {
            background-color: #164564;
            color: white;
        }


        .toggle-button:hover {
            background-color: #164564;
            color: white;
            border-color: #164564;
        }
    </style>
</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">
        <!-- Navbar -->
    <?php $fonte = 'produto'; include '../navbar.php'; ?>



        <!-- notificacao de erro -->
        <?php if (isset($_GET['msgErro'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <p class="font-medium text-sm">Erro</p>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msgErro']) ?></p>
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


        <!-- ////////////////////////////////////////////////////////////////////////////// -->
        <!-- FORMULARIO -->
        <div class="flex justify-center items-center py-16">
            <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-4xl">
                <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">Qual o endereço do seu produto?</h1>

                <form action="../../control/ProdutoController.php" method="post" class="space-y-6">
                    <div>
                        <input type="hidden" name="acao" value="cadastrarEnd">
                        <label for="cep" class="block text-sm font-medium text-gray-700 mb-1">CEP: </label>
                        <input type="text" id="cep" name="cep" placeholder="" value="<?= htmlspecialchars($formData['cep'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade: </label>
                        <input type="text" id="cidade" name="cidade" placeholder="" value="<?= htmlspecialchars($formData['cidade'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="rua" class="block text-sm font-medium text-gray-700 mb-1">Rua: </label>
                        <input type="text" id="rua" name="rua" placeholder="" value="<?= htmlspecialchars($formData['rua'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Bairro: </label>
                        <input type="text" id="bairro" name="bairro" placeholder="" value="<?= htmlspecialchars($formData['bairro'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="numero" class="block text-sm font-medium text-gray-700 mb-1">N°: </label>
                        <input type="number" id="numero" name="numero" placeholder="00" step="1" min="0" value="<?= htmlspecialchars($formData['numero'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="complemento" class="block text-sm font-medium text-gray-700 mb-1">Complemento: </label>
                        <input type="text" id="complemento" name="complemento" placeholder="AP.. " value="<?= htmlspecialchars($formData['complemento'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                        <br><br>
                        <div class="flex justify-between mt-6">
                            <!-- Botão Cancelar -->
                            <button type="button" id="btnCancelar" class="px-4 py-2 rounded-md text-gray-700 hover:underline">
                                Cancelar
                            </button>

                            <div>
                                <!-- Botão Voltar -->
                                <button id="btnVoltar" type="button" onclick="history.back()"
                                    class="px-4 py-2 rounded-md bg-primary text-white">
                                    Voltar
                                </button>
                                <!-- Botão Confirmar -->
                                <button id="btnConfirmar" type="submit"
                                    class="px-4 py-2 rounded-md bg-primary text-white">
                                    Confirmar
                                </button>
                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Footer -->
    <?php include '../footer.php'; ?>

    </div>



    <script>
        document.getElementById('btnCancelar').addEventListener('click', () => {
            window.location.href = "../../control/ProdutoController.php?acao=cancelarCadastro";
        });

        // BOTAO DO PERFIL ESSENCIAIS ///////////////////////////////////////////////////////////
        const btnPerfil = document.getElementById('btnPerfil');
        const cardPerfil = document.getElementById('cardPerfil');

        // Alterna o card ao clicar no botão
        btnPerfil.addEventListener('click', () => {
            cardPerfil.classList.toggle('hidden');
        });

        // Fecha ao clicar fora
        document.addEventListener('click', (e) => {
            if (!btnPerfil.contains(e.target) && !cardPerfil.contains(e.target)) {
                cardPerfil.classList.add('hidden');
            }
        });
        // /////////////////////////////////////////////////////////////////////////////////////
    </script>


</body>

</html>