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
        $nome = $dadosProduto['nomeProduto'];
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
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition transform hover:-translate-y-1 duration-300 cursor-pointer">

            <img src="<?= $srcImg ?>" alt="Imagem do produto"
                class="w-full h-48 object-cover hover:scale-105 transition duration-500">

            <div class="p-4">

                <!-- Nome (padrão oficial) -->
                <h3 class="text-lg font-semibold text-primary truncate">
                    <?= $nome ?>
                </h3>

                <!-- Valor (padrão oficial) -->
                <p class="text-gray-700 font-medium text-sm mt-1">
                    R$<?= $valorReserva ?>
                </p>

                <!-- Status com badge -->
                <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-semibold
            <?php if ($status === 'Solicitada') echo 'bg-yellow-100 text-yellow-700'; ?>
            <?php if ($status === 'Aprovada') echo 'bg-blue-100 text-blue-700'; ?>
            <?php if ($status === 'Confirmada') echo 'bg-green-100 text-green-700'; ?>
            <?php if ($status === 'Recusada') echo 'bg-red-100 text-red-700'; ?>
            <?php if ($status === 'Cancelada') echo 'bg-gray-100 text-gray-700'; ?>
        ">
                    <?= $status ?>
                </span>

            </div>
        </div>

    <?php endwhile; ?>
    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">

        <div class="bg-white rounded-2xl w-11/12 md:w-3/4 lg:w-2/3 p-8 shadow-2xl relative animate-[fadeIn_0.25s_ease-out]">

            <!-- Botão fechar -->
            <button id="closeModal"
                class="absolute top-4 right-4 text-gray-500 hover:text-primary transition text-3xl font-bold">
                &times;
            </button>

            <!-- Conteúdo dinâmico -->
            <div id="modalContent" class="space-y-4 text-gray-700"></div>

        </div>
    </div>


    <script>
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');
        const closeModal = document.getElementById('closeModal');


        function abrirModal(idReserva) {
            modal.classList.remove('hidden');
            modalContent.innerHTML = `<h2 class="text-xl font-bold text-primary">Carregando...</h2>`;



            fetch(`/louer/control/ReservaController.php?acao=acessar&idReserva=${idReserva}`)
                .then(res => res.json())
                .then(data => {
                    if (data.erro) {
                        modalContent.innerHTML = `<p class="text-red-500">${data.erro}</p>`;
                        return;
                    }

                    const dataFormatadaInicial = new Date(data.dataInicial).toLocaleDateString("pt-BR");
                    const dataFormatadaFinal = new Date(data.dataFinal).toLocaleDateString("pt-BR");
                    const dataFormatadaSolicitada = new Date(data.dataSolicitada.replace(" ", "T")).toLocaleString("pt-BR");

                    modalContent.innerHTML = `
            
            <!-- Título + link para o produto -->
            <a href="/louer/control/ProdutoController.php?acao=acessar&id=${data.idProduto}">
                <h2 class="text-2xl font-semibold text-primary mb-4">
                    ${data.nomeProduto}
                </h2>
            </a>

            <!-- Grid de detalhes -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-gray-800">Valor diário</p>
                    <p class="text-gray-600">${data.valorDiaria}</p>
                </div>

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-gray-800">Quantidade de dias</p>
                    <p class="text-gray-600">${data.quantDias}</p>
                </div>

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-gray-800">Data inicial</p>
                    <p class="text-gray-600">${dataFormatadaInicial}</p>
                </div>

                <div class="bg-secondary p-4 rounded-xl">
                    <p class="font-semibold text-gray-800">Data final</p>
                    <p class="text-gray-600">${dataFormatadaFinal}</p>
                </div>

            </div>

            <!-- Total -->
            <p class="text-xl font-bold text-primary mt-4">
                Total: R$ ${data.valorReserva}
            </p>

            <!-- Status -->
            <div>
                <p class="font-semibold text-primary">Status:</p>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold
                    ${data.status === "Solicitada" ? "bg-yellow-100 text-yellow-700" : ""}
                    ${data.status === "Aprovada" ? "bg-blue-100 text-blue-700" : ""}
                    ${data.status === "Confirmada" ? "bg-green-100 text-green-700" : ""}
                    ${data.status === "Cancelada" ? "bg-gray-100 text-gray-700" : ""}
                    ${data.status === "Recusada" ? "bg-red-100 text-red-700" : ""}">
                    ${data.status}
                </span>
            </div>
            
            <!-- Data Solicitacao -->
            <p class="text-gray-600"><strong>Data da Solicitação:</strong> ${dataFormatadaSolicitada}</p>
            `;

                    /* Botões para aprovadas */
                    if (data.status === "Aprovada") {
                        modalContent.innerHTML += `
                <div class="flex justify-end gap-4 mt-6">

                    <!-- Pagar -->
                    <a href="/louer/view/cliente/pag-pagamento.php?idReserva=${idReserva}"
                       class="px-5 py-2.5 rounded-xl bg-green-500 text-white font-semibold shadow-md 
                              hover:bg-green-600 hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Realizar Pagamento
                    </a>

                    <!-- Cancelar -->
                    <form action="/louer/control/ReservaController.php" method="post">
                        <input type="hidden" name="acao" value="cancelar">
                        <input type="hidden" name="idReserva" value="${idReserva}">

                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-red-500 text-white font-semibold shadow-md 
                                   hover:bg-red-600 hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Cancelar
                        </button>
                    </form>

                </div>
                `;
                    }
                    if (data.status === "Confirmada") {
                        modalContent.innerHTML += `
                            <!-- Ver comprovante -->
                <div class="flex justify-end mt-6">
                    <a href="/louer/view/cliente/pag-pagamento.php?idReserva=${idReserva}"
                       class="px-5 py-2.5 rounded-xl bg-green-500 text-white font-semibold shadow-md 
                              hover:bg-green-600 hover:shadow-lg transition transform hover:-translate-y-0.5">
                        Ver Comprovante
                    </a>

                </div>

`;
                    }

                    if (data.status === "Solicitada") {
                        modalContent.innerHTML += `
                            <!-- Cancelar -->
                <div class="flex justify-end mt-6">
                    <form action="/louer/control/ReservaController.php" method="post">
                        <input type="hidden" name="acao" value="cancelar">
                        <input type="hidden" name="idReserva" value="${idReserva}">

                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-red-500 text-white font-semibold shadow-md 
                                   hover:bg-red-600 hover:shadow-lg transition transform hover:-translate-y-0.5">
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