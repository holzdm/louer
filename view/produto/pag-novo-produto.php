<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location: /louer/view/pag-inicial.php");
  exit;
}
if (isset($_SESSION['novoProduto'])) {
  $novoProduto = $_SESSION['novoProduto'];
}



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
  <!-- script e style padrao -->
  <?php include '../script-style.php'; ?>
</head>

<body>

  <div class="min-h-screen flex flex-col pt-24">
    <!-- Navbar e Notificacao-->
    <?php $fonte = 'produto';
    include '../navbar.php';
    include '../notificacao-erro.php'; ?>


    <!-- ////////////////////////////////////////////////////////////////////////////// -->
    <!-- FORMULARIO -->
    <div class="flex justify-center items-center py-16">
      <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-4xl">
        <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">O que deseja anunciar?</h1>

        <form action="/louer/control/ProdutoController.php" method="post" class="space-y-6" id="form">
          <input type="hidden" name="acao" value="cadastrar">

          <div>
            <div class="flex justify-center max-w-xs mx-auto rounded-lg border border-gray-300 divide-x divide-gray-300 overflow-hidden">
              <label class="flex-1 cursor-pointer flex justify-center items-center relative py-3">
                <input type="radio" name="tipoProduto" value="Equipamento" class="hidden peer" />
                <div class="absolute inset-0 peer-checked:bg-gray-300 peer-checked:text-white transition-colors rounded-l-lg"></div>
                <span class="relative z-10 font-semibold text-lg">Equipamento</span>
              </label>
              <label class="flex-1 cursor-pointer flex justify-center items-center relative py-3">
                <input type="radio" name="tipoProduto" value="Espaco" class="hidden peer" />
                <div class="absolute inset-0 peer-checked:bg-gray-300 peer-checked:text-white transition-colors rounded-r-lg"></div>
                <span class="relative z-10 font-semibold text-lg">Espaço</span>
              </label>
            </div>
            <label for="nomeProduto" class="block text-sm font-medium text-gray-700 mb-1">Nome do produto</label>
            <input type="text" id="nomeProduto" name="nomeProduto" placeholder="Digite o nome do seu produto" value="<?= htmlspecialchars($novoProduto['nomeProduto'] ?? '') ?>"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
            <br><br>
            <label for="valorProduto" class="block text-sm font-medium text-gray-700 mb-1">Valor do produto</label>
            <input type="number" id="valorProduto" name="valorProduto" placeholder="R$00.00" step="0.01" min="0" value="<?= htmlspecialchars($novoProduto['valorProduto'] ?? '') ?>"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
            <br><br>
            <label for="descricaoProduto" class="block text-sm font-medium text-gray-700 mb-1">Descrição do produto</label>
            <textarea id="descricaoProduto" name="descricaoProduto" placeholder="Um produto incrível.." rows="5" cols="30"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary"><?= htmlspecialchars($novoProduto['descricaoProduto'] ?? '') ?></textarea>
          </div>

          <!-- CARD: TAGS -->
          <div class="bg-white rounded-xl shadow p-6 mb-8">
            <h2 class="text-lg font-semibold text-primary mb-4">Tags</h2>

            <div class="flex flex-wrap gap-2 mb-4" id="lista-tags">
              <?php foreach (($novoProduto['tagsProduto'] ?? []) as $tag): ?>
                <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm flex items-center gap-2">
                  <?= htmlspecialchars($tag) ?>
                  <button type="button" class="text-red-600 remove-tag" data-value="<?= htmlspecialchars($tag) ?>">✕</button>
                </span>
              <?php endforeach; ?>
            </div>

            <div class="flex gap-3">
              <input id="novaTag" type="text" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" placeholder="Adicionar tag">
              <button type="button" id="addTag" class="bg-primary text-white px-5 py-3 rounded-lg hover:bg-primary/90">
                Adicionar
              </button>
            </div>

            <input type="hidden" name="tags" form="form" id="tagsCampo">
          </div>
          <!-- DIAS DISPONIVEIS -->

          <label class="block mb-2 font-medium text-gray-700">Selecione os dias disponíveis:</label>
          <div class="flex gap-2 flex-wrap">

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Dom" class="hidden" />
              Dom
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Seg" class="hidden" />
              Seg
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Ter" class="hidden" />
              Ter
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Qua" class="hidden" />
              Qua
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Qui" class="hidden" />
              Qui
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Sex" class="hidden" />
              Sex
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Sab" class="hidden" />
              Sab
            </label>

          </div>
          <div class="flex justify-between mt-6">
            <!-- Botão Cancelar -->
            <button type="button" id="btnCancelar" class="px-4 py-2 rounded-md text-gray-700 hover:underline onclick=" history.back()"">
              Cancelar
            </button>

            <!-- Botão Confirmar -->
            <button id="btnConfirmar" type="submit" disabled
              class="px-4 py-2 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed transition">
              Confirmar
            </button>
          </div>
        </form>
      </div>
    </div>
    <!-- //////////////////////////////////////////////////////////////////////// -->

    <!-- Footer -->
    <?php include '../footer.php'; ?>

  </div>

</body>
<script>
  /* ------------------ TAGS ------------------ */

  let tags = <?= json_encode($novoProduto['tagsProduto'] ?? []) ?>;

  const tagsCampo = document.getElementById("tagsCampo");
  const listaTags = document.getElementById("lista-tags");
  const addBtn = document.getElementById("addTag");
  const novaTagInput = document.getElementById("novaTag");

  // Atualiza o hidden
  function atualizarTags() {
    tagsCampo.value = JSON.stringify(tags);
  }

  // Adiciona tag
  addBtn.addEventListener("click", function() {
    const nova = novaTagInput.value.trim();
    if (!nova || tags.includes(nova)) return;

    tags.push(nova);

    listaTags.innerHTML += `
        <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm flex items-center gap-2">
            ${nova}
            <button type="button" class="text-red-600 remove-tag" data-value="${nova}">✕</button>
        </span>
    `;

    novaTagInput.value = "";
    atualizarTags();
  });

  // Remover tag com delegação de evento
  listaTags.addEventListener("click", function(e) {
    if (!e.target.classList.contains("remove-tag")) return;

    const valor = e.target.dataset.value;

    tags = tags.filter(t => t !== valor);
    e.target.parentElement.remove();

    atualizarTags();
  });

  // Inicializa hidden já na primeira carga
  atualizarTags();


  // /////////////////////
  document.querySelectorAll('.toggle-button').forEach(label => {
    const checkbox = label.querySelector('input[type="checkbox"]');

    // Atualiza o estilo da label conforme o estado inicial do checkbox
    if (checkbox.checked) {
      label.classList.add('bg-primary', 'text-white', 'border-primary');
    }

    label.addEventListener('click', () => {
      // Depois do clique, verifica o estado real do checkbox e aplica/remova as classes
      setTimeout(() => {
        if (checkbox.checked) {
          label.classList.add('bg-primary', 'text-white', 'border-primary');
        } else {
          label.classList.remove('bg-primary', 'text-white', 'border-primary');
        }
      }, 0); // timeout para esperar o checkbox ser marcado/desmarcado pelo navegador
    });
  });
  const radios = document.querySelectorAll('input[name="tipoProduto"]');
  const btnConfirmar = document.getElementById('btnConfirmar');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      btnConfirmar.disabled = false;
      btnConfirmar.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
      btnConfirmar.classList.add('bg-primary', 'text-white');
    });
  });
  document.getElementById('btnCancelar').addEventListener('click', () => {
    window.location.href = "/louer/control/ProdutoController.php?acao=cancelarCadastro";
  });
</script>

</html>