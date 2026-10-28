<?php
/**
 * Conteúdo central do Museu Paleo.
 * Tudo que aparece nas páginas (e no buscador) sai daqui.
 */

date_default_timezone_set('America/Sao_Paulo');

const MUSEU_NOME   = 'Museu Paleo';
const MUSEU_SLOGAN = 'Ossos que contam a história da Terra';

/* ---------- Navegação principal (header) ---------- */
$NAV = [
    ['id' => 'home',       'label' => 'Home',        'href' => 'index.php'],
    ['id' => 'interesses', 'label' => 'Interesses',  'href' => 'index.php#interesses'],
    ['id' => 'guia',       'label' => 'Guia de Horários', 'href' => 'index.php#guia'],
    ['id' => 'valores',    'label' => 'Valores',     'href' => 'index.php#valores'],
    ['id' => 'kids',       'label' => 'Kids',        'href' => 'index.php#kids'],
    ['id' => 'exposicoes', 'label' => 'Exposições',  'href' => 'exposicoes.php'],
    ['id' => 'sobre',      'label' => 'Sobre Nós',   'href' => 'sobre.php'],
];

/* ---------- Dias e horários (0 = domingo ... 6 = sábado) ---------- */
$HORARIOS = [
    1 => ['dia' => 'Segunda-feira', 'abre' => null,    'fecha' => null,    'nota' => 'Fechado para cuidado do acervo'],
    2 => ['dia' => 'Terça-feira',   'abre' => '09:00', 'fecha' => '18:00', 'nota' => 'Entrada gratuita o dia todo'],
    3 => ['dia' => 'Quarta-feira',  'abre' => '09:00', 'fecha' => '18:00', 'nota' => ''],
    4 => ['dia' => 'Quinta-feira',  'abre' => '09:00', 'fecha' => '18:00', 'nota' => ''],
    5 => ['dia' => 'Sexta-feira',   'abre' => '09:00', 'fecha' => '18:00', 'nota' => ''],
    6 => ['dia' => 'Sábado',        'abre' => '09:00', 'fecha' => '20:00', 'nota' => 'Noite no Museu: visita com lanternas às 18h'],
    0 => ['dia' => 'Domingo',       'abre' => '10:00', 'fecha' => '17:00', 'nota' => 'Hora da História Kids às 11h e 15h'],
];

/** Situação atual do museu, calculada no servidor. */
function status_agora(array $horarios): array
{
    $hoje  = (int) date('w');
    $agora = date('H:i');
    $h     = $horarios[$hoje];

    if ($h['abre'] === null) {
        return ['aberto' => false, 'texto' => 'Fechado hoje', 'hoje' => $hoje];
    }
    if ($agora < $h['abre']) {
        return ['aberto' => false, 'texto' => "Abre hoje às {$h['abre']}", 'hoje' => $hoje];
    }
    if ($agora >= $h['fecha']) {
        return ['aberto' => false, 'texto' => 'Fechado agora', 'hoje' => $hoje];
    }
    return ['aberto' => true, 'texto' => "Aberto agora · até {$h['fecha']}", 'hoje' => $hoje];
}

/* ---------- Ingressos ---------- */
$PRECOS = [
    ['nome' => 'Inteira',     'valor' => 40, 'desc' => 'Acesso a todas as galerias e ao laboratório aberto.', 'destaque' => false],
    ['nome' => 'Meia-entrada','valor' => 20, 'desc' => 'Estudantes, professores, idosos e PcD, com documento.', 'destaque' => false],
    ['nome' => 'Família',     'valor' => 95, 'desc' => '2 adultos + até 2 crianças, com uma atividade Kids inclusa.', 'destaque' => true],
    ['nome' => 'Kids (3–12)', 'valor' => 15, 'desc' => 'Crianças até 2 anos não pagam.', 'destaque' => false],
];
$PRECO_NOTAS = [
    'Terça-feira: entrada gratuita para todos.',
    'Escolas públicas: visita gratuita com agendamento.',
    'Escavação Kids: + R$ 10 por criança (sessões de 40 min).',
];

