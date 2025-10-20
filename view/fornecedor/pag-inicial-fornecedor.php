<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
  header("Location: ../pag-inicial.php");
  exit;
}

// Limpa a sessão se tiver alguma sessao de novo produto
if (isset($_SESSION['novoProduto'])) {
  unset($_SESSION['novoProduto']);
}
$pagina = $_GET['pagina'] ?? 'meus-dados';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOUER | Aluguel Facilitado </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
    <?php $fonte = 'pag-inicial-fornecedor';
    include '../navbar.php'; ?>


    <!-- notificacao -->
    <?php include '../notificacao.php';
    include '../notificacao-erro.php'; ?>

    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Conteúdo -->

    <!-- Div pai que controla altura e espaçamento -->
    <div class="min-h-screen flex justify-center items-start py-5 px-2">

      <!-- Container branco (dashboard) -->
      <div class="flex w-full max-w-6xl bg-white rounded-2xl shadow-lg overflow-hidden h-[calc(100vh-4rem)]">

        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow rounded-lg p-4">
          <ul class="space-y-2">
            <li>
              <a href="?pagina=meus-dados"
                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'meus-dados') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                Meus dados
              </a>
            </li>
            <li>
              <a href="?pagina=meus-produtos"
                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'meus-produtos') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                Meus produtos
              </a>
            </li>
            <li>
              <a href="?pagina=minhas-reservas"
                class="block px-4 py-2 rounded
               <?php echo ($pagina === 'minhas-reservas') ? 'bg-gray-100 text-primary font-semibold' : 'hover:bg-gray-100 text-gray-700'; ?>">
                Reservas
              </a>
            </li>
          </ul>
        </aside>

        <!-- Conteúdo -->
        <main class="flex-1 bg-white shadow rounded-lg p-6 ml-2 overflow-y-auto">
          <?php
          if ($pagina === 'meus-dados') {
            include 'meus-dados.php';
          } elseif ($pagina === 'meus-produtos') {

            include 'meus-produtos.php';
          } elseif ($pagina === 'minhas-reservas') {
            include 'minhas-reservas.php';
          } else {
            echo "<p>Escolha uma opção no menu.</p>";
          }
          ?>
        </main>

      </div>
    </div>


    <a href="/louer/view/produto/pag-novo-produto.php"
      class="fixed bottom-6 right-6 bg-primary hover:bg-secondary hover:text-primary text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg text-3xl">
      +
    </a>

    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Footer -->
    <?php include '../footer.php'; ?>


</body>

</html>