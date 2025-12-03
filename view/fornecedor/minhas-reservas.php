<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Reservas</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">

  <?php
  require_once "../../model/ReservaDao.php";
  require_once "../../model/ProdutoDao.php";
  $res1 = listarReservasFornecedor($_SESSION['id']);


  while ($registro = mysqli_fetch_assoc($res1)):
    $idReserva = $registro['id'];
    $idProduto = $registro['id_produto'];
    $dadosProduto = consultarProduto($idProduto);
    $nomeProduto = $dadosProduto['nome'];
    $valorReserva = $registro['valor_reserva'];
    $status = $registro['status'];

    $img = listarUmaImg($idProduto);

    if ($img) {
      // monta a URL base64
      $srcImg = "data:" . $img['tipo'] . ";base64," . $img['dados'];
    } else {
      // imagem padrão
      $srcImg = "/louer/a-uploads/New-piskel.png";
    }

  ?>
    <div onclick="abrirModal(<?= $idReserva ?>)"
      class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl hover:-translate-y-1 transition transform duration-300 cursor-pointer">

      <img src="<?= $srcImg ?>" class="w-full h-44 object-cover">

      <div class="p-4">
        <h3 class="text-lg font-semibold text-primary truncate"><?= $nomeProduto ?></h3>

        <p class="text-gray-700 font-medium text-sm">
          R$<?= $valorReserva ?>/h
        </p>

        <span class="inline-block mt-3 px-3 py-1 rounded-full text-sm 
                <?= $status === 'Solicitada' ? 'bg-yellow-100 text-yellow-700' : '' ?>
                <?= $status === 'Aprovada' ? 'bg-blue-100 text-blue-700' : '' ?>
                <?= $status === 'Confirmada' ? 'bg-green-100 text-green-700' : '' ?>
                <?= $status === 'Cancelada' ? 'bg-red-100 text-red-700' : '' ?>
                <?= $status === 'Recusada' ? 'bg-gray-100 text-gray-700' : '' ?>">
          <?= $status ?>
        </span>
      </div>
    </div>

  <?php endwhile; ?>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">

  <div class="bg-white rounded-2xl w-11/12 md:w-3/4 lg:w-1/2 p-8 shadow-2xl relative animate-[fadeIn_0.25s_ease-out]
            max-h-[90vh] overflow-y-auto">


    <!-- Botão fechar -->
    <button id="closeModal"
      class="absolute top-4 right-4 text-gray-500 hover:text-primary transition text-3xl font-bold">
      &times;
    </button>

    <!-- TITULO DO MODAL -->
    <h2 class="text-2xl font-bold text-primary mb-6 pb-3 border-b">
      Detalhes do Aluguel
    </h2>

    <!-- Conteúdo JS -->
    <div id="modalContent" class="space-y-4"></div>

  </div>
</div>



