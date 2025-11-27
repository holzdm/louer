<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Alterar Meus Dados</h1>
<br>
<form action="../../control/ClienteController.php" method="post">
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
            <br><br>
            <a href="/louer/control/ClienteController.php?acao=excluir"
                class="bg-red-800 block text-center mt-2 w-full py-3 px-4 rounded-lg text-white font-medium transition-all duration-300 ease hover:bg-red-900">
                Excluir Conta
            </a>
        </div>
    </div>
</form>
</main>