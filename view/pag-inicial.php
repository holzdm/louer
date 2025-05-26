<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link rel="stylesheet" href="styles.css?v=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://kit.fontawesome.com/414a446042.js" crossorigin="anonymous"></script>
  <title>Louer - Pagina Inicial</title>
</head>

<body>
  <nav class="navbar" role="navigation" aria-label="main navigation">

    <!-- LOGO-->
    <div class="navbar-brand"> <!-- lado esquerdo -->
      <a href="pag-inicial.php">
        <img class="logo" src="../a-imagens/louer-logo.png" alt="Logo">
      </a>
    </div>

    <div class="navbar-meio">
      <div class="barra-pesquisa">
        <div class="categorias-dropdown" id="dropdown-categorias">
          <div class="categorias-dropdown-trigger">
            <button class="categorias-button">O que?</button>
          </div>
        </div>
        
        <hr class="divisor-vertical">
        <div class="localizacao">
          Tem na minha cidade?
          <div class="circulo-pesquisar"><i class="fa-solid fa-magnifying-glass"></i></div>
        </div>
      </div>
    </div>

    <div class="navbar-direita">
      <div class="navbar-item">
        <div class="dropdown is-right" id="dropdown-perfil">
          <div class="dropdown-trigger">
            <button class="button perfil-button" aria-haspopup="true" aria-controls="dropdown-menu">
              <span class="icon is-small">
                <i class="fa-solid fa-bars"></i>
              </span>
              <figure class="image is-32x32">
                <!-- imagem dinamica -->
                <img class="img-perfil" src="https://bulma.io/assets/images/placeholders/128x128.png" /> <!-- PEGAR IMAGEM INSERIDA NO FORMULARIO DO CADASTRO, MAX 128x128 -->
              </figure>
            </button>
          </div>

          <div class="dropdown-menu" id="dropdown-menu" role="menu">
            <div class="dropdown-content">
              <a href="#" class="dropdown-item">
                Meu Perfil
              </a>
              <a href="#" class="dropdown-item">
                Configurações
              </a>
              <hr class="dropdown-divider">
              <a href="#" class="dropdown-item">
                Sair
              </a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </nav>

  <script>
    const dropdownPerfil = document.getElementById('dropdown-perfil');
    const dropdownTrigger = dropdownPerfil.querySelector('.dropdown-trigger');
    const perfilButton = document.querySelector('.perfil-button');

    const dropdownCategorias = document.getElementById('dropdown-categorias')

    dropdownTrigger.addEventListener('click', function(event) {
      event.stopPropagation(); // Impede que o clique suba para o document
      if (dropdownPerfil.classList.contains('is-active')) {
        dropdownPerfil.classList.remove('is-active');
        perfilButton.blur();
      } else {
        dropdownPerfil.classList.add('is-active');
        perfilButton.focus();
      }
    });

    // Fechar se clicar fora
    document.addEventListener('click', function(event) {
      if (!dropdownPerfil.contains(event.target)) {
        dropdownPerfil.classList.remove('is-active');
        perfilButton.blur();
      }
    });



  </script>
</body>

</html>