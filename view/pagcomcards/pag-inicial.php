<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
  <link rel="stylesheet" href="styles.css?">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://kit.fontawesome.com/414a446042.js" crossorigin="anonymous"></script>
  <script src="script.js" defer></script>

  <title>Louer - Pagina Inicial</title>
</head>

<body>
  <nav class="navbar" role="navigation" aria-label="main navigation">

    <!-- LOGO-->
    <div class="navbar-brand"> <!-- lado esquerdo -->
      <a href="pag-inicial.php">
        <img class="logo" src="../../a-imagens/louer-logo.png" alt="Logo">
      </a>
    </div>

    <div class="navbar-meio">
      <div class="barra-pesquisa">
        <div class="categorias-dropdown">
          <!-- botão -->
          <div class="categorias-dropdown-trigger">
            <button class="categorias-dropdown-button">O que?</button>
          </div>
          <!-- Conteteúdo -->
          <div class="categorias-dropdown-conteudo">

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
        <div class="perfil-dropdown">
          <div class="perfil-dropdown-trigger">
            <button class="perfil-dropdown-button" aria-haspopup="true" aria-controls="perfil-dropdown-conteudo">
              <span class="icon">
                <i class="fa-solid fa-bars"></i>
              </span>
              <figure class="image is-32x32">
                <!-- imagem dinamica -->
                <img class="img-perfil" src="https://bulma.io/assets/images/placeholders/128x128.png" /> <!-- PEGAR IMAGEM INSERIDA NO FORMULARIO DO CADASTRO, MAX 128x128 -->
              </figure>
            </button>
          </div>

          <div class="perfil-dropdown-conteudo" id="perfil-dropdown-conteudo" role="menu">
            <div class="dropdown-content">
              <a href="#" class="dropdown-item">
                Cadastrar-se
              </a>
              <a href="#" class="dropdown-item">
                Entrar
              </a>
              <!-- <hr class="divisor-horizontal">
              <a href="#" class="dropdown-item">
                Sair
              </a> -->
            </div>
          </div>
        </div>
      </div>

    </div>
  </nav>




  <div class="containercoluna">
    
  <div class="coluna">
    <div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img
        src="https://bulma.io/assets/images/placeholders/1280x960.png"
        alt="Placeholder image"
      />
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img
            src="https://bulma.io/assets/images/placeholders/96x96.png"
            alt="Placeholder image"
          />
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
      iaculis mauris. <a>@bulmaio</a>. <a href="#">#css</a>
      <a href="#">#responsive</a>
      <br />
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div>
    </div>
    <div class="coluna">
    <div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img
        src="https://bulma.io/assets/images/placeholders/1280x960.png"
        alt="Placeholder image"
      />
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img
            src="https://bulma.io/assets/images/placeholders/96x96.png"
            alt="Placeholder image"
          />
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
      iaculis mauris. <a>@bulmaio</a>. <a href="#">#css</a>
      <a href="#">#responsive</a>
      <br />
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div>
    </div>
    <div class="coluna">
    <div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img
        src="https://bulma.io/assets/images/placeholders/1280x960.png"
        alt="Placeholder image"
      />
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img
            src="https://bulma.io/assets/images/placeholders/96x96.png"
            alt="Placeholder image"
          />
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
      iaculis mauris. <a>@bulmaio</a>. <a href="#">#css</a>
      <a href="#">#responsive</a>
      <br />
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div>
    </div>
    <div class="coluna">
    <div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img
        src="https://bulma.io/assets/images/placeholders/1280x960.png"
        alt="Placeholder image"
      />
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img
            src="https://bulma.io/assets/images/placeholders/96x96.png"
            alt="Placeholder image"
          />
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
      iaculis mauris. <a>@bulmaio</a>. <a href="#">#css</a>
      <a href="#">#responsive</a>
      <br />
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div>
    </div>
    <div class="coluna">
    <div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img
        src="https://bulma.io/assets/images/placeholders/1280x960.png"
        alt="Placeholder image"
      />
    </figure>
  </div>
  <div class="card-content">
    <div class="media">
      <div class="media-left">
        <figure class="image is-48x48">
          <img
            src="https://bulma.io/assets/images/placeholders/96x96.png"
            alt="Placeholder image"
          />
        </figure>
      </div>
      <div class="media-content">
        <p class="title is-4">John Smith</p>
        <p class="subtitle is-6">@johnsmith</p>
      </div>
    </div>

    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec
      iaculis mauris. <a>@bulmaio</a>. <a href="#">#css</a>
      <a href="#">#responsive</a>
      <br />
      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
    </div>
  </div>
</div>
    </div>

  </div>
</body>

</html>