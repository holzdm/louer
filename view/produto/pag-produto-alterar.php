<?php
session_start();

// Obter dados do produto
$dadosProduto = $_SESSION['Produto'] ?? null;
if (!$dadosProduto) {
    header("Location: ../pag-inicial.php?msg=Produto não encontrado.");
    exit;
}

$idProduto = $dadosProduto['idProduto'];
$nomeProduto = $dadosProduto['nome'];
$tipo = $dadosProduto['tipo'];
$descricaoProduto = $dadosProduto['descricao'];
$valorProduto = $dadosProduto['valor'];
$nomeFornecedor = $dadosProduto['nomeFornecedor'];
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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#164564',
                        secondary: '#f0fbfe',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <style>
        body {
            background-color: #f0fbfe;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #164564;
            box-shadow: 0 0 0 2px rgba(22, 69, 100, 0.2);
        }

        .btn-primary {
            background-color: #164564;
            transition: all 0.3s ease;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }

        .btn-primary:hover {
            background-color: #0d3854;
        }

        .toggle-button {
            transition: all 0.3s ease;
        }

        .toggle-button.active {
            background-color: #164564;
            color: white;
        }

        .data-selecionada {
            background-color: red !important;
            color: white !important;
        }

        .status {
            margin: 20px 0;
        }

        #botao-enviar:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Notificação */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -10px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translate(-50%, 0);
            }

            to {
                opacity: 0;
                transform: translate(-50%, -10px);
            }
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .fade-out {
            animation: fadeOut 0.4s ease-in forwards;
        }
    </style>
</head>

<body>
    <div class="min-h-screen flex flex-col bg-secondary">

    <!-- Navbar -->
    <div class=" w-full">
        <?php $fonte = 'produto';
        include '../navbar.php'; ?>
    </div>

    <!-- Container centralizado -->
    <div class="flex-1 w-full max-w-5xl mx-auto p-6">

        <!-- Notificação -->
        <?php if (isset($_GET['msg'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msg']) ?></p>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const notif = document.getElementById('notificacao');
                    if (notif) {
                        notif.classList.remove('fade-in');
                        notif.classList.add('fade-out');
                        setTimeout(() => notif.remove(), 500);
                    }
                }, 4000);
            </script>
        <?php endif; ?>

        <!-- Informações do Produto -->
        <section class="my-6">
            <h2 class="text-2xl font-bold"><?= htmlspecialchars($nomeProduto) ?></h2>
            <p class="mt-2"><?= htmlspecialchars($descricaoProduto) ?></p>
            <p class="mt-1 font-semibold">R$ <?= htmlspecialchars($valorProduto) ?> / dia</p>
            <p class="mt-1 text-gray-600">Publicado por: <?= htmlspecialchars($nomeFornecedor) ?></p>
        </section>

        <!-- Seletor de Datas -->
        <section class="my-6">
            <h3 class="text-lg font-semibold mb-2">Seletor de Datas</h3>
            <form id="form-datas" action="../../control/ProdutoController.php" method="POST">
                <div id="input"></div>

                <div class="status">
                    <h4 class="font-medium">Datas Selecionadas:</h4>
                    <div id="datas-selecionadas"></div>
                </div>

                <input type="hidden" name="acao" value="alterar">
                <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto) ?>">
                <input type="hidden" name="datas_selecionadas" id="campo-datas">
                <button type="submit" id="botao-enviar" class="btn-primary mt-2" disabled>Enviar Datas</button>
            </form>
            <a href="/louer/control/ProdutoController.php?id=<?= $idProduto ?>&acao=excluir" class="mt-2 inline-block text-red-600 hover:underline">Apagar Produto</a>
        </section>

    </div>

    <!-- Footer -->
    <?php $fonte = 'produto';
    include '../footer.php'; ?>

    </div>
</body>


<!-- Scripts -->
<script>
    const datasSelecionadas = new Set();
    const divDatasSelecionadas = document.querySelector("#datas-selecionadas");
    const campoDatas = document.querySelector("#campo-datas");
    const botaoEnviar = document.querySelector("#botao-enviar");
    const form = document.querySelector("#form-datas");

    function atualizarFormulario() {
        const datasArray = Array.from(datasSelecionadas);
        campoDatas.value = JSON.stringify(datasArray);
        botaoEnviar.disabled = datasArray.length === 0;
    }

    form.addEventListener("submit", function(e) {
        if (datasSelecionadas.size === 0) {
            e.preventDefault();
            alert("Por favor, selecione pelo menos uma data antes de enviar.");
        }
    });

    flatpickr("#input", {
        inline: true,
        dateFormat: "Y-m-d",
        locale: "pt",
        onDayCreate: function(dataObj, dataStr, flatpicker, diaEl) {
            diaEl.addEventListener("click", () => {
                const data = flatpicker.formatDate(diaEl.dateObj, "Y-m-d");
                if (datasSelecionadas.has(data)) {
                    datasSelecionadas.delete(data);
                    diaEl.classList.remove("data-selecionada");
                    document.querySelector('#data-' + data)?.remove();
                } else {
                    datasSelecionadas.add(data);
                    diaEl.classList.add("data-selecionada");
                    const p = document.createElement("p");
                    p.id = 'data-' + data;
                    p.innerText = data;
                    divDatasSelecionadas.append(p);
                }
                atualizarFormulario();
            });

            const data = flatpicker.formatDate(diaEl.dateObj, "Y-m-d");
            if (datasSelecionadas.has(data)) diaEl.classList.add("data-selecionada");
        }
    });

    atualizarFormulario();
</script>

</body>

</html>