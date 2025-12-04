<?php
session_start();

if (empty($_SESSION['id'])) {
    header("Location: /louer/view/pag-inicial.php");
    exit;
}
// Obter dados do produto
$dadosProduto = $_SESSION['Produto'] ?? null;
if (!$dadosProduto) {
    header("Location: /louer/pag-inicial.php?msg=Produto não encontrado.");
    exit;
}


$idProduto = $dadosProduto['idProduto'];
$nomeProduto = $dadosProduto['nomeProduto'];
$tipoProduto = $dadosProduto['tipo'];
$descricaoProduto = $dadosProduto['descricaoProduto'];
$valorDia = $dadosProduto['valorDia'];
$nomeFornecedor = $dadosProduto['nomeFornecedor'];
$imgArray = $dadosProduto['imgsArray'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto | <?= htmlspecialchars($nomeProduto) ?></title>

    <!-- CSS e Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    =
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <?php include "../script-style.php" ?>
</head>

<body>
    <div class="min-h-screen flex flex-col bg-secondary pt-24">

        <!-- Navbar -->
        <div class=" w-full">
            <?php $fonte = 'produto';
            include '../navbar.php'; ?>
        </div>


        <div class="max-w-5xl mx-auto px-6 pb-20">

            <?php include "../notificacao.php";
            include "../notificacao-erro.php"; ?>

            <!-- TÍTULO -->
            <h1 class="text-2xl font-semibold text-primary mb-6">
                Editar Produto
            </h1>

            <!-- CARD: INFORMAÇÕES PRINCIPAIS -->
            <div class="bg-white rounded-xl shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-primary mb-4">Informações Básicas</h2>

                <form id="infoProduto" action="/louer/control/ProdutoController.php" method="POST">
                    <input type="hidden" name="acao" value="alterar">
                    <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto) ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Nome -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <input type="text" name="nomeProduto" value="<?= htmlspecialchars($nomeProduto) ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" required>
                        </div>

                        <!-- Valor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Valor por Dia</label>
                            <input type="number" name="valorDia" step="0.01" min="0"
                                value="<?= htmlspecialchars($valorDia) ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" required>
                        </div>

                        <!-- Tipo -->
                        <div>
                            <p class="block text-sm font-medium text-gray-700 mb-1">Tipo do Produto: <?= htmlspecialchars($tipoProduto) ?></p>
                        </div>

                    </div>

                    <!-- Descrição -->
                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                        <textarea name="descricaoProduto"
                            class="w-full h-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"><?= htmlspecialchars($descricaoProduto) ?></textarea>
                    </div>
                </form>
            </div>

            <!-- CARD: TAGS -->
            <div class="bg-white rounded-xl shadow p-6 mb-8">
                <h2 class="text-lg font-semibold text-primary mb-4">Tags</h2>

                <div class="flex flex-wrap gap-2 mb-4" id="lista-tags">
                    <?php foreach ($dadosProduto['tagsArray'] as $tag): ?>
                        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm flex items-center gap-2">
                            <?= htmlspecialchars($tag) ?>
                            <button type="button" class="text-red-600 remove-tag" data-value="<?= htmlspecialchars($tag) ?>">✕</button>
                        </span>
                    <?php endforeach; ?>
                </div>

                <div class="flex gap-3">
                    <input id="novaTag" type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" placeholder="Adicionar tag">
                    <button id="addTag" class="bg-primary text-white px-5 py-3 rounded-lg hover:bg-primary/90">
                        Adicionar
                    </button>
                </div>

                <input type="hidden" name="tags" form="infoProduto" id="tagsCampo">
            </div>

            <!-- CARD: IMAGENS -->
            <div class="bg-white rounded-xl shadow p-6 mb-8">

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Imagens</label>

                    <div class="flex items-center gap-3 flex-wrap">

                        <?php foreach ($imgArray as $img):
                            // montar src a partir do blob (como você já faz)
                            $src = "data:" . $img['tipo'] . ";base64," . $img['dados'];
                            // id seguro (escaped)
                            $imgId = htmlspecialchars($img['id'], ENT_QUOTES, 'UTF-8');
                        ?>
                            <div class="relative group inline-block">
                                <img
                                    src="<?= $src ?>"
                                    class="h-28 w-28 rounded-xl object-cover shadow-sm border border-gray-200"
                                    alt="Imagem do produto <?= $imgId ?>">
                                <!-- botão de remover: não usar onclick inline -->
                                <button
                                    type="button"
                                    data-img-id="<?= $imgId ?>"
                                    class="remove-img-btn absolute -top-2 -right-2 bg-red-500 text-white w-7 h-7 rounded-full 
                   shadow-md opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-sm"
                                    aria-label="Remover imagem">
                                    &times;
                                </button>
                            </div>
                        <?php endforeach; ?>

                        <!-- Input para adicionar novas -->
                        <label
                            class="w-28 h-28 border-2 border-dashed border-primary/40 flex flex-col items-center justify-center 
           rounded-xl text-primary/70 cursor-pointer hover:bg-primary/5 transition ml-2">
                            <span class="text-3xl">＋</span>
                            <span class="text-xs mt-1">Adicionar</span>
                            <input type="file" name="imagens[]" class="hidden" multiple form="infoProduto">
                        </label>
                    </div>

                </div>
            </div>

            <!-- CARD: DATAS -->
            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-primary mb-4">Disponibilidade</h2>

                <div id="calendar"></div>

                <form id="form-datas" action="/louer/control/ProdutoController.php" method="POST" class="mt-4">
                    <input type="hidden" name="acao" value="alterarDatas">
                    <input type="hidden" name="idProduto" value="<?= $idProduto ?>">
                    <input type="hidden" name="datas_selecionadas" id="datasCampo">

                    <button type="submit" id="btnDatas" disabled
                        class="bg-primary disabled:bg-gray-400 text-white px-6 py-3 rounded-lg">
                        Atualizar Datas
                    </button>
                </form>
            </div>

            <!-- AÇÕES FINAIS -->
            <div class="flex flex-col gap-3 mb-20">
                <button type="submit" form="infoProduto"
                    class="bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary/90">
                    Salvar Alterações
                </button>

                <a href="/louer/control/ProdutoController.php?acao=excluir&id=<?= $idProduto ?>"
                    class="bg-red-700 text-white py-3 rounded-lg font-medium text-center hover:bg-red-800">
                    Excluir Produto
                </a>
            </div>

        </div>


        <!-- Footer -->
        <?php $fonte = 'produto';
        include '../footer.php'; ?>


