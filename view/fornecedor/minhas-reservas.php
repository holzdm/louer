<?php
require_once "../../model/ReservaDao.php";
require_once "../../model/ProdutoDao.php";
?>

<div class="flex justify-between mb-4">
    <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Minhas Reservas</h1>

    <!-- Filtro -->
    <div class="relative inline-block " id="filtro-container">
        <button id="btnFiltro"
            onclick="toggleFiltro(event)"
            class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700 
                   px-4 py-2 rounded-full shadow-sm transition-all duration-200
                   hover:shadow-md hover:scale-[1.02] active:scale-95">

            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 5h18v2H3V5zm4 6h10v2H7v-2zm3 6h4v2h-4v-2z" />
            </svg>

            <span class="font-medium">Filtro</span>
        </button>

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

<div id="listaReservas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
    <p class="text-gray-500">Carregando...</p>
</div>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl w-11/12 md:w-3/4 lg:w-2/3 p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto animate-[fadeIn_0.25s_ease-out]">
        <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-primary transition text-3xl font-bold">&times;</button>
        <div id="modalContent" class="space-y-4 text-gray-700"></div>
    </div>
</div>

<script>
const modal = document.getElementById('modal');
const modalContent = document.getElementById('modalContent');
const closeModal = document.getElementById('closeModal');

// Abrir modal
function abrirModal(idReserva) {
    modal.classList.remove('hidden');
    modalContent.innerHTML = `<p class="text-primary font-medium">Carregando dados...</p>`;

    fetch(`/louer/control/ReservaController.php?acao=acessar&idReserva=${idReserva}`)
        .then(res => res.json())
        .then(data => {
            if (data.erro) {
                modalContent.innerHTML = `<p class="text-red-600">${data.erro}</p>`;
                return;
            }

            const dataInicial = new Date(data.dataInicial).toLocaleDateString("pt-BR");
            const dataFinal = new Date(data.dataFinal).toLocaleDateString("pt-BR");
            const dataSolicitada = new Date(data.dataSolicitada.replace(" ", "T")).toLocaleString("pt-BR");
            const dataPagamento = data.dataPagamento ? new Date(data.dataPagamento.replace(" ", "T")).toLocaleString("pt-BR") : "";

            modalContent.innerHTML = `
                <!-- Cliente -->
                <div class="bg-secondary p-4 rounded-xl">
                    <h3 class="text-lg font-semibold text-primary mb-1">Cliente</h3>
                    <p><strong>Nome:</strong> ${data.nomeUsuario}</p>
                    <p><strong>Email:</strong> ${data.emailUsuario}</p>
                </div>

                <!-- Produto -->
                <div class="bg-secondary p-4 rounded-xl">
                    <h3 class="text-lg font-semibold text-primary mb-1">Produto</h3>
                    <p>${data.nomeProduto}</p>
                </div>

                <!-- Datas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-secondary p-4 rounded-xl">
                        <p class="font-semibold text-primary">Data Inicial</p>
                        <p>${dataInicial}</p>
                    </div>
                    <div class="bg-secondary p-4 rounded-xl">
                        <p class="font-semibold text-primary">Data Final</p>
                        <p>${dataFinal}</p>
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

                <p class="text-gray-600 mt-2"><strong>Data da Solicitação:</strong> ${dataSolicitada}</p>
                ${dataPagamento ? `<p class="text-gray-600"><strong>Data do Pagamento:</strong> ${dataPagamento}</p>` : ""}
            `;

            // Botões condicional
            if (data.status === "Solicitada") {
                modalContent.innerHTML += `
                    <div class="flex justify-end gap-3 mt-6">
                        <form action="/louer/control/ReservaController.php" method="post">
                            <input type="hidden" name="acao" value="aceitar">
                            <input type="hidden" name="idReserva" value="${data.idReserva}">
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Aceitar</button>
                        </form>
                        <form action="/louer/control/ReservaController.php" method="post">
                            <input type="hidden" name="acao" value="recusar">
                            <input type="hidden" name="idReserva" value="${data.idReserva}">
                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Recusar</button>
                        </form>
                    </div>`;
            }
        })
        .catch(() => {
            modalContent.innerHTML = `<p class="text-red-600">Erro ao carregar dados.</p>`;
        });
}

// Fechar modal
closeModal.addEventListener('click', () => modal.classList.add('hidden'));
modal.addEventListener('click', e => { if(e.target===modal) modal.classList.add('hidden'); });

// FILTRO
function filtrarReservas(status) {
    const lista = document.getElementById('listaReservas');
    lista.innerHTML = `<p class="text-gray-500">Carregando...</p>`;

    const bodyRequest = status === "todas" ? "acao=listarCliente" : `acao=filtrarStatusCliente&status=${encodeURIComponent(status)}`;

    fetch("/louer/control/ReservaController.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: bodyRequest
    })
    .then(res => res.json())
    .then(data => {
        if (!data.length) {
            lista.innerHTML = `<p class="text-gray-500">Nenhuma reserva encontrada.</p>`;
            return;
        }

        lista.innerHTML = data.map(registro => {
            const badge =
                registro.status === 'Solicitada' ? 'bg-yellow-100 text-yellow-700' :
                        registro.status === 'Aprovada' ? 'bg-blue-100 text-blue-700' :
                        registro.status === 'Confirmada' ? 'bg-green-100 text-green-700' :
                        registro.status === 'Cancelada' ? 'bg-red-100 text-red-700' :
                        registro.status === 'Finalizada' ? 'text-gray-700' :
                        registro.status === 'Recusada' ? 'bg-gray-100 text-gray-700' :
                'bg-gray-100 text-gray-700';

            return `
            <div onclick="abrirModal(${registro.id})"
                 class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition transform hover:-translate-y-1 cursor-pointer">
                <img src="${registro.img}" alt="Produto" class="w-full h-48 object-cover hover:scale-105 transition duration-500">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-primary truncate">${registro.nome}</h3>
                    <p class="text-gray-700 font-medium text-sm">R$${registro.valor_reserva}</p>
                    <span class="inline-block mt-3 px-3 py-1 rounded-full text-xs font-semibold ${badge}">${registro.status}</span>
                </div>
            </div>`;
        }).join('');
    })
    .catch(err => {
        console.error(err);
        lista.innerHTML = `<p class="text-red-500">Erro ao carregar dados.</p>`;
    });
}

// Toggle filtro
function toggleFiltro(e) {
    e.stopPropagation();
    document.getElementById('filtroDropdown').classList.toggle('hidden');
}
document.addEventListener('click', e => {
    const container = document.getElementById('filtro-container');
    if(!container.contains(e.target)) document.getElementById('filtroDropdown').classList.add('hidden');
});
</script>
