<?php
session_start();


$dadosReserva = $_SESSION['Reserva'] ?? null;

if ($dadosReserva) {
    $idProduto = $dadosReserva['idProduto'];
    $nomeProduto = $dadosReserva['nome'];
    $tipo = $dadosReserva['tipo'];
    $descricaoProduto = $dadosReserva['descricao'];
    $nomeFornecedor = $dadosReserva['nomeFornecedor'];
    $descricao = $dadosReserva['descricao'];


    $dataInicial = $dadosReserva['dataInicial']; // sem uso 
    $dataFinal = $dadosReserva['dataFinal'];  // sem uso 
    $valorReserva = $dadosReserva['valorReserva'];
    $status = $dadosReserva['status'];
} else {
    // Redirecionar ou mostrar erro se não houver produto
    header("Location: pag-ic.php?msg=Reserva não encontrado.");
    exit;
}

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
            <?php $fonte = 'cliente'; include '../navbar.php'; ?>



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
        <!-- Informacoes da Reserva -->

        <h2> <?php echo $nomeProduto ?> </h2>
        <br>
        <h3> <?php echo $descricao ?> </h3>
        <h3> <?php echo $valorReserva ?> </h3>
        <h3> Puplicado por: <?php echo $nomeFornecedor ?> </h3>
        <h3> <?php echo $dataInicial ?> </h3>
        <h3> <?php echo $dataFinal ?> </h3>
        <h3> <?php echo $status ?> </h3>

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