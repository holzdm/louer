<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial do Fornecedor</title>
</head>
<body>
    <?php
    // Mostrar a mensagem de retorno
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo "<FONT color=pink>$msg</FONT>";
    }
    ?>
    <h3>Crie seu produto <a href="pag-novo-produto.php"> AQUI! </a></h3>
</body>
</html>