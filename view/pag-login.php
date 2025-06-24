<?php
session_start();
session_destroy(); // remove todos os dados da sessão
?> 
<!-- nao sei exatamente se essa eh a melhor forma de apagar os dados da sessao -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pag-login</title>
</head>

<body>
    <h1>LOGIN</h1>
    <?php
    // Mostrar a mensagem de retorno
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo "<FONT color=pink>$msg</FONT>";
    }
    ?>

    <form action="../control/LogCliente.php" method="post">

        <table>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" required></td>
            </tr>
            <tr>
                <td><label for="senha">Senha:</label></td>
                <td><input type="password" id="senha" name="senha" required></td>
            </tr>
        </table>

        <br><br>

        <button type="submit">Entrar</button>
    </form>

    <br><br>

    <p>Não possui uma conta? <a href="cliente/pag-cad-cliente.php">Cadastre-se</a></p>

    <?php
    // Mostrar a mensagem de retorno
    if (isset($_GET["msgErro"])) {
        $msgErro = $_GET["msgErro"];
        echo "<FONT color=red>$msgErro</FONT>";
    }
    ?>

</body>
</html>