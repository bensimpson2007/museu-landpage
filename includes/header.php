<?php
/** @var string $pagina  id da página atual (home, exposicoes, sobre) */
/** @var string $titulo  título da aba */
require_once __DIR__ . '/data.php';
$status = status_agora($HORARIOS);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($titulo) ?> · <?= MUSEU_NOME ?></title>
<meta name="description" content="<?= MUSEU_NOME ?> — <?= MUSEU_SLOGAN ?>. Dinossauros, mamutes e os ossos da pré-história.">
<meta name="theme-color" content="#0d0b09">
<link rel="icon" href="assets/img/osso.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,500;1,600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<script>document.documentElement.classList.add('js')</script>
</head>
<body data-page="<?= e($pagina) ?>" data-scene="cave">

<div class="scene-bg" aria-hidden="true">
  <div class="scene-layer" data-layer="cave"></div>
  <canvas class="dust"></canvas>
  <div class="grain"></div>
</div>

<a class="skip" href="#conteudo">Pular para o conteúdo</a>

<header class="topbar">
  <div class="topbar__inner">
    <a class="logo" href="index.php" aria-label="<?= MUSEU_NOME ?> — página inicial">
      <img src="assets/img/osso.svg" alt="" width="34" height="34">
      <span>Museu <em>Paleo</em></span>
    </a>

    <form class="search" action="search.php" method="get" role="search" autocomplete="off">
      <label class="sr-only" for="busca">Buscar no site</label>
      <svg class="search__icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
      <input id="busca" name="q" type="search" placeholder="Buscar: mamute, horários, kids…"
             aria-controls="busca-resultados" aria-expanded="false" aria-autocomplete="list">
      <kbd class="search__kbd" aria-hidden="true">/</kbd>
      <div class="search__results" id="busca-resultados" role="listbox" hidden></div>
    </form>

    <span class="status <?= $status['aberto'] ? 'is-open' : '' ?>" title="Horário de Brasília">
      <i></i><?= e($status['texto']) ?>
    </span>

    <button class="burger" aria-label="Abrir menu" aria-expanded="false" aria-controls="menu">
      <span></span><span></span>
    </button>
  </div>

  <nav class="nav" id="menu" aria-label="Principal">
    <?php foreach ($NAV as $item):
      $ativo = ($item['id'] === $pagina) || ($pagina === 'home' && $item['id'] === 'home'); ?>
      <a href="<?= e($item['href']) ?>" data-nav="<?= e($item['id']) ?>" <?= $ativo ? 'aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
    <?php endforeach; ?>
  </nav>
</header>

<main id="conteudo">
