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
    <?php include "../script-style.php"; ?>
</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">
        <!-- Navbar -->
        <?php $fonte = 'cliente'; include '../navbar.php'; 
        include '../notificacao.php'; include '../notificacao-erro.php';?>


    

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