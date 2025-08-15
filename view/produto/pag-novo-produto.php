<?php
session_start();

if (empty($_SESSION['id'])) {
  header("Location: ../pag-inicial.php");
  exit;
}

$formData = $_SESSION['formData'] ?? [];


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Novo produto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css"> <script>
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
      user-select: none;
    }


    .toggle-button.active {
      background-color: #164564;
      color: white;
    }


    .toggle-button:hover {
      background-color: #164564;
      color: white;
      border-color: #164564;
    }
  </style>
</head>

<body>

  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm py-4">
      <div class="container mx-auto px-4 md:px-6 flex justify-between items-center">
        <a href="../pag-inicial.php" class="text-primary font-bold text-3xl">LOUER</a>
        <div class="hidden md:flex space-x-6">
          <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
          <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
          <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div>
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
                <a href="#" class="block px-5 py-1 mt-2 hover:bg-gray-100 ">Informações da Conta</a>
                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Meus Aluguéis</a>
                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Favoritos</a>
                <a href="#" class="block px-5 py-1 hover:bg-gray-100">Notificacões</a>
                <a href="../../control/ClienteController.php?acao=sair" class="block px-5 py-1 hover:bg-gray-100 text-red-600 ">Sair</a>
                <div class="border-t border-gray-200 my-2 mx-2"></div> <!-- Divisor sem hover -->
                <?php if ($tipo == 'Fornecedor'): ?>
                  <a href="../fornecedor/pag-inicial-fornecedor.php" class="block px-5 py-1 mb-2  hover:bg-gray-100 ">Página do Fornecedor</a>
                <?php else: ?>
                  <a href="../fornecedor/pag-cad-fornecedor.php" class="block px-5 py-1 mb-2 hover:bg-gray-100">Quero ser um fornecedor!</a>
                <?php endif; ?>
              </div>
            </div>
          <?php else: ?>
            <a href="../cliente/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>

    <!-- notificacao de erro -->
    <?php if (isset($_GET['msgErro'])): ?>
      <div id="notificacao" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
        <div class="bg-white border border-orange-300 text-orange-600 rounded-lg p-4 shadow-lg flex items-start max-w-md w-full">
          <svg class="w-6 h-6 text-orange-600 mt-1 mr-2" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 14a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm1-8h-2v6h2V8z" />
          </svg>
          <div>
            <p class="font-medium text-sm">Erro</p>
            <p class="text-sm text-gray-600"><?= ($_GET['msgErro']) ?></p>
            <!-- htmlspecialchars tirei pq o <br> estava sendo escrito -->
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
            setTimeout(() => notif.remove(), 800);
          }
        }, 4000);
      </script>
    <?php endif; ?>


    <!-- ////////////////////////////////////////////////////////////////////////////// -->
    <!-- FORMULARIO -->
    <div class="flex justify-center items-center py-16">
      <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-4xl">
        <h1 class="text-2xl md:text-3xl font-bold text-primary mb-6">O que deseja anunciar?</h1>

        <form action="../../control/ProdutoController.php" method="post" class="space-y-6">
          <input type="hidden" name="acao" value="cadastrar">

          <div>
            <div class="flex justify-center max-w-xs mx-auto rounded-lg border border-gray-300 divide-x divide-gray-300 overflow-hidden">
              <label class="flex-1 cursor-pointer flex justify-center items-center relative py-3">
                <input type="radio" name="tipoProduto" value="Equipamento" class="hidden peer" />
                <div class="absolute inset-0 peer-checked:bg-gray-300 peer-checked:text-white transition-colors rounded-l-lg"></div>
                <span class="relative z-10 font-semibold text-lg">Equipamento</span>
              </label>
              <label class="flex-1 cursor-pointer flex justify-center items-center relative py-3">
                <input type="radio" name="tipoProduto" value="Espaco" class="hidden peer" />
                <div class="absolute inset-0 peer-checked:bg-gray-300 peer-checked:text-white transition-colors rounded-r-lg"></div>
                <span class="relative z-10 font-semibold text-lg">Espaço</span>
              </label>
            </div>
            <label for="nomeProduto" class="block text-sm font-medium text-gray-700 mb-1">Nome do produto</label>
            <input type="text" id="nomeProduto" name="nomeProduto" placeholder="Digite o nome do seu produto" value="<?= htmlspecialchars($formData['nomeProduto'] ?? '') ?>"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
            <br><br>
            <label for="valorProduto" class="block text-sm font-medium text-gray-700 mb-1">Valor do produto</label>
            <input type="number" id="valorProduto" name="valorProduto" placeholder="R$00.00" step="0.01" min="0" value="<?= htmlspecialchars($formData['valorProduto'] ?? '') ?>"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
            <br><br>
            <label for="descricaoProduto" class="block text-sm font-medium text-gray-700 mb-1">Descrição do produto</label>
            <textarea id="descricaoProduto" name="descricaoProduto" placeholder="Um produto incrível.." rows="5" cols="30"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary"><?= htmlspecialchars($formData['descricaoProduto'] ?? '') ?></textarea>
          </div>
          <!-- combombox -->
          <div>
            <label for="arrayTags[]" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
            <select name="arrayTags[]" id="arrayTags" multiple size="6"
              class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary">
              <option value="" disabled selected>Selecione uma categoria</option>
              <?php
              require_once "../../model/TagsDao.php";
              $arrayTags = listarTags($conexao); // chama a função do model
              foreach ($arrayTags as $idTag => $nomeTag) {
                echo "<option value='$idTag'>$nomeTag</option>";
              }
              ?>
            </select>
            <!-- DIAS DISPONIVEIS -->
          </div>
          <label class="block mb-2 font-medium text-gray-700">Selecione os dias disponíveis:</label>
          <div class="flex gap-2 flex-wrap">

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Dom" class="hidden" />
              Dom
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Seg" class="hidden" />
              Seg
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Ter" class="hidden" />
              Ter
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Qua" class="hidden" />
              Qua
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Qui" class="hidden" />
              Qui
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Sex" class="hidden" />
              Sex
            </label>

            <label class="cursor-pointer select-none px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-primary hover:text-white transition toggle-button">
              <input type="checkbox" name="diasDisponiveis[]" value="Sab" class="hidden" />
              Sab
            </label>

          </div>
          <div class="flex justify-between mt-6">
            <!-- Botão Cancelar -->
            <button type="button" id="btnCancelar" class="px-4 py-2 rounded-md text-gray-700 hover:underline onclick=" history.back()"">
              Cancelar
            </button>

            <!-- Botão Confirmar -->
            <button id="btnConfirmar" type="submit" disabled
              class="px-4 py-2 rounded-md bg-gray-300 text-gray-500 cursor-not-allowed transition">
              Confirmar
            </button>
          </div>
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
<script>
  document.querySelectorAll('.toggle-button').forEach(label => {
    const checkbox = label.querySelector('input[type="checkbox"]');

    // Atualiza o estilo da label conforme o estado inicial do checkbox
    if (checkbox.checked) {
      label.classList.add('bg-primary', 'text-white', 'border-primary');
    }

    label.addEventListener('click', () => {
      // Depois do clique, verifica o estado real do checkbox e aplica/remova as classes
      setTimeout(() => {
        if (checkbox.checked) {
          label.classList.add('bg-primary', 'text-white', 'border-primary');
        } else {
          label.classList.remove('bg-primary', 'text-white', 'border-primary');
        }
      }, 0); // timeout para esperar o checkbox ser marcado/desmarcado pelo navegador
    });
  });
  const radios = document.querySelectorAll('input[name="tipoProduto"]');
  const btnConfirmar = document.getElementById('btnConfirmar');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      btnConfirmar.disabled = false;
      btnConfirmar.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
      btnConfirmar.classList.add('bg-primary', 'text-white');
    });
  });
  document.getElementById('btnCancelar').addEventListener('click', () => {
    window.location.href = "../../control/ProdutoController.php?acao=cancelarCadastro";
  });

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

</html>