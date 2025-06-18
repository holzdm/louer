document.addEventListener('DOMContentLoaded', function() {
  const dropdowns = document.querySelectorAll('[class$="-dropdown"]');
  const barraPesquisaDropdown = document.querySelector('.barra-pesquisa-dropdown'); // Seleciona a barra-pesquisa-dropdown

  dropdowns.forEach(dropdown => {
    const className = Array.from(dropdown.classList).find(c => c.endsWith('-dropdown'));

    if (!className) return;

    const trigger = dropdown.querySelector(`.${className}-trigger`);
    const button = trigger ? trigger.querySelector(`.${className}-button`) : null;
    const conteudo = dropdown.querySelector(`.${className}-conteudo`);

    dropdown.addEventListener('click', function(event) {
      event.stopPropagation();

      const isActive = dropdown.classList.contains('is-active');

      // Fecha todos antes de abrir o atual
      dropdowns.forEach(d => d.classList.remove('is-active'));
      if (barraPesquisaDropdown) barraPesquisaDropdown.classList.remove('is-active'); // Remove a classe da barra-pesquisa-dropdown

      if (!isActive) {
        dropdown.classList.add('is-active');
        
        // Adiciona a classe is-active à barra-pesquisa-dropdown se o dropdown clicado for categorias-dropdown
        if (dropdown.classList.contains('categorias-dropdown') && barraPesquisaDropdown) {
          barraPesquisaDropdown.classList.add('is-active');
        }

        if (button) button.focus();
      } else {
        if (button) button.blur();
      }
    });

    document.addEventListener('click', function(event) {
      if (!dropdown.contains(event.target)) {
        dropdown.classList.remove('is-active');
        if (barraPesquisaDropdown) barraPesquisaDropdown.classList.remove('is-active'); // Remove a classe da barra-pesquisa-dropdown
        if (button) button.blur();
      }
    });
  });
});