<script>
  const modal = document.getElementById('modal');
  const modalContent = document.getElementById('modalContent');
  const closeModal = document.getElementById('closeModal');

  function abrirModal(idReserva) {
    modal.classList.remove('hidden');
    modalContent.innerHTML = `<p class="text-primary font-medium">Carregando dados...</p>`;

    fetch(`/louer/control/ReservaController.php?acao=acessarFornecedor&idReserva=${idReserva}`)
      .then(res => res.json())
      .then(data => {

        if (data.erro) {
          modalContent.innerHTML = `<p class="text-red-600">${data.erro}</p>`;
          return;
        }

        const dataFormatadaInicial = new Date(data.dataInicial).toLocaleDateString("pt-BR");
        const dataFormatadaFinal = new Date(data.dataFinal).toLocaleDateString("pt-BR");
        const dataFormatadaSolicitada = new Date(data.dataSolicitada.replace(" ", "T")).toLocaleString("pt-BR");
        let dataFormatadaPagamento = "";
        if (data.dataPagamento) {
          dataFormatadaPagamento = new Date(data.dataPagamento.replace(" ", "T")).toLocaleString("pt-BR");
        }

        modalContent.innerHTML = `

            <!-- Usuário -->
            <div class="bg-secondary p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-primary mb-1">Cliente</h3>
                <p class="text-gray-700"><strong>Nome:</strong> ${data.nomeUsuario}</p>
                <p class="text-gray-700"><strong>Email:</strong> ${data.emailUsuario}</p>
            </div>

            <!-- Produto -->
            <div class="bg-secondary p-4 rounded-xl">
                <h3 class="text-lg font-semibold text-primary mb-1">Produto</h3>
                <p class="text-gray-700">${data.nome}</p>
            </div>

            <!-- Datas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-primary">Data Inicial</p>
                    <p class="text-gray-700">${dataFormatadaInicial}</p>
                </div>

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-primary">Data Final</p>
                    <p class="text-gray-700">${dataFormatadaFinal}</p>
                </div>

            </div>

            <!-- Valor total -->
            <div class="p-4 bg-[#e8f6fc] border border-[#c6e9f5] rounded-xl">
                <p class="font-semibold text-primary text-lg">Valor Total</p>
                <p class="text-gray-800 text-xl font-bold">R$ ${data.valorReserva}</p>
            </div>

            <!-- Status -->
            <div>
                <p class="font-semibold text-primary">Status:</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold
                    ${data.status === "Solicitada" ? "bg-yellow-100 text-yellow-700" : ""}
                    ${data.status === "Aprovada" ? "bg-blue-100 text-blue-700" : ""}
                    ${data.status === "Confirmada" ? "bg-green-100 text-green-700" : ""}
                    ${data.status === "Cancelada" ? "bg-red-100 text-red-700" : ""}
                    ${data.status === "Recusada" ? "bg-gray-100 text-gray-700" : ""}">
                    ${data.status}
                </span>
            </div>

            <div class="mt-5 gap-2">
                <p class="text-gray-600"><strong>• Data da Solicitação:</strong> ${dataFormatadaSolicitada}</p>
                
              ${data.status === "Confirmada" 
                ?  `<p class='text-gray-600'><strong>• Data do Pagamento:</strong> ${dataFormatadaPagamento}</p>` 
                : ""
              }                       
            </div>
            `;

        // Botões apenas se "Solicitada"
        if (data.status === "Solicitada") {
          modalContent.innerHTML += `
                <div class="flex justify-end gap-3 mt-6">

                    <!-- Aceitar -->
                    <form action="/louer/control/ReservaController.php" method="post">
                        <input type="hidden" name="acao" value="aceitar">
                        <input type="hidden" name="idReserva" value="${data.idReserva}">
                        <button
                          class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                            Aceitar
                        </button>
                    </form>

                    <!-- Recusar -->
                    <form action="/louer/control/ReservaController.php" method="post">
                        <input type="hidden" name="acao" value="recusar">
                        <input type="hidden" name="idReserva" value="${data.idReserva}">
                        <button
                          class="px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                            Recusar
                        </button>
                    </form>

                </div>`;
        }

        // Botões apenas se "Confirmada"
        const hoje = new Date();
        const dataFinal = new Date(data.dataFinal + "T23:59:59");

        if (data.status === "Confirmada" && hoje > dataFinal) {

          modalContent.innerHTML += `
          
                <div class="flex justify-end gap-3 mt-6">

                    <!-- Finalizar -->
                    <form action="/louer/control/ReservaController.php" method="post">
                        <input type="hidden" name="acao" value="finalizar">
                        <input type="hidden" name="idReserva" value="${data.idReserva}">
                        <button
                          class="px-4 py-2 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                            Finalizar
                        </button>
                    </form>

                </div>`;
        }

      })
      .catch(() => {
        modalContent.innerHTML = `<p class="text-red-600">Erro ao carregar dados.</p>`;
      });
  }

  closeModal.addEventListener('click', () => modal.classList.add('hidden'));
  modal.addEventListener('click', e => {
    if (e.target === modal) modal.classList.add('hidden');
  });
</script>