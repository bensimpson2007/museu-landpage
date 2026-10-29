# Relatório: o que o PHP fazia no Museu Paleo

Este projeto tem duas versões do mesmo site:

| Branch | Pasta no seu computador | Tecnologias |
|---|---|---|
| `main` | `landing-page/museu` | PHP + HTML + CSS + JavaScript |
| `versao-sem-php` | `landing-page/museu-sem-php` | só HTML + CSS + JavaScript |

Visualmente as duas são **iguais**. A diferença está em **onde** as coisas acontecem e em **quanto trabalho dá manter**.

---

## 1. A ideia principal

- **PHP roda no servidor.** Antes de a página chegar ao navegador, o servidor executa o PHP, monta o HTML e só então envia o resultado pronto.
- **JavaScript roda no navegador.** A página chega como está, e o JS do visitante faz as mudanças depois.
- **HTML puro não "pensa".** É um arquivo fixo: o que está escrito é o que aparece.

```
Versão PHP:      navegador ──pede──▶ servidor (roda PHP, monta HTML) ──envia HTML pronto──▶ navegador
Versão sem PHP:  navegador ──pede──▶ servidor (só entrega o arquivo)   ──envia arquivo─────▶ navegador (JS faz o resto)
```

---

## 2. As funções do PHP neste projeto

### 2.1 Reaproveitar o cabeçalho e o rodapé (`include`)

**Com PHP:** o topo (logo, busca, menu) e o rodapé ficam em `includes/header.php` e `includes/footer.php`. Cada página tem só uma linha para puxar cada um:

```php
<?php require __DIR__ . '/includes/header.php'; ?>
```

**Sem PHP:** o cabeçalho (cerca de 35 linhas) e o rodapé (cerca de 32 linhas) estão **copiados nas 4 páginas**.
Para trocar um item do menu, é preciso editar 4 arquivos e torcer para não esquecer nenhum.

> Foi o ganho mais visível do PHP: **um lugar só para mudar**.

### 2.2 Um arquivo central com todo o conteúdo (`includes/data.php`)

**Com PHP:** horários, preços, as 12 peças do acervo, a linha do tempo, os cards e o carrossel ficam em **listas** dentro do `data.php`. As páginas usam `foreach` para gerar o HTML:

```php
<?php foreach ($ACERVO as $peca): ?>
  <figure class="specimen">... <?= e($peca['titulo']) ?> ...</figure>
<?php endforeach; ?>
```

Para adicionar uma peça nova, basta **uma linha** no `data.php`. Ela aparece na galeria, no filtro, na contagem e no buscador ao mesmo tempo.

**Sem PHP:** as 12 peças estão escritas uma a uma no `exposicoes.html`. Para adicionar uma peça, é preciso copiar um bloco de HTML inteiro e, se quiser que ela apareça na busca, adicionar também no `dados.js`.
Ou seja, **a mesma informação existe em dois lugares**, e é fácil um ficar diferente do outro.

### 2.3 "Aberto agora / Fechado" e o dia de hoje

**Com PHP:** a função `status_agora()` olha o relógio **do servidor**, no fuso de Brasília, e escreve "Aberto agora · até 18:00" já no HTML. O dia de hoje vem marcado com o selo **HOJE**.

**Sem PHP:** a página chega com "Verificando horário…", e o JavaScript calcula com o relógio **do computador do visitante**. Usei `Intl.DateTimeFormat` com o fuso `America/Sao_Paulo` para dar o mesmo resultado em qualquer lugar.
- Funciona, mas depende de o relógio do visitante estar certo.
- Por uma fração de segundo aparece "Verificando horário…" antes do texto certo.

### 2.4 O buscador

**Com PHP:** o `search.php` recebe a palavra, procura no conteúdo do `data.php` e devolve os resultados.
- Pelo campo do topo, o JavaScript pergunta ao servidor (`search.php?format=json&q=mamute`) e mostra a lista.
- Sem JavaScript, o formulário abre uma página de resultados montada pelo próprio servidor.
- O índice de busca é **gerado automaticamente** a partir do conteúdo. Mudou um preço, a busca já sabe.

**Sem PHP:** o índice inteiro (47 itens) fica no `assets/js/dados.js` e é baixado por **todo visitante**, mesmo quem nunca usa a busca. A procura roda no navegador.
- Para um site pequeno como este, funciona muito bem e é até mais rápido (não precisa ir ao servidor).
- Para um site com milhares de páginas, ficaria pesado demais baixar tudo.
- O índice **não se atualiza sozinho**: se um texto mudar no HTML, é preciso mudar no `dados.js` também.

### 2.5 Segurança ao mostrar textos (`htmlspecialchars`)

