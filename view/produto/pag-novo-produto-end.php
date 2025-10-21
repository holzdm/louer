<?php
session_start();

if (empty($_SESSION['id'])) {
    header("Location: /louer/view/pag-inicial.php");
    exit;
}

$novoProduto = $_SESSION['novoProduto'] ?? [];


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOUER | Novo produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <?php include "../script-style.php" ; ?>
</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">
        <!-- Navbar -->
    <?php $fonte = 'produto'; include '../navbar.php'; ?>



        <!-- notificacao de erro -->
        <?php include "../notificacao-erro.php"; ?>


        <!-- ////////////////////////////////////////////////////////////////////////////// -->
        <!-- FORMULARIO -->
        <div class="flex justify-center items-center py-16">
            <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-4xl">
                <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">Qual o endereço do seu produto?</h1>

                <form action="../../control/ProdutoController.php" method="post" class="space-y-6">
                    <div>
                        <input type="hidden" name="acao" value="cadastrarEnd">
                        <label for="cep" class="block text-sm font-medium text-gray-700 mb-1">CEP: </label>
                        <input type="text" id="cep" name="cep" placeholder="" value="<?= htmlspecialchars($novoProduto['cep'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade: </label>
                        <input type="text" id="cidade" name="cidade" placeholder="" value="<?= htmlspecialchars($novoProduto['cidade'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="rua" class="block text-sm font-medium text-gray-700 mb-1">Rua: </label>
                        <input type="text" id="rua" name="rua" placeholder="" value="<?= htmlspecialchars($novoProduto['rua'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Bairro: </label>
                        <input type="text" id="bairro" name="bairro" placeholder="" value="<?= htmlspecialchars($novoProduto['bairro'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="numero" class="block text-sm font-medium text-gray-700 mb-1">N°: </label>
                        <input type="number" id="numero" name="numero" placeholder="00" step="1" min="0" value="<?= htmlspecialchars($novoProduto['numero'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                        <br><br>
                        <label for="complemento" class="block text-sm font-medium text-gray-700 mb-1">Complemento: </label>
                        <input type="text" id="complemento" name="complemento" placeholder="AP.. " value="<?= htmlspecialchars($novoProduto['complemento'] ?? '') ?>"
                            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
                        <br><br>
                        <div class="flex justify-between mt-6">
                            <!-- Botão Cancelar -->
                            <button type="button" id="btnCancelar" class="px-4 py-2 rounded-md text-gray-700 hover:underline">
                                Cancelar
                            </button>

                            <div>
                                <!-- Botão Voltar -->
                                <button id="btnVoltar" type="button" onclick="history.back()"
                                    class="px-4 py-2 rounded-md bg-primary text-white">
                                    Voltar
                                </button>
                                <!-- Botão Confirmar -->
                                <button id="btnConfirmar" type="submit"
                                    class="px-4 py-2 rounded-md bg-primary text-white">
                                    Confirmar
                                </button>
                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Footer -->
    <?php include '../footer.php'; ?>

    </div>



    <script>
        document.getElementById('btnCancelar').addEventListener('click', () => {
            window.location.href = "/louer/control/ProdutoController.php?acao=cancelarCadastro";
        });

    </script>


</body>

</html>