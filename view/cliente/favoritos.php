<?php
require_once "../../model/ProdutoDao.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../pag-inicial.php");
    exit();
}

// Obtém os favoritos do usuário
$idUsuario = $_SESSION['id'];
$favoritos = listarFavoritosDAO($idUsuario);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Favoritos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="">
<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Favoritos</h1>
    <div class="container mx-auto p-4">
        <br>
        <?php if ($favoritos && mysqli_num_rows($favoritos) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php while ($registro = mysqli_fetch_assoc($favoritos)): ?>
                    <?php
                    $idProduto = $registro["id"];
                    $nome = htmlspecialchars($registro["nome"]);
                    $valorDia = htmlspecialchars($registro["valor_dia"]);
                    $srcImg = "/louer/a-imagem/image.php?idProduto=" . $idProduto;
                    ?>
                    <div>
                        <div class="bg-white rounded-lg overflow-hidden h-70 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300">
                            <a href="../../control/ProdutoController.php?acao=acessar&id=<?= $idProduto ?>">
                                <img src="<?= $srcImg ?>" class="w-full h-40 object-cover" alt="Imagem do produto">
                                <div class="p-2">
                                    <h3 class="text-sm text-gray-800 font-medium truncate"><?= $nome ?></h3>
                                    <p class="text-gray-600">R$<?= $valorDia ?>/dia</p>
                                    <form action='../../control/ProdutoController.php' method='POST' class='p-2'>
                                    <input type='hidden' name='acao' value='excluirFavorito'>
                                    <input type='hidden' name='idProduto' value='$idProduto'>
                                    <button type='submit' class='text-red-500 hover:underline'>Remover</button>
                            </form>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Você ainda não possui produtos favoritos.</p>
        <?php endif; ?>
    </div>
</body>

</html>