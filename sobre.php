<?php
$pagina = 'sobre';
$titulo = 'Sobre Nós';
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero scene about-hero" data-scene="cave">
  <div class="wrap about-hero__grid">
    <div>
      <p class="eyebrow reveal">Sobre nós</p>
      <h1 class="reveal">Tudo começou com <em>uma caixa de ossos</em></h1>
      <p class="reveal">Em 1958, a paleontóloga Helena Ravel voltou de uma expedição ao interior com uma caixa
        de fragmentos que ninguém sabia identificar. Guardou tudo no porão de casa, catalogou peça por peça
        e começou a mostrar aos vizinhos. Oito anos depois, aquele porão virou o Museu Paleo.</p>
      <p class="reveal">Hoje somos uma equipe de 40 pessoas — paleontólogos, preparadores, educadores e
        contadores de histórias — cuidando de um acervo de mais de 12 mil fósseis.</p>
    </div>
    <figure class="about-hero__art reveal" data-parallax="0.12">
      <img src="assets/img/cranio-rex.svg" alt="Ilustração de crânio de tiranossauro">
    </figure>
  </div>
</section>

<section class="scene" id="historia" data-scene="forest">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">Linha do tempo</p>
      <h2>Camadas da <em>nossa história</em></h2>
      <p>Como nas rochas, cada época deixou sua marca no museu.</p>
    </header>

    <ol class="timeline">
      <?php foreach ($LINHA_DO_TEMPO as $i => $t): ?>
        <li class="timeline__item reveal" style="--i:<?= $i % 2 ?>">
          <span class="timeline__year"><?= e($t['ano']) ?></span>
          <div class="timeline__card">
            <h3><?= e($t['titulo']) ?></h3>
            <p><?= e($t['texto']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="scene" data-scene="ember">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">O que nos move</p>
      <h2>Pesquisar, <em>preservar</em>, contar</h2>
    </header>
    <div class="pillars">
      <article class="pillar reveal" style="--i:0">
        <span class="pillar__n">01</span>
        <h3>Pesquisa</h3>
        <p>Participamos de escavações todos os anos e publicamos o que encontramos, com acesso aberto.</p>
      </article>
      <article class="pillar reveal" style="--i:1">
        <span class="pillar__n">02</span>
        <h3>Preservação</h3>
        <p>Cada osso é limpo, consolidado e guardado com controle de umidade para durar mais milhões de anos.</p>
      </article>
      <article class="pillar reveal" style="--i:2">
        <span class="pillar__n">03</span>
        <h3>Educação</h3>
        <p>Mais de 30 mil estudantes de escolas públicas nos visitam por ano, sem pagar nada.</p>
      </article>
    </div>
  </div>
</section>

<section class="scene cta-band" data-scene="kids">
  <div class="wrap reveal">
    <h2>Venha conhecer de perto</h2>
    <p>Terça a domingo. Às terças, a entrada é gratuita.</p>
    <div class="hero__cta">
      <a class="btn btn--solid" href="index.php#guia">Ver horários</a>
      <a class="btn btn--ghost" href="index.php#valores">Ver valores</a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
