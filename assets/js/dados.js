/* Dados do site usados pelo JavaScript.
 * Na versão PHP, isso vinha de includes/data.php e era processado no servidor.
 * Aqui fica tudo no navegador: horários (para o "Aberto agora") e o índice do buscador.
 * Ao mudar um horário ou texto, lembre de mudar também no HTML das páginas.
 */
window.PALEO = {
    "horarios": {
        "1": {
            "dia": "Segunda-feira",
            "abre": null,
            "fecha": null,
            "nota": "Fechado para cuidado do acervo"
        },
        "2": {
            "dia": "Terça-feira",
            "abre": "09:00",
            "fecha": "18:00",
            "nota": "Entrada gratuita o dia todo"
        },
        "3": {
            "dia": "Quarta-feira",
            "abre": "09:00",
            "fecha": "18:00",
            "nota": ""
        },
        "4": {
            "dia": "Quinta-feira",
            "abre": "09:00",
            "fecha": "18:00",
            "nota": ""
        },
        "5": {
            "dia": "Sexta-feira",
            "abre": "09:00",
            "fecha": "18:00",
            "nota": ""
        },
        "6": {
            "dia": "Sábado",
            "abre": "09:00",
            "fecha": "20:00",
            "nota": "Noite no Museu: visita com lanternas às 18h"
        },
        "0": {
            "dia": "Domingo",
            "abre": "10:00",
            "fecha": "17:00",
            "nota": "Hora da História Kids às 11h e 15h"
        }
    },
    "indice": [
        {
            "titulo": "Sobre o museu",
            "url": "index.html#museu",
            "secao": "Home",
            "texto": "Museu de paleontologia dedicado à pré-história: dinossauros, mamutes e os ossos e fósseis que restaram desses animais.",
            "chaves": "home inicio museu paleontologia pre-historia ossos fosseis esqueleto"
        },
        {
            "titulo": "Guia de Horários",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "Dias e horários em que o museu está aberto. Segunda-feira fechado.",
            "chaves": "horario horarios dias aberto fechado funcionamento guia visita agenda trabalho"
        },
        {
            "titulo": "Valores e ingressos",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "Inteira, meia-entrada, família e kids. Terça gratuita.",
            "chaves": "preco precos valor valores ingresso ingressos comprar meia inteira gratis gratuito"
        },
        {
            "titulo": "Paleo Kids",
            "url": "index.html#kids",
            "secao": "Kids",
            "texto": "Área de brincadeira e de histórias para crianças.",
            "chaves": "kids criancas infantil brincadeira historia escola familia"
        },
        {
            "titulo": "Interesses",
            "url": "index.html#interesses",
            "secao": "Interesses",
            "texto": "Destaques das galerias do museu.",
            "chaves": "interesses destaques exposicoes galerias"
        },
        {
            "titulo": "Exposições",
            "url": "exposicoes.html",
            "secao": "Exposições",
            "texto": "Galeria completa com as peças do acervo.",
            "chaves": "exposicoes galeria acervo pecas fotos imagens"
        },
        {
            "titulo": "Sobre Nós",
            "url": "sobre.html",
            "secao": "Sobre Nós",
            "texto": "A história do Museu Paleo desde 1958.",
            "chaves": "sobre historia fundacao helena ravel missao quem somos"
        },
        {
            "titulo": "Segunda-feira",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "fechado. Fechado para cuidado do acervo.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Terça-feira",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "09:00 às 18:00. Entrada gratuita o dia todo.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Quarta-feira",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "09:00 às 18:00.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Quinta-feira",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "09:00 às 18:00.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Sexta-feira",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "09:00 às 18:00.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Sábado",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "09:00 às 20:00. Noite no Museu: visita com lanternas às 18h.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Domingo",
            "url": "index.html#guia",
            "secao": "Guia",
            "texto": "10:00 às 17:00. Hora da História Kids às 11h e 15h.",
            "chaves": "horario dia"
        },
        {
            "titulo": "Ingresso Inteira",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "R$ 40 — Acesso a todas as galerias e ao laboratório aberto.",
            "chaves": "preco ingresso valor"
        },
        {
            "titulo": "Ingresso Meia-entrada",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "R$ 20 — Estudantes, professores, idosos e PcD, com documento.",
            "chaves": "preco ingresso valor"
        },
        {
            "titulo": "Ingresso Família",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "R$ 95 — 2 adultos + até 2 crianças, com uma atividade Kids inclusa.",
            "chaves": "preco ingresso valor"
        },
        {
            "titulo": "Ingresso Kids (3–12)",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "R$ 15 — Crianças até 2 anos não pagam.",
            "chaves": "preco ingresso valor"
        },
        {
            "titulo": "Condição especial",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "Terça-feira: entrada gratuita para todos.",
            "chaves": "preco gratis desconto"
        },
        {
            "titulo": "Condição especial",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "Escolas públicas: visita gratuita com agendamento.",
            "chaves": "preco gratis desconto"
        },
        {
            "titulo": "Condição especial",
            "url": "index.html#valores",
            "secao": "Valores",
            "texto": "Escavação Kids: + R$ 10 por criança (sessões de 40 min).",
            "chaves": "preco gratis desconto"
        },
        {
            "titulo": "Caixa de Escavação",
            "url": "index.html#kids",
            "secao": "Kids",
            "texto": "Pincel, pá e muita areia: os pequenos desenterram réplicas de ossos como paleontólogos de verdade.",
            "chaves": "kids criancas"
        },
        {
            "titulo": "Hora da História",
            "url": "index.html#kids",
            "secao": "Kids",
            "texto": "Aos domingos, contadores levam a turma numa viagem até o Cretáceo — com sons, sombras e fantoches.",
            "chaves": "kids criancas"
        },
        {
            "titulo": "Oficina de Moldes",
            "url": "index.html#kids",
            "secao": "Kids",
            "texto": "Cada criança faz o molde de uma pegada de dinossauro em gesso e leva para casa.",
            "chaves": "kids criancas"
        },
        {
            "titulo": "Gigantes do Cretáceo",
            "url": "index.html#interesses",
            "secao": "Interesses",
            "texto": "Frente a frente com o crânio do maior predador terrestre e a garra que inspirou lendas.",
            "chaves": "destaque galeria"
        },
        {
            "titulo": "Era do Gelo: Mamutes",
            "url": "index.html#interesses",
            "secao": "Interesses",
            "texto": "Um mamute-lanoso montado osso a osso, com presas de quase quatro metros.",
            "chaves": "destaque galeria"
        },
        {
            "titulo": "Mares Antigos",
            "url": "index.html#interesses",
            "secao": "Interesses",
            "texto": "Amonites, trilobitas e peixes de 500 milhões de anos, quando tudo ainda era oceano.",
            "chaves": "destaque galeria"
        },
        {
            "titulo": "Laboratório Aberto",
            "url": "index.html#interesses",
            "secao": "Interesses",
            "texto": "Pelo vidro, veja nossos paleontólogos limpando e montando ossos recém-chegados de campo.",
            "chaves": "destaque galeria"
        },
        {
            "titulo": "Crânio de Tiranossauro",
            "url": "exposicoes.html#cranio-rex",
            "secao": "Exposições · Dinossauros",
            "texto": "Cretáceo · 67 milhões de anos. Réplica em tamanho real moldada a partir de um crânio de 1,5 m. As cavidades revelam onde ficavam músculos de mordida capazes de esmagar ossos.",
            "chaves": "dinossauros fossil osso"
        },
        {
            "titulo": "Fêmur de Saurópode",
            "url": "exposicoes.html#femur",
            "secao": "Exposições · Dinossauros",
            "texto": "Jurássico · 150 milhões de anos. Peça original de 1,8 m, a mais pesada do acervo. Foi preciso um guindaste para trazê-la até a galeria principal.",
            "chaves": "dinossauros fossil osso"
        },
        {
            "titulo": "Garra de Raptor",
            "url": "exposicoes.html#garra",
            "secao": "Exposições · Dinossauros",
            "texto": "Cretáceo · 75 milhões de anos. A garra em forma de foice ficava no segundo dedo do pé e era mantida erguida para não perder o fio.",
            "chaves": "dinossauros fossil osso"
        },
        {
            "titulo": "Dente serrilhado",
            "url": "exposicoes.html#dente",
            "secao": "Exposições · Dinossauros",
            "texto": "Cretáceo · 68 milhões de anos. Repare nas serrilhas da borda: funcionavam como uma faca de pão para rasgar carne.",
            "chaves": "dinossauros fossil osso"
        },
        {
            "titulo": "Coluna vertebral",
            "url": "exposicoes.html#vertebras",
            "secao": "Exposições · Dinossauros",
            "texto": "Jurássico · 155 milhões de anos. Sequência de vértebras caudais encontrada articulada — rara chance de ver a cauda como ela era em vida.",
            "chaves": "dinossauros fossil osso"
        },
        {
            "titulo": "Mamute-lanoso",
            "url": "exposicoes.html#mamute",
            "secao": "Exposições · Era do Gelo",
            "texto": "Pleistoceno · 20 mil anos. Esqueleto montado com 3,4 m de altura. As presas curvas eram usadas para afastar a neve e encontrar pasto.",
            "chaves": "gelo fossil osso"
        },
        {
            "titulo": "Presa de mamute",
            "url": "exposicoes.html#presa",
            "secao": "Exposições · Era do Gelo",
            "texto": "Pleistoceno · 35 mil anos. Os anéis internos da presa funcionam como os de uma árvore e contam a história de cada inverno do animal.",
            "chaves": "gelo fossil osso"
        },
        {
            "titulo": "Amonite",
            "url": "exposicoes.html#amonite",
            "secao": "Exposições · Mares Antigos",
            "texto": "Jurássico · 180 milhões de anos. Concha espiral de um molusco marinho. As câmaras internas controlavam a flutuação, como um submarino.",
            "chaves": "mares fossil osso"
        },
        {
            "titulo": "Trilobita",
            "url": "exposicoes.html#trilobita",
            "secao": "Exposições · Mares Antigos",
            "texto": "Cambriano · 500 milhões de anos. Um dos primeiros animais com olhos complexos. Viveu nos oceanos por quase 300 milhões de anos.",
            "chaves": "mares fossil osso"
        },
        {
            "titulo": "Peixe fossilizado",
            "url": "exposicoes.html#peixe",
            "secao": "Exposições · Mares Antigos",
            "texto": "Cretáceo · 110 milhões de anos. Vindo da Chapada do Araripe, conserva até as finas espinhas das nadadeiras.",
            "chaves": "mares fossil osso"
        },
        {
            "titulo": "Pegada tridáctila",
            "url": "exposicoes.html#pegada",
            "secao": "Exposições · Vestígios",
            "texto": "Jurássico · 140 milhões de anos. Três dedos e 40 cm de comprimento: um terópode passou por aqui caminhando sobre lama mole.",
            "chaves": "vestigios fossil osso"
        },
        {
            "titulo": "Samambaia fóssil",
            "url": "exposicoes.html#samambaia",
            "secao": "Exposições · Vestígios",
            "texto": "Carbonífero · 300 milhões de anos. Folhas como esta formavam as florestas que, comprimidas, viraram o carvão mineral de hoje.",
            "chaves": "vestigios fossil osso"
        },
        {
            "titulo": "1958 · Uma caixa de ossos",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "A paleontóloga Helena Ravel guarda no porão de casa as primeiras peças encontradas no interior do estado.",
            "chaves": "historia"
        },
        {
            "titulo": "1966 · Portas abertas",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "Com doações da comunidade, o acervo ganha um casarão no centro e vira o Museu Paleo.",
            "chaves": "historia"
        },
        {
            "titulo": "1979 · O primeiro gigante",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "Chega o fêmur de saurópode de 1,8 m — até hoje a peça mais pesada da casa.",
            "chaves": "historia"
        },
        {
            "titulo": "1994 · A ala da Era do Gelo",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "Um mamute-lanoso é montado osso a osso e passa a receber os visitantes no saguão.",
            "chaves": "historia"
        },
        {
            "titulo": "2008 · Laboratório de vidro",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "O trabalho de preparação de fósseis passa a acontecer à vista do público.",
            "chaves": "historia"
        },
        {
            "titulo": "2017 · Nasce o Paleo Kids",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "Caixa de escavação, oficinas e a Hora da História trazem as crianças para o centro do museu.",
            "chaves": "historia"
        },
        {
            "titulo": "2025 · Nova iluminação",
            "url": "sobre.html#historia",
            "secao": "Sobre Nós",
            "texto": "As galerias ganham luz cênica pensada para revelar cada textura dos ossos.",
            "chaves": "historia"
        }
    ]
};
