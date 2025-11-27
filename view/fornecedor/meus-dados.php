<h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Alterar Meus Dados</h1>
<br>
<form action="../../control/CadFornecedor.php" method="post">
    <input type="hidden" name="acao" value="alterar">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_SESSION['id']) ?>">
    <div class="space-y-5">
        <div>
            <label for="cep" class="block text-sm font-medium text-gray-700 mb-1">Cep</label>
            <input type="text" id="cep" name="cep" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['cep']) ?>" required />
        </div>

        <div>
            <label for="bairro" class="block text-sm font-medium text-gray-700 mb-1">Bairro</label>
            <input type="text" id="bairro" name="bairro" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['bairro']) ?>" required />
        </div>

        <div>
            <label for="rua" class="block text-sm font-medium text-gray-700 mb-1">Rua</label>
            <input type="text" id="rua" name="rua" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['rua']) ?>" required />
        </div>

        <div>
            <label for="nEnd" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
            <input type="text" id="nEnd" name="nEnd" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['nEnd']) ?>" required />
        </div>

        <div>
            <label for="complemento" class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
            <input type="text" id="complemento" name="complemento" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" value="<?= htmlspecialchars($_SESSION['complemento']) ?>" />
        </div>


        <div class="flex items-start">
            <input type="hidden" id="terms" name="terms" class="mt-1 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required />
        </div>

        <div >
            <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                Alterar Dados
            </button>
            <br><br>
            <a href="/louer/control/CadFornecedor.php?acao=excluir"
                class="bg-red-800 block text-center mt-2 w-full py-3 px-4 rounded-lg text-white font-medium transition-all duration-300 ease hover:bg-red-900">
                Deixar de ser um fornecedor
            </a>

        </div>
    </div>
</form>
</main>