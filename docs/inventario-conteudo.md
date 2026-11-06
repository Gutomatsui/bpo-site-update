# Inventário de conteúdo — Solution Business BPO

Auditoria do site original **https://www.solutionbpo.com.br/** feita em 06/11/2026.
Os arquivos originais (HTML, CSS, JS) foram arquivados em `docs/arquivo-original/` como referência.

Base das URLs de origem: `https://www.solutionbpo.com.br/public/img/`

## 1. Resumo da auditoria

| Item | Situação no site original |
|---|---|
| Tecnologia | HTML estático + Bootstrap 5, jQuery 3.2.1, Font Awesome 4.7 (CDN), fonte Roboto |
| Páginas | `/` (home) e `/contato` (formulário **sem envio**: `action=""`, campos sem `name`) + mapa do Google |
| Banner | Carrossel Bootstrap com 4 slides (`banner3.png` a `banner6.png`, 1366×525), sem `alt`, com texto embutido nas imagens |
| Meta tags | `title` "Solution Bussiness BPO"; `description` e `keywords` vazias; sem Open Graph, canonical ou dados estruturados |
| Favicon | Referência quebrada (`/Content/images/favicon-nescau.ico` → 404); `/favicon.ico` existe, mas tem **0 bytes** |
| robots.txt | `User-agent: * / Disallow:` (libera tudo); não há sitemap (`/sitemap.xml` → 404) |
| WhatsApp | Botão flutuante (`wa.me`) com mensagem "Quero mais informações sobre: {URL}"; botões usam `web.whatsapp.com` (não funciona bem no celular) |
| Paleta (estilos.css) | `#025893`, `#1783cc`, `#1a428a`, `#1c386c`, `#091124`, `#0a0f42`, `#ffa235` |

## 2. Imagens recuperadas

Status: **OK** = baixada, verificada visualmente e em uso · **Arquivada** = existe no servidor, mas não era exibida pelo site (guardada em `docs/arquivo-original/nao-utilizadas/`, não publicada) · **Gerada** = derivada de um arquivo original.

Para todas as imagens em uso foi gerada uma versão `.webp` ao lado do original (o original fica como fallback no `<picture>`).

### Logotipo e favicon

| Imagem | Origem | Caminho local | Seção | Status |
|---|---|---|---|---|
| Logotipo (199×100, branco + "ON" ciano) | `logoSolution.png` | `public/assets/images/logo/logo-solution.png` (+ `.webp`) | Header, Sobre Nós, Rodapé, JSON-LD | OK |
| Favicon 16/32/48 | recorte do círculo "ON" de `logoSolution.png` | `public/favicon.ico`, `public/favicon-32.png` | `<head>` | Gerada |
| Apple touch / 192 px | idem | `public/apple-touch-icon.png`, `public/icon-192.png` | `<head>` | Gerada |

### Banner rotativo (ordem original preservada)

| # | Imagem | Origem | Caminho local | Status |
|---|---|---|---|---|
| 1 | "Sua empresa é a nossa prioridade — Gestão de contas a Pagar" | `banner3.png` | `public/assets/images/banners/banner3.png` + `banner3-1366.webp` + `banner3-768.webp` | OK |
| 2 | Mulher de óculos — "A sua empresa lucra o quanto deveria lucrar?" (6 perguntas) | `banner4.png` | `.../banners/banner4.*` | OK |
| 3 | "BPO Financeiro — uma revolução sem precedentes…" | `banner5.png` | `.../banners/banner5.*` | OK |
| 4 | "Saiba como vamos te ajudar?" (trilha de 5 etapas) | `banner6.png` | `.../banners/banner6.*` | OK |
| — | Mesa com moedas e notebook | `banner1.jpg` | `docs/arquivo-original/nao-utilizadas/` | Arquivada |
| — | Painel "BPO / Business Process Outsourcing" | `banner2.jpg` | `docs/arquivo-original/nao-utilizadas/` | Arquivada |

Peso: PNG ~470–590 KB → WebP 1366 px 34–65 KB / WebP 768 px 19–30 KB.

### Serviços

| Imagem | Origem | Caminho local | Status |
|---|---|---|---|
| Gestão de Faturamento (400×280) | `img-gestao-faturamento.jpg` | `public/assets/images/servicos/img-gestao-faturamento.jpg` (+ `.webp`) | OK |
| Gestão de Contas a Pagar (400×280) | `img-contas-pagar.jpg` | `.../servicos/img-contas-pagar.*` | OK |
| Integração Contábil (187×280, retrato) | `img-integracao-contabil.jpg` | `.../servicos/img-integracao-contabil.*` | OK |
| Relatórios e Análises (400×280) | `img-relatorios-analises.jpg` | `.../servicos/img-relatorios-analises.*` | OK |

