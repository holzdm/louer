<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
    header("Location: ../pag-inicial.php");
    exit;
}

// Limpa a sessão se tiver alguma sessao de novo produto
if (isset($_SESSION['formData'])) {
    unset($_SESSION['formData']);
}

if (!isset($_SESSION['Usuario'])) {
    header("Location: ../../control/ClienteController.php");
    exit;
}
$pagina = $_GET['pagina'] ?? 'meus-dados';


$dadosUsuario = $_SESSION['Usuario'];

$idUsuario = $dadosUsuario['idUsuario'];
$nomeUsuario = $dadosUsuario['nomeUsuario'];
$tipoUsuario = $dadosUsuario['tipoUsuario'];
$cpf = $dadosUsuario['cpf'];
$cnpj = $dadosUsuario['cnpj'];
$cidade = $dadosUsuario['cidade'];
$telefone = $dadosUsuario['telefone'];
$email = $dadosUsuario['email'];
$senha = $dadosUsuario['senha'];
$cep = $dadosUsuario['cep'];
$bairro = $dadosUsuario['bairro'];
$rua = $dadosUsuario['rua'];
$numero = $dadosUsuario['numero'];
$complemento = $dadosUsuario['complemento'];
$conta_ativa = $dadosUsuario['conta_ativa'];


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOUER | Aluguel Facilitado </title>
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
        <?php $fonte = 'cliente'; include '../navbar.php'; ?>



        <!-- notificacao de erro -->
        <?php if (isset($_GET['msg'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <!-- <p class="font-medium text-sm">Erro no cadastro</p> Tirei pra poder receber varias mensagens, n so as de erro de cadastro-->
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
        <!-- Div pai que controla altura e espaçamento -->
        <div class="min-h-screen flex justify-center items-start py-5 px-2">

            <!-- Container branco (dashboard) -->
            <div class="flex w-full max-w-6xl bg-white rounded-2xl shadow-lg overflow-hidden h-[calc(100vh-4rem)]">

                <!-- Sidebar -->
                <aside class="w-64 bg-white shadow rounded-lg p-4">
                    <ul class="space-y-2">
                        <li>
                            <a href="?pagina=meus-dados"
                                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'meus-dados') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                                Meus dados
                            </a>
                        </li>
                        <li>
                            <a href="?pagina=meus-alugueis"
                                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'meus-alugueis') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                                Meus alugueis
                            </a>
                        </li>
                        <li>
                            <a href="?pagina=favoritos"
                                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'favoritos') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                                Favoritos
                            </a>
                        </li>
                    </ul>
                </aside>

                <!-- Conteúdo -->
                <main class="flex-1 bg-white shadow rounded-lg p-6 ml-2 overflow-y-auto">
                    <?php
                    if ($pagina === 'meus-dados') {
                        include 'meus-dados.php';
                    } elseif ($pagina === 'meus-alugueis') {
                        include 'meus-alugueis.php';
                    } elseif ($pagina === 'favoritos') {
                        include 'favoritos.php';
                    } else {
                        echo "<p>Escolha uma opção no menu.</p>";
                    }
                    ?>
                </main>

            </div>
        </div>

        <!-- Footer -->
        <?php include '../footer.php'; ?>

    </div>


</body>

</html>