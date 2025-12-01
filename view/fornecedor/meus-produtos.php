<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Produtos</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
    <?php
    require_once "../../model/ProdutoDao.php";

    $res = listarMeusProdutos();

    while ($registro = mysqli_fetch_assoc($res)) {
        $idProduto = $registro["id"];
        $nome = $registro["nome"];
        $descricao = $registro["descricao"];
        $valorDia = $registro["valor_dia"];

        $img = listarUmaImg($idProduto);

        if ($img) {
            // monta a URL base64
            $srcImg = "data:" . $img['tipo'] . ";base64," . $img['dados'];
        } else {
            // imagem padrão
            $srcImg = "/louer/a-uploads/New-piskel.png";
        }

        echo "
<div class='bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300'>
    <a href='/louer/control/ProdutoController.php?acao=acessarMeuProduto&id=$idProduto' class='block'>

        <!-- Imagem -->
        <div class='w-full h-48 overflow-hidden'>
            <img src='$srcImg' class='w-full h-full object-cover hover:scale-105 transition duration-500'>
        </div>

        <!-- Conteúdo do card -->
        <div class='p-4'>

            <h3 class='text-lg font-semibold text-primary truncate'>
                $nome
            </h3>

            <p class='text-gray-700 font-medium text-sm'>
                R$$valorDia / dia
            </p>

        </div>

    </a>
</div>
";
    } ?>
</div>