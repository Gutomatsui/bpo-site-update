# Relatório — SEO técnico, responsividade e acessibilidade

**Projeto:** bpo-site-update (Solution Business BPO)
**Data:** 06/11/2026
**Escopo:** otimização técnica sem refazer o layout, sem substituir imagens, sem remover seções e sem alterar o carrossel original.
**Deploy:** não realizado. O site antigo, o robots.txt e o sitemap do domínio oficial **não foram tocados**.

---

## 1. Auditoria inicial (antes das alterações)

| Área | Situação encontrada |
|---|---|
| Rotas | `/`, `/contato` e `/contato.html` (301), `/robots.txt`, `/sitemap.xml`, `/up` (health check) e **`/storage/{path}` GET e PUT** (recurso "serve" do disco local, ativo por padrão no Laravel 12 e desnecessário) |
| Title / description | "Solution Business BPO \| BPO Financeiro em Santos/SP" / texto institucional de 168 caracteres (cortado nos resultados de busca) |
| Canonical / OG / sitemap | Gerados a partir de `APP_URL`: no Lando apontavam para `bpo-site-update.lndo.site` |
| Meta robots | Só `noindex` fora de produção; nenhuma diretiva em produção |
| Sitemap | Rota Laravel, com `changefreq`/`priority` sem base real |
| JSON-LD | `ProfessionalService` + `WebSite` + `FAQPage`, com catálogo de serviços e a diretora como `employee` |
| Imagem Open Graph | Banner de 1366×525 (proporção 2,6:1; cortada nas prévias, que usam 1,91:1) |
| Headings | 1 H1 ✔ · H2 por seção ✔ · H3 nos serviços e subseções ✔ |
| Carrossel | Swiper 11 (Navigation, Pagination, Autoplay, EffectFade, Keyboard, A11y), 4 slides originais, botão de pausa |
| CSS/JS | 2 arquivos CSS (o CSS do Swiper importado pelo JS virava um arquivo separado); GSAP carregado sob demanda |
| axe-core (WCAG 2.2 AA) | 1 violação: botão flutuante do WhatsApp fora de landmark |
| Contraste (cálculo manual) | Rótulos laranja `#e8891a` sobre fundo claro: **2,52:1** ✘ · indicador de foco laranja sobre branco: **2,01:1** ✘ · ícone branco sobre o verde do WhatsApp: **1,98:1** ✘ |
| Alvos de toque | Botão de pausa 40×40, ícones sociais 40×40, links do rodapé e "ou ligue" com 20 px de altura, indicadores do carrossel com 6 px de altura |
| Texto < 16 px no mobile | Listas de serviços e etapas a 15,2 px, destaques da diretora a 14 px, copyright a 12 px |
| Autoplay sem pausa | Carrosséis de depoimentos e de clientes (WCAG 2.2.2) |
| HTML | `<div>` como filho de `<ol>` (benefícios) e `<figcaption>` fora de `<figure>` (depoimentos) |
| Sem JavaScript | Conteúdo das abas 2–4 e das respostas do FAQ ficava oculto |
| Lighthouse (Lando) | Mobile: Perf 98 · A11y 100 · BP 100 · SEO 69\* — Desktop: Perf 100 · A11y 100 · BP 100 · SEO 69\* |

\* No ambiente local o SEO fica em 69 **de propósito**: a página é `noindex` (auditoria `is-crawlable`).

---

## 2. O que foi corrigido

