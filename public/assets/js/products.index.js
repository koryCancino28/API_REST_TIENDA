(function(){
  const table = document.getElementById('tbl');
  if (!table) return;

  const tbody = table.querySelector('tbody');

  // Modal refs
  const modal = document.getElementById('productModal');
  const modalForm = document.getElementById('modalForm');
  const btnSave = document.getElementById('btnSaveModal');

  let currentId = null; // id del producto que se edita

  async function load(){
    const data = await Api.request(`/products`);
    render(data.data || []);
  }

  function render(items){
    tbody.innerHTML = '';
    items.forEach(p => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${p.id}</td>
        <td>${p.sku}</td>
        <td>${p.name}</td>
        <td>${Number(p.price).toFixed(2)}</td>
        <td>${p.stock}</td>
        <td class="col-actions">
          <div class="row-actions">
            <button class="icon-btn" type="button" data-edit="${p.id}" title="Editar" aria-label="Editar">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/>
                <path d="M14.06 6.19l2.12-2.12a1.5 1.5 0 1 1 2.12 2.12L16.19 8.31"/>
              </svg>
            </button>
            <button class="icon-btn icon-danger" data-del="${p.id}" type="button" title="Eliminar" aria-label="Eliminar">
              <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M4 7h16" stroke-linecap="round"/>
                <path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
                <path d="M6 7l1 13a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-13"/>
              </svg>
            </button>
          </div>
        </td>
      `;
      tbody.appendChild(tr);
    });
    // Asegurar que los trazos del SVG hereden el color
    tbody.querySelectorAll('.icon-btn svg *').forEach(p => {
      p.style.stroke = 'currentColor';
      if (!p.getAttribute('stroke')) p.setAttribute('stroke','currentColor');
      p.setAttribute('stroke-width','1.6');
    });
    bindRowActions();
  }

  function bindRowActions(){
    // Editar -> abrir modal y cargar datos
    tbody.querySelectorAll('[data-edit]').forEach(btn=>{
      btn.onclick = async ()=>{
        currentId = btn.getAttribute('data-edit');
        try{
          const res = await Api.request(`/products/${currentId}`);
          const p = res.data;
          modalForm.sku.value = p.sku || '';
          modalForm.name.value = p.name || '';
          modalForm.description.value = p.description || '';
          modalForm.price.value = p.price ?? 0;
          modalForm.stock.value = p.stock ?? 0;
          openModal();
        }catch(err){
          alert(err.message);
        }
      };
    });

    // Eliminar
    tbody.querySelectorAll('[data-del]').forEach(btn=>{
      btn.onclick = async ()=>{
        const id = btn.getAttribute('data-del');
        if (!confirm('¿Eliminar producto?')) return;
        await Api.request(`/products/${id}`, { method:'DELETE' });
        await load();
      };
    });
  }

  // Modal helpers
  function openModal(){
    modal.hidden = false;
    modal.setAttribute('aria-hidden','false');
    document.addEventListener('keydown', onEsc);
    document.addEventListener('click', onBackdrop, true);
  }
  function closeModal(){
    modal.hidden = true;
    modal.setAttribute('aria-hidden','true');
    document.removeEventListener('keydown', onEsc);
    document.removeEventListener('click', onBackdrop, true);
    currentId = null;
  }
  function onEsc(e){ if (e.key === 'Escape') closeModal(); }
  function onBackdrop(e){
    if (e.target?.hasAttribute('data-close-modal')) closeModal();
  }
  // Botones de cerrar
  modal.querySelectorAll('[data-close-modal]').forEach(el=>{
    el.addEventListener('click', closeModal);
  });

  // Guardar cambios (PUT)
  btnSave.addEventListener('click', async ()=>{
    if (!currentId) return;
    const payload = {
      sku: modalForm.sku.value,
      name: modalForm.name.value,
      description: modalForm.description.value,
      price: parseFloat(modalForm.price.value || 0),
      stock: parseInt(modalForm.stock.value || 0, 10),
    };
    try{
      await Api.request(`/products/${currentId}`, {
        method: 'PUT',
        body: JSON.stringify(payload)
      });
      closeModal();
      await load();
    }catch(err){
      alert(err.message);
    }
  });

  // Botón Volver (historial)
  const btnBack = document.getElementById('btnBack');
  if (btnBack) {
    btnBack.addEventListener('click', (e) => {
      if (window.history.length > 1) { e.preventDefault(); history.back(); }
    });
  }

  load();
})();
