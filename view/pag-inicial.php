<?php
session_start(); // necessário para acessar $_SESSION


// Limpa a sessão se tiver alguma sessao de produto
if (isset($_SESSION['Produto'])) {
  unset($_SESSION['Produto']);
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
  <!-- <link rel="stylesheet" href="styles.css?"> -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
  <!-- <script src="https://kit.fontawesome.com/414a446042.js" crossorigin="anonymous"></script> -->
  <!-- <script src="script.js" defer></script> -->
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
    <?php $fonte = 'pag-inicial';
    include 'navbar.php';
    include "notificacao.php"; include "notificacao-erro.php"; ?>


    <!-- //////////////////////////////////////////////////////////////////////// -->

    <div class="mx-[3%] my-[2%]">
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        <?php
        require_once "../model/ProdutoDao.php";
        require_once "../control/FuncoesUteis.php";

        $res = listarProdutos();

        while ($registro = mysqli_fetch_assoc($res)) {
          $idProduto = $registro["id"];
          $nome = $registro["nome"];
          $valorDia = $registro["valor_dia"];

          $srcImg = "/louer/a-imagem/image.php?idProduto=" . $idProduto;


          // $jaFavorito = verificarFavorito($_SESSION['id'], $idProduto);

          echo "
      <div >
        <div class='bg-white rounded-lg overflow-hidden h-60 flex flex-col shadow hover:shadow-lg hover:scale-105 transition transform duration-300'>
            <a href='../control/ProdutoController.php?acao=acessar&id=$idProduto'>
                <img src='$srcImg' class='w-full h-40 object-cover' alt='Imagem do produto'>
                <div class='p-2'>
                    <h3 class='text-sm text-gray-800 font-medium truncate'>$nome</h3>
                    <p class='text-gray-600'>R$$valorDia/dia</p>
                </div>
            </a> 
        </div>
    </div>
    ";
        }
        ?>
      </div>
    </div>


    <!-- //////////////////////////////////////////////////////////////////////// -->


    <!-- Footer -->
    <?php include 'footer.php'; ?>

  </div>


  
</body>

</html>


<!-- favoritos pra depois:
            <form action='../control/FavoritoController.php' method='POST' class='absolute top-2 right-2'>
                <input type='hidden' name='idProduto' value='$idProduto'>
                <button type='submit' class='focus:outline-none'>
                    " . ($jaFavorito ? "
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-red-500 transition-colors' fill='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/>
                        </svg>
                    " : "
                        <svg xmlns='http://www.w3.org/2000/svg' class='h-6 w-6 text-gray-400 hover:text-red-500 transition-colors' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z' />
                        </svg>
                    ") . "
                </button>
            </form> -->