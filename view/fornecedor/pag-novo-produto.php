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
                <td><label for="nome">Nome:</label></td>
                <td><input type="text" id="nome" name="nome" required></td>
            </tr>
            <tr>
                <td><label for="tag">Tag:</label></td>
                <td>
                    <select name="tag">
                        <option value="">Selecione uma Tag</option>
                        <?php
                        require_once "../model/TagsDao.php";
                            echo listarTags();
                        ?>

                    </select>
                </td>

            </tr>
        </table>

        <br><br>

        <button type="submit">Criar</button>
    </form>
</body>

</html>