### Institucional

| Imagem | Origem | Caminho local | Status |
|---|---|---|---|
| Foto de Flávia Jacob (200×300, fundo transparente) | `img-sobre.png` | `public/assets/images/institucional/flavia-jacob.png` (+ `.webp`) | OK |

### Clientes e depoimentos

| Imagem | Origem | Caminho local | Uso | Status |
|---|---|---|---|---|
| Hydrojexe | `logo-hydrojexe.png` | `public/assets/images/clientes/logo-hydrojexe.*` | Clientes | OK |
| Blue Royal Logistic | `logo-blueroyal.png` | `.../clientes/logo-blueroyal.*` | Clientes | OK |
| Grupo Conexão Ideal | `conexao-ideal.jpg` | `.../clientes/conexao-ideal.*` | Clientes + depoimento | OK |
| CertLíder | `certificado-lider.jpg` | `.../clientes/certificado-lider.*` | Clientes + depoimento | OK |
| `emp1.jpg`, `emp5.jpg`, `emp6.jpg`, `empresa.png` | `/public/img/` | `docs/arquivo-original/nao-utilizadas/` | Comentados no HTML original (placeholders) | Arquivada |

### Ícones

| Ícones | Origem | Caminho local | Uso | Status |
|---|---|---|---|---|
| `icon-experts`, `icon-gastos`, `icon-gerenciamento-de-tempo` (75×75) | `/public/img/` | `public/assets/icons/beneficios/` | Cards de benefícios | OK |
| `icon-passo1` a `icon-passo5` (laranja) | `/public/img/` | `public/assets/icons/passos/` | Timeline "Como funciona" | OK |
| `icon-moedas`, `icon-conta`, `icon-contabil`, `icon-relatorio` | CSS (`background-image` das abas) | `public/assets/icons/ui/` | Abas de serviços | OK |
| `icon-cel`, `icon-email`, `icon-instagram`, `icon-pin`, `icon-site`, `icon-check`, `seta-direita-menor` | CSS / HTML | `public/assets/icons/ui/` | Recuperados; substituídos por SVG inline na nova interface | OK (não exibidos) |
| `icon-nav`, `icon-nav-open`, `triangulo-topo` | CSS | `docs/arquivo-original/nao-utilizadas/` | Elementos do layout antigo | Arquivada |

Não restou nenhuma dependência de imagens hospedadas no domínio antigo.

## 3. Textos preservados

Todos os textos estão centralizados em `config/site.php`, transcritos do original sem resumo:

- Título e introdução de benefícios + 3 cards.
- 4 serviços: título, destaques, "O que nós fazemos", "O que você faz / Você ainda recebe".
- 5 etapas de "Como funciona" com descrições completas.
- "Comece agora!" (3 parágrafos).
- Sobre Nós (2 parágrafos + frase "Confie em nós…").
- Flávia Jacob — Diretora (texto integral).
- 2 depoimentos (Grupo Conexão Ideal e Certlíder).
- 3 perguntas frequentes com respostas.
- Contatos: (13) 99633-8514 · contato@solutionbpo.com.br · instagram.com/solution.bpofinanceira · Av. Washington Luis, 61 - cj. 32 - VL Mathias - Santos/SP.

### Ajustes editoriais mínimos (para validação do cliente)

| Original | Novo | Motivo |
|---|---|---|
| "Solution **Bussiness** BPO" | "Solution **Business** BPO" | Grafia do próprio logotipo e do briefing |
| "Gestão Contas a Pagar" (título do painel) | "Gestão de Contas a Pagar" | Igual ao rótulo da aba |
| "…é um sistema ?" | "…é um sistema?" | Espaço antes do ponto de interrogação |

### Textos novos de interface (não institucionais)

Rótulos de navegação e microcopy criados para a nova interface: "O que dizem nossos clientes", "Parcerias de longo prazo, construídas com transparência e proximidade.", "Clientes que confiam na Solution", "Ainda com dúvidas? Fale diretamente com a nossa equipe.", "Vamos conversar sobre o financeiro da sua empresa", "Escolha o canal que preferir para falar com a nossa equipe.", rótulos "Liderança", "Etapa 01…05", "BPO Financeiro". Nenhum número, cliente ou depoimento foi inventado. **Recomenda-se validar esses textos com o cliente.**
