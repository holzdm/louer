document.addEventListener('DOMContentLoaded', function() {
  const dropdowns = document.querySelectorAll('[class$="-dropdown"]');

  dropdowns.forEach(dropdown => {
    const className = Array.from(dropdown.classList).find(c => c.endsWith('-dropdown'));

    if (!className) return;

    const trigger = dropdown.querySelector(`.${className}-trigger`);
    const button = trigger.querySelector(`.${className}-button`);
    const conteudo = dropdown.querySelector(`.${className}-conteudo`);

    trigger.addEventListener('click', function(event) {
      event.stopPropagation();

      const isActive = dropdown.classList.contains('is-active');

      // Fecha todos antes de abrir o atual
      dropdowns.forEach(d => d.classList.remove('is-active'));

      if (!isActive) {
        dropdown.classList.add('is-active');
        button.focus();
      } else {
        button.blur();
      }
    });

    document.addEventListener('click', function(event) {
      if (!dropdown.contains(event.target)) {
        dropdown.classList.remove('is-active');
        button.blur();
      }
    });
  });
});


