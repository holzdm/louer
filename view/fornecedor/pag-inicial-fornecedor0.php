<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
    header("Location: ../pag-login.php");
    exit;
}

// Recupera os dados da sessão
$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial do Fornecedor</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        <nav class="bg-white shadow-sm py-4">
            <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
                <a href="../cliente/pag-inicial-cliente.php" class="text-primary font-bold text-3xl">LOUER</a>
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
                    <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="../../view/tela-provisoria-perfil.php" class="text-gray-600 hover:text-primary">Perfil</a>
                </div>
            </div>
        </nav>

        <br>
        <h4> SESSAO DE: <?php echo $nome; ?></h4>
        <br>
        <h3>Crie seu produto <a href="../../view-bonitinha/fornecedor/pag-novo-produto.php"> AQUI! </a></h3>
        <?php

        // Mostrar a mensagem de retorno
        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            echo "<FONT color=pink>$msg</FONT>";
        }
        ?>
    </div>
</body>

</html>

<!-- Essa pag prov deixara de existir ou mudara de nome. Porque vai ser parte da pag do perfil -->