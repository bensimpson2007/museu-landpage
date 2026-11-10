/* Painel do GitHub: mostra o estado do projeto e sincroniza com um clique. */
(() => {
  const $ = (s) => document.querySelector(s);
  const escapar = (s) => String(s).replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  const form = $('.painel__form');
  const botao = form.querySelector('button');
  const log = $('.painel__log');

  const chamar = async (dados) => {
    const r = await fetch('sync.php', { method: 'POST', headers: { 'X-Museu-Sync': '1' }, body: new URLSearchParams(dados) });
    return r.json();
  };

  function chip(nome, valor, texto) {
    const el = $(`[data-info="${nome}"]`);
    el.textContent = `${valor} ${texto}`;
    el.classList.toggle('is-alert', valor > 0);
  }

  async function carregar() {
    try {
      const d = await chamar({ acao: 'status' });

      const repo = $('.painel__repo');
      repo.href = d.repo;
      repo.textContent = d.repo.replace('https://', '');
      repo.hidden = !d.repo;

      chip('arquivos', d.arquivos.length, d.arquivos.length === 1 ? 'arquivo mudado' : 'arquivos mudados');
      chip('enviar', d.aEnviar, 'commits para enviar');
      chip('baixar', d.aBaixar, 'commits para baixar');

      $('.painel__files').innerHTML = d.arquivos.length
        ? d.arquivos.map((f) => `<li><span class="tag" data-estado="${escapar(f.estado)}">${escapar(f.estado)}</span>${escapar(f.arquivo)}</li>`).join('')
        : '<li class="painel__empty">Nenhuma mudança. Está tudo igual ao último envio.</li>';

      $('.painel__commits').innerHTML = d.commits.length
        ? d.commits.map((c) => `<li><strong>${escapar(c.assunto)}</strong><small><code>${escapar(c.hash)}</code> · ${escapar(c.autor)} · ${escapar(c.quando)}</small></li>`).join('')
        : '<li class="painel__empty">Nenhum envio ainda.</li>';
    } catch {
      $('.painel__files').innerHTML = '<li class="painel__empty">Não consegui ler o projeto. O servidor PHP está ligado?</li>';
    }
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    botao.disabled = true;
    botao.textContent = 'Sincronizando…';
    log.className = 'painel__log';
    log.textContent = 'Conversando com o GitHub…';
    try {
      const res = await chamar({ acao: 'enviar', msg: $('#msg').value });
      log.textContent = res.log;
      log.classList.add(res.ok ? 'is-ok' : 'is-erro');
      if (res.ok) $('#msg').value = '';
    } catch {
      log.textContent = 'Não consegui falar com o servidor PHP.';
      log.classList.add('is-erro');
    }
    botao.disabled = false;
    botao.textContent = 'Sincronizar com o GitHub';
    carregar();
  });

  $('.painel__refresh').addEventListener('click', carregar);
  carregar();
})();
