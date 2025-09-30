<?php
session_start();


$dadosProduto = $_SESSION['Produto'] ?? null;

if ($dadosProduto) {
    $idProduto = $dadosProduto['idProduto'];
    $nomeProduto = $dadosProduto['nome'];
    $tipo = $dadosProduto['tipo'];
    $descricaoProduto = $dadosProduto['descricao'];
    $valorProduto = $dadosProduto['valor'];
    $nomeFornecedor = $dadosProduto['nomeFornecedor'];
} else {
    // Redirecionar ou mostrar erro se não houver produto
    header("Location: ../pag-inicial.php?msg=Produto não encontrado.");
    exit;
}

// if (!empty($_SESSION['nome'])) {
//     $nome = $_SESSION['nome'];
//     $nomePrimeiraLetra = $nome['0'];
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">


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
    </style>
</head>

<body>

    <div class="min-h-screen flex flex-col pt-24">
        <!-- Navbar -->
        <?php $fonte = 'produto';
        include '../navbar.php'; ?>



        <!-- notificacao -->
        <?php if (isset($_GET['msg'])): ?>
            <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
                <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
                    <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
                    </svg>
                    <div>
                        <!-- <p class="font-medium text-sm">Erro no cadastro</p>  Tirei pra poder receber varias mensagens, n so as de erro de cadastro -->
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msg']) ?></p>
                    </div>
                </div>
            </div>

            <style>
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


        <!-- //////////////////////////////////////////////////////////////////////// -->
        <!-- Informacoes do Produto -->

        <h2> <?php echo $nomeProduto ?> </h2>
        <br>
        <h3> <?php echo $descricaoProduto ?> </h3>
        <h3> <?php echo $valorProduto ?> </h3>
        <h3> Publicado por: <?php echo $nomeFornecedor ?> </h3>


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


        <style>
            .data-selecionada {
                background-color: red !important;
                color: white !important;
            }

            body {
                font-family: Arial, sans-serif;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .status {
                margin: 20px 0;
            }

            #botao-enviar {
                background-color: #007cba;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }

            #botao-enviar:hover {
                background-color: #005a8a;
            }

            #botao-enviar:disabled {
                background-color: #ccc;
                cursor: not-allowed;
            }
        </style>


        <h1>Seletor de Datas</h1>

        <form id="form-datas" action="../../control/ProdutoController.php" method="POST">
            <div id="input"></div>

            <div class="status">
                <h3>Datas Selecionadas:</h3>
                <div id="datas-selecionadas"></div>
            </div>

            <input type="hidden" name="acao" value="alterar">
            <input type="hidden" name="idProduto" value="<?= htmlspecialchars($idProduto) ?>">

            <!-- Campo hidden que vai conter as datas selecionadas -->
            <input type="hidden" name="datas_selecionadas" id="campo-datas">

            <button type="submit" id="botao-enviar" disabled>Enviar Datas</button>
        </form>

        <a href="/louer/control/ProdutoController.php?id=<?php echo $idProduto ?>&acao=excluir"> Apagar </a>


        <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
        <script>
            /**
             * Um set é tipo uma lista que te permite adicionar
             * e remover itens com mais facilidade
             * 
             * ex: 
             * const set = new Set();
             * const item = {...}
             * set.add(item);
             * set.delete(item); 
             */
            const datasSelecionadas = new Set();
            const divDatasSelecionadas = document.querySelector("#datas-selecionadas");
            const campoDatas = document.querySelector("#campo-datas");
            const botaoEnviar = document.querySelector("#botao-enviar");
            const form = document.querySelector("#form-datas");

            /**
             * Função para atualizar o campo hidden e o estado do botão
             */
            function atualizarFormulario() {
                /**
                 * Transforma o Set em uma lista normal
                 */
                const datasArray = Array.from(datasSelecionadas);
                /**
                 * Esconde a lista de datas em um campo no formulário
                 */
                campoDatas.value = JSON.stringify(datasArray);

                /**
                 * Habilita/desabilita o botão de envio baseado na quantidade
                 * de datas selecionadas. Aqui você também pode fazer outros
                 * tipos de verificações
                 */
                botaoEnviar.disabled = datasArray.length === 0;

                console.log("Datas selecionadas:", datasArray);
            }

            /**
             * Evento de submit do formulário
             */
            form.addEventListener("submit", function(e) {
                /**
                 * Caso não tenha nenhuma data selecionada, cancele o envio
                 * do formulário
                 */
                if (datasSelecionadas.size === 0) {
                    /**
                     * essa função faz o formulário não ser enviado
                     */
                    e.preventDefault();
                    alert("Por favor, selecione pelo menos uma data antes de enviar.");
                    return false;
                }

                /**
                 * Aqui seria o lugar pra validar as datas antes
                 * de mandar para o backend, caso queira
                 */
                console.log("Enviando datas:", Array.from(datasSelecionadas));
            });

            /**
             * Inicializador do flatpickr
             */
            flatpickr("#input", {
                /**
                 * Pra renderizar calendário o tempo todo 
                 */
                inline: true,
                /**
                 * Pra formatar a data
                 */
                dateFormat: "Y-m-d",
                /**
                 * Idioma do calendário (instalado pela linha 18)
                 */
                locale: "pt",
                /**
                 * Função que vai ser chamada para cada data
                 * que for renderizada no calendário
                 */
                onDayCreate: function(dataObj, dataStr, flatpicker, diaEl) {
                    /**
                     * Adicionar um evento de "clique" à data renderizada
                     */
                    diaEl.addEventListener("click", () => {
                        /**
                         * Pegar a data já formatada para o banco de dados
                         */
                        const data = flatpicker.formatDate(diaEl.dateObj, "Y-m-d");

                        /**
                         * Ao clicar, se o Set já tiver a data, remove ela 
                         * e remove a classe de "data-selecionada" do elemento de data
                         */
                        if (datasSelecionadas.has(data)) {
                            datasSelecionadas.delete(data);
                            /**
                             * Essa classe é o que estiliza a data no frontend
                             */
                            diaEl.classList.remove("data-selecionada");
                            /**
                             * Remove o item da lista do frontend
                             */
                            const itemEl = document.querySelector('#data-' + data);
                            itemEl.remove();
                        } else {
                            /**
                             * Caso a data não exista, simplesmente adiciona ao Set
                             * e adiciona a classe "data-selecionada" ao elemento de data
                             */
                            datasSelecionadas.add(data);
                            diaEl.classList.add("data-selecionada");
                            /**
                             * Cria o elemento da lista na interface
                             */
                            const p = document.createElement("p");
                            p.innerText = data;
                            p.id = 'data-' + data;
                            divDatasSelecionadas.append(p);
                        }

                        /**
                         * Atualiza o formulário após cada clique
                         */
                        atualizarFormulario();
                    });

                    /**
                     * Uma verificação imediata, logo ao renderizar,
                     * para aplicar a classe à data caso ela já esteja
                     * selecionada durante sua renderização
                     * 
                     * Isso é necessário porque eu ACHO que toda vez que 
                     * voce clica em uma data, todas as datas são re-renderizadas
                     * (posso estar falando bosta, mas de qualquer forma
                     * o código não funciona sem essa parte kkkkk)
                     */
                    const data = flatpicker.formatDate(diaEl.dateObj, "Y-m-d");
                    if (datasSelecionadas.has(data)) {
                        diaEl.classList.add("data-selecionada");
                    }
                }
            });

            /**
             * Inicializa o formulário
             */
            atualizarFormulario();
        </script>


        <!-- footer -->
        <?php $fonte = 'produto';
        include '../footer.php'; ?>





        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Função utilitária para adicionar evento só se o elemento existir
                const on = (selector, event, handler) => {
                    const el = document.querySelector(selector);
                    if (el) el.addEventListener(event, handler);
                };

                // Perfil
                on("#btnPerfil", "click", () => {
                    const cardPerfil = document.querySelector("#cardPerfil");
                    cardPerfil?.classList.toggle("hidden");
                });

                document.addEventListener("click", (e) => {
                    const btnPerfil = document.querySelector("#btnPerfil");
                    const cardPerfil = document.querySelector("#cardPerfil");
                    if (btnPerfil && cardPerfil && !btnPerfil.contains(e.target) && !cardPerfil.contains(e.target)) {
                        cardPerfil.classList.add("hidden");
                    }
                });

                // Flatpickr
                if (document.querySelector("#intervalo")) {
                    flatpickr("#intervalo", {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        minDate: "today",
                        disableMobile: true,
                        clickOpens: true,
                        allowInput: false
                    });
                }

                // Solicitar com login
                on("#btnSolicitar", "click", () => {
                    const intervalo = document.querySelector("#intervalo")?.value;
                    if (!intervalo) {
                        alert("Por favor, selecione um intervalo de datas antes.");
                        return;
                    }
                    document.querySelector("#modalSolicitar")?.classList.remove("hidden");
                });

                // Fechar modal
                on("#fecharModal", "click", () => {
                    document.querySelector("#modalSolicitar")?.classList.add("hidden");
                });

                // Fechar modal clicando fora
                window.addEventListener("click", (e) => {
                    const modal = document.querySelector("#modalSolicitar");
                    if (modal && e.target === modal) {
                        modal.classList.add("hidden");
                    }
                });

                // Solicitar sem login
                on("#btnSolicitarSemLogin", "click", () => {
                    window.location.assign(`../cliente/login-cliente.php`);
                });
            });
        </script>


</body>

</html>