<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Novo produto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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

  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4">
      <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
        <a href="../../view/cliente/pag-inicial-cliente.php" class="text-primary font-bold text-3xl">LOUER</a>
        <div class="hidden md:flex space-x-6">
          <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
          <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
          <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div>
        <div class="flex items-center space-x-4">
          <a href="../../view/tela-provisoria-perfil.php" class="text-gray-600 hover:text-primary">Perfil</a>
        </div>
      </div>
    </nav>

    <!-- notificacao de erro -->
    <?php if (isset($_GET['msg'])): ?>
  <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
    <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
      <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z"/>
      </svg>
      <div>
        <p class="font-medium text-sm">Erro</p>
        <p class="text-sm text-gray-600"><?= htmlspecialchars($_GET['msg']) ?></p>
      </div>
    </div>
  </div>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translate(-50%, -10px); }
      to { opacity: 1; transform: translate(-50%, 0); }
    }
    @keyframes fadeOut {
      from { opacity: 1; transform: translate(-50%, 0); }
      to { opacity: 0; transform: translate(-50%, -10px); }
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


    <!-- ////////////////////////////////////////////////////////////////////////////// -->
     <!-- FORMULARIO -->
    <div class="flex justify-center items-center py-16">
    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">
      <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">O que deseja anunciar primeiro?</h1>

      <form action="../../control/ProdutoController.php?acao='cadastrar'" method="post" class="space-y-6">
        <div>
          <label for="nomeProduto" class="block text-sm font-medium text-gray-700 mb-1">Nome do produto</label>
          <input type="text" id="nomeProduto" name="nomeProduto" placeholder="Digite o nome do seu produto" required
            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        <!-- combombox -->
        <div>
          <label for="arrayTags[]" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
          <select name="arrayTags[]" id="arrayTags" multiple size="6"
            class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
            <option value="" disabled selected>Selecione uma categoria</option>
            <?php
            require_once "../../model/TagsDao.php";
            $arrayTags = listarTags($conexao); // chama a função do model
            foreach ($arrayTags as $idTag => $nomeTag) {
              echo "<option value='$idTag'>$nomeTag</option>";
            }
            ?>
          </select>
        </div>

        <button type="submit"
          class="bg-primary text-white w-full py-3 rounded-md font-medium hover:bg-[#0d3854] transition">
          Confirmar
        </button>
        <p class="mt-6 text-center text-gray-600">
            <a href="../../view/fornecedor/pag-inicial-fornecedor0.php" class="text-primary font-medium hover:underline">Cancelar</a>
          </p>
      </form>
    </div>
  </div>
<!-- //////////////////////////////////////////////////////////////////////// -->

    <!-- Footer -->
    <footer class="bg-white py-6 border-t border-gray-200 mt-auto">
      <div class="container mx-auto px-4 md:px-6">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <a href="#" class="text-primary font-bold text-2xl">LOUER</a>
            <p class="mt-1 text-gray-600 text-sm">Alugue espaços e itens de forma simples.</p>
          </div>
          <p class="text-gray-500 text-sm">© 2023 LOUER. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  </div>

</body>
</html>