</body>


<!-- Scripts -->
<script>
    /* ------------------ TAGS ------------------ */

    let tags = <?= json_encode($dadosProduto['tagsArray']) ?>;
    const tagsCampo = document.getElementById("tagsCampo");
    const listaTags = document.getElementById("lista-tags");
    const addBtn = document.getElementById("addTag");

    function atualizarTags() {
        tagsCampo.value = JSON.stringify(tags);
    }

    addBtn.onclick = function() {
        const nova = document.getElementById("novaTag").value.trim();
        if (!nova || tags.includes(nova)) return;

        tags.push(nova);
        listaTags.innerHTML += `
        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm flex items-center gap-2">
            ${nova}
            <button type="button" class="text-red-600 remove-tag" data-value="${nova}">✕</button>
        </span>
    `;

        document.getElementById("novaTag").value = "";
        atualizarTags();
    };

    listaTags.addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-tag")) {
            const valor = e.target.dataset.value;
            tags = tags.filter(t => t !== valor);
            e.target.parentElement.remove();
            atualizarTags();
        }
    });

    atualizarTags();



    /* ------------------ DATAS ------------------ */

    const datasSelecionadas = new Set();
    const datasCampo = document.getElementById("datasCampo");
    const btnDatas = document.getElementById("btnDatas");

    flatpickr("#calendar", {
        inline: true,
        locale: "pt",
        dateFormat: "Y-m-d",

        onChange: function(selectedDates, dateStr) {

            if (!dateStr) return;

            if (datasSelecionadas.has(dateStr)) {
                datasSelecionadas.delete(dateStr);
            } else {
                datasSelecionadas.add(dateStr);
            }

            datasCampo.value = JSON.stringify([...datasSelecionadas]);
            btnDatas.disabled = datasSelecionadas.size === 0;
        }
    });
</script>


</body>

</html>