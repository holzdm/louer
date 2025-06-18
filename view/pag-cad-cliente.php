<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pag-cadastro</title>
</head>

<body>
    <h1>CADASTRO DE CLIENTE</h1>

    <form action="../control/CadCliente.php" method="post">

        <table>
            <tr>
                <td><label for="nome">Nome:</label></td>
                <td><input type="text" id="nome" name="nome" required></td>
            </tr>

            <tr>
                <td><label for="cpf">CPF:</label></td>
                <td><input type="text" id="cpf" name="cpf"></td>
            </tr>
            <tr>
                <td><label for="cnpj">CNPJ:</label></td>
                <td><input type="text" id="cnpj" name="cnpj"></td>
            </tr>
            <tr>
                <td><label for="cidade">Cidade:</label></td>
                <td><input type="text" id="cidade" name="cidade"></td>
            </tr>
            <tr>
                <td><label for="telefone">Telefone:</label></td>
                <td><input type="text" id="telefone" name="telefone"></td>
            </tr>
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

        <button type="submit">Confirmar</button>
    </form>

    <br><br>

    <p>Já Possui uma conta? <a href="pag-login.php">Login</a></p>
   

    <?php
    // Mostrar a mensagem de retorno
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo "<FONT color=red>$msg</FONT>";
    }
    ?>

</body>

</html>