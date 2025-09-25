<nav class="bg-white shadow-sm py-4">
    <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
    <?php if ($fonte == 'pag-inicial'): ?>
        <a href="#" class="text-primary font-bold text-3xl">LOUER</a>
        <?php else:?>
            <a href="../pag-inicial.php" class="text-primary font-bold text-3xl">LOUER</a>
            <?php endif; ?>

        <!-- <div class="hidden md:flex space-x-6">
            <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
            <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
            <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div> -->
        <?php if ($fonte == 'pag-inicial'): ?>
            <div class="hidden md:flex space-x-6">

                <form action="../control/ProdutoController.php" method="POST" class="flex items-center space-x-2">
                    <input type="hidden" name="acao" value="pesquisar">

                    <label for="pesquisa" class="sr-only">Pesquisar</label>

                    <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar..." class="w-80 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-gray-300" />
                    <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded-full font-medium transition-colors">🔎</button>
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
                        <img src="https://via.placeholder.com/40" alt="Foto de perfil" class="w-5 h-5 rounded-full">
                        <span class="font-medium"><?php echo $_SESSION['nome']['0'] ?></span>
                    </button>
                    <div id="cardPerfil" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-[0_-1px_6px_-1px_rgba(0,0,0,0.10),0_1px_3px_rgba(0,0,0,0.06)] z-50 hidden">
                        <style>
                            #cardPerfil a {
                                margin: 0;
                            }
                        </style>
                        <?php if ($fonte == 'pag-inicial'): ?>
                            <a href="../control/ClienteController.php?acao=acessar" class="block px-5 py-1 mt-2 hover:bg-gray-100 ">Informações da Conta</a>
                        <?php else: ?>
                            <a href="../../control/ClienteController.php?acao=acessar" class="block px-5 py-1 mt-2 hover:bg-gray-100 ">Informações da Conta</a>
                        <?php endif; ?>

                        <a href="#" class="block px-5 py-1 hover:bg-gray-100">Notificacões</a>
                        <?php if ($fonte == 'pag-inicial'): ?>
                        <a href="../control/ClienteController.php?acao=sair" class="block px-5 py-1 hover:bg-gray-100 text-red-600 ">Sair</a>

                        <?php else: ?>
                        <a href="../../control/ClienteController.php?acao=sair" class="block px-5 py-1 hover:bg-gray-100 text-red-600 ">Sair</a>

                        <?php endif; ?>

                        <div class="border-t border-gray-200 my-2 mx-2"></div> <!-- Divisor sem hover -->
                        <?php if ($tipo == 'Fornecedor') {
                            if ($fonte == 'pag-fornecedor-inicial') {
                                echo "
                                <a href='#' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                            } elseif ($fonte == 'produto' || $fonte == 'cliente') {
                                echo "
                                <a href='../fornecedor/pag-inicial-fornecedor.php' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                            } else {
                                echo "
                                <a href='fornecedor/pag-inicial-fornecedor.php' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                            }
                        } else {
                            if ($fonte == 'produto' || $fonte == 'cliente') {
                                echo "
                                <a href='../fornecedor/pag-cad-fornecedor.php' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                            } else {
                                echo "
                                <a href='fornecedor/pag-cad-fornecedor.php' class='block px-5 py-1 mb-2  hover:bg-gray-100 '>Página do Fornecedor</a>";
                            }
                        } ?>
                    </div>
                </div>
            <?php else: ?>
                <?php if ($fonte == 'pag-inicial'): ?>
                <a href="cliente/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
                <?php else: ?>
                    <a href="../cliente/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
                    <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</nav>