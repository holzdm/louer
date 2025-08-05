<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
    header("Location: ../pag-login.php");
    exit;
}

$nome = $_SESSION['nome'];
$tipo = $_SESSION['tipo'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela provisoria perfil</title>
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
                <a href="cliente/pag-inicial-cliente.php" class="text-primary font-bold text-3xl">LOUER</a>

            </div>
        </nav>
        <br>
        <h4> SESSAO DE: <?php echo ("$nome e tipo: $tipo"); ?></h4>
        <h3><a href="#">Informações da Conta</a></h3>
        <h3><a href="#">Meus Aluguéis</a></h3>
        <h3><a href="#">Favoritos</a></h3>
        <h3><a href="#">Notificações</a></h3>
        <?php if ($tipo == 'Fornecedor'): ?>
            <h3><a href="../fornecedor/pag-inicial-fornecedor0.php"> Página do Fornecedor </a></h3>

        <?php else: ?>
            <h3><a href="../view-bonitinha/fornecedor/pag-cad-fornecedor.php"> Quero ser um fornecedor! </a></h3>

        <?php endif; ?>
        <h3><a href="#">Sair</a></h3>
    </div>
</body>

</html>