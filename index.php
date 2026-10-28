<?php
$pagina = 'home';
$titulo = 'Home';
require __DIR__ . '/includes/header.php';
$cenas = ['inicio' => 'Início', 'museu' => 'O museu', 'guia' => 'Dias', 'valores' => 'Valores', 'kids' => 'Kids', 'interesses' => 'Interesses'];
$ICONES = [
    'pa'     => '<svg viewBox="0 0 24 24"><path d="M14 4l6 6M17 7L9 15"/><path d="M9 15l-4.5 1.5a2 2 0 0 0-1 3l1 1a2 2 0 0 0 3-1L9 15z"/></svg>',
    'livro'  => '<svg viewBox="0 0 24 24"><path d="M3 5c3-1.5 6-1.5 9 0v14c-3-1.5-6-1.5-9 0zM21 5c-3-1.5-6-1.5-9 0v14c3-1.5 6-1.5 9 0z"/></svg>',
    'pegada' => '<svg viewBox="0 0 24 24"><path d="M12 20c-3 0-4-2-3-4l3-12 3 12c1 2 0 4-3 4zM9 15L4 8M15 15l5-7"/></svg>',
];
?>

<nav class="scene-dots" aria-label="Seções da página">
  <?php foreach ($cenas as $id => $nome): ?>
    <a href="#<?= $id ?>" data-dot="<?= $id ?>"><span><?= e($nome) ?></span></a>
  <?php endforeach; ?>
</nav>

<!-- ============ 1 · O MUSEU (cenário caverna) ============ -->
<section class="scene hero" id="inicio" data-scene="cave">
  <figure class="hero__photo" aria-hidden="true">
    <img src="assets/img/hero-cranios.jpg" alt="" width="1920" height="1080">
  </figure>
  <span class="hero__frame" aria-hidden="true"></span>

  <div class="hero__inner">
    <div class="hero__text">
      <?php [$hAbre, $mAbre] = explode(":", $HORARIOS[3]["abre"]); [$hFecha, $mFecha] = explode(":", $HORARIOS[3]["fecha"]); ?>
      <p class="hero__hours reveal">Exposição: <?= (int) $hAbre ?><sup><?= $mAbre ?></sup> – <?= (int) $hFecha ?><sup><?= $mFecha ?></sup></p>
      <h1 class="hero__title reveal">Bem-vindo ao<br>Museu Paleo</h1>
      <p class="hero__sub reveal"><span>Ossos que contam</span> a história da Terra</p>
      <a class="btn-line reveal" href="#guia">Planeje sua visita</a>
    </div>

    <aside class="hero__cards" aria-label="Galerias em destaque">
      <?php foreach (array_slice($DESTAQUES, 0, 3) as $i => $d): ?>
        <a class="hero-card reveal" href="exposicoes.php" style="--i:<?= $i + 2 ?>">
          <img class="hero-card__bg" src="assets/img/<?= e($d["foto"]) ?>" alt="">
          <strong><?= e($d["titulo"]) ?></strong>
          <span>Visitar galeria <i aria-hidden="true">⟶</i></span>
        </a>
      <?php endforeach; ?>
    </aside>
  </div>

  <a class="scroll-hint" href="#museu" aria-label="Rolar para conhecer o museu">
    <span></span>role para escavar
  </a>
</section>

<!-- ============ 1b · SOBRE O MUSEU (mesmo cenário) ============ -->
<section class="scene" id="museu" data-scene="cave">
  <div class="wrap about-intro">
    <div>
      <p class="eyebrow reveal">Paleontologia · desde 1966</p>
      <h2 class="about-intro__title reveal">Os <em>ossos</em> guardam a memória da Terra.</h2>
    </div>
    <div>
      <p class="hero__lead reveal">
        O Museu Paleo reúne mais de 12 mil fósseis de dinossauros, mamutes e criaturas
        dos mares antigos. Aqui, cada fêmur, crânio e vértebra é uma pista: o que
        restou de animais que viveram há milhões de anos — e que ainda tem muito a dizer.
      </p>
      <p class="hero__lead reveal">
        Caminhe entre esqueletos montados osso a osso, acompanhe pelo vidro o trabalho
        dos paleontólogos e descubra como uma pedra vira história.
      </p>
      <div class="hero__cta reveal">
        <a class="btn btn--solid" href="exposicoes.php">Ver exposições</a>
        <a class="btn btn--ghost" href="#guia">Planejar visita</a>
      </div>
      <dl class="stats reveal">
        <div><dt data-count="12000">12.000</dt><dd>fósseis no acervo</dd></div>
        <div><dt data-count="500">500</dt><dd>milhões de anos de história</dd></div>
        <div><dt data-count="3">3</dt><dd>galerias permanentes</dd></div>
      </dl>
    </div>
  </div>
</section>