**Com PHP:** a função `e()` passa todo texto por `htmlspecialchars()` antes de colocar no HTML. Assim, uma busca como `<script>` aparece como texto e não é executada.

**Sem PHP:** o JavaScript faz o mesmo papel com a função `escapar()`. A proteção continua, mas agora depende de você lembrar de usá-la em todo lugar que mostra texto digitado pelo usuário.

### 2.6 O botão "Atualizar GitHub" e o Painel

**Com PHP:** o `sync.php` roda comandos `git` no seu computador (pull, commit, push), e o `painel.php` mostra os arquivos alterados e os últimos envios. O botão redondo só aparece em `localhost`.

**Sem PHP:** **isso não existe.** O navegador, por segurança, **não pode** rodar programas no seu computador. Só um programa no servidor, como o PHP, consegue fazer isso.
Nesta branch, para enviar ao GitHub, use o `sincronizar.bat` ou os comandos do git.

> Esse é o exemplo mais claro de algo que **só** um servidor consegue fazer.

### 2.7 Coisas menores

- **Ano do rodapé:** o PHP escrevia `date('Y')`. Sem PHP, um JS atualiza o ano.
- **Contagem dos filtros** ("Dinossauros 5"): o PHP contava as peças. Sem PHP, os números estão escritos à mão no HTML.
- **Links:** `index.php` virou `index.html`, `search.php` virou `busca.html`.

---

## 3. Comparação em números

| | Com PHP (`main`) | Sem PHP (`versao-sem-php`) |
|---|---|---|
| Arquivos de página | 4 páginas `.php` + 3 `includes` | 4 páginas `.html` + `dados.js` |
| Linhas de código das páginas | ~770 (páginas + includes, sem o painel) | ~1.030 HTML + 382 do `dados.js` |
| Onde fica o menu | 1 arquivo (`header.php`) | copiado em 4 arquivos |
| Adicionar uma peça ao acervo | 1 linha no `data.php` | 1 bloco no HTML + 1 item no `dados.js` |
| Precisa de servidor especial | sim (PHP instalado) | não (abre com dois cliques) |
| Hospedagem grátis (GitHub Pages, Netlify) | **não funciona** no GitHub Pages | **funciona** |
| Botão/painel do GitHub | sim | não é possível |
| "Aberto agora" | calculado no servidor | calculado no navegador |

---

## 4. Quando vale a pena usar PHP

Use PHP (ou outra linguagem de servidor) quando o site precisa de algo que **o navegador não pode ou não deve fazer**:

1. **Guardar dados enviados pelo visitante:** formulário de contato, cadastro, comentários, agendamento de visita, venda de ingressos. Os dados precisam ir para um banco de dados no servidor.
2. **Login e áreas restritas:** senhas e permissões precisam ser verificadas no servidor, onde o visitante não consegue mexer.
3. **Conteúdo que muda sozinho ou vem de um banco de dados:** catálogo com centenas de peças, notícias, estoque, eventos cadastrados por um painel administrativo.
4. **Esconder informações:** chaves de API, senhas de banco e regras de negócio. Tudo que vai para o navegador pode ser visto por qualquer um (botão direito → "Exibir código-fonte").
5. **Muitas páginas com a mesma estrutura:** reaproveitar cabeçalho, rodapé e modelos evita copiar e colar.
6. **Ações no servidor ou no computador:** rodar comandos, gerar PDFs, enviar e-mails, como o painel do GitHub deste projeto.

## 5. Quando NÃO é preciso usar PHP

1. **Sites pequenos e informativos**, com poucas páginas que quase não mudam: portfólio, landing page, cardápio, página de evento. Este museu, sem o painel do GitHub, é um exemplo.
2. **Quando você quer hospedar de graça** e sem configurar servidor: GitHub Pages, Netlify e Vercel servem arquivos HTML/CSS/JS direto.
3. **Interações que acontecem só na tela:** carrossel, filtros da galeria, lightbox, animações, menu. Tudo isso já era JavaScript, mesmo na versão PHP.
4. **Protótipos e estudos**, quando o objetivo é aprender visual e interação.

> Um caminho comum: começar estático (HTML/CSS/JS) e só adicionar PHP quando surgir uma necessidade real, como um formulário que precisa salvar dados.

---

## 6. Resumo

- O PHP deste projeto serviu principalmente para **organizar**: um arquivo de dados, cabeçalho e rodapé reaproveitados, e o buscador gerado automaticamente.
- Ele também fez duas coisas que o HTML sozinho **não consegue**: calcular o horário no servidor e rodar o git pelo botão do site.
- A versão sem PHP prova que, para um site deste tamanho, **dá para viver sem PHP**, com a vantagem de abrir com dois cliques e hospedar de graça.
- O custo é **repetição**: a mesma informação em mais de um lugar e mais cuidado na hora de editar.
