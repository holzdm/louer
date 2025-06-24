<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
    header("Location: ../pag-login.php");
    exit;
}

// Recupera os dados da sessão
$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial do Cliente</title>
</head>
<body>
    <h1> Pagina do Cliente logado </h1>
    <h3> PERFIL: <?php echo $nome ?> <a href="../pag-login.php"> Sair </a></h2>
    <br>
    <h3><a href="../fornecedor/pag-cad-fornecedor.php"> Quero ser um fornecedor! </a></h3>

</body>
</html>