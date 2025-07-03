<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do Fornecedor</title>
</head>
<body>
     
    <h1>CADASTRO DE FORNECEDOR</h1>


    <form action="../../control/CadFornecedor.php" method="post">

        <table>
            <tr>
                <td><label for="cep">CEP:</label></td>
                <td><input type="text" id="cep" name="cep" required></td>
            </tr>

            <tr>
                <td><label for="rua">Rua:</label></td>
                <td><input type="text" id="rua" name="rua"></td>
            </tr>
            <tr>
                <td><label for="bairro">Bairro:</label></td>
                <td><input type="text" id="bairro" name="bairro"></td>
            </tr>
            <tr>
                <td><label for="nEnd">Nº:</label></td>
                <td><input type="text" id="nEnd" name="nEnd"></td>
            </tr>
            <tr>
                <td><label for="complemento">Complemento:</label></td>
                <td><input type="text" id="complemento" name="complemento"></td>
            </tr>
        </table>

        <br><br>

        <input type="checkbox" id="termo" name="termo" required> Sou maior de 18 anos.

        <br><br>

        <button type="submit">Confirmar</button>
    </form>

    <?php
    // Mostrar a mensagem de retorno
    if (isset($_GET["msg"])) {
        $msg = $_GET["msg"];
        echo "<FONT color=pink>$msg</FONT>";
    }
    ?>

</body>
</html>