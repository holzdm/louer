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
        <!-- Conteúdo -->
        <div class="py-5 px-3 flex flex-col gap-8 mx-auto w-2/3 items-center">

            <!--Formulário de alteração-->
            <div class="md:w-1/2 w-full flex flex-col justify-center">
                <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10 w-full h-full">
                    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Alterar Meus Dados</h1>
                    <br>
                    <form action="../../control/ClienteController.php" method="post">
                        <input type="hidden" name="acao" value="alterar">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                        <input type="hidden" name="emailAntigo" value="<?= htmlspecialchars($_SESSION['email']) ?>">
                        <div class="space-y-5">
                            <div>
                                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                                <input type="text" id="nome" name="nome" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required />
                            </div>

                            <div>
                                <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                                <input type="text" id="cidade" name="cidade" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['cidade']) ?>" required />
                            </div>

                            <div>
                                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                                <input type="tel" id="telefone" name="telefone" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['telefone']) ?>" required />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['email']) ?>" required />
                            </div>

                            <div>
                                <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                                <input type="password" id="senha" name="senha" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="******" required />
                                <p class="mt-1 text-xs text-gray-500">Mínimo de 6 caracteres com letras ou números</p>
                            </div>

                            <div class="flex items-start">
                                <input type="hidden" id="terms" name="terms" class="mt-1 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required />
                            </div>

                            <div>
                                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                                    Alterar Dados
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aluguéis -->
            <div class="md:w-1/2 w-full flex flex-col">
                <h2 class="text-2xl md:text-3xl font-bold text-primary mb-5"><br>Meus aluguéis</h2>
                <div class="columns is-multiline pb-5">
                    <?php
                    require_once "../../model/ReservaDao.php";
                    require_once "../../model/ProdutoDao.php";
                    $res = listarReservas($_SESSION['id']);
                    while ($registro = mysqli_fetch_assoc($res)) {
                        $idReserva = $registro['id'];
                        $idProduto = $registro["id_produto"];
                        $dadosProduto = consultarProduto($idProduto);
                        $nome = $dadosProduto["nome"];
                        $dataInicial = $registro['data_reserva'];
                        $dataFinal = $registro['data_final'];
                        $valorReserva = $registro['valor_reserva'];
                        $status = $registro['status'];
                        echo "
        <div class='column is-one-quarter'>
            <div class='card'><a href='../../control/ReservaController.php?acao=acessar&id=$idReserva'>
                <div class='card-image'>
                    <figure class='image is-4by3'>
                        <img src='https://bulma.io/assets/images/placeholders/1280x960.png' alt='Imagem do produto' />
                    </figure>
                </div>
                <div class='card-content'>
                    <div class='media'>
                        <div class='media-left'>
                            <figure class='image is-48x48'>
                                <img src='https://bulma.io/assets/images/placeholders/96x96.png' alt='Avatar do fornecedor' />
                            </figure>
                        </div>
                        <div class='media-content'>
                            <p class='title is-5'>$nome</p>
                            <p class='subtitle is-6'>R$$valorReserva/h</p>
                        </div>
                    </div>
                    <div class='content'>
                        $status
                    </div>
                </div>
            </a></div>
        </div>
        ";
                    }
                    ?>
                </div>
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