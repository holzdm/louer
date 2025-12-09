<nav class="fixed top-0 w-full z-50 bg-white shadow-sm py-4">
    <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
        <a href="/louer/view/pag-inicial.php" class="text-primary font-bold text-3xl">LOUER</a>

        <!-- <div class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
            <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
            <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div> -->
        <?php if ($fonte == 'pag-inicial'): ?>
            <div class="hidden md:flex space-x-6">

                <form action="/louer/control/ProdutoController.php" method="POST" class="flex items-center space-x-2">
                    <input type="hidden" name="acao" value="pesquisar">

                    <label for="pesquisa" class="sr-only">Pesquisar</label>

                    <div class="flex items-center gap-2">

                        <!-- INPUT -->
                        <input
                            type="text"
                            id="pesquisa"
                            name="pesquisa"
                            placeholder="Pesquisar..."
                            class="w-80 px-4 py-2 border border-gray-300 rounded-lg 
               focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 
               transition-all duration-200" />

                        <!-- BOTÃO -->
                        <button type="submit"
                            class="bg-gray-200 text-gray-700 p-2 rounded-full 
               transition-all duration-200 flex items-center justify-center
               hover:bg-gray-300 hover:shadow-md hover:scale-[1.05]
               active:scale-95 active:shadow-sm">

                            <svg class="w-5 h-5 text-primary"
                                fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M10 2a8 8 0 105.293 14.293l4.707 4.707 1.414-1.414-4.707-4.707A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z" />
                            </svg>

                        </button>
                    </div>


                </form>
            </div>
        <?php endif; ?>
        <div class="flex items-center space-x-4">
            <!-- Navbar: CLIENTE LOGADO -->
            <?php if (!empty($_SESSION['id'])):
                $tipo = $_SESSION['tipo']; ?>
                <div class="relative">
                    <!-- Botão de perfil -->
                    <button id="btnPerfil" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow hover:bg-gray-100 transition">
                        <!-- <img src="https://via.placeholder.com/40" alt="Foto de perfil" class="w-5 h-5 rounded-full"> -->
                        <span class="font-medium"><?php echo $_SESSION['nome']['0'] ?></span>

                    </button>
                    <div id="cardPerfil" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-[0_-1px_6px_-1px_rgba(0,0,0,0.10),0_1px_3px_rgba(0,0,0,0.06)] z-50 hidden">
                        <style>
                            #cardPerfil a {
                                margin: 0;
                            }
                        </style>
                        <a href="/louer/control/ClienteController.php?acao=acessar" class="block px-5 py-1 mt-2 hover:bg-gray-100 ">Informações da Conta</a>

                        <a href="/louer/control/ClienteController.php?acao=acessar&pagina=favoritos" class="block px-5 py-1 hover:bg-gray-100">Favoritos</a>
                        <a href="/louer/control/ClienteController.php?acao=sair" class="block px-5 py-1 hover:bg-gray-100 text-red-600 ">Sair</a>

                        <div class="border-t border-gray-200 my-2 mx-2"></div> <!-- Divisor sem hover -->
                        <?php if ($tipo == 'Fornecedor') {
                            echo "
                                <a href='/louer/control/CadFornecedor.php?acao=acessar' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                        } else {
                            echo "
                                <a href='/louer/view/fornecedor/pag-cad-fornecedor.php' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Quero ser Fornecedor</a>";
                        } ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="/louer/view/cliente/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
            <?php endif; ?>

        </div>
    </div>
</nav>

<script>
    // BOTAO DO PERFIL ESSENCIAIS ///////////////////////////////////////////////////////////
    const btnPerfil = document.getElementById('btnPerfil');
    const cardPerfil = document.getElementById('cardPerfil');

    // Alterna o card ao clicar no botão
    btnPerfil.addEventListener('click', () => {
        cardPerfil.classList.toggle('hidden');
    });

    // Fecha ao clicar fora
    document.addEventListener('click', (e) => {
        if (!btnPerfil.contains(e.target) && !cardPerfil.contains(e.target)) {
            cardPerfil.classList.add('hidden');
        }
    });
    // /////////////////////////////////////////////////////////////////////////////////////
</script>