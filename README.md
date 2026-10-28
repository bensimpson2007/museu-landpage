# Museu Paleo

Site institucional de um museu de pré-história (dinossauros, mamutes e fósseis), feito com PHP, HTML, CSS e JavaScript.

## Páginas

- **Home** (`index.php`): o museu, guia de horários, valores, área Kids e interesses. O fundo muda de cenário a cada seção.
- **Exposições** (`exposicoes.php`): galeria do acervo com filtros e visualização ampliada.
- **Sobre Nós** (`sobre.php`): história do museu em linha do tempo.
- **Busca** (`search.php`): buscador por palavras-chave do site.

## Como rodar

Precisa do PHP 8 instalado. Dentro desta pasta:

```bash
php -S localhost:8080
```

Depois abra http://localhost:8080 no navegador.

## Onde editar o conteúdo

Horários, preços, peças do acervo e a linha do tempo ficam em `includes/data.php`.
