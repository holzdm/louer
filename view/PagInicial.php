<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Louer | Aluguel Confiável</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
      body {
        font-family: 'Inter', sans-serif;
      }
    </style>
  </head>
  <body class="bg-[#eef8fa]">
    <!-- Topbar -->
    <header class="bg-[#16415f] text-white p-4 flex justify-between items-center">
      <div class="flex items-center gap-2">
        <img src="logo.png" alt="Logo Louer" class="h-12" />
        <a href="#" class="text-2xl font-semibold">Louer</a>
      </div>

      <!-- Barra de busca -->
      <div class="bg-[#eef8fa] flex items-center px-4 py-2 rounded-full w-[500px] text-black">
        <button class="font-semibold px-2 hover:underline">O quê?</button>
        <span class="mx-2 text-gray-400">|</span>
        <button class="font-semibold px-2 hover:underline">Tem na minha cidade?</button>
        <button class="ml-auto">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1011.25 18a7.5 7.5 0 005.4-2.25z" />
          </svg>
        </button>
      </div>

      <!-- Menu e perfil -->
      <div class="flex items-center gap-4">
        <button>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <button>
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-8 h-8">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"/>
          </svg>
        </button>
      </div>
    </header>

    <!-- Grade de produtos -->
    <main class="p-8">
      <div class="grid grid-cols-4 gap-6 max-w-screen-xl mx-auto">
        <!-- Card de produto -->
        <a href="#" class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition">
          <div class="bg-pink-300 h-48 flex items-start justify-end p-2">
            <button>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.318 6.318a4.5 4.5 0 016.364 0l.318.318.318-.318a4.5 4.5 0 116.364 6.364L12 21.364l-6.682-6.682a4.5 4.5 0 010-6.364z" />
              </svg>
            </button>
          </div>
          <div class="p-4 text-center">
            <h3 class="font-bold text-lg">Título</h3>
            <p class="text-sm text-gray-600">Descrição do produto</p>
            <p class="text-sm text-gray-800 mt-1">Valor</p>
          </div>
        </a>

        <!-- Cards vazios (modelo) -->
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">coisas</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">coisas</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">coisas para</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">alugar</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">alugar</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">alugar</div>
        <div class="bg-[#d7ebf0] rounded-2xl h-72 flex items-center justify-center text-white font-semibold">alugar</div>
      </div>
    </main>
  </body>
</html>