### SEO técnico
- **Title:** `BPO Financeiro e Terceirização Financeira | Solution BPO` (56 caracteres).
- **Description:** `Simplifique a gestão financeira da sua empresa com a Solution BPO. Serviços de faturamento, contas a pagar, integração contábil e relatórios.` (140 caracteres, dentro do limite de exibição).
- **URL canônica separada do `APP_URL`:** nova variável `SITE_URL` (padrão `https://www.solutionbpo.com.br`). Canonical, `og:url`, `og:image`, sitemap, robots e JSON-LD usam sempre o domínio oficial, inclusive no Lando.
- **Meta robots:** produção usa `index, follow, max-image-preview:large, max-snippet:-1`; outros ambientes usam `noindex, nofollow`.
- **Open Graph e Twitter Cards completos**, com `twitter:image:alt`.
- **Nova imagem OG de 1200×630:** o banner original 1 inteiro, centralizado sobre o azul-marinho da marca, sem cortes (`public/assets/images/og/solution-bpo-og.jpg`, 67 KB).
- **Metadados para páginas futuras:** `App\Support\Seo::page(title:, description:, path:, image:, indexable:)` gera um conjunto completo, e o título vira automaticamente "Página | Solution BPO". O layout funciona com ou sem JSON-LD.
- **JSON-LD reduzido a `Organization` + `WebSite`**, só com dados oficiais: nome, site, logotipo, telefone, e-mail, endereço, Instagram e ponto de contato. Saíram o `FAQPage` (o Google restringe esse rich result a sites governamentais e de saúde desde 2023), o catálogo e a diretora. Não há avaliações nem estatísticas. `LocalBusiness` não foi usado porque o site não informa horário de funcionamento nem confirma atendimento presencial no endereço. Pode ser adotado se o cliente confirmar esses dados.
- **Conteúdo das abas no HTML inicial:** já estava no HTML; agora também fica **visível sem JavaScript** (fallback `<noscript>`), assim como as respostas do FAQ.

### Sitemap e robots
- O sitemap lista somente a URL canônica da Home. Seções com `#` não entram.
- `changefreq` e `priority` foram removidos.
- `lastmod` só aparece quando houver data real em `config/site.php` (`sitemap[].lastmod`). Hoje fica vazio, porque não existe data confiável de alteração do conteúdo.
- Entradas duplicadas são descartadas.
- O XML é gerado sem Blade, por compatibilidade com hospedagens que têm `short_open_tag` ativo.
- O **robots.txt** em produção libera tudo (CSS, JS e imagens incluídos) e informa `Sitemap: https://www.solutionbpo.com.br/sitemap.xml`. Nos outros ambientes, `Disallow: /`.
- **Proteção de ambientes que não são produção** (middleware `ProtectNonProduction`):
  - cabeçalho `X-Robots-Tag: noindex, nofollow` em todas as respostas;
  - senha HTTP opcional (`STAGING_AUTH_USER` / `STAGING_AUTH_PASSWORD`) para homologação pública, ignorada em produção.

### Acessibilidade (WCAG 2.2 AA)
- **Contraste:**
  - nova cor `accent-ink` `#9c4a00` para texto laranja sobre fundo claro: **5,8–6,0:1**;
  - foco azul `#025893` sobre fundo claro: **7,45:1**; laranja sobre fundo escuro: **9,37:1**;
  - verde do WhatsApp ajustado para `#1a9e4b`: **3,48:1** com o ícone branco.
- **Alvos de toque de 44 px:**
  - botões de pausa, ícones sociais, botão Contato e links do menu desktop;
  - linhas dos links do rodapé, "ou ligue" e "Voltar ao topo";
  - indicadores do carrossel: área de toque de 44 px de altura, sem mudar a aparência.
- **Pausa de animação (2.2.2):**
  - botão de pausar/retomar nos carrosséis de depoimentos e de clientes, que se esconde quando os 4 logos cabem na tela;
  - todos os carrosséis pausam com o foco do teclado dentro deles e quando saem da tela.
- **Semântica:** a lista de benefícios voltou a ser `<ol>` válida, o `<figure>`/`<figcaption>` dos depoimentos foi corrigido, os carrosséis viraram `<section>` com rótulo e as respostas do FAQ viraram `<section aria-labelledby>`.
- **Landmark:** o botão flutuante do WhatsApp ficou dentro de `<aside aria-label="Atendimento rápido">`.
- **Texto ≥ 16 px no mobile** nas listas de serviços, etapas, destaques da diretora e rodapé.

