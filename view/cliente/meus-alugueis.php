<?php
require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
$res = listarReservas($_SESSION['id']);
?>

<div class="flex justify-between">
    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Meus Aluguéis</h1>
    <div class="relative inline-block" id="filtro-container">

        <!-- Botão principal -->
        <button id="btnFiltro"
            onclick="toggleFiltro(event)"
            class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 
               px-4 py-2 rounded-full shadow-sm transition-all duration-200
               hover:shadow-md hover:scale-[1.02] active:scale-95">

            <!-- Ícone de filtro (SVG clean) -->
            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 5h18v2H3V5zm4 6h10v2H7v-2zm3 6h4v2h-4v-2z" />
            </svg>

            <span class="font-medium">Filtro</span>
        </button>

        <!-- Dropdown -->
        <div id="filtroDropdown"
            class="z-50 hidden absolute mt-2 right-0 bg-white shadow-xl rounded-xl p-3 w-48 
               border border-gray-200 animate-[fadeIn_0.15s_ease-out]">

            <div class="flex flex-col gap-2">

                <button class="filtro-btn" onclick="filtrarReservas('todas')">Todas</button>
                <button class="filtro-btn" onclick="filtrarReservas('solicitada')">Solicitadas</button>
                <button class="filtro-btn" onclick="filtrarReservas('aprovada')">Aprovadas</button>
                <button class="filtro-btn" onclick="filtrarReservas('confirmada')">Confirmadas</button>
                <button class="filtro-btn" onclick="filtrarReservas('recusada')">Recusadas</button>
                <button class="filtro-btn" onclick="filtrarReservas('cancelada')">Canceladas</button>
                <button class="filtro-btn" onclick="filtrarReservas('finalizada')">Finalizadas</button>

            </div>

        </div>
    </div>

</div>


<div id="listaReservas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2">

</div>
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

    // FILTRO ////////////////////////////////////
    function filtrarReservas(status) {
        const lista = document.getElementById("listaReservas");
        lista.innerHTML = `<p class="text-gray-500">Carregando...</p>`;

        // ⭐ SE FOR "todas", usamos o endpoint normal que traz tudo
        const bodyRequest =
            status === "todas" ?
            "acao=listarCliente" :
            `acao=filtrarStatusCliente&status=${encodeURIComponent(status)}`;

        fetch("/louer/control/ReservaController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: bodyRequest
            })
            .then(res => res.json())
            .then(data => {
                console.log("Dados recebidos:", data);

                if (!data.length) {
                    lista.innerHTML = `<p class="text-gray-500">Nenhuma reserva encontrada.</p>`;
                    return;
                }

                lista.innerHTML = data.map(registro => {

                    const badge =
                        registro.status === 'Solicitada' ? 'bg-yellow-100 text-yellow-700' :
                        registro.status === 'Aprovada' ? 'bg-blue-100 text-blue-700' :
                        registro.status === 'Confirmada' ? 'bg-green-100 text-green-700' :
                        registro.status === 'Cancelada' ? 'bg-gray-100 text-gray-700' :
                        registro.status === 'Finalizada' ? 'text-gray-700' :
                        registro.status === 'Recusada' ? 'bg-red-100 text-red-700' :
                        'bg-gray-100 text-gray-700';

                    return `
            <div onclick="abrirModal(${registro.id})"
                class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl 
                       transition transform hover:-translate-y-1 duration-300 cursor-pointer">

                <img src="${registro.img}" 
                    alt="Imagem do produto"
                    class="w-full h-48 object-cover hover:scale-105 transition duration-500">

                <div class="p-4">

                    <h3 class="text-lg font-semibold text-primary truncate">
                        ${registro.nome}
                    </h3>

                    <p class="text-gray-700 font-medium text-sm mt-1">
                        R$${registro.valor_reserva}
                    </p>

                    <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-semibold ${badge}">
                        ${registro.status}
                    </span>

                </div>
            </div>`;
                }).join("");
            })
            .catch(err => {
                console.error(err);
                lista.innerHTML = `<p class="text-red-500">Erro ao carregar dados.</p>`;
            });
    }

    // ////////////////////////////////////////////////////

    // BOTAO DE FILTRO
    function toggleFiltro(e) {
        e.stopPropagation(); // ⬅️ impede o clique no botão de disparar o eventListener global

        const drop = document.getElementById("filtroDropdown");
        drop.classList.toggle("hidden");
    }


    // Fechar ao clicar fora
    document.addEventListener("click", function(e) {
        const container = document.getElementById("filtro-container");
        const dropdown = document.getElementById("filtroDropdown");

        // se não clicou dentro do container, fecha
        if (!container.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });


    // /////////////////////////////////////
</script>