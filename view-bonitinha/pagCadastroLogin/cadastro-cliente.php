<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Cadastre-se</title>
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
        <a href="#" class="text-primary font-bold text-3xl">LOUER</a>
        <div class="hidden md:flex space-x-6">
          <a href="#" class="text-gray-600 hover:text-primary">Início</a>
          <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
          <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
          <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div>
        <div class="flex items-center space-x-4">
          <a href="login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
        </div>
      </div>
    </nav>

    <!-- Formulário -->
    <div class="flex-grow container mx-auto px-4 py-10 md:py-16 flex justify-center">
      <div class="w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
          <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Crie sua conta</h1>
          <p class="text-gray-600 mb-8">Junte-se ao LOUER e comece a alugar ou disponibilizar espaços e itens.</p>

          <!-- Mensagem de erro -->
          <?php if (isset($_GET['msg'])): ?>
            <p class="text-red-600 text-sm mb-4"><?= htmlspecialchars($_GET['msg']) ?></p>
          <?php endif; ?>

          <form action="../../control/CadCliente.php" method="post" onsubmit="return enviarDocumento()">
            <div class="space-y-5">
              <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                <input type="text" id="nome" name="nome" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Seu nome completo" required />
              </div>

              <!-- CPF ou CNPJ -->
              <div>
                <div class="flex justify-between items-center mb-1">
                  <label class="block text-sm font-medium text-gray-700">Documento</label>
                  <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                    <button type="button" id="cpfToggle" class="toggle-button px-3 py-1 text-sm active">CPF</button>
                    <button type="button" id="cnpjToggle" class="toggle-button px-3 py-1 text-sm">CNPJ</button>
                  </div>
                </div>
                <input type="text" id="documentInput" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="000.000.000-00" data-type="cpf" required />

                <!-- Campos ocultos para envio -->
                <input type="hidden" id="cpf" name="cpf" />
                <input type="hidden" id="cnpj" name="cnpj" />
              </div>

              <div>
                <label for="cidade" class="block text-sm font-medium text-gray-700 mb-1">Cidade</label>
                <input type="text" id="cidade" name="cidade" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Sua cidade" required />
              </div>

              <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                <input type="tel" id="telefone" name="telefone" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="(00) 00000-0000" required />
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="seu@email.com" required />
              </div>

              <div>
                <label for="senha" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input type="password" id="senha" name="senha" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Crie uma senha" required />
                <p class="mt-1 text-xs text-gray-500">Mínimo de 6 caracteres com letras ou números</p>
              </div>

              <div class="flex items-start">
                <input type="checkbox" id="terms" name="terms" class="mt-1 h-4 w-4 text-primary border-gray-300 rounded focus:ring-primary" required />
                <label for="terms" class="ml-2 block text-sm text-gray-600">
                  Concordo com os <a href="#" class="text-primary hover:underline">Termos de Serviço</a> e <a href="#" class="text-primary hover:underline">Política de Privacidade</a> do LOUER
                </label>
              </div>

              <div>
                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                  Criar conta
                </button>
              </div>
            </div>
          </form>

          <p class="mt-6 text-center text-gray-600">
            Já tem uma conta? <a href="login-cliente.php" class="text-primary font-medium hover:underline">Entrar</a>
          </p>
        </div>
      </div>
    </div>

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

  <!-- Scripts -->
  <script>
    const cpfToggle = document.getElementById('cpfToggle');
    const cnpjToggle = document.getElementById('cnpjToggle');
    const documentInput = document.getElementById('documentInput');

    cpfToggle.addEventListener('click', () => {
      cpfToggle.classList.add('active');
      cnpjToggle.classList.remove('active');
      documentInput.placeholder = '000.000.000-00';
      documentInput.setAttribute('data-type', 'cpf');
    });

    cnpjToggle.addEventListener('click', () => {
      cnpjToggle.classList.add('active');
      cpfToggle.classList.remove('active');
      documentInput.placeholder = '00.000.000/0000-00';
      documentInput.setAttribute('data-type', 'cnpj');
    });

    function enviarDocumento() {
      const tipo = documentInput.getAttribute('data-type');
      const valor = documentInput.value;
      if (tipo === 'cpf') {
        document.getElementById('cpf').value = valor;
        document.getElementById('cnpj').value = '';
      } else {
        document.getElementById('cnpj').value = valor;
        document.getElementById('cpf').value = '';
      }
      return true; // permite o envio do formulário
    }
  </script>
</body>
</html>
