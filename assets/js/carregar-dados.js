/* =========================================================
   Carrega os dados do site a partir da pasta data/ (arquivos JSON).

   Antes, tudo ficava num único dados.js de 382 linhas. Agora cada assunto tem
   o seu arquivo JSON, e este script só sabe ONDE buscar:
     data/horarios.json        dias e horários (para o "Aberto agora")
     data/galerias.json        as 4 galerias do acervo
     data/acervo/<galeria>.json  as peças de cada galeria
     data/busca.json           textos das páginas para o buscador

   Importante: fetch() não funciona abrindo o arquivo com dois cliques (file://).
   O site precisa ser aberto por um servidor, ex.: http://localhost:8080
   ========================================================= */
(() => {
  const cache = {};

  // Busca um JSON uma única vez; as próximas chamadas reaproveitam a mesma resposta
  const json = (caminho) => {
    cache[caminho] ??= fetch(caminho).then((r) => {
      if (!r.ok) throw new Error(`Não foi possível carregar ${caminho} (${r.status})`);
      return r.json();
    });
    return cache[caminho];
  };

  // Todas as galerias, cada uma já com a lista de peças
  async function acervo() {
    const galerias = await json('data/galerias.json');
    const listas = await Promise.all(galerias.map((g) => json(`data/acervo/${g.slug}.json`)));
    return galerias.map((g, i) => ({ ...g, pecas: listas[i] }));
  }

  // Índice do buscador: textos fixos das páginas + dias da semana + peças do acervo.
  // Os dias e as peças entram sozinhos: adicionou uma peça no JSON, ela já aparece na busca.
  async function indiceBusca() {
    const [geral, horarios, galerias] = await Promise.all([json('data/busca.json'), json('data/horarios.json'), acervo()]);

    const dias = Object.values(horarios).map((h) => ({
      titulo: h.dia,
      url: 'horarios.html',
      secao: 'Guia',
      texto: `${h.abre ? `${h.abre} às ${h.fecha}` : 'fechado'}${h.nota ? `. ${h.nota}` : ''}.`,
      chaves: 'horario dia',
    }));

    const pecas = galerias.flatMap((g) => g.pecas.map((p) => ({
      titulo: p.titulo,
      url: `exposicoes.html#${p.id}`,
      secao: `Exposições · ${g.nome}`,
      texto: `${p.era}. ${p.descricao}`,
      chaves: `${g.slug} fossil osso`,
    })));

    return [...geral, ...dias, ...pecas];
  }

  window.Dados = { horarios: () => json('data/horarios.json'), acervo, indiceBusca };
})();
