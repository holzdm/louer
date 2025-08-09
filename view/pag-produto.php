<?php 
session_start();

if (!isset($_SESSION['Produto'])) {
    header("Location: ../view-bonitinha/pag-inicial.php?msgErro=Produto inválido. (pag-produto)");
    exit;
}
$dadosProduto = $_SESSION['Produto'];
$nomeProduto = $dadosProduto['nome'];
$tipoProduto = $dadosProduto['tipo'];
$descricaoProduto = $dadosProduto['descricao'];
$valorProduto = $dadosProduto['valor'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pag do produto</title>
</head>
<body>


<h2> <?php echo $nomeProduto?> </h2>
<br>
<h3> <?php echo $descricaoProduto?> </h3>
<h3> <?php echo $valorProduto?> </h3>

</body>
</html>