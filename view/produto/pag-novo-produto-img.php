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

                    <!-- Botão Cancelar -->
                    <div class="flex justify-between">
                        <button type="button" id="btnCancelar" class="px-4 py-2 rounded-md text-gray-700 hover:underline">
                            Cancelar
                        </button>

                        <div>
                            <!-- Botão Voltar -->
                            <button id="btnVoltar" type="button" onclick="history.back()" class="px-4 py-2 rounded-md bg-primary text-white">
                                Voltar
                            </button>
                            <!-- Botão Confirmar -->
                            <button id="btnConfirmar" type="submit" form="confirmarProduto" class="px-4 py-2 rounded-md bg-primary text-white">
                                Confirmar
                            </button>
                        </div>
                    </div>

                    <!-- Galeria (botão + imagens) -->
                    <div id="preview" class="grid grid-cols-6 gap-4">

                        <!-- Botão de adicionar imagens -->
                        <div>
                            <label class="h-30 aspect-square cursor-pointer flex items-center justify-center bg-red-700 hover:bg-red-800 text-white rounded-lg shadow transition-all duration-300">
                                +
                                <input type="file" name="imagens[]" id="imagens" class="hidden" multiple accept="image/jpeg,image/png,image/gif">
                            </label>
                        </div>

                        <!-- Loop das imagens -->
                        <?php if (!empty($novoProduto['imagens'])): ?>
                            <?php foreach ($novoProduto['imagens'] as $img_url): ?>
                                <div class="relative h-30 aspect-square">
                                    <img src="<?php echo $img_url ?>" class="object-cover w-full h-full rounded-lg shadow">
                                    <button type="button" class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs remove-btn">x</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>


    <!-- SCRIPT -->
    <script>
        const inputImagens = document.getElementById('imagens');
        const preview = document.getElementById('preview');

        // Preview para novas imagens
        inputImagens.addEventListener('change', function(event) {
            const files = event.target.files;

            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement("div");
                    div.classList.add("relative", "w-32", "h-32");

                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("object-cover", "w-full", "h-full", "rounded-lg", "shadow");

                    // Botão de remover
                    const btn = document.createElement("button");
                    btn.type = "button";
                    btn.innerText = "x";
                    btn.classList.add("absolute", "top-1", "right-1", "bg-red-600", "hover:bg-red-700", "text-white", "rounded-full", "w-6", "h-6", "flex", "items-center", "justify-center", "text-xs", "remove-btn");

                    btn.addEventListener("click", () => {
                        div.remove();
                    });

                    div.appendChild(img);
                    div.appendChild(btn);
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        });

        // Remover imagens já carregadas (do PHP/session)
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener("click", (e) => {
                e.target.parentElement.remove();
            });
        });

        // Botão cancelar
        document.getElementById('btnCancelar').addEventListener('click', () => {
            window.location.href = "/louer/control/ProdutoController.php?acao=cancelarCadastro";
        });
    </script>
</body>

</html>