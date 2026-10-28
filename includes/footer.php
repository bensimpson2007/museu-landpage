</main>

<footer class="footer" data-scene="cave">
  <div class="footer__grid">
    <div>
      <a class="logo" href="index.php">
        <img src="assets/img/osso.svg" alt="" width="34" height="34">
        <span>Museu <em>Paleo</em></span>
      </a>
      <p class="footer__slogan"><?= MUSEU_SLOGAN ?>.</p>
    </div>
    <div>
      <h4>Visite</h4>
      <p>Rua das Escavações, 65 — Centro</p>
      <p>Terça a domingo · Segunda fechado</p>
    </div>
    <div>
      <h4>Explore</h4>
      <?php foreach ($NAV as $item): ?>
        <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
      <?php endforeach; ?>
    </div>
    <div>
      <h4>Contato</h4>
      <p>contato@museupaleo.org</p>
      <p>(11) 4000-0065</p>
    </div>
  </div>
  <p class="footer__copy">© <?= date('Y') ?> <?= MUSEU_NOME ?> · Projeto fictício de estudo</p>
</footer>

<?php if (eh_local()): /* ferramenta de desenvolvimento: não aparece fora do seu computador */ ?>
<a class="dev-sync" href="painel.php" target="_blank" rel="noopener" title="Painel do GitHub (abre em nova aba)" aria-label="Abrir painel do GitHub em nova aba">
  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12a8 8 0 0 1 14-5.3M20 12a8 8 0 0 1-14 5.3"/><path d="M18 3v4h-4M6 21v-4h4"/></svg>
  <span class="dev-sync__badge" hidden></span>
</a>
<?php endif; ?>

<script src="assets/js/main.js" defer></script>
</body>
</html>
