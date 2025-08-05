<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Aluguel Facilitado </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link rel="stylesheet" href="styles.css?">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://kit.fontawesome.com/414a446042.js" crossorigin="anonymous"></script>
  <script src="script.js" defer></script>
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
          <a href="#" class="text-gray-600 hover:text-primary">Espaços</a>
          <a href="#" class="text-gray-600 hover:text-primary">Itens</a>
          <a href="#" class="text-gray-600 hover:text-primary">Ajuda</a>
        </div>
        <div class="flex items-center space-x-4">
          <a href="../view-bonitinha/pagCadastroLogin/login-cliente.php" class="text-gray-600 hover:text-primary">Entrar</a>
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
        <p class="font-medium text-sm">Erro no cadastro</p>
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


<!-- //////////////////////////////////////////////////////////////////////// -->

<div class="mx-[10%] mt-[5%]">
  <div class="columns is-multiline">

    <?php
    function conectarBD() {
        $conexao = mysqli_connect('127.0.0.1','root','','louerbd');
        if (!$conexao) {
            die("Falha na conexão: " . mysqli_connect_error());
        }
        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, "SET character_set_connection=utf8");
        mysqli_query($conexao, "SET character_set_client=utf8");
        mysqli_query($conexao, "SET character_set_results=utf8");
        return $conexao;
    }

    $conexao = conectarBD(); 
    $sql = "SELECT * FROM produto WHERE ativo = 1";
    $res = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    while ($registro = mysqli_fetch_assoc($res)) {
        $nome = $registro["nome"];
        $descricao = $registro["descricao"];
        $valor_hora = $registro["valor_hora"];

        echo "
        <div class='column is-one-quarter'>
            <div class='card'>
                <div class='card-image'>
                    <figure class='image is-4by3'>
                        <img src='https://bulma.io/assets/images/placeholders/1280x960.png' alt='Imagem do produto' />
                    </figure>
                </div>
                <div class='card-content'>
                    <div class='media'>
                        <div class='media-left'>
                            <figure class='image is-48x48'>
                                <img src='https://bulma.io/assets/images/placeholders/96x96.png' alt='Avatar do fornecedor' />
                            </figure>
                        </div>
                        <div class='media-content'>
                            <p class='title is-5'>$nome</p>
                            <p class='subtitle is-6'>R$$valor_hora/h</p>
                        </div>
                    </div>
                    <div class='content'>
                        $descricao
                    </div>
                </div>
            </div>
        </div>
        ";
    }
    ?>

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
