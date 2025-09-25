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
        <?php $fonte = 'produto';
        include '../navbar.php'; ?>


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
                <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">Adicione fotos</h1>

                <form action="../../control/ProdutoController.php" method="post" class="space-y-6" enctype="multipart/form-data">
                    <input type="hidden" name="acao" value="cadastrarImg">
                    <label for="imagens">Escolha as imagens (JPG, PNG, GIF, max 1MB cada):</label>
                    <input type="file" name="imagens[]" id="imagens" multiple accept="image/jpeg,image/png,image/gif">
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
        <!-- //////////////////////////////////////////////////////////////////////// -->

        <!-- Footer -->
        <footer class="bg-white py-6 border-t border-gray-200 mt-auto">
            <div class="container mx-auto px-4 md:px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <a href="#" class="text-primary font-bold text-2xl">LOUER</a>
                        <p class="mt-1 text-gray-600 text-sm">Alugue espaços e itens de forma simples.</p>
                    </div>
                    <p class="text-gray-500 text-sm">© 2023 LOUER. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
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