### Performance
- **Banner:** nova variante de 480 px para celulares (10–15 KB por slide).
- **Prioridades:** slide 1 com `fetchpriority="high"` + preload com `href` de fallback; slides 2–4 com `fetchpriority="low"`.
- **WebP** nos ícones (benefícios e etapas, de 2 a 3 vezes menores) e no logotipo (`<picture>` com fallback PNG).
- **CSS do Swiper** incorporado ao bundle principal: 1 arquivo CSS em vez de 2.
- **Rotas `storage/*` desativadas** (`'serve' => false`).

---

## 3. Arquivos modificados ou criados

| Arquivo | Alteração |
|---|---|
| `config/site.php` | `url` (SITE_URL), novo title/description, imagem OG, lista do sitemap, `staging_auth` |
| `config/filesystems.php` | `serve => false` (remove `/storage/*`) |
| `app/Support/Seo.php` | **Novo:** metadados por página, URLs canônicas, robots, JSON-LD |
| `app/Http/Controllers/HomeController.php` | Usa `Seo::page()` e `Seo::graph()` |
| `app/Http/Controllers/SeoController.php` | Sitemap (sem changefreq/priority, lastmod real, deduplicação) e robots com domínio oficial |
| `app/Http/Middleware/ProtectNonProduction.php` | **Novo:** `X-Robots-Tag` e Basic Auth opcional |
| `bootstrap/app.php` | Registro do middleware |
| `resources/views/layouts/app.blade.php` | `<head>` orientado por `$meta`, preload com href, `<noscript>`, `<aside>` |
| `resources/views/components/*.blade.php` | header, hero-slider, benefits, services, workflow, cta, about, testimonials, faq, contact, footer, whatsapp-float: ajustes de acessibilidade, toque, contraste e WebP |
| `resources/css/app.css` | Swiper no bundle, `accent-ink`, foco por contexto, área de toque dos indicadores, `[x-cloak]` fora de camada |
| `resources/js/components/sliders.js` | Controle de autoplay acessível compartilhado pelos 3 carrosséis |
| `public/assets/images/og/solution-bpo-og.jpg` | **Nova:** imagem OG 1200×630 (derivada do banner original) |
| `public/assets/images/banners/*-480.webp` | **Novas:** variantes para celular |
| `public/assets/icons/{beneficios,passos}/*.webp` | **Novos:** ícones em WebP |
| `.env.example`, `deploy/shared-hosting/.env.production.example` | `SITE_URL`, `STAGING_AUTH_*` |
| `tests/Feature/SiteTest.php`, `tests/Fixtures/sitemap-0.9.xsd` | 13 testes; XSD oficial do sitemaps.org |

## 4. Rotas

| Rota | Situação |
|---|---|
| `GET /` | Home |
| `GET /robots.txt` | Dinâmico por ambiente |
| `GET /sitemap.xml` | Dinâmico, sempre no domínio oficial |
| `/contato`, `/contato.html` | 301 → `/#contato` (URLs do site antigo) |
| `GET /up` | Health check do Laravel (mantido para monitoramento; fora do sitemap) |
| `/storage/{path}` | **Removida** |

Nenhuma rota nova foi criada nesta etapa.

---

## 5. Verificação do sitemap

| Verificação | Resultado |
|---|---|
| HTTP | `200`, `Content-Type: application/xml; charset=UTF-8` (Lando e produção simulada) |
| Validação XSD (sitemaps.org 0.9) | **Válido**, no teste automatizado e no XML servido pela produção simulada |
| URLs | Somente `https://www.solutionbpo.com.br/`; nenhuma URL `lndo.site`, `#`, arquivo estático ou rota interna |
| changefreq / priority | Ausentes |
| lastmod | Ausente (sem data real); comportamento com data configurada coberto por teste |

## 6. Verificação do robots.txt

| Ambiente | Resultado |
|---|---|
| Lando (local) | `User-agent: * / Disallow: /` + `X-Robots-Tag: noindex, nofollow` + meta `noindex, nofollow` |
| Produção simulada | `User-agent: * / Allow: / / Sitemap: https://www.solutionbpo.com.br/sitemap.xml`; sem `X-Robots-Tag`; meta `index, follow…` |

