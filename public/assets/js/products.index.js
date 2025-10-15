(function(){
  const table = document.getElementById('tbl');
  if (!table) return;

  const tbody = table.querySelector('tbody');

  // Modales
  const editModal   = document.getElementById('productModal');
  const createModal = document.getElementById('productCreateModal');

  const formEdit   = document.getElementById('modalFormEdit');
  const formCreate = document.getElementById('modalFormCreate');

  const btnSaveEdit   = document.getElementById('btnSaveEdit');
  const btnSaveCreate = document.getElementById('btnSaveCreate');
  const btnNew        = document.getElementById('btnNew');

  let currentId = null;

  // ===== Listar =====
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
    // Asegurar color trazos SVG
    tbody.querySelectorAll('.icon-btn svg *').forEach(p => {
      p.style.stroke = 'currentColor';
      if (!p.getAttribute('stroke')) p.setAttribute('stroke','currentColor');
      p.setAttribute('stroke-width','1.6');
    });
    bindRowActions();
  }

  // ===== Acciones por fila =====
  function bindRowActions(){
    // abrir EDITAR
    tbody.querySelectorAll('[data-edit]').forEach(btn=>{
      btn.onclick = async ()=>{
        currentId = btn.getAttribute('data-edit');
        try{
          const res = await Api.request(`/products/${currentId}`);
          const p = res.data;
          formEdit.sku.value         = p.sku || '';
          formEdit.name.value        = p.name || '';
          formEdit.description.value = p.description || '';
          formEdit.price.value       = p.price ?? 0;
          formEdit.stock.value       = p.stock ?? 0;
          openModal(editModal);
        }catch(err){ alert(err.message); }
      };
    });

    // ELIMINAR
    tbody.querySelectorAll('[data-del]').forEach(btn=>{
      btn.onclick = async ()=>{
        const id = btn.getAttribute('data-del');
        if (!confirm('¿Eliminar producto?')) return;
        await Api.request(`/products/${id}`, { method:'DELETE' });
        await load();
      };
    });
  }

  // ===== Crear (abrir modal) =====
  btnNew?.addEventListener('click', ()=>{
    formCreate.reset();
    // defaults
    formCreate.price.value = '';
    formCreate.stock.value = '0';
    openModal(createModal);
  });

  // ===== Guardar EDIT =====
  btnSaveEdit.addEventListener('click', async ()=>{
    if (!currentId) return;
    const payload = {
      sku:  formEdit.sku.value,
      name: formEdit.name.value,
      description: formEdit.description.value,
      price: parseFloat(formEdit.price.value || 0),
      stock: parseInt(formEdit.stock.value || 0, 10),
    };
    try{
      await Api.request(`/products/${currentId}`, {
        method: 'PUT',
        body: JSON.stringify(payload)
      });
      closeModal(editModal);
      await load();
    }catch(err){ alert(err.message); }
  });

  // ===== Guardar CREATE =====
  btnSaveCreate.addEventListener('click', async ()=>{
    const payload = {
      sku:  formCreate.sku.value,
      name: formCreate.name.value,
      description: formCreate.description.value,
      price: parseFloat(formCreate.price.value || 0),
      stock: parseInt(formCreate.stock.value || 0, 10),
    };
    try{
      await Api.request(`/products`, {
        method: 'POST',
        body: JSON.stringify(payload)
      });
      closeModal(createModal);
      await load();
    }catch(err){ alert(err.message); }
  });

  // ===== Modal helpers (genéricos) =====
  function openModal(node){
    node.hidden = false;
    node.setAttribute('aria-hidden','false');
    document.addEventListener('keydown', onEsc);
    document.addEventListener('click', onBackdrop, true);
  }
  function closeModal(node){
    node.hidden = true;
    node.setAttribute('aria-hidden','true');
    document.removeEventListener('keydown', onEsc);
    document.removeEventListener('click', onBackdrop, true);
    currentId = null;
  }
  function onEsc(e){
    if (e.key === 'Escape'){
      if (!editModal.hidden)   closeModal(editModal);
      if (!createModal.hidden) closeModal(createModal);
    }
  }
  function onBackdrop(e){
    if (e.target?.hasAttribute('data-close-modal')) {
      if (!editModal.hidden)   closeModal(editModal);
      if (!createModal.hidden) closeModal(createModal);
    }
  }
  // botones de cerrar (X y Cancelar)
  document.querySelectorAll('[data-close-modal]').forEach(el=>{
    el.addEventListener('click', ()=>{
      if (!editModal.hidden)   closeModal(editModal);
      if (!createModal.hidden) closeModal(createModal);
    });
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
