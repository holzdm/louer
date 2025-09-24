<?php
session_start(); // necessário para acessar $_SESSION

// Verifica se a pessoa está logada
if (!isset($_SESSION['id'])) {
  header("Location: ../pag-inicial.php");
  exit;
}

// Limpa a sessão se tiver alguma sessao de novo produto
if (isset($_SESSION['formData'])) {
  unset($_SESSION['formData']);
}

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

  <div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <?php $fonte = 'pag-inicial-fornecedor'; include '../navbar.php'; ?>



      <!-- Notificacao de sucesso do cadastro -->
<style>
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translate(-50%, -10px); /* mantém -50% no X (centralizado) */
    }
    to {
      opacity: 1;
      transform: translate(-50%, 0); /* continua centralizado */
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
    animation: fadeIn 0.5s ease-out forwards;
  }
  .fade-out {
    animation: fadeOut 0.4s ease-in forwards;
  }
</style>

<?php if (isset($_GET["msg"])): ?>
  <div id="notificacao"
       class="fixed top-5 left-1/2 z-50 fade-in"
       style="transform: translate(-50%, 0);">
    <div class="bg-white rounded-lg border border-blue-300 p-4 shadow-lg flex items-start max-w-md w-full">
      <svg width="24" height="24" viewBox="0 0 1792 1792" fill="#3B82F6" xmlns="http://www.w3.org/2000/svg" class="mt-1">
        <path d="M1299 813l-422 422q-19 19-45 19t-45-19l-294-294q-19-19-19-45t19-45l102-102q19-19 45-19t45 19l147 147 275-275q19-19 45-19t45 19l102 102q19 19 19 45t-19 45zm141 83q0-148-73-273t-198-198-273-73-273 73-198 198-73 273 73 273 198 198 273 73 273-73 198-198 73-273zm224 0q0 209-103 385.5t-279.5 279.5-385.5 103-385.5-103-279.5-279.5-103-385.5 103-385.5 279.5-279.5 385.5-103 385.5 103 279.5 279.5 103 385.5z"/>
      </svg>
      <div class="ml-3">
        <p class="font-semibold text-sm text-blue-600">Tudo pronto!</p>
        <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($_GET["msg"]); ?></p>
      </div>
    </div>
  </div>

  <script>
    setTimeout(() => {
      const notif = document.getElementById('notificacao');
      if (notif) {
        notif.classList.remove('fade-in');
        notif.classList.add('fade-out');
        setTimeout(() => notif.remove(), 500);
      }
    }, 5000);
  </script>
<?php endif; ?>



  <div class="min-h-screen flex flex-col">


<!-- Notificacao de erro do login -->
 <?php if (isset($_GET['msgErro'])): ?>
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translate(-50%, -10px); }
      to { opacity: 1; transform: translate(-50%, 0); }
    }
    @keyframes fadeOut {
      from { opacity: 1; transform: translate(-50%, 0); }
      to { opacity: 0; transform: translate(-50%, -10px); }
    }
    .fade-in { animation: fadeIn 0.5s ease-out forwards; }
    .fade-out { animation: fadeOut 0.4s ease-in forwards; }
  </style>

  <div id="erroLogin" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 fade-in">
    <div class="notification-box shadow-lg rounded-lg bg-white mx-auto p-4 flex border border-orange-400">
      <div class="pr-2">
        <svg class="fill-current text-orange-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
          <path class="heroicon-ui" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 2a8 8 0 1 0 0 16 8 8 0 0 0 0-16zm0 9a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0v4a1 1 0 0 1-1 1zm0 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </svg>
      </div>
      <div>
        <div class="text-sm pb-2 font-semibold text-orange-600">
          Erro. 
        </div>
        <div class="text-sm text-gray-600 tracking-tight">
          <?php echo htmlspecialchars($_GET['msgErro']); ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    setTimeout(() => {
      const notif = document.getElementById('erroLogin');
      if (notif) {
        notif.classList.remove('fade-in');
        notif.classList.add('fade-out');
        setTimeout(() => notif.remove(), 500);
      }
    }, 5000);
  </script>

  <style>
    .notification-box {
      width: 20rem;
    }
  </style>
<?php endif; ?>

    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Conteúdo -->
    <div class="py-5 px-3">

      <h3>Crie seu produto <a href="../produto/pag-novo-produto.php">AQUI!</a></h3>

    </div>

    <div class="mx-[10%] mt-[5%]">
    <div class="columns is-multiline pb-5">

      <?php 

      require_once "../../model/ProdutoDao.php";
      
      $res = listarMeusProdutos();

      while ($registro = mysqli_fetch_assoc($res)) {
        $idProduto = $registro["id"];
        $nome = $registro["nome"];
        $descricao = $registro["descricao"];
        $valorDia = $registro["valor_dia"];

        echo "
        <div class='column is-one-quarter'>
            <div class='card'><a href='../../control/ProdutoController.php?acao=alterar&id=$idProduto'>
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
                            <p class='subtitle is-6'>R$$valorDia/dia</p>
                        </div>
                    </div>
                    <div class='content'>
                        $descricao
                    </div>
                </div>
            </a></div>
        </div>
        ";
      }
       ?>

    </div>
  </div>



    <!-- //////////////////////////////////////////////////////////////////////// -->
    <!-- Footer -->
        <?php include '../footer.php'; ?>

  </div>

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
</body>

</html>