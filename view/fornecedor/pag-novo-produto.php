<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>ADICIONANDO NOVO PRODUTO</h1>

    <form action="../../control/CadProduto.php" method="post">

        <table>
            <tr>
                <td><label for="nomeProduto">Nome:</label></td>
                <td><input type="text" id="nomeProduto" name="nomeProduto" required></td>
            </tr>
            <tr>
                <td><label for="arrayTags[]">Tag:</label></td>
                <td>
                    <select name="arrayTags[]" multiple size="6">
                        <option disabled> -- Selecione uma Tag -- </option>
                        <?php
                        require_once "../../model/TagsDao.php";
                        $arrayTags = listarTags($conexao); //chamo a funcao la do model

                        foreach ($arrayTags as $idTag => $nomeTag) {
                            echo "<OPTION value='$idTag'>$nomeTag</OPTION>";
                        }
                        /*
                        require_once '../../model/TagsDao.php';
                        $arrayTags = listarTags($conexao);  // retorna [idTag => nomeTag]

                        foreach ($arrayTags as $idTag => $nomeTag) {
                            echo "<label>";
                            echo "<input type='checkbox' name='arrayTags[]' value='$idTag'> $nomeTag";
                            echo "</label><br>";
                        }
                        */
                        ?>
                    </select>
                </td>

            </tr>
        </table>

        <br><br>

        <button type=" submit">Criar</button>
    </form>

    <br><br>

    <?php
    if (isset($_GET['msgErro'])) {
        $msgErro = $_GET['msgErro'];
        echo "<FONT color=red>$msgErro</FONT>";
    }
    if (isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        echo "<FONT color=pink>$msg</FONT>";
    }
    ?>
</body>

</html>