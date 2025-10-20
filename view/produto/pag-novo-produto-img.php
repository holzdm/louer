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
                </form>

                <!-- Galeria (botão + imagens) -->
                <div id="preview" class="grid grid-cols-6 gap-4">
                    <!-- Botão de adicionar imagens -->
                    <div>
                        <label for="inputAddImg" class="h-30 aspect-square cursor-pointer flex items-center justify-center bg-red-700 hover:bg-red-800 text-white rounded-lg shadow transition-all duration-300">
                            +
                        </label>
                    </div>
                    <input type="file" name="imagens[]" id="inputAddImg" multiple accept="image/jpeg,image/png,image/gif" style="display:none;">
                    <!-- Remova o <div id="imagensPreview"></div> -->
                </div>
            </div>
        </div>
    </div>
    <?php include "../footer.php" ?>


    <!-- SCRIPT -->
    <script>
<<<<<<< HEAD
        let imagens = [];

        const inputAddImg = document.getElementById('inputAddImg');
        const preview = document.getElementById('preview');

        // Botão "+" abre o seletor de arquivos
        document.querySelector('label[for="inputAddImg"]').addEventListener('click', () => {
            inputAddImg.click();
        });

        // Preview e adição
        inputAddImg.addEventListener('change', function(e) {
            for (const file of e.target.files) {
                imagens.push(file);
            }
            atualizarPreview();
            inputAddImg.value = ""; // Limpa o input para permitir adicionar novamente
        });

        // Função para atualizar o preview
        function atualizarPreview() {
            // Mantém o botão "+" como primeiro filho
            preview.innerHTML = preview.children[0].outerHTML;
            imagens.forEach((img, idx) => {
                const url = URL.createObjectURL(img);
                const div = document.createElement('div');
                div.className = "relative h-30 aspect-square";
                div.innerHTML = `
            <img src="${url}" class="object-cover w-full h-full rounded-lg shadow">
            <button type="button" class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs" onclick="removerImg(${idx})">x</button>
        `;
                preview.appendChild(div);
            });
        }

        // Remoção
        window.removerImg = function(idx) {
            imagens.splice(idx, 1);
            atualizarPreview();
        }
        // Ao confirmar, envia todas as imagens via FormData
        document.getElementById('confirmarProduto').addEventListener('submit', function(e) {
            if (imagens.length === 0) return; // Se não há imagens, segue normal
            e.preventDefault();
            const formData = new FormData(this);
            imagens.forEach(img => formData.append('imagens[]', img));
            fetch(this.action, {
                method: 'POST',
                body: formData
            }).then(res => res.text()).then(resp => {
                // Redireciona ou mostra mensagem
                window.location.href = "/louer/view/fornecedor/pag-inicial-fornecedor.php";
            });
        });

=======
        const inputImagens = document.getElementById('imagens');
const preview = document.getElementById('preview');

// Função para atualizar o preview
function adicionarPreview(file, indexSessao) {
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
        btn.classList.add(
            "absolute", "top-1", "right-1", "bg-red-600", "hover:bg-red-700",
            "text-white", "rounded-full", "w-6", "h-6", "flex", "items-center",
            "justify-center", "text-xs", "remove-btn"
        );

        btn.addEventListener("click", () => {
            // Remove do preview
            div.remove();

            // Remove da sessão via AJAX
            fetch(`/louer/control/ProdutoController.php?acao=removerImg&nomeImg=${encodeURIComponent(file.name)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== "ok") {
                        console.error("Erro ao remover imagem da sessão:", data.msg);
                    }
                });
        });

        div.appendChild(img);
        div.appendChild(btn);
        preview.appendChild(div);
    }
    reader.readAsDataURL(file);
}


>>>>>>> 51bc78eeab9e099ac2c391ee18705aadcbe53994

    </script>
</body>

</html>