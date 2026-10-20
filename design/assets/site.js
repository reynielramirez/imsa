(() => {
  'use strict';
  const header = document.querySelector('#main-header');
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('#main-nav');

  if (header && toggle && nav) {
    const closeMenu = () => {
      header.classList.remove('menu-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Abrir menú');
    };
    toggle.addEventListener('click', () => {
      const shouldOpen = !header.classList.contains('menu-open');
      header.classList.toggle('menu-open', shouldOpen);
      toggle.setAttribute('aria-expanded', String(shouldOpen));
      toggle.setAttribute('aria-label', shouldOpen ? 'Cerrar menú' : 'Abrir menú');
    });
    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', event => { if (event.key === 'Escape') closeMenu(); });
    document.addEventListener('click', event => { if (!header.contains(event.target)) closeMenu(); });
  }
  const year = document.querySelector('#year');
  if (year) year.textContent = String(new Date().getFullYear());

  const filterButtons = [...document.querySelectorAll('.filter-btn')];
  const cards = [...document.querySelectorAll('.product-card[data-category]')];
  const count = document.querySelector('#product-count');
  filterButtons.forEach(button => button.addEventListener('click', () => {
    const filter = button.dataset.filter;
    filterButtons.forEach(b => {
      const selected = b === button;
      b.classList.toggle('active', selected);
      b.setAttribute('aria-pressed', String(selected));
    });
    let shown = 0;
    cards.forEach(card => {
      const visible = filter === 'todos' || card.dataset.category === filter;
      card.hidden = !visible;
      if (visible) shown++;
    });
    if (count) count.textContent = `${shown} ${shown === 1 ? 'producto' : 'productos'}`;
  }));

  const dialog = document.querySelector('#product-dialog');
  const dataElement = document.querySelector('#product-data');
  if (dialog && dataElement) {
    let data = {};
    try { data = JSON.parse(dataElement.textContent); } catch (_) { data = {}; }
    const dialogTitle = document.querySelector('#dialog-title');
    const dialogDesc = document.querySelector('#dialog-desc');
    const dialogImg = document.querySelector('#dialog-img');
    const dialogCategory = document.querySelector('#dialog-category');
    const dialogSizes = document.querySelector('#dialog-sizes');
    const dialogUses = document.querySelector('#dialog-uses');
    document.querySelectorAll('.detail-button').forEach(button => button.addEventListener('click', () => {
      const item = data[button.dataset.product];
      if (!item) return;
      dialogTitle.textContent = item.name;
      dialogDesc.textContent = item.details;
      dialogImg.src = `assets/producto-${item.id}.svg`;
      dialogImg.alt = `Representación gráfica de ${item.name}`;
      dialogCategory.textContent = item.label;
      dialogSizes.textContent = item.sizes;
      dialogUses.replaceChildren(...item.uses.map(usage => {
        const li = document.createElement('li'); li.textContent = usage; return li;
      }));
      if (typeof dialog.showModal === 'function') dialog.showModal();
      else dialog.setAttribute('open', '');
    }));
    const closeButton = dialog.querySelector('.close-dialog');
    if (closeButton) closeButton.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', event => {
      const rect = dialog.getBoundingClientRect();
      if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) dialog.close();
    });
  }

  const revealItems = [...document.querySelectorAll('.reveal')];
  if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: .09, rootMargin: '0px 0px 35px 0px' });
    revealItems.forEach(item => observer.observe(item));
  } else revealItems.forEach(item => item.classList.add('visible'));
})();
