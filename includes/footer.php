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

<script src="assets/js/main.js" defer></script>
</body>
</html>
