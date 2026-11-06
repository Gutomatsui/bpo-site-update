# bpo-site-update — Solution Business BPO

Nova versão do site institucional da **Solution Business BPO** (https://www.solutionbpo.com.br/), desenvolvida pela **Matsui Tecnologia**.
O projeto é independente do site antigo: o repositório, o servidor e os dados anteriores não foram alterados.

**Stack:** Laravel 12 · PHP 8.3 · Blade · Tailwind CSS 4 · Alpine.js · Swiper · GSAP (ScrollTrigger) · Vite 7 · Lando

## Ambiente local (Lando)

```bash
lando start                     # sobe appserver (PHP 8.3 + Apache), node 20 e mysql 8
cp .env.example .env            # primeira vez
lando composer install
lando artisan key:generate
lando npm install
lando npm run dev               # Vite com HMR em https://vite.bpo-site-update.lndo.site
# ou
lando npm run build             # assets de produção em public/build
```

Acesse: **https://bpo-site-update.lndo.site**

| Comando | Função |
|---|---|
| `lando info` | URLs e serviços |
| `lando php …` / `lando composer …` | PHP e Composer no container `appserver` |
| `lando artisan …` | Atalho para `php artisan` |
| `lando npm …` / `lando node …` / `lando npx …` | Node 20 no container `node` |
| `lando artisan test` | Testes automatizados |
| `lando artisan optimize:clear` | Limpa os caches do Laravel |
| `lando package` | Pacote de deploy em `dist/`: modo raiz (`index.php` na raiz pública) |
| `lando package separado` | Pacote com o núcleo fora do `public_html` |

O site **não usa banco de dados** (sessão e cache em arquivo). O MySQL 8 vem da receita LAMP e fica disponível para expansões futuras (credenciais `lamp`/`lamp`, host `database`).

## Onde editar o conteúdo

| O quê | Onde |
|---|---|
| Textos, contatos, slides, serviços, FAQ, depoimentos, clientes | `config/site.php` |
| Layout e SEO (`<head>`, Open Graph) | `resources/views/layouts/app.blade.php` |
| Seções da home | `resources/views/components/*.blade.php` |
| Estilos e cores da marca | `resources/css/app.css` (`@theme`) |
| Interações (menu, abas, carrosséis, animações) | `resources/js/` |
| Imagens | `public/assets/images/` e `public/assets/icons/` |

Depois de editar o `config/site.php`, rode `lando artisan optimize:clear`.

## SEO

- Metadados por página: `App\Support\Seo::page()` (ver `HomeController`).
- `SITE_URL` (padrão `https://www.solutionbpo.com.br`) é a base de canonical, Open Graph, sitemap e JSON-LD, inclusive no Lando.
- `/robots.txt` e `/sitemap.xml` são rotas Laravel. Só `APP_ENV=production` libera a indexação; os demais ambientes enviam `noindex` e, opcionalmente, pedem senha (`STAGING_AUTH_USER`/`STAGING_AUTH_PASSWORD`).
- Páginas do sitemap: `config/site.php` → `sitemap` (preencha `lastmod` só com uma data real).
- Relatório da etapa: [docs/RELATORIO_SEO_RESPONSIVIDADE.md](docs/RELATORIO_SEO_RESPONSIVIDADE.md).

## Estrutura

```text
app/Http/Controllers/HomeController.php   # home + dados estruturados (JSON-LD)
app/Http/Controllers/SeoController.php    # robots.txt e sitemap.xml dinâmicos
app/Http/Middleware/SecurityHeaders.php   # cabeçalhos de segurança
config/site.php                           # conteúdo institucional centralizado
resources/views/layouts/app.blade.php
resources/views/home.blade.php
resources/views/components/               # header, hero-slider, benefits, services, workflow,
                                          # cta, about, testimonials, faq, contact, footer…
resources/js/app.js                       # Alpine + componentes
resources/js/components/                  # site-header, service-tabs, sliders (Swiper)
resources/js/animations.js                # GSAP + ScrollTrigger (carregado sob demanda)
public/assets/                            # imagens originais + WebP
deploy/                                   # index.php de produção, .env de exemplo, script de pacote
docs/inventario-conteudo.md               # auditoria e inventário de imagens/textos
docs/DEPLOY_HOSPEDAGEM_COMPARTILHADA.md    # guia de publicação e rollback
docs/arquivo-original/                    # HTML/CSS/JS e imagens não utilizadas do site antigo
```

## Deploy

Ver [docs/DEPLOY_HOSPEDAGEM_COMPARTILHADA.md](docs/DEPLOY_HOSPEDAGEM_COMPARTILHADA.md).
**Não publique em produção sem autorização do cliente.**
