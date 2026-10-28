<?php
/**
 * Buscador do site.
 *  - search.php?q=mamute&format=json  → JSON (usado pelo campo de busca do topo)
 *  - search.php?q=mamute              → página de resultados (funciona sem JavaScript)
 */
require_once __DIR__ . '/includes/data.php';

$q = trim((string) ($_GET['q'] ?? ''));
$q = mb_substr($q, 0, 80);
$resultados = $q === '' ? [] : buscar($q, ($_GET['format'] ?? '') === 'json' ? 8 : 30);

if (($_GET['format'] ?? '') === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['q' => $q, 'resultados' => $resultados], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

$pagina = 'busca';
$titulo = 'Busca';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero scene" data-scene="cave">
  <div class="wrap">
    <p class="eyebrow">Busca</p>
    <h1><?= $q === '' ? 'O que você quer <em>escavar</em>?' : 'Resultados para <em>“' . e($q) . '”</em>' ?></h1>
    <?php if ($q !== ''): ?>
      <p><?= count($resultados) ?> resultado<?= count($resultados) === 1 ? '' : 's' ?> encontrado<?= count($resultados) === 1 ? '' : 's' ?>.</p>
    <?php endif; ?>

    <ul class="search-page">
      <?php foreach ($resultados as $r): ?>
        <li>
          <a href="<?= e($r['url']) ?>">
            <span class="tag"><?= e($r['secao']) ?></span>
            <strong><?= e($r['titulo']) ?></strong>
            <small><?= e($r['texto']) ?></small>
          </a>
        </li>
      <?php endforeach; ?>
      <?php if ($q !== '' && !$resultados): ?>
        <li class="search-page__empty">Nada encontrado. Tente “dinossauro”, “mamute”, “terça” ou “kids”.</li>
      <?php endif; ?>
    </ul>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
