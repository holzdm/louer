<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Louer - Pagina Inicial</title>
</head>
<body>
  <nav class="navbar" role="navigation" aria-label="main navigation">

    <!-- lado esquerdo -->
    <div class="navbar-brand">
      <a class="navbar-item" href="pag-inicial.php">
        <img src="../a-imagens/louer-logo.png" alt="Logo">
      </a>
    </div>

    <!-- MENU -->
    <div class="navbar-menu">
      <!-- MENU: lado esquerdo (ver como vou colocar a barra do meio) -->
      <div class="navbar-start">
      </div>

      <!-- MENU: lado direito (perfil) -->
       <div class="navbar-end">
          <div class="navbar-item">
            <div class="dropdown">
              <!-- botao do perfil -->
              <div class="dropdown-trigger">
                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                  <span>Perfil</span>
                  <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                  </span>
                </button>
              </div>

              <!-- conteudo dentro do dropdown do perfil -->
               <div class="dropdown-menu">

               </div>
            </div>
          </div>
      </div>
    </div>
  </nav>
  
</body>
</html>