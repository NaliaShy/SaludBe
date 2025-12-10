  <style>
      /* -----------------------------
       VARIABLES (personaliza aquí)
       ----------------------------- */
      :root {
          --bg: #f5f7fb;
          /* fondo de la página */
          --container-bg: #ffffff;
          /* fondo del container */
          --accent: #458a1d;
          /* color principal (usa para botones, badges) */
          --muted: #6b7280;
          /* texto secundario */
          --card-bg: linear-gradient(180deg, rgba(255, 255, 255, 0.9), rgba(250, 250, 255, 0.95));
          --radius: 14px;
          /* radio de esquinas */
          --shadow: 0 8px 24px rgba(18, 23, 40, 0.06);
          --glass: rgba(255, 255, 255, 0.6);
      }

      /* -----------------------------
       RESET Y LAYOUT
       ----------------------------- */
      * {
          box-sizing: border-box
      }

      html,
      body {
          height: 100%;
          margin: 0;
          font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
          background: var(--bg);
          color: #0f172a
      }

      .wrap {
          max-width: 1200px;
          margin: 40px auto;
          padding: 28px;
          background: var(--container-bg);
          border-radius: 20px;
          box-shadow: var(--shadow);
          border: 1px solid rgba(15, 23, 42, 0.04);
      }

      header.row {
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 12px;
          margin-bottom: 18px;
      }

      header .title {
          display: flex;
          gap: 12px;
          align-items: center;
      }

      header h1 {
          font-size: 18px;
          margin: 0
      }

      header p {
          margin: 0;
          color: var(--muted);
          font-size: 13px
      }

      /* -----------------------------
       GRID DE TARJETAS
       ----------------------------- */
      .grid {
          display: grid;
          grid-template-columns: repeat(3, 1fr);
          gap: 18px;
      }

      /* responsive */
      @media (max-width:920px) {
          .grid {
              grid-template-columns: repeat(2, 1fr);
          }
      }

      @media (max-width:560px) {
          .grid {
              grid-template-columns: 1fr;
          }

          .wrap {
              padding: 18px
          }
      }

      /* -----------------------------
       TARJETA
       ----------------------------- */
      .card {
          background: var(--card-bg);
          border-radius: var(--radius);
          padding: 16px;
          box-shadow: 0 6px 18px rgba(11, 14, 26, 0.05);
          display: flex;
          flex-direction: column;
          gap: 12px;
          min-height: 170px;
          transition: transform .22s ease, box-shadow .22s ease;
          border: 1px solid rgba(12, 17, 29, 0.03);
          overflow: hidden;
      }

      .card:hover {
          transform: translateY(-6px);
          box-shadow: 0 18px 42px rgba(12, 16, 32, 0.08);
      }

      .card .media {
          height: 90px;
          border-radius: 12px;
          background: linear-gradient(135deg, rgba(108, 92, 231, 0.12), rgba(108, 92, 231, 0.04));
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: 600;
          color: var(--accent);
      }

      .card h3 {
          margin: 0;
          font-size: 15px
      }

      .card p {
          margin: 0;
          color: var(--muted);
          font-size: 13px
      }

      .meta {
          display: flex;
          justify-content: space-between;
          align-items: center;
          gap: 8px;
          margin-top: auto;
      }

      .badge {
          font-size: 12px;
          padding: 6px 10px;
          border-radius: 999px;
          background: rgba(108, 92, 231, 0.12);
          color: var(--accent);
          font-weight: 600;
      }

      .actions {
          display: flex;
          gap: 8px
      }

      .btn {
          font-size: 13px;
          padding: 8px 12px;
          border-radius: 10px;
          border: 0;
          cursor: pointer;
          background: var(--accent);
          color: white;
          box-shadow: 0 6px 18px rgba(108, 92, 231, 0.14);
      }

      .btn.ghost {
          background: transparent;
          color: var(--accent);
          border: 1px solid rgba(108, 92, 231, 0.12);
          box-shadow: none
      }

      /* ayuda visual para edición */
      .hint {
          font-size: 12px;
          color: #94a3b8
      }
  </style>

  <!--
    Plantilla: Container con 6 tarjetas
    - Personaliza colores cambiando las variables en :root
    - Añade/edita contenido dentro de cada <article class="card">...
    - Las tarjetas están pensadas para mostrar: imagen (o iniciales), título, descripción, badge y acciones.
  -->
  <seccion class="wrap" id="Psicologo-CrearTest" style="display: none;">

      <header class="row">
          <div class="title">
              <svg width="36" height="36" viewBox="0 0 24 24" fill="none" aria-hidden>
                  <rect width="24" height="24" rx="6" fill="var(--accent)" opacity="0.12" />
                  <path d="M7 12h10M7 8h10M7 16h6" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div>
                  <h1>Mis tarjetas</h1>
                  <p class="hint">6 tarjetas dentro de un container — arréglalas como quieras</p>
              </div>
          </div>
          <div style="display:flex; gap:10px;">
              <button class="btn">Nueva tarjeta</button>
          </div>
      </header>

      <div style="margin-bottom:20px; text-align:right;">
          <button class="btn" onclick="mostrarFormulario()">Agregar más test</button>
      </div>

      <section class="grid" id="contenedorTests">

          <!-- Tarjeta 1 -->
          <article class="card">
              <div class="media" style="background: linear-gradient(135deg, #4ade80, #22c55e); color:white;">Test-1</div>
              <h3>Título tarjeta 1</h3>
              <p class="hint">Descripción breve o subtítulo. Aquí puedes poner texto que explique la tarjeta.</p>
              <div class="meta">
                  <span class="badge">Activo</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

          <!-- Tarjeta 2 -->
          <article class="card">
              <div class="media" style="background: linear-gradient(135deg, #60a5fa, #3b82f6); color:white;">Test-2</div>
              <h3>Título tarjeta 2</h3>
              <p class="hint">Descripción breve.</p>
              <div class="meta">
                  <span class="badge">Nuevo</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

          <!-- Tarjeta 3 -->
          <article class="card">
              <div class="media" style="background: linear-gradient(135deg, #f472b6, #ec4899); color:white;">Test-3</div>
              <h3>Título tarjeta 3</h3>
              <p class="hint">Pequeña nota o dato.</p>
              <div class="meta">
                  <span class="badge">Info</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

          <!-- Tarjeta 4 -->
          <article class="card">
              <div class="media">IMG</div>
              <h3>Título tarjeta 4</h3>
              <p class="hint">Texto de ejemplo para que edites.</p>
              <div class="meta">
                  <span class="badge">Baja</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

          <!-- Tarjeta 5 -->
          <article class="card">
              <div class="media">IMG</div>
              <h3>Título tarjeta 5</h3>
              <p class="hint">Puedes poner aquí una lista corta o etiquetas.</p>
              <div class="meta">
                  <span class="badge">Pro</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

          <!-- Tarjeta 6 -->
          <article class="card">
              <div class="media">IMG</div>
              <h3>Título tarjeta 6</h3>
              <p class="hint">Otro texto de muestra para personalizar.</p>
              <div class="meta">
                  <span class="badge">5%</span>
                  <div class="actions">
                      <button class="btn ghost">Editar</button>
                      <button class="btn">Abrir</button>
                  </div>
              </div>
          </article>

      </section>


      <!-- Modal para crear test -->
      <div id="modalCrearTest" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.45); backdrop-filter:blur(3px); align-items:center; justify-content:center;">
          <div style="background:white; padding:25px; border-radius:16px; width:90%; max-width:420px; box-shadow:0 8px 30px rgba(0,0,0,0.2);">

              <h2 style="margin-top:0; font-size:20px;">Crear nuevo test</h2>

              <label>Título</label>
              <input id="tituloModal" type="text" style="width:100%; padding:10px; border-radius:8px; border:1px solid #cbd5e1; margin-bottom:10px;">

              <label>Descripción</label>
              <textarea id="descripcionModal" style="width:100%; padding:10px; border-radius:8px; border:1px solid #cbd5e1; margin-bottom:15px;"></textarea>

              <div style="display:flex; justify-content:flex-end; gap:10px;">
                  <button class="btn ghost" onclick="cerrarModal()">Cancelar</button>
                  <button class="btn" onclick="guardarDesdeModal()">Guardar</button>
              </div>
          </div>
      </div>

  </seccion>

  <script>
      function mostrarFormulario() {
          document.getElementById('formCrearTest').style.display = 'block';
      }

      function agregarPregunta() {
          const cont = document.getElementById('preguntasContainer');
          const p = document.createElement('div');
          p.style.marginBottom = '10px';
          p.innerHTML = `
    <input type="text" placeholder="Pregunta" style="width:100%; padding:8px; border-radius:8px; border:1px solid #94a3b8; margin-bottom:6px;">
    <select style="padding:8px; border-radius:8px; border:1px solid #94a3b8; width:100%;">
      <option>Nunca</option>
      <option>Probablemente</option>
      <option>Más o menos</option>
      <option>Siempre</option>
    </select>
  `;
          cont.appendChild(p);
      }

      function guardarTest() {
          const titulo = document.getElementById('tituloTest').value;
          const descripcion = document.getElementById('descripcionTest').value;
          const contenedor = document.getElementById('contenedorTests');
          const nueva = document.createElement('article');
          nueva.classList.add('card');
          nueva.innerHTML = `
    <div class="media" style="background: linear-gradient(135deg, #a78bfa, #8b5cf6);">Nuevo</div>
    <h3>${titulo}</h3>
    <p>${descripcion}</p>
    <div class="meta">
      <span class="badge">Nuevo</span>
      <div class="actions">
        <button class="btn ghost">Editar</button>
        <button class="btn">Abrir</button>
      </div>
    </div>
  `;
          contenedor.appendChild(nueva);
          alert('Test creado exitosamente');
      }
  </script>