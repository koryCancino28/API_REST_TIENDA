(function () {
  const base = document.querySelector('meta[name="api-base"]')?.content || '';
  const token = document.querySelector('meta[name="api-token"]')?.content || '';
  const csrf  = document.querySelector('meta[name="csrf-token"]')?.content || '';

  // Helper global para consumir /api/v1 desde vistas
  window.Api = {
    base, token, csrf,
    async request(path, options = {}) {
      const headers = new Headers(options.headers || {});
      if (this.token) headers.set('Authorization', `Bearer ${this.token}`);
      if (!headers.has('Content-Type')) headers.set('Content-Type', 'application/json');
      headers.set('Accept', 'application/json');
      headers.set('X-Requested-With', 'XMLHttpRequest');

      const res = await fetch(`${this.base}${path}`, {
        ...options,
        headers,
        // MUY IMPORTANTE: enviar cookies/sesión al backend Laravel
        credentials: 'same-origin',
      });

      // Intenta parsear solo si es JSON
      const ct = res.headers.get('Content-Type') || '';
      if (!res.ok) {
        const payload = ct.includes('application/json') ? await res.json().catch(() => ({}))
                                                       : await res.text();
        const msg = typeof payload === 'string'
          ? payload
          : (payload.message || JSON.stringify(payload));
        throw new Error(`HTTP ${res.status}: ${msg}`);
      }

      return ct.includes('application/json') ? res.json() : res.text();
    }
  };
})();
