/* =========================================================
   MUSEU PALEO · interações
   ========================================================= */
(() => {
  const $ = (s, el = document) => el.querySelector(s);
  const $$ = (s, el = document) => [...el.querySelectorAll(s)];
  const body = document.body;
  const reduzido = matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Transição entre páginas ---------- */
  addEventListener('pageshow', (e) => { if (e.persisted) body.classList.remove('is-leaving'); });

  document.addEventListener('click', (e) => {
    const a = e.target.closest('a[href]');
    if (!a || e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || a.target === '_blank') return;
    const url = new URL(a.href, location.href);
    if (url.origin !== location.origin) return;
    const caminho = (p) => p.replace(/index\.php$/, '');
    const mesmaPagina = caminho(url.pathname) === caminho(location.pathname) && url.search === location.search;
    if (mesmaPagina) {
      // âncora na mesma página: rolagem suave + destaque
      if (url.hash) {
        const alvo = document.getElementById(decodeURIComponent(url.hash.slice(1)));
        if (alvo) {
          e.preventDefault();
          fecharMenu();
          history.pushState(null, '', url.hash);
          alvo.scrollIntoView({ behavior: reduzido ? 'auto' : 'smooth', block: 'start' });
          destacar(alvo);
        }
      }
      return;
    }
    e.preventDefault();
    body.classList.add('is-leaving');
    setTimeout(() => { location.href = url.href; }, reduzido ? 0 : 420);
  });

  function destacar(alvo) {
    const el = alvo.matches('section') ? ($('.section-head', alvo) || $('.hero__text', alvo) || alvo) : ($('.specimen__open', alvo) || alvo);
    el.classList.remove('is-found');
    void el.offsetWidth;
    el.classList.add('is-found');
  }
  if (location.hash) {
    const alvo = document.getElementById(decodeURIComponent(location.hash.slice(1)));
    if (alvo) setTimeout(() => destacar(alvo), 700);
  }

  /* ---------- Revelar ao rolar ---------- */
  const revelar = new IntersectionObserver((entradas) => {
    entradas.forEach((en) => {
      if (!en.isIntersecting) return;
      const el = en.target;
      el.classList.add('is-in');
      revelar.unobserve(el);
      // depois de aparecer, devolve as transições próprias do elemento (hover etc.)
      const atraso = parseFloat(getComputedStyle(el).transitionDelay) * 1000 || 0;
      setTimeout(() => el.classList.remove('reveal', 'is-in'), 1300 + atraso);
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
  $$('.reveal').forEach((el) => revelar.observe(el));


  /* ---------- Cenários (troca de cor a cada seção) ---------- */
  const navPorSecao = { inicio: 'home', museu: 'home', guia: 'guia', valores: 'valores', kids: 'kids', interesses: 'interesses' };
  const cenas = $$('main [data-scene], .footer[data-scene]');
  const trocarCena = new IntersectionObserver((entradas) => {
    entradas.forEach((en) => {
      if (!en.isIntersecting) return;
      const sec = en.target;
      body.dataset.scene = sec.dataset.scene;
      $$('.scene-dots a').forEach((d) => d.classList.toggle('is-active', d.dataset.dot === sec.id));
      if (body.dataset.page === 'home' && navPorSecao[sec.id]) marcarNav(navPorSecao[sec.id]);
    });
  }, { rootMargin: '-48% 0px -48% 0px' });
  cenas.forEach((s) => trocarCena.observe(s));

  /* ---------- Header ---------- */
  const topbar = $('.topbar');
  const nav = $('.nav');
  const burger = $('.burger');
  let ultimoY = scrollY;
  let tick = false;
  addEventListener('scroll', () => {
    if (tick) return;
    tick = true;
    requestAnimationFrame(() => {
      const y = scrollY;
      topbar.classList.toggle('is-scrolled', y > 40);
      const descendo = y > ultimoY + 4;
      const subindo = y < ultimoY - 4;
      const ocupado = nav.classList.contains('is-open') || document.activeElement === $('#busca');
      if (descendo && y > 400 && !ocupado) topbar.classList.add('is-hidden');
      if (subindo || y < 400) topbar.classList.remove('is-hidden');
      ultimoY = y;
      parallax();
      tick = false;
    });
  }, { passive: true });

  function fecharMenu() {
    nav.classList.remove('is-open');
    burger.setAttribute('aria-expanded', 'false');
  }
  burger.addEventListener('click', () => {
    const aberto = nav.classList.toggle('is-open');
    burger.setAttribute('aria-expanded', String(aberto));
  });

  // indicador deslizante sob o link ativo
  const ind = document.createElement('span');
  ind.className = 'nav__ind';
  nav.appendChild(ind);
  const linkAtivo = () => $('.nav a.is-active') || $('.nav a[aria-current="page"]');
  function moverInd(link) {
    if (!link) { ind.style.opacity = 0; return; }
    ind.style.opacity = 1;
    ind.style.width = `${link.offsetWidth - 28}px`;
    ind.style.transform = `translateX(${link.offsetLeft + 14}px)`;
  }
  function marcarNav(id) {
    $$('.nav a').forEach((a) => a.classList.toggle('is-active', a.dataset.nav === id));
    moverInd(linkAtivo());
  }
  $$('.nav a').forEach((a) => a.addEventListener('mouseenter', () => moverInd(a)));
  nav.addEventListener('mouseleave', () => moverInd(linkAtivo()));
  addEventListener('resize', () => moverInd(linkAtivo()));
  document.fonts?.ready.then(() => moverInd(linkAtivo()));
  moverInd(linkAtivo());

  /* ---------- Buscador ---------- */
  const form = $('.search');
  const campo = $('#busca');
  const caixa = $('#busca-resultados');
  let ativo = -1;
  let timer;
  let ultimaBusca = '';

  const escapar = (s) => s.replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const semAcento = (s) => s.normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();

  function marcar(texto, termos) {
    // destaca os termos ignorando acentos, sem quebrar o HTML
    const base = semAcento(texto);
    const marcas = new Array(texto.length).fill(false);
    termos.forEach((t) => {
      let i = base.indexOf(t);
      while (t && i !== -1) { for (let k = i; k < i + t.length; k++) marcas[k] = true; i = base.indexOf(t, i + t.length); }
    });
    let out = '';
    let dentro = false;
    [...texto].forEach((ch, i) => {
      if (marcas[i] && !dentro) { out += '<mark>'; dentro = true; }
      if (!marcas[i] && dentro) { out += '</mark>'; dentro = false; }
      out += escapar(ch);
    });
    return out + (dentro ? '</mark>' : '');
  }

  function abrirCaixa() {
    caixa.hidden = false;
    campo.setAttribute('aria-expanded', 'true');
    requestAnimationFrame(() => caixa.classList.add('is-open'));
  }
  function fecharCaixa() {
    caixa.classList.remove('is-open');
    campo.setAttribute('aria-expanded', 'false');
    ativo = -1;
    setTimeout(() => { if (!caixa.classList.contains('is-open')) caixa.hidden = true; }, 300);
  }

  async function buscar(q) {
    ultimaBusca = q;
    try {
      const r = await fetch(`search.php?format=json&q=${encodeURIComponent(q)}`);
      const dados = await r.json();
      if (q !== ultimaBusca) return; // chegou resposta antiga
      const termos = semAcento(q).split(/[\s-]+/).filter((t) => t.length >= 2);
      if (!dados.resultados.length) {
        caixa.innerHTML = `<p class="search__empty">Nenhum fóssil encontrado para “${escapar(q)}”. Tente “mamute”, “terça” ou “kids”.</p>`;
      } else {
        caixa.innerHTML = dados.resultados.map((r, i) => `
          <a href="${escapar(r.url)}" role="option" id="res-${i}">
            <span class="tag">${escapar(r.secao)}</span>
            <strong>${marcar(r.titulo, termos)}</strong>
            <small>${marcar(r.texto, termos)}</small>
          </a>`).join('') +
          `<a class="search__more" href="search.php?q=${encodeURIComponent(q)}">Ver todos os resultados</a>`;
      }
      ativo = -1;
      abrirCaixa();
    } catch {
      caixa.innerHTML = '<p class="search__empty">Busca indisponível. Abra o site pelo servidor PHP.</p>';
      abrirCaixa();
    }
  }

  campo.addEventListener('input', () => {
    clearTimeout(timer);
    const q = campo.value.trim();
    if (q.length < 2) { ultimaBusca = ''; fecharCaixa(); return; }
    timer = setTimeout(() => buscar(q), 180);
  });
  campo.addEventListener('focus', () => { if (campo.value.trim().length >= 2 && caixa.innerHTML) abrirCaixa(); });
  campo.addEventListener('keydown', (e) => {
    const itens = $$('a', caixa);
    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
      if (!itens.length) return;
      e.preventDefault();
      ativo = (ativo + (e.key === 'ArrowDown' ? 1 : -1) + itens.length) % itens.length;
      itens.forEach((a, i) => a.classList.toggle('is-active', i === ativo));
      itens[ativo].scrollIntoView({ block: 'nearest' });
      campo.setAttribute('aria-activedescendant', itens[ativo].id || '');
    } else if (e.key === 'Enter' && ativo >= 0 && itens[ativo]) {
      e.preventDefault();
      itens[ativo].click();
    } else if (e.key === 'Escape') {
      fecharCaixa();
      campo.blur();
    }
  });
  caixa.addEventListener('click', (e) => { if (e.target.closest('a')) { fecharCaixa(); campo.blur(); } });
  document.addEventListener('click', (e) => { if (!form.contains(e.target)) fecharCaixa(); });
  document.addEventListener('keydown', (e) => {
    if (e.key === '/' && !/input|textarea/i.test(document.activeElement.tagName)) {
      e.preventDefault();
      topbar.classList.remove('is-hidden');
      campo.focus();
    }
  });

  /* ---------- Contadores ---------- */
  const contar = new IntersectionObserver((entradas) => {
    entradas.forEach((en) => {
      if (!en.isIntersecting) return;
      contar.unobserve(en.target);
      const fim = +en.target.dataset.count;
      if (reduzido) return;
      const inicio = performance.now();
      const dur = 1800;
      const passo = (t) => {
        const p = Math.min((t - inicio) / dur, 1);
        const v = Math.round(fim * (1 - Math.pow(1 - p, 4)));
        en.target.textContent = v.toLocaleString('pt-BR');
        if (p < 1) requestAnimationFrame(passo);
      };
      requestAnimationFrame(passo);
    });
  }, { threshold: 0.6 });
  $$('[data-count]').forEach((el) => contar.observe(el));

  /* ---------- Parallax (osso do hero e crânio do Sobre) ---------- */
  const paralaxe = $$('[data-parallax]');
  let mx = 0;
  let my = 0;
  function parallax() {
    if (reduzido) return;
    paralaxe.forEach((el) => {
      const f = +el.dataset.parallax;
      el.style.setProperty('--py', `${(-scrollY * f + my * 14).toFixed(1)}px`);
      el.style.setProperty('--px', `${(mx * 18).toFixed(1)}px`);
    });
  }
  if (paralaxe.length && matchMedia('(pointer: fine)').matches) {
    addEventListener('pointermove', (e) => {
      mx = e.clientX / innerWidth - 0.5;
      my = e.clientY / innerHeight - 0.5;
      requestAnimationFrame(parallax);
    }, { passive: true });
  }

  /* ---------- Brilho que segue o mouse nos cartões ---------- */
  $$('.price, .highlight, .kid-card, .specimen__open, .pillar, .timeline__card, .day').forEach((card) => {
    card.classList.add('glow');
    card.addEventListener('pointermove', (e) => {
      const r = card.getBoundingClientRect();
      card.style.setProperty('--mx', `${e.clientX - r.left}px`);
      card.style.setProperty('--my', `${e.clientY - r.top}px`);
    });
  });

  /* ---------- Curiosidades Kids ---------- */
  const fato = $('.fact__text');
  if (fato) {
    const lista = JSON.parse(fato.dataset.facts);
    let i = 0;
    $('.fact__btn').addEventListener('click', () => {
      const box = $('.fact');
      i = (i + 1 + Math.floor(Math.random() * (lista.length - 1))) % lista.length;
      fato.classList.add('is-swapping');
      box.classList.remove('is-bump');
      void box.offsetWidth;
      box.classList.add('is-bump');
      setTimeout(() => { fato.textContent = lista[i]; fato.classList.remove('is-swapping'); }, 320);
    });
  }

  /* ---------- Galeria: filtros ---------- */
  const pecas = $$('.specimen');
  $$('.chip').forEach((chip) => chip.addEventListener('click', () => {
    $$('.chip').forEach((c) => { c.classList.toggle('is-active', c === chip); c.setAttribute('aria-pressed', String(c === chip)); });
    const f = chip.dataset.filter;
    pecas.forEach((p) => {
      p.classList.remove('reveal', 'is-in');
      const mostrar = f === 'todos' || p.dataset.cat === f;
      if (mostrar) {
        p.classList.remove('is-hidden');
        requestAnimationFrame(() => requestAnimationFrame(() => p.classList.remove('is-hiding')));
      } else {
        p.classList.add('is-hiding');
        setTimeout(() => { if (p.classList.contains('is-hiding')) p.classList.add('is-hidden'); }, 400);
      }
    });
  }));

  /* ---------- Galeria: lightbox ---------- */
  const lb = $('.lightbox');
  if (lb) {
    let atual = 0;
    const visiveis = () => pecas.filter((p) => !p.classList.contains('is-hidden') && !p.classList.contains('is-hiding'));
    function preencher(peca) {
      const d = $('.specimen__open', peca).dataset;
      $('.lightbox__art img', lb).src = d.img;
      $('.lightbox__art img', lb).alt = d.title;
      $('.tag', lb).textContent = d.cat;
      $('#lb-title', lb).textContent = d.title;
      $('.lightbox__era', lb).textContent = d.era;
      $('.lightbox__desc', lb).textContent = d.desc;
    }
    function ir(delta) {
      const lista = visiveis();
      atual = (atual + delta + lista.length) % lista.length;
      lb.classList.add('is-swapping');
      setTimeout(() => { preencher(lista[atual]); lb.classList.remove('is-swapping'); }, 220);
    }
    pecas.forEach((p) => $('.specimen__open', p).addEventListener('click', () => {
      atual = visiveis().indexOf(p);
      preencher(p);
      lb.showModal();
    }));
    $('.lightbox__close', lb).addEventListener('click', () => lb.close());
    $('.lightbox__prev', lb).addEventListener('click', () => ir(-1));
    $('.lightbox__next', lb).addEventListener('click', () => ir(1));
    lb.addEventListener('click', (e) => { if (e.target === lb) lb.close(); });
    lb.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight') ir(1);
      if (e.key === 'ArrowLeft') ir(-1);
    });
  }

  /* ---------- Poeira flutuando no fundo ---------- */
  const canvas = $('.dust');
  if (canvas && !reduzido) {
    const ctx = canvas.getContext('2d');
    let w;
    let h;
    let cor = '#e0a458';
    const n = innerWidth < 700 ? 28 : 60;
    const ps = [];
    const dimensionar = () => {
      const dpr = Math.min(devicePixelRatio || 1, 2);
      w = canvas.width = innerWidth * dpr;
      h = canvas.height = innerHeight * dpr;
    };
    dimensionar();
    addEventListener('resize', dimensionar);
    for (let i = 0; i < n; i++) {
      ps.push({ x: Math.random(), y: Math.random(), r: Math.random() * 1.6 + 0.4, v: Math.random() * 0.00025 + 0.00008, a: Math.random() * 0.5 + 0.15, o: Math.random() * Math.PI * 2 });
    }
    setInterval(() => { cor = getComputedStyle(body).getPropertyValue('--accent').trim() || cor; }, 400);
    const desenhar = (t) => {
      ctx.clearRect(0, 0, w, h);
      ctx.fillStyle = cor;
      ps.forEach((p) => {
        p.y -= p.v;
        if (p.y < -0.02) { p.y = 1.02; p.x = Math.random(); }
        const x = (p.x + Math.sin(t / 4000 + p.o) * 0.01) * w;
        ctx.globalAlpha = p.a * (0.6 + Math.sin(t / 1200 + p.o) * 0.4);
        ctx.beginPath();
        ctx.arc(x, p.y * h, p.r * (w / innerWidth), 0, Math.PI * 2);
        ctx.fill();
      });
      requestAnimationFrame(desenhar);
    };
    requestAnimationFrame(desenhar);
  }
})();

/* ---------- Botão do painel do GitHub: mostra quantos arquivos mudaram ---------- */
(() => {
  const badge = document.querySelector('.dev-sync__badge');
  if (!badge) return;
  fetch('sync.php', { method: 'POST', headers: { 'X-Museu-Sync': '1' }, body: new URLSearchParams({ acao: 'status' }) })
    .then((r) => r.json())
    .then(({ arquivos }) => {
      badge.hidden = !arquivos.length;
      badge.textContent = arquivos.length;
    })
    .catch(() => {});
})();

/* ---------- Carrossel de fotos (seção "O museu") ---------- */
(() => {
  const box = document.querySelector('.carousel');
  if (!box) return;
  const slides = [...box.querySelectorAll('.carousel__slide')];
  const dots = [...box.querySelectorAll('.carousel__dots button')];
  const contador = box.querySelector('.carousel__count b');
  const reduzido = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const DURACAO = 5000;
  let atual = 0;
  let timer;
  let restante = DURACAO;
  let inicio;

  box.style.setProperty('--dur', `${DURACAO}ms`);

  function ir(n) {
    atual = (n + slides.length) % slides.length;
    slides.forEach((s, i) => {
      s.classList.toggle('is-active', i === atual);
      s.setAttribute('aria-hidden', String(i !== atual));
    });
    dots.forEach((d, i) => {
      d.classList.toggle('is-done', i < atual);
      d.classList.remove('is-active');
    });
    void box.offsetWidth; // reinicia a barra de progresso
    dots[atual].classList.add('is-active');
    contador.textContent = String(atual + 1).padStart(2, '0');
    agendar(DURACAO);
  }

  function agendar(ms) {
    clearTimeout(timer);
    if (reduzido || box.classList.contains('is-paused')) { restante = ms; return; }
    restante = ms;
    inicio = Date.now();
    timer = setTimeout(() => ir(atual + 1), ms);
  }

  function pausar() {
    if (box.classList.contains('is-paused')) return;
    box.classList.add('is-paused');
    clearTimeout(timer);
    restante -= Date.now() - inicio;
  }
  function continuar() {
    box.classList.remove('is-paused');
    agendar(Math.max(restante, 300));
  }

  box.querySelector('.carousel__prev').addEventListener('click', () => ir(atual - 1));
  box.querySelector('.carousel__next').addEventListener('click', () => ir(atual + 1));
  dots.forEach((d, i) => d.addEventListener('click', () => ir(i)));
  box.addEventListener('mouseenter', pausar);
  box.addEventListener('mouseleave', continuar);
  box.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') ir(atual + 1);
    if (e.key === 'ArrowLeft') ir(atual - 1);
  });

  // arrastar com o dedo no celular
  let x0 = null;
  box.addEventListener('touchstart', (e) => { x0 = e.touches[0].clientX; }, { passive: true });
  box.addEventListener('touchend', (e) => {
    if (x0 === null) return;
    const dx = e.changedTouches[0].clientX - x0;
    if (Math.abs(dx) > 40) ir(atual + (dx < 0 ? 1 : -1));
    x0 = null;
  });

  // só começa a girar quando o carrossel aparece na tela
  new IntersectionObserver(([en]) => {
    if (en.isIntersecting) { box.classList.remove('is-paused'); ir(atual); }
    else pausar();
  }, { threshold: 0.3 }).observe(box);
  box.classList.add('is-paused');
})();

/* ---------- Fotos de fundo: mostra com um fade assim que carregam ---------- */
document.querySelectorAll('.section-photo img, .hero__photo img').forEach((img) => {
  const pronto = () => img.classList.add('is-loaded');
  if (img.complete && img.naturalWidth) pronto();
  else {
    img.addEventListener('load', pronto, { once: true });
    img.addEventListener('error', pronto, { once: true });
  }
});
