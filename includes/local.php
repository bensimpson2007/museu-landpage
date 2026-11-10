<?php
/**
 * Ajudantes da ferramenta "Atualizar GitHub" (sync.php e painel.php).
 * O site do museu é só HTML/CSS/JS; o PHP aqui serve apenas para o botão rodar o git
 * no seu computador, porque o navegador sozinho não tem permissão para isso.
 */

date_default_timezone_set('America/Sao_Paulo');

const MUSEU_NOME = 'Museu Paleo';

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
