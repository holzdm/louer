<!-- Só o esboço, ainda vou conectar ao BD e acertar as funções etc -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Entrar</title>
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
          <a href="#" class="text-gray-600 hover:text-primary">Cadastre-se</a>
        </div>
      </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="flex-grow container mx-auto px-4 py-10 md:py-16 flex justify-center">
      <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10">
          <h1 class="text-2xl md:text-3xl font-bold text-primary mb-3">Entrar</h1>
          <p class="text-gray-600 mb-8">Bem-vindo de volta! Acesse sua conta no LOUER.</p>

          <!-- Formulário de login -->
          <form id="loginForm">
            <div class="space-y-5">
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="seu@email.com" required />
              </div>

              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Senha</label>
                <input type="password" id="password" name="password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none" placeholder="Sua senha" required />
              </div>

              <div class="flex items-start justify-between">
                <div class="flex items-center">
                  <input type="checkbox" id="remember" class="h-4 w-4 text-primary border-gray-300 rounded" />
                  <label for="remember" class="ml-2 text-sm text-gray-600">Lembrar de mim</label>
                </div>
                <a href="#" class="text-sm text-primary hover:underline">Esqueceu a senha?</a>
              </div>

              <div>
                <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-medium">
                  Entrar
                </button>
              </div>
            </div>
          </form>

          <p class="mt-6 text-center text-gray-600">
            Ainda não tem uma conta? <a href="#" class="text-primary font-medium hover:underline">Cadastre-se</a>
          </p>
        </div>
      </div>
    </div>

    <!-- Rodapé -->
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

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;

      if (!email || !password) {
        alert('Por favor, preencha todos os campos.');
        return;
      }

      // Aqui você pode adicionar verificação com backend ou localStorage
      alert('Login realizado com sucesso! Bem-vindo de volta ao LOUER.');
      this.reset();
    });
  </script>
</body>
</html>
