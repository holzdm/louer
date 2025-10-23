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
        <div id="openModal" class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300' onclick="abrirModal(<?= $idReserva ?>)">
            
                <img src='<?php echo $srcImg ?>' class='w-full h-40 object-cover' alt='Imagem do produto'
                    alt='Imagem do produto' class="w-full h-40 object-cover">
                <div class="p-4">
                    <h3 class="font-bold text-lg"><?= $nomeProduto ?></h3>
                    <p class="text-gray-600">R$<?= $valorReserva ?>/h</p>
                    <p class="text-sm mt-2"><?= $status ?></p>
                </div>
            
        </div>
    <?php endwhile; ?>
</div>

                    <!-- Modal -->
                    <div id="modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                        <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-2/3 p-6 relative">

                            <!-- Botão fechar no canto -->
                            <button id="closeModal" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

                            <!-- Conteúdo do modal -->
                            <h2 class="text-2xl font-bold mb-4">Solicitação de Aluguel</h2>
                            <div id="modalContent" class="mb-4">
                                <p>Nome do Cliente: <?php $nomeCliente ?></p>  
                            </div>

                            <!-- Botão dentro do modal -->
                            <div class="flex justify-end">

                                <button id="confirmarSolicitacao" type="submit" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Confirmar Solicitacao</button>
                            </div>

                        </div>
                    </div>


<script>
    const modal = document.getElementById('modal');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementById('closeModal');

function abrirModal(idReserva) {
  modal.classList.remove('hidden');
  modalContent.innerHTML = `<h2 class="text-xl font-bold mb-4">Carregando...</h2>`;

  fetch(`/louer/control/ReservaController.php?acao=acessarFornecedor&id=${idReserva}`)
    .then(res => res.json())
    .then(data => {
      if (data.erro) {
        modalContent.innerHTML = `<p class="text-red-500">${data.erro}</p>`;
        return;
      }

      modalContent.innerHTML = `
        <p><strong>Cliente:</strong> ${data.nomeUsuario}</p>
        <p><strong>Email:</strong> ${data.emailUsuario}</p>
        <p><strong>Produto:</strong> ${data.nome}</p>
        <p><strong>Data Inicial:</strong> ${data.dataInicial}</p>
        <p><strong>Data Final:</strong> ${data.dataFinal}</p>
        <p><strong>Valor:</strong> R$${data.valorReserva}</p>
        <p><strong>Status:</strong> ${data.status}</p>

      `;
    })
    .catch(() => {
      modalContent.innerHTML = `<p class="text-red-500">Erro ao carregar dados da reserva.</p>`;
    });
}

closeModal.addEventListener('click', () => modal.classList.add('hidden'));
modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });
</script>