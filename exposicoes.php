<?php
$pagina = 'exposicoes';
$titulo = 'Exposições';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero scene" data-scene="cave">
  <div class="wrap">
    <p class="eyebrow reveal">Exposições</p>
    <h1 class="reveal">O acervo, <em>peça por peça</em></h1>
    <p class="reveal">Do trilobita de 500 milhões de anos ao mamute que viu os primeiros humanos.
      Clique em qualquer fóssil para vê-lo de perto.</p>
  </div>
</section>

<section class="scene gallery-section" data-scene="amber">
  <div class="wrap">
    <div class="filters reveal" role="group" aria-label="Filtrar por galeria">
      <button class="chip is-active" data-filter="todos" aria-pressed="true">Todos <small><?= count($ACERVO) ?></small></button>
      <?php foreach ($CATEGORIAS as $slug => $nome):
        $qtd = count(array_filter($ACERVO, fn($a) => $a['cat'] === $slug)); ?>
        <button class="chip" data-filter="<?= e($slug) ?>" aria-pressed="false"><?= e($nome) ?> <small><?= $qtd ?></small></button>
      <?php endforeach; ?>
    </div>

    <div class="gallery">
      <?php foreach ($ACERVO as $i => $a): ?>
        <figure class="specimen reveal" id="<?= e($a['id']) ?>" data-cat="<?= e($a['cat']) ?>" style="--i:<?= $i % 4 ?>">
          <button class="specimen__open" type="button"
                  data-title="<?= e($a['titulo']) ?>" data-era="<?= e($a['era']) ?>"
                  data-desc="<?= e($a['desc']) ?>" data-img="assets/img/<?= e($a['img']) ?>"
                  data-cat="<?= e($CATEGORIAS[$a['cat']]) ?>">
            <span class="specimen__art"><img src="assets/img/<?= e($a['img']) ?>" alt="<?= e($a['titulo']) ?>" loading="lazy"></span>
            <figcaption>
              <span class="tag"><?= e($CATEGORIAS[$a['cat']]) ?></span>
              <strong><?= e($a['titulo']) ?></strong>
              <small><?= e($a['era']) ?></small>
            </figcaption>
          </button>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<dialog class="lightbox" aria-labelledby="lb-title">
  <button class="lightbox__close" type="button" aria-label="Fechar">×</button>
  <button class="lightbox__nav lightbox__prev" type="button" aria-label="Peça anterior">‹</button>
  <div class="lightbox__body">
    <div class="lightbox__art"><img src="" alt=""></div>
    <div class="lightbox__info">
      <span class="tag"></span>
      <h2 id="lb-title"></h2>
      <p class="lightbox__era"></p>
      <p class="lightbox__desc"></p>
    </div>
  </div>
  <button class="lightbox__nav lightbox__next" type="button" aria-label="Próxima peça">›</button>
</dialog>

<?php require __DIR__ . '/includes/footer.php'; ?>
