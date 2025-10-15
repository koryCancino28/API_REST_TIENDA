(function () {
  const form = document.getElementById('loginForm');
  if (!form) return;

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
  const toListHtml = (arr) => `<ul style="text-align:left;margin:0;padding-left:1.1rem;">${arr.map(e=>`<li>${e}</li>`).join('')}</ul>`;

  // Errores renderizados previos (si hubo reload)
  const errEl = document.getElementById('login-errors');
  if (errEl) {
    try {
      const list = JSON.parse(errEl.dataset.errors || '[]');
      if (Array.isArray(list) && list.length) {
        Swal.fire({ icon: 'error', title: 'Revisa tus datos', html: toListHtml(list) });
      }
    } catch (_) {}
  }

  const statusEl = document.getElementById('login-status');
  if (statusEl) {
    try {
      const msg = JSON.parse(statusEl.dataset.status || '""');
      if (msg) Swal.fire({ icon: 'success', title: msg, timer: 1600, showConfirmButton: false });
    } catch (_) {}
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const data = Object.fromEntries(new FormData(form).entries());
    if (!data.email || !data.password) {
      return Swal.fire({ icon:'warning', title:'Completa tu email y contraseña' });
    }

    Swal.fire({ title:'Ingresando…', allowOutsideClick:false, allowEscapeKey:false, didOpen:()=>Swal.showLoading() });

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        credentials: 'same-origin',           // <— IMPORTANTE
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',       // <— fuerza JSON en validación
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': csrf,
        },
        body: JSON.stringify(data)
      });

      const ct = res.headers.get('Content-Type') || '';

      if (res.ok) {
        const j = ct.includes('application/json') ? await res.json() : { redirect: '/dashboard', message: 'Bienvenido' };
        Swal.fire({ icon:'success', title: j.message || 'Bienvenido', timer: 800, showConfirmButton:false });
        setTimeout(()=> location.href = j.redirect || '/dashboard', 500);
        return;
      }

      // 422 validación
      if (res.status === 422) {
        const j = ct.includes('application/json') ? await res.json() : {};
        const list = j.errors ? Object.values(j.errors).flat() : [j.message || 'Datos inválidos'];
        return Swal.fire({ icon:'error', title:'Revisa tus datos', html: toListHtml(list) });
      }

      // 401 credenciales
      if (res.status === 401) {
        const j = ct.includes('application/json') ? await res.json().catch(()=> ({})) : {};
        return Swal.fire({ icon:'error', title: j.message || 'Credenciales inválidas' });
      }

      // Otros errores (incluye 419 CSRF o HTML)
      const txt = ct.includes('application/json') ? JSON.stringify(await res.json(), null, 2)
                                                  : await res.text();
      Swal.fire({ icon:'error', title:`Error ${res.status}`, html: `<pre style="text-align:left;max-height:300px;overflow:auto">${txt}</pre>` });

    } catch (err) {
      Swal.fire({ icon:'error', title:'Error de red', text: err.message || 'No se pudo conectar' });
    }
  });
})();
