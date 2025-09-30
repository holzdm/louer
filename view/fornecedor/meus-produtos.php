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

        $srcImg = $img ? $img['url_img'] : '/louer/a-uploads/New-piskel.png';

        echo "
      
        <div class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300'>
            <a href='/louer/control/ProdutoController.php?acao=acessarMeuProduto&id=$idProduto'>
                <img src='$srcImg' class='w-full h-40 object-cover' alt='Imagem do produto'>
                <div class='p-2'>
                    <h3 class='text-sm text-gray-800 font-medium truncate'>$nome</h3>
                    <p class='text-gray-600'>R$$valorDia/dia</p>
                </div>
            </a> 
        </div>
    
        ";
    } ?>
</div>