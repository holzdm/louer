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
            <?php include "../notificacao-erro.php";
            include "../notificacao.php"; ?>

            <!-- Informações do Produto -->
            <!-- <form action="../../control/ClienteController.php" method="post">
                <input type="hidden" name="acao" value="alterar">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                <input type="hidden" name="emailAntigo" value="<?= htmlspecialchars($_SESSION['email']) ?>">
                <div class="space-y-5">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                        <input type="text" id="nome" name="nome" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['nome']) ?>" required />
                    </div>

                    <div>
                        <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['cidade']) ?>" required />
                    </div>

                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['telefone']) ?>" required />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['email']) ?>" required />
                    </div>

                    <div>
                        <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                        <input type="password" id="senha" name="senha" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="******" required />
                        <p class="mt-1 text-xs text-gray-500">Mínimo de 6 caracteres com letras ou números</p>
                    </div>

                    <div class="flex items-start">
                        <input type="hidden" id="terms" name="terms" class="mt-1 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required />
                    </div>

                    <div>
                        <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                            Alterar Dados
                        </button>
                    </div>
                </div>
            </form> -->

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