/* ---------- Área Kids ---------- */
$KIDS = [
    ['titulo' => 'Caixa de Escavação', 'icone' => 'pa',      'texto' => 'Pincel, pá e muita areia: os pequenos desenterram réplicas de ossos como paleontólogos de verdade.'],
    ['titulo' => 'Hora da História',   'icone' => 'livro',   'texto' => 'Aos domingos, contadores levam a turma numa viagem até o Cretáceo — com sons, sombras e fantoches.'],
    ['titulo' => 'Oficina de Moldes',  'icone' => 'pegada',  'texto' => 'Cada criança faz o molde de uma pegada de dinossauro em gesso e leva para casa.'],
];
$CURIOSIDADES = [
    'O fêmur de um Tiranossauro podia passar de 1,30 m — maior que muitas crianças de 8 anos!',
    'Mamutes-lanosos ainda viviam numa ilha do Ártico quando as pirâmides do Egito já existiam.',
    'Ossos viram fósseis quando minerais da água tomam, aos poucos, o lugar do material original.',
    'Os dentes do T. rex eram trocados a vida toda: quando um caía, outro já estava crescendo.',
    'Amonites são parentes antigos das lulas e dos polvos — e algumas tinham concha de 2 metros.',
    'As aves de hoje são dinossauros. Sim: a galinha é prima distante do Velociraptor.',
    'A presa de um mamute podia medir 4 metros e pesar mais de 90 kg.',
];

/* ---------- Exposições / galeria ---------- */
$CATEGORIAS = [
    'dinossauros' => 'Dinossauros',
    'gelo'        => 'Era do Gelo',
    'mares'       => 'Mares Antigos',
    'vestigios'   => 'Vestígios',
];

$ACERVO = [
    ['id' => 'cranio-rex',  'cat' => 'dinossauros', 'img' => 'cranio-rex.svg',  'titulo' => 'Crânio de Tiranossauro',   'era' => 'Cretáceo · 67 milhões de anos', 'desc' => 'Réplica em tamanho real moldada a partir de um crânio de 1,5 m. As cavidades revelam onde ficavam músculos de mordida capazes de esmagar ossos.'],
    ['id' => 'femur',       'cat' => 'dinossauros', 'img' => 'osso.svg',        'titulo' => 'Fêmur de Saurópode',       'era' => 'Jurássico · 150 milhões de anos', 'desc' => 'Peça original de 1,8 m, a mais pesada do acervo. Foi preciso um guindaste para trazê-la até a galeria principal.'],
    ['id' => 'garra',       'cat' => 'dinossauros', 'img' => 'garra.svg',       'titulo' => 'Garra de Raptor',          'era' => 'Cretáceo · 75 milhões de anos', 'desc' => 'A garra em forma de foice ficava no segundo dedo do pé e era mantida erguida para não perder o fio.'],
    ['id' => 'dente',       'cat' => 'dinossauros', 'img' => 'dente.svg',       'titulo' => 'Dente serrilhado',         'era' => 'Cretáceo · 68 milhões de anos', 'desc' => 'Repare nas serrilhas da borda: funcionavam como uma faca de pão para rasgar carne.'],
    ['id' => 'vertebras',   'cat' => 'dinossauros', 'img' => 'vertebras.svg',   'titulo' => 'Coluna vertebral',         'era' => 'Jurássico · 155 milhões de anos', 'desc' => 'Sequência de vértebras caudais encontrada articulada — rara chance de ver a cauda como ela era em vida.'],
    ['id' => 'mamute',      'cat' => 'gelo',        'img' => 'mamute.svg',      'titulo' => 'Mamute-lanoso',            'era' => 'Pleistoceno · 20 mil anos', 'desc' => 'Esqueleto montado com 3,4 m de altura. As presas curvas eram usadas para afastar a neve e encontrar pasto.'],
    ['id' => 'presa',       'cat' => 'gelo',        'img' => 'presa.svg',       'titulo' => 'Presa de mamute',          'era' => 'Pleistoceno · 35 mil anos', 'desc' => 'Os anéis internos da presa funcionam como os de uma árvore e contam a história de cada inverno do animal.'],
    ['id' => 'amonite',     'cat' => 'mares',       'img' => 'amonite.svg',     'titulo' => 'Amonite',                  'era' => 'Jurássico · 180 milhões de anos', 'desc' => 'Concha espiral de um molusco marinho. As câmaras internas controlavam a flutuação, como um submarino.'],
    ['id' => 'trilobita',   'cat' => 'mares',       'img' => 'trilobita.svg',   'titulo' => 'Trilobita',                'era' => 'Cambriano · 500 milhões de anos', 'desc' => 'Um dos primeiros animais com olhos complexos. Viveu nos oceanos por quase 300 milhões de anos.'],
    ['id' => 'peixe',       'cat' => 'mares',       'img' => 'peixe.svg',       'titulo' => 'Peixe fossilizado',        'era' => 'Cretáceo · 110 milhões de anos', 'desc' => 'Vindo da Chapada do Araripe, conserva até as finas espinhas das nadadeiras.'],
    ['id' => 'pegada',      'cat' => 'vestigios',   'img' => 'pegada.svg',      'titulo' => 'Pegada tridáctila',        'era' => 'Jurássico · 140 milhões de anos', 'desc' => 'Três dedos e 40 cm de comprimento: um terópode passou por aqui caminhando sobre lama mole.'],
    ['id' => 'samambaia',   'cat' => 'vestigios',   'img' => 'samambaia.svg',   'titulo' => 'Samambaia fóssil',         'era' => 'Carbonífero · 300 milhões de anos', 'desc' => 'Folhas como esta formavam as florestas que, comprimidas, viraram o carvão mineral de hoje.'],
];

