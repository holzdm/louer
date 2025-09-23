<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Aluguéis</h1>

<?php
require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
$res = listarReservas($_SESSION['id']);
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-5">
    <?php while ($registro = mysqli_fetch_assoc($res)):
        $idReserva = $registro['id'];
        $idProduto = $registro['id_produto'];
        $dadosProduto = consultarProduto($idProduto);
        $nome = $dadosProduto['nome'];
        $valorReserva = $registro['valor_reserva'];
        $status = $registro['status'];
    ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <a href='../../control/ReservaController.php?acao=acessar&id=<?= $idReserva ?>'>
            <img src='https://bulma.io/assets/images/placeholders/1280x960.png' 
                 alt='Imagem do produto' class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-lg"><?= $nome ?></h3>
                <p class="text-gray-600">R$<?= $valorReserva ?>/h</p>
                <p class="text-sm mt-2"><?= $status ?></p>
            </div>
        </a>
    </div>
    <?php endwhile; ?>
</div>