<!-- ============ 2 · DIAS (cenário floresta jurássica) ============ -->
<section class="scene" id="guia" data-scene="forest">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">Guia de horários</p>
      <h2>Quando a pré-história está <em>de portas abertas</em></h2>
      <p>Funcionamos de terça a domingo. A última entrada é sempre uma hora antes do fechamento —
        reserve cerca de duas horas para ver tudo com calma.</p>
    </header>

    <div class="schedule">
      <ul class="days">
        <?php foreach ([2, 3, 4, 5, 6, 0, 1] as $i => $d):
          $h = $HORARIOS[$d];
          $hoje = $d === $status['hoje']; ?>
          <li class="day reveal <?= $hoje ? 'is-today' : '' ?> <?= $h['abre'] ? '' : 'is-closed' ?>" style="--i:<?= $i ?>">
            <span class="day__name"><?= e($h['dia']) ?><?= $hoje ? ' <b>hoje</b>' : '' ?></span>
            <span class="day__hours"><?= $h['abre'] ? e("{$h['abre']} – {$h['fecha']}") : 'Fechado' ?></span>
            <?php if ($h['nota']): ?><span class="day__note"><?= e($h['nota']) ?></span><?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>

      <aside class="schedule__aside reveal">
        <div class="now <?= $status['aberto'] ? 'is-open' : '' ?>">
          <i></i>
          <strong><?= e($status['texto']) ?></strong>
          <small>Horário de Brasília</small>
        </div>
        <h3>Dicas para a visita</h3>
        <ul class="tips">
          <li>Chegue cedo: os esqueletos ficam mais vazios antes das 11h.</li>
          <li>O laboratório aberto funciona de terça a sexta, das 10h às 16h.</li>
          <li>Fotos sem flash são bem-vindas — o flash desbota os fósseis.</li>
          <li>Guarda-volumes gratuito na entrada.</li>
        </ul>
      </aside>
    </div>
  </div>
</section>

<!-- ============ 3 · VALORES (cenário rocha vulcânica) ============ -->
<section class="scene" id="valores" data-scene="ember">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">Valores</p>
      <h2>Um ingresso, <em>500 milhões de anos</em></h2>
      <p>Todos os ingressos dão acesso às três galerias permanentes e ao laboratório aberto.</p>
    </header>

    <div class="prices">
      <?php foreach ($PRECOS as $i => $p): ?>
        <article class="price reveal <?= $p['destaque'] ? 'is-featured' : '' ?>" style="--i:<?= $i ?>">
          <?php if ($p['destaque']): ?><span class="price__badge">Mais escolhido</span><?php endif; ?>
          <h3><?= e($p['nome']) ?></h3>
          <p class="price__value"><small>R$</small><?= $p['valor'] ?></p>
          <p><?= e($p['desc']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <ul class="price-notes reveal">
      <?php foreach ($PRECO_NOTAS as $n): ?><li><?= e($n) ?></li><?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ 4 · KIDS (cenário noite de histórias) ============ -->
<section class="scene" id="kids" data-scene="kids">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">Paleo Kids</p>
      <h2>Pequenos <em>paleontólogos</em>, grandes descobertas</h2>
      <p>Uma área inteira para brincar, ouvir histórias e colocar a mão na massa — ou melhor, na areia.</p>
    </header>

    <div class="kids">
      <?php foreach ($KIDS as $i => $k): ?>
        <article class="kid-card reveal" style="--i:<?= $i ?>">
          <span class="kid-card__icon" aria-hidden="true"><?= $ICONES[$k['icone']] ?></span>
          <h3><?= e($k['titulo']) ?></h3>
          <p><?= e($k['texto']) ?></p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="fact reveal" aria-live="polite">
      <img src="assets/img/pegada.svg" alt="" class="fact__foot">
      <div>
        <p class="fact__label">Você sabia?</p>
        <p class="fact__text" data-facts='<?= e(json_encode($CURIOSIDADES, JSON_UNESCAPED_UNICODE)) ?>'><?= e($CURIOSIDADES[0]) ?></p>
      </div>
      <button class="btn btn--solid fact__btn" type="button">Outra curiosidade</button>
    </div>
  </div>
</section>

<!-- ============ 5 · INTERESSES (cenário âmbar) ============ -->
<section class="scene" id="interesses" data-scene="amber">
  <div class="wrap">
    <header class="section-head reveal">
      <p class="eyebrow">Interesses</p>
      <h2>Por onde começar a <em>escavar</em></h2>
      <p>Os destaques das nossas galerias. A coleção completa está na página de exposições.</p>
    </header>

    <div class="highlights">
      <?php foreach ($DESTAQUES as $i => $d): ?>
        <a class="highlight reveal" href="exposicoes.php" style="--i:<?= $i ?>">
          <div class="highlight__art"><img src="assets/img/<?= e($d['img']) ?>" alt="" loading="lazy"></div>
          <span class="tag"><?= e($d['tag']) ?></span>
          <h3><?= e($d['titulo']) ?></h3>
          <p><?= e($d['texto']) ?></p>
          <span class="arrow" aria-hidden="true">→</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