/* ---------- Destaques da home (seção Interesses) ---------- */
$DESTAQUES = [
    ['titulo' => 'Gigantes do Cretáceo',  'img' => 'cranio-rex.svg', 'texto' => 'Frente a frente com o crânio do maior predador terrestre e a garra que inspirou lendas.', 'tag' => 'Galeria 1'],
    ['titulo' => 'Era do Gelo: Mamutes',  'img' => 'mamute.svg',     'texto' => 'Um mamute-lanoso montado osso a osso, com presas de quase quatro metros.', 'tag' => 'Galeria 2'],
    ['titulo' => 'Mares Antigos',         'img' => 'amonite.svg',    'texto' => 'Amonites, trilobitas e peixes de 500 milhões de anos, quando tudo ainda era oceano.', 'tag' => 'Galeria 3'],
    ['titulo' => 'Laboratório Aberto',    'img' => 'vertebras.svg',  'texto' => 'Pelo vidro, veja nossos paleontólogos limpando e montando ossos recém-chegados de campo.', 'tag' => 'Ao vivo'],
];

/* ---------- História (Sobre Nós) ---------- */
$LINHA_DO_TEMPO = [
    ['ano' => '1958', 'titulo' => 'Uma caixa de ossos',      'texto' => 'A paleontóloga Helena Ravel guarda no porão de casa as primeiras peças encontradas no interior do estado.'],
    ['ano' => '1966', 'titulo' => 'Portas abertas',          'texto' => 'Com doações da comunidade, o acervo ganha um casarão no centro e vira o Museu Paleo.'],
    ['ano' => '1979', 'titulo' => 'O primeiro gigante',      'texto' => 'Chega o fêmur de saurópode de 1,8 m — até hoje a peça mais pesada da casa.'],
    ['ano' => '1994', 'titulo' => 'A ala da Era do Gelo',    'texto' => 'Um mamute-lanoso é montado osso a osso e passa a receber os visitantes no saguão.'],
    ['ano' => '2008', 'titulo' => 'Laboratório de vidro',    'texto' => 'O trabalho de preparação de fósseis passa a acontecer à vista do público.'],
    ['ano' => '2017', 'titulo' => 'Nasce o Paleo Kids',      'texto' => 'Caixa de escavação, oficinas e a Hora da História trazem as crianças para o centro do museu.'],
    ['ano' => '2025', 'titulo' => 'Nova iluminação',         'texto' => 'As galerias ganham luz cênica pensada para revelar cada textura dos ossos.'],
];

