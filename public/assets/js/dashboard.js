(function(){
  const fab   = document.querySelector('.user-fab');
  const panel = document.getElementById('userPanel');
  const closeBtn = document.querySelector('[data-user-close]');

  if (!fab || !panel) return;

  const open = () => {
    panel.hidden = false;
    fab.setAttribute('aria-expanded','true');
    // Trampa de focus mínima
    closeBtn?.focus();
    document.addEventListener('keydown', onKey);
    document.addEventListener('click', onClickOutside, true);
  };

  const close = () => {
    panel.hidden = true;
    fab.setAttribute('aria-expanded','false');
    document.removeEventListener('keydown', onKey);
    document.removeEventListener('click', onClickOutside, true);
    fab.focus();
  };

  const onKey = (e) => { if (e.key === 'Escape') close(); };

  const onClickOutside = (e) => {
    if (!panel.contains(e.target) && !fab.contains(e.target)) {
      close();
    }
  };

  fab.addEventListener('click', () => {
    panel.hidden ? open() : close();
  });

  closeBtn?.addEventListener('click', close);
})();