Produção simulada = pacote real de `lando package` (modos `raiz` e `separado`) em container `php:8.3-apache` sem ajustes especiais, `APP_ENV=production`, `APP_DEBUG=false`, com `config:cache`, `route:cache` e `view:cache`.

---

## 7. Testes executados

### Testes automatizados (PHPUnit)
`lando artisan test`: **13 testes, 165 asserções, todos passando.** Cobrem:
- conteúdo original completo, com as abas no HTML inicial;
- os 4 slides na ordem original;
- metadados sem duplicação e um único H1;
- imagens existentes, com `alt` e dimensões;
- slide LCP sem lazy loading;
- JSON-LD só com dados oficiais;
- sitemap validado pelo XSD;
- robots por ambiente;
- Basic Auth de homologação e sua desativação em produção;
- redirecionamentos e rotas internas desativadas.

### Navegador automatizado (Chromium 156, Playwright)

| Largura | Carrossel (4 slides, autoplay, setas) | Abas | FAQ | Menu mobile | Overflow X | Imagens quebradas | Erros de console |
|---|---|---|---|---|---|---|---|
| 360 | ✔ (variante 480w) | ✔ | ✔ | ✔ | 0 | 0 | 0 |
| 375 | ✔ (480w) | ✔ | ✔ | ✔ | 0 | 0 | 0 |
| 390 | ✔ (480w) | ✔ | ✔ | ✔ | 0 | 0 | 0 |
| 430 | ✔ (480w) | ✔ | ✔ | ✔ | 0 | 0 | 0 |
| 768 | ✔ (768w) | ✔ | ✔ | ✔ | 0 | 0 | 0 |
| 1024 | ✔ (1366w) | ✔ | ✔ | menu desktop | 0 | 0 | 0 |
| 1440 | ✔ (1366w) | ✔ | ✔ | menu desktop | 0 | 0 | 0 |
| 1920 | ✔ (1366w) | ✔ | ✔ | menu desktop | 0 | 0 | 0 |

- **Proporção do banner:** 2,60 em todas as larguras, igual ao original de 1366×525. Com `object-contain` e caixa na proporção exata, nenhum texto ou rosto é cortado.
- **Header em 1024 px:** os links terminam em 787 px e o botão Contato começa em 867 px, sem sobreposição.

### Teclado, toque, movimento reduzido e sem JavaScript
**31 verificações, todas OK.** Entre elas:
- **Teclado:**
  - "Pular para o conteúdo" é o primeiro Tab;
  - foco visível em todos os elementos percorridos;
  - abas com setas, Home e End (com `aria-selected` acompanhando);
  - FAQ com Enter e Espaço;
  - banner pausa com o foco do teclado e avança com Enter;
  - o botão de pausa troca o rótulo acessível.
- **Menu mobile:**
  - abre com Enter e por toque, com `aria-expanded`;
  - o foco fica preso no menu e a rolagem da página é bloqueada;
  - Esc fecha e o foco volta ao botão;
  - o link fecha o menu e posiciona a seção logo abaixo do header.
- **Movimento reduzido:** o banner não troca sozinho, o GSAP não é baixado e a timeline aparece completa.
- **Sem JavaScript:** as 4 abas, as 3 respostas do FAQ e o primeiro slide ficam visíveis.

### axe-core 4 (WCAG 2.0/2.1/2.2 A e AA + boas práticas)
**0 violações** em 360, 768 e 1440 px. Antes havia 1.

### html-validate (HTML renderizado)
- **Antes:** 12 apontamentos.
- **Depois:** 3, todos sobre o estilo `<link … />` das tags geradas pelo Vite. É HTML válido; trata-se só de preferência de estilo.

### Lighthouse 12 (medição local; rede e CPU emuladas pelo Lighthouse)