/* ---------- Índice do buscador ---------- */
function indice_busca(): array
{
    global $HORARIOS, $PRECOS, $PRECO_NOTAS, $KIDS, $ACERVO, $DESTAQUES, $LINHA_DO_TEMPO, $CATEGORIAS;

    $idx = [
        ['titulo' => 'Sobre o museu',   'url' => 'index.php#inicio',     'secao' => 'Home',       'texto' => 'Museu de paleontologia dedicado à pré-história: dinossauros, mamutes e os ossos e fósseis que restaram desses animais.', 'chaves' => 'home inicio museu paleontologia pre-historia ossos fosseis esqueleto'],
        ['titulo' => 'Guia de Horários','url' => 'index.php#guia',       'secao' => 'Guia',       'texto' => 'Dias e horários em que o museu está aberto. Segunda-feira fechado.', 'chaves' => 'horario horarios dias aberto fechado funcionamento guia visita agenda trabalho'],
        ['titulo' => 'Valores e ingressos', 'url' => 'index.php#valores','secao' => 'Valores',    'texto' => 'Inteira, meia-entrada, família e kids. Terça gratuita.', 'chaves' => 'preco precos valor valores ingresso ingressos comprar meia inteira gratis gratuito'],
        ['titulo' => 'Paleo Kids',      'url' => 'index.php#kids',       'secao' => 'Kids',       'texto' => 'Área de brincadeira e de histórias para crianças.', 'chaves' => 'kids criancas infantil brincadeira historia escola familia'],
        ['titulo' => 'Interesses',      'url' => 'index.php#interesses', 'secao' => 'Interesses', 'texto' => 'Destaques das galerias do museu.', 'chaves' => 'interesses destaques exposicoes galerias'],
        ['titulo' => 'Exposições',      'url' => 'exposicoes.php',       'secao' => 'Exposições', 'texto' => 'Galeria completa com as peças do acervo.', 'chaves' => 'exposicoes galeria acervo pecas fotos imagens'],
        ['titulo' => 'Sobre Nós',       'url' => 'sobre.php',            'secao' => 'Sobre Nós',  'texto' => 'A história do Museu Paleo desde 1958.', 'chaves' => 'sobre historia fundacao helena ravel missao quem somos'],
    ];

    foreach ($HORARIOS as $h) {
        $quando = $h['abre'] ? "{$h['abre']} às {$h['fecha']}" : 'fechado';
        $idx[] = ['titulo' => $h['dia'], 'url' => 'index.php#guia', 'secao' => 'Guia', 'texto' => trim("$quando. {$h['nota']}", ' .') . '.', 'chaves' => 'horario dia'];
    }
    foreach ($PRECOS as $p) {
        $idx[] = ['titulo' => "Ingresso {$p['nome']}", 'url' => 'index.php#valores', 'secao' => 'Valores', 'texto' => "R$ {$p['valor']} — {$p['desc']}", 'chaves' => 'preco ingresso valor'];
    }
    foreach ($PRECO_NOTAS as $n) {
        $idx[] = ['titulo' => 'Condição especial', 'url' => 'index.php#valores', 'secao' => 'Valores', 'texto' => $n, 'chaves' => 'preco gratis desconto'];
    }
    foreach ($KIDS as $k) {
        $idx[] = ['titulo' => $k['titulo'], 'url' => 'index.php#kids', 'secao' => 'Kids', 'texto' => $k['texto'], 'chaves' => 'kids criancas'];
    }
    foreach ($DESTAQUES as $d) {
        $idx[] = ['titulo' => $d['titulo'], 'url' => 'index.php#interesses', 'secao' => 'Interesses', 'texto' => $d['texto'], 'chaves' => 'destaque galeria'];
    }
    foreach ($ACERVO as $a) {
        $idx[] = ['titulo' => $a['titulo'], 'url' => "exposicoes.php#{$a['id']}", 'secao' => 'Exposições · ' . $CATEGORIAS[$a['cat']], 'texto' => "{$a['era']}. {$a['desc']}", 'chaves' => $a['cat'] . ' fossil osso'];
    }
    foreach ($LINHA_DO_TEMPO as $t) {
        $idx[] = ['titulo' => "{$t['ano']} · {$t['titulo']}", 'url' => 'sobre.php#historia', 'secao' => 'Sobre Nós', 'texto' => $t['texto'], 'chaves' => 'historia'];
    }
    return $idx;
}

/** Minúsculas e sem acento, para comparar "pré-história" com "pre historia". */
function normalizar(string $s): string
{
    $s = mb_strtolower($s, 'UTF-8');
    $s = strtr($s, [
        'á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ä'=>'a','é'=>'e','ê'=>'e','è'=>'e','ë'=>'e',
        'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i','ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
        'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u','ç'=>'c','–'=>' ','—'=>' ','-'=>' ',
    ]);
    return preg_replace('/\s+/', ' ', trim($s));
}

/** Busca por palavras-chave com pontuação simples (título vale mais que texto). */
function buscar(string $q, int $limite = 8): array
{
    $termos = array_filter(explode(' ', normalizar($q)), fn($t) => mb_strlen($t) >= 2);
    if (!$termos) return [];

    $resultados = [];
    foreach (indice_busca() as $item) {
        $titulo = normalizar($item['titulo']);
        $corpo  = normalizar($item['texto'] . ' ' . $item['secao']);
        $chaves = normalizar($item['chaves']);
        $pontos = 0;
        foreach ($termos as $t) {
            $achou = false;
            if (str_contains($titulo, $t)) { $pontos += 5; $achou = true; }
            if (str_contains($chaves, $t)) { $pontos += 3; $achou = true; }
            if (str_contains($corpo, $t))  { $pontos += 1; $achou = true; }
            if (!$achou) { $pontos = 0; break; } // todos os termos precisam aparecer
        }
        if ($pontos > 0) {
            unset($item['chaves']);
            $item['pontos'] = $pontos;
            $resultados[] = $item;
        }
    }
    usort($resultados, fn($a, $b) => $b['pontos'] <=> $a['pontos']);
    return array_slice($resultados, 0, $limite);
}

/** True quando o site está rodando no próprio computador (php -S localhost). */
function eh_local(): bool
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $host = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));
    return in_array($ip, ['127.0.0.1', '::1'], true) && in_array($host, ['localhost', '127.0.0.1', '[::1]'], true);
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function reais(int $v): string
{
    return 'R$ ' . number_format($v, 0, ',', '.');
}
