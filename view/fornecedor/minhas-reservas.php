<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Reservas</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">

<?php
    require_once "../../model/ReservaDao.php";
    require_once "../../model/ProdutoDao.php";
    $res1 = listarReservasFornecedor($_SESSION['id']);


    while ($registro = mysqli_fetch_assoc($res1)):
        $idReserva = $registro['id'];
        $idProduto = $registro['id_produto'];
        $dadosProduto = consultarProduto($idProduto);
        $nome = $dadosProduto['nome'];
        $valorReserva = $registro['valor_reserva'];
        $status = $registro['status'];

        $img = listarUmaImg($idProduto);
        $srcImg = $img ? $img['url_img'] : '/louer/a-uploads/New-piskel.png';

    ?>
        <div class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300'>
            <a href='/louer/control/ReservaController.php?acao=acessarFornecedor&id=<?= $idReserva ?>'>
                <img src='<?= $srcImg ?>'
                    alt='Imagem do produto' class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg"><?= $nome ?></h3>
                    <p class="text-gray-600">R$<?= $valorReserva ?>/h</p>
                    <p class="text-sm mt-2"><?= $status ?></p>
                </div>
            </a>
        </div>
    <?php endwhile; ?>
</div>