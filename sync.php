<?php
/**
 * Botão "Atualizar GitHub" do site.
 * Só funciona quando o site roda no seu computador (localhost) — nunca em um servidor público.
 *
 *  POST sync.php  acao=status         → mostra quantos arquivos mudaram
 *  POST sync.php  acao=enviar&msg=... → pull, commit e push
 */
require_once __DIR__ . '/includes/data.php';

header('Content-Type: application/json; charset=utf-8');

function responder(int $codigo, array $dados): never
{
    http_response_code($codigo);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit;
}

// Proteções: só localhost, só POST, e só a partir do próprio site
// (o cabeçalho customizado impede que outra página dispare isso pelo seu navegador).
if (!eh_local()) {
    responder(403, ['ok' => false, 'log' => 'Disponível apenas no computador local.']);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || ($_SERVER['HTTP_X_MUSEU_SYNC'] ?? '') !== '1') {
    responder(405, ['ok' => false, 'log' => 'Requisição inválida.']);
}

/** Roda um comando git na pasta do projeto e devolve [código de saída, saída]. */
function git(array $args): array
{
    $env = getenv() + ['GIT_TERMINAL_PROMPT' => '0'];
    $proc = proc_open(array_merge(['git'], $args), [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, __DIR__, $env);
    if (!is_resource($proc)) {
        return [1, 'Não foi possível executar o git.'];
    }
    $saida = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    return [proc_close($proc), rtrim($saida)];
}

$acao = $_POST['acao'] ?? 'status';
$log = [];

if ($acao === 'status') {
    $nomes = ['M' => 'alterado', 'A' => 'novo', 'D' => 'apagado', 'R' => 'renomeado', '??' => 'novo'];
    [, $mudancas] = git(['status', '--porcelain']);
    $arquivos = [];
    foreach (array_filter(preg_split('/\R/', $mudancas)) as $linha) {
        $codigo = trim(substr($linha, 0, 2));
        $arquivos[] = ['estado' => $nomes[$codigo] ?? $nomes[$codigo[0] ?? ''] ?? $codigo, 'arquivo' => substr($linha, 3)];
    }

    [, $log] = git(['log', '-6', '--pretty=format:%h%x1f%an%x1f%ar%x1f%s']);
    $commits = [];
    foreach (array_filter(preg_split('/\R/', $log)) as $linha) {
        [$hash, $autor, $quando, $assunto] = explode("\x1f", $linha);
        $commits[] = compact('hash', 'autor', 'quando', 'assunto');
    }

    [, $ramo] = git(['status', '-sb']);
    $ramo = strtok($ramo, "\n");
    preg_match('/ahead (\d+)/', $ramo, $frente);
    preg_match('/behind (\d+)/', $ramo, $atras);

    [, $remoto] = git(['remote', 'get-url', 'origin']);
    $repo = preg_replace('/\.git$/', '', trim($remoto));

    responder(200, [
        'ok'       => true,
        'arquivos' => $arquivos,
        'commits'  => $commits,
        'aEnviar'  => (int) ($frente[1] ?? 0),
        'aBaixar'  => (int) ($atras[1] ?? 0),
        'repo'     => $repo,
    ]);
}

if ($acao !== 'enviar') {
    responder(400, ['ok' => false, 'log' => 'Ação desconhecida.']);
}

$passos = [
    ['Baixando alterações do GitHub', ['pull', '--rebase', '--autostash']],
    ['Preparando arquivos',           ['add', '-A']],
];
foreach ($passos as [$titulo, $args]) {
    [$codigo, $saida] = git($args);
    $log[] = "▸ $titulo\n$saida";
    if ($codigo !== 0) {
        responder(200, ['ok' => false, 'log' => implode("\n\n", $log)]);
    }
}

[$semMudancas] = git(['diff', '--cached', '--quiet']);
if ($semMudancas === 0) {
    $log[] = 'Nada novo para enviar. O projeto já está atualizado.';
    responder(200, ['ok' => true, 'log' => implode("\n\n", $log)]);
}

$msg = trim(mb_substr((string) ($_POST['msg'] ?? ''), 0, 200));
if ($msg === '') {
    $msg = 'Atualização ' . date('d/m/Y H:i');
}

foreach ([['Salvando suas mudanças', ['commit', '-m', $msg]], ['Enviando para o GitHub', ['push']]] as [$titulo, $args]) {
    [$codigo, $saida] = git($args);
    $log[] = "▸ $titulo\n$saida";
    if ($codigo !== 0) {
        responder(200, ['ok' => false, 'log' => implode("\n\n", $log)]);
    }
}

$log[] = 'Pronto! Tudo sincronizado.';
responder(200, ['ok' => true, 'log' => implode("\n\n", $log)]);
