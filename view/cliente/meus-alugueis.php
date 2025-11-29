<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Aluguéis</h1>

<?php
require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
$res = listarReservas($_SESSION['id']);
?>


<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
    <?php while ($registro = mysqli_fetch_assoc($res)):
        $idReserva = $registro['id'];
        $idProduto = $registro['id_produto'];
        $dadosProduto = consultarProduto($idProduto);
        $nome = $dadosProduto['nome'];
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
        <div id="openModal" class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300 ' onclick="abrirModal(<?= $idReserva ?>)">
            <img src='<?= $srcImg ?>'
                alt='Imagem do produto' class="w-full h-40 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-lg"><?= $nome ?></h3>
                <p class="text-gray-600">R$<?= $valorReserva ?>/h</p>
                <p class="text-sm mt-2"><?= $status ?></p>
            </div>
        </div>
    <?php endwhile; ?>
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-11/12 md:w-3/4 lg:w-2/3 p-6 relative">

            <!-- Botão fechar no canto -->
            <button id="closeModal" type="button" class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>

            <!-- Conteúdo do modal -->
            <div id="modalContent" class="mb-4">
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

            fetch(`/louer/control/ReservaController.php?acao=acessar&id=${idReserva}`)
                .then(res => res.json())
                .then(data => {
                    if (data.erro) {
                        modalContent.innerHTML = `<p class="text-red-500">${data.erro}</p>`;
                        return;
                    }

                    modalContent.innerHTML = `
                    <a href="/louer/control/ProdutoController.php?acao=acessar&id=${data.idProduto}"> <h2 class="text-2xl font-bold mb-4 text-primary">${data.nomeProduto}</h2> </a>
                    <p class="text-gray-600">Valor Diário: ${data.valorDiaria}</p>
                    <p class="text-gray-600">Quantidade de dias: ${data.quantDias}</p>
                    <p class="text-xl text-gray-600 font-bold mt-2">Total: ${data.valorReserva}</p>

      `;
                    // 👉 Mostrar botões somente se a reserva estiver "Solicitada"
                    if (data.status === "Aprovada") {
                        modalContent.innerHTML += `
      <div class="flex justify-end gap-3 mt-4">

        <!-- pagar -->
        <a href="/louer/view/cliente/pag-pagamento.php?idReserva=${data.idReserva}" class="px-4 py-2 bg-green-300 rounded hover:bg-green-400">
            Realizar Pagamento
          </a>

        <!-- Cancelar -->
        <form action="/louer/control/ReservaController.php" method="post">
          <input type="hidden" name="acao" value="cancelar">
          <input type="hidden" name="idReserva" value="${data.idReserva}">
          <button type="submit"
            class="px-4 py-2 bg-red-300 rounded hover:bg-red-400">
            Cancelar
          </button>
        </form>

      </div>
    `;
                    }
                })
                .catch(() => {
                    modalContent.innerHTML = `<p class="text-red-500">Erro ao carregar dados da reserva.</p>`;
                });
        }

        closeModal.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', e => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    </script>