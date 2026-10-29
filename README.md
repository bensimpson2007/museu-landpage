# Museu Paleo · versão sem PHP

Esta é a branch **`versao-sem-php`**: o mesmo site da branch `main`, feito só com **HTML, CSS e JavaScript**.
Ela existe para comparar e aprender o que o PHP fazia na versão original. Leia o [RELATORIO-PHP.md](RELATORIO-PHP.md).

## Páginas

- `index.html`: Home (o museu, horários, valores, Kids e interesses)
- `exposicoes.html`: galeria do acervo com filtros
- `sobre.html`: história do museu
- `busca.html`: resultados do buscador

## Como abrir

Não precisa de servidor PHP. Basta dar dois cliques no `index.html`.

Para testar como num site de verdade, dá para usar qualquer servidor de arquivos estáticos. Por exemplo, com Python, dentro desta pasta:

```bash
python -m http.server 8090
```

Depois abra http://localhost:8090

## Onde editar o conteúdo

Sem PHP, não existe um arquivo central de dados. Cada texto fica direto no HTML da página onde aparece.
A exceção é `assets/js/dados.js`, que guarda os horários (para o "Aberto agora") e o índice do buscador.
Se mudar um horário ou um texto, mude no HTML **e** no `dados.js`.

O cabeçalho e o rodapé estão copiados em cada uma das 4 páginas. Para mudar o menu, é preciso editar as 4.