| Cenário | Performance | Acessibilidade | Boas práticas | SEO | FCP | LCP | TBT | CLS |
|---|---|---|---|---|---|---|---|---|
| Antes — Lando, mobile | 98 | 100 | 100 | 69\* | 1,5 s | 1,7 s | 110 ms | 0,008 |
| Antes — Lando, desktop | 100 | 100 | 100 | 69\* | 0,4 s | 0,4 s | 0 ms | 0,002 |
| Depois — Lando, mobile | 99 | 100 | 100 | 69\* | 1,5 s | 1,7 s | 100 ms | 0,008 |
| Depois — Lando, desktop | 100 | 100 | 100 | 69\* | 0,4 s | 0,4 s | 0 ms | 0,002 |
| Depois — produção simulada, mobile | 98 | 100 | 100 | **100** | 1,5 s | 2,3 s | 30 ms | 0,008 |
| Depois — produção simulada, desktop | 100 | 100 | 100 | **100** | 0,4 s | 0,5 s | 0 ms | 0,003 |

\* `noindex` proposital fora de produção.

As medições são locais (servidor na própria máquina) e servem para comparar versões. **Não substituem** o PageSpeed Insights com o site publicado e os dados reais de campo (CrUX). As variações de LCP entre execuções (1,7 s a 2,3 s) são normais nesse tipo de medição.

---

## 8. Problemas restantes e limitações

1. **Lighthouse "image delivery" nos banners de 768 px:** falso positivo. A auditoria compara com o tamanho em CSS (380 px) e ignora a densidade de tela (DPR 1,75 → 665 px). Usar a variante de 480 px deixaria o banner borrado.
2. **Slides 2–4 baixados no carregamento:** com o efeito *fade* do carrossel original, todos os slides ocupam a mesma área, e o navegador considera todos visíveis. Ficaram com prioridade baixa e não atrasam o LCP. Adiá-los exigiria mudar o efeito do carrossel, o que está fora do escopo.
3. **JavaScript não utilizado (~30–51 KB):** partes do Alpine, do Swiper e do GSAP. O GSAP já é carregado sob demanda e nunca para quem prefere movimento reduzido.
4. **Cache de longo prazo:** o Apache do Lando não tem `mod_headers`/`mod_expires`. As regras já estão no `.htaccess` e valem na hospedagem se os módulos existirem; conferir com o provedor.
5. **Favicon:** o site antigo não tinha favicon funcional (arquivo de 0 bytes / 404). O atual é recortado do logotipo oficial de 71 px. **Recomenda-se pedir o arquivo vetorial da marca.**
6. **Fotos de serviço e da diretora em baixa resolução** (400×280 e 200×300): exibidas no tamanho natural. Pedir originais maiores ao cliente.
7. **Mapa do Google (iframe):** não carrega no navegador de testes sem rede externa; conferir em navegador comum.
8. **Textos de interface criados para a nova versão** (por exemplo, "O que dizem nossos clientes") e os ajustes editoriais documentados em `docs/inventario-conteudo.md` aguardam validação do cliente.
9. **`/up`:** health check do Laravel mantido para monitoramento; pode ser removido em `bootstrap/app.php` se não for usado.

## 9. Recomendações para a próxima etapa

1. Depois da publicação autorizada: cadastrar o domínio no **Google Search Console**, enviar o `sitemap.xml`, inspecionar a URL da Home e rodar o **Rich Results Test** e o **PageSpeed Insights** no domínio real.
2. Se houver homologação pública antes da troca de domínio: definir `STAGING_AUTH_USER`/`STAGING_AUTH_PASSWORD` no `.env` desse ambiente.
3. Quando forem criadas páginas próprias (por exemplo, uma por serviço): usar `Seo::page()` no controller e incluir o caminho em `config('site.sitemap')`, com `lastmod` real.
4. Pedir ao cliente: logotipo vetorial (favicon e OG mais nítidos), fotos em alta resolução e validação dos textos de interface.
5. Ajustes visuais da próxima etapa: manter os tokens de cor (`accent-ink` para texto laranja em fundo claro) e as áreas de toque de 44 px.
