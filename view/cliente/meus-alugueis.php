<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Aluguéis</h1>

<?php
require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
$res = listarReservas($_SESSION['id']);
?>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
    <?php while ($registro = mysqli_fetch_assoc($res)):
        $idReserva = $registro['id'];
        $idProduto = $registro['id_produto'];
        $dadosProduto = consultarProduto($idProduto);
        $nome = $dadosProduto['nome'];
        $valorReserva = $registro['valor_reserva'];
        $status = $registro['status'];

        $img = listarUmaImg($idProduto);

          if ($img) {
            // monta a URL base64
            $srcImg = "data:" . $img['tipo'] . ";base64," . $img['dados'];
          } else {
            // imagem padrão
            $srcImg = "/louer/a-uploads/New-piskel.png";
          }

    ?>
        <div class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300'>
            <a href='/louer/control/ReservaController.php?acao=acessar&id=<?= $idReserva ?>'>
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