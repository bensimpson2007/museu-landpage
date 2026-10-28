<?php
/**
 * Painel do GitHub: abre em nova aba pelo botão do canto inferior direito.
 * Só existe quando o site roda no seu computador (localhost).
 */
require_once __DIR__ . '/includes/data.php';

if (!eh_local()) {
    http_response_code(404);
    exit('Página não encontrada.');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex">
<title>Painel do GitHub · <?= MUSEU_NOME ?></title>
<link rel="icon" href="assets/img/osso.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,500;1,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/painel.css">
</head>
<body data-scene="cave" class="painel">

<main class="painel__wrap">
  <header class="painel__head">
    <div>
      <p class="eyebrow">Ferramenta local</p>
      <h1>Painel do <em>GitHub</em></h1>
      <a class="painel__repo" href="#" target="_blank" rel="noopener" hidden></a>
    </div>
    <div class="painel__actions">
      <a class="btn btn--solid" href="index.php">← Ir para o site do museu</a>
      <button class="btn btn--ghost painel__refresh" type="button">Atualizar informações</button>
    </div>
  </header>

  <div class="painel__chips">
    <span class="chip-info" data-info="arquivos">— arquivos mudados</span>
    <span class="chip-info" data-info="enviar">— commits para enviar</span>
    <span class="chip-info" data-info="baixar">— commits para baixar</span>
  </div>

  <div class="painel__grid">
    <section class="painel__card">
      <h2>Mudanças no seu computador</h2>
      <ul class="painel__files"><li class="painel__empty">Carregando…</li></ul>

      <form class="painel__form">
        <label for="msg">O que você mudou?</label>
        <input id="msg" type="text" maxlength="200" placeholder="Ex.: troquei a foto da home (ou deixe em branco)">
        <button class="btn btn--solid" type="submit">Sincronizar com o GitHub</button>
      </form>
      <pre class="painel__log" aria-live="polite"></pre>
    </section>

    <section class="painel__card">
      <h2>Últimos envios</h2>
      <ol class="painel__commits"><li class="painel__empty">Carregando…</li></ol>
    </section>
  </div>

  <p class="painel__note">Esta página só funciona no seu computador. Ela não aparece se o site for publicado na internet.</p>
</main>

<script src="assets/js/painel.js" defer></script>
</body>
</html>
