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
    <?php include "../script-style.php" ?>
</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">
        <!-- Navbar e Notificacao -->
        <?php $fonte = 'produto';
        include '../navbar.php';
        include '../notificacao-erro.php'; ?>

        <div class="flex justify-center items-center py-16">
            <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-4xl">

                <!-- FORMULARIO -->
                <form action="/louer/control/ProdutoController.php" id="confirmarProduto" name="confirmarProduto" method="post" enctype="multipart/form-data" class="space-y-6">
                    <input type="hidden" name="acao" value="cadastrarProdutoFinal">


                    <!-- Botao de adicionar imagens -->
                    <div class="flex items-center">
                            <label for="images" class="h-16 w-16 rounded-full cursor-pointer flex items-center justify-center bg-red-700 hover:bg-red-800 text-white rounded-full shadow transition-all duration-300">
                                +
                            </label>
                            <input type="file" id="images" name="images[]" accept="image/*" class="hidden" multiple required>

                        <h3 class="text-xl md:text-3xl font-bold text-primary text-center ml-4">Adicione imagens de seu produto:</h3>
                    </div>




                    <!-- Galeria -->
                    <div id="preview" class="grid grid-cols-6 gap-4">

                    </div>



                    <!-- BOTOES CANCELAR, VOLTAR E CONFIRMAR -->
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
    <?php include "../footer.php" ?>


    <!-- SCRIPT -->
    <script>
        // botao cancelar
        document.getElementById('btnCancelar').addEventListener('click', () => {
            window.location.href = "/louer/control/ProdutoController.php?acao=cancelarCadastro";
        });

        // PREVIEW DE IMAGENS /////////////////////////////
        const input = document.getElementById('images');
        const preview = document.getElementById('preview');

        input.addEventListener('change', () => {
            preview.innerHTML = '';
            const files = Array.from(input.files);
            files.forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const img = document.createElement('img');
                img.alt = file.name;
                const reader = new FileReader();
                reader.onload = e => img.src = e.target.result;
                reader.readAsDataURL(file);

                // envolver a img num card para o grid (recomendado)
                const card = document.createElement('div');
                card.className = 'relative w-full h-32 rounded-lg overflow-hidden shadow';
                img.className = 'object-cover w-full h-full';
                card.appendChild(img);

                preview.appendChild(card);
            });
        });
        // //////////////////////////////////////////////
    </script>
</body>

</html>