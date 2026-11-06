# Deploy em hospedagem compartilhada — Solution BPO

> **Atenção:** nenhuma publicação foi feita. O site atual em `www.solutionbpo.com.br` continua intacto.
> Siga este roteiro **somente após a autorização do cliente**.

## 1. Requisitos da hospedagem

| Requisito | Mínimo |
|---|---|
| PHP | **8.2 ou superior** (recomendado 8.3, a mesma versão do Lando) |
| Extensões PHP | `ctype`, `fileinfo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `dom`, `filter`, `json`, `session` |
| Servidor | Apache com `mod_rewrite` e suporte a `.htaccess` (`AllowOverride All`) |
| Opcional | `mod_headers`, `mod_expires`, `mod_deflate` (cache e compressão; o site funciona sem eles) |
| Banco de dados | **Não é necessário** |
| Node.js / Composer no servidor | **Não são necessários**: o pacote já sai com `vendor/` e os assets compilados |
| SSH | Opcional, mas facilita a limpeza de cache. Sem SSH, ver a seção 7 |

## 2. Organização dos arquivos

Existem dois modos de pacote. **O padrão é o modo "raiz".**

### Modo "raiz" (padrão): `index.php` na raiz pública

Use quando a hospedagem só permite usar a pasta pública (`public_html`). O conteúdo de `public/` (index, build, assets, favicon) vai para a raiz, ao lado das pastas do Laravel:

```text
/home/USUARIO/public_html/
├── index.php            <- deploy/shared-hosting/raiz/index.php (caminhos a partir da raiz)
├── .htaccess            <- deploy/shared-hosting/raiz/.htaccess (bloqueia as pastas internas)
├── build/  assets/  favicon.ico  favicon-32.png  apple-touch-icon.png  icon-192.png
├── app/  bootstrap/  config/  database/  resources/  routes/  storage/  vendor/
│     └── cada uma com um .htaccess "Require all denied" (segunda camada de proteção)
├── artisan  composer.json  composer.lock
└── .env                 <- criado no servidor (ver seção 5)
```

Proteções do modo raiz (validadas em Apache + PHP 8.3 padrão, com `short_open_tag` ativo):

- `/app`, `/bootstrap`, `/config`, `/database`, `/resources`, `/routes`, `/storage` e `/vendor` → **403**;
- `/.env`, `/.htaccess`, `/artisan`, `/composer.json|lock`, `/package.json`, `/vite.config.js`, `*.md`, `*.log` → **403**;
- listagem de diretórios desativada (`/assets/` e `/build/` → 403).

> Importante: neste modo, a proteção depende do Apache respeitar o `.htaccess`. Depois do upload, **sempre** teste `https://www.solutionbpo.com.br/.env` e `/vendor/autoload.php`: os dois precisam retornar 403. Se retornarem 200 ou mostrarem conteúdo, tire o site do ar e fale com o provedor.

### Modo "separado": núcleo fora da pasta pública (mais seguro, quando permitido)

O núcleo do Laravel fica **fora** da pasta pública. Só `public_html` é acessível pela web.

```text
/home/USUARIO/
├── bpo-site-update/          <- núcleo Laravel (NÃO acessível pela web)
│   ├── app/  bootstrap/  config/  resources/  routes/  storage/  vendor/
│   ├── artisan  composer.json
│   └── .env                  <- criado no servidor (ver seção 5)
│
└── public_html/              <- raiz do domínio
    ├── index.php             <- versão de PRODUÇÃO (deploy/shared-hosting/public_html/index.php)
    ├── .htaccess
    ├── build/                <- CSS/JS/fontes compilados pelo Vite
    ├── assets/               <- imagens e ícones
    ├── favicon.ico  favicon-32.png  apple-touch-icon.png  icon-192.png
```

> `robots.txt` e `sitemap.xml` são gerados pelo Laravel (rotas), a partir do `APP_URL`.
> Não crie arquivos estáticos com esses nomes em `public_html`, porque eles teriam prioridade sobre as rotas.

**Alternativa preferida:** se o painel permitir apontar o *document root* do domínio para uma pasta, envie o projeto inteiro e aponte o domínio para `bpo-site-update/public`. Nesse caso use o `public/index.php` original, sem adaptação.

## 3. Build e geração do pacote (máquina local)

```bash
lando start
lando composer install
lando npm install
lando npm run build        # gera public/build (assets com hash + manifest.json)
lando artisan test         # testes automatizados
lando package              # modo raiz     -> dist/solutionbpo-raiz-AAAAMMDD-HHMM.tar.gz
lando package separado     # modo separado -> dist/solutionbpo-separado-AAAAMMDD-HHMM.tar.gz
```

O script `deploy/build-package.sh`:

1. copia o núcleo, sem `.git`, `node_modules`, `tests`, `docs`, `.env` e arquivos do Lando;
2. roda `composer install --no-dev --optimize-autoloader`;
3. move o conteúdo de `public/` para a raiz pública e coloca o `index.php` e o `.htaccess` do modo escolhido;
4. no modo raiz, cria um `.htaccess` de bloqueio em cada pasta interna;
5. compacta tudo em `dist/` (fora do Git).

O `public/index.php` do projeto **não é alterado**: o Lando continua funcionando normalmente.

## 4. Upload

1. **Backup antes de tudo (rollback):** baixe uma cópia completa do `public_html` atual (e de qualquer outra pasta do site antigo) pelo gerenciador de arquivos ou FTP. Guarde fora do servidor e também em `/home/USUARIO/backup-site-antigo-AAAAMMDD/`.
2. Envie o `.tar.gz` para `/home/USUARIO/` e extraia (gerenciador de arquivos do cPanel → *Extract*, ou `tar -xzf` via SSH).
3. Isso cria `bpo-site-update/` e `public_html/`. **Se `public_html` já existir com o site antigo**, extraia primeiro em uma pasta temporária e só troque o conteúdo depois do backup.

## 5. Variáveis de ambiente

Em `/home/USUARIO/bpo-site-update/`, crie o `.env` a partir de `.env.production.example`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.solutionbpo.com.br
APP_KEY=            # gere uma chave NOVA, exclusiva de produção
```

- Gere a chave com SSH: `php artisan key:generate`. Sem SSH: rode `lando artisan key:generate --show` localmente e cole o valor. Não reutilize a chave do `.env` local.
- `SITE_URL=https://www.solutionbpo.com.br` define a URL usada em canonical, Open Graph, sitemap e JSON-LD.
- Nunca deixe `APP_DEBUG=true` em produção.
- `APP_ENV=production` é o que libera a indexação (meta robots, `robots.txt` com `Allow` e a linha `Sitemap:`). Com qualquer outro valor, o site responde com `noindex`.
- **Homologação pública** (antes da troca de domínio): use `APP_ENV=staging` e defina `STAGING_AUTH_USER` e `STAGING_AUTH_PASSWORD` para exigir senha. Essas variáveis são ignoradas em produção.
- O `.env` nunca vai para o Git nem para o pacote.

## 6. Paths do index.php

**Modo raiz:** `deploy/shared-hosting/raiz/index.php` usa caminhos relativos à própria raiz:

```php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);   // a raiz é a pasta pública (manifest do Vite, assets)
```

No modo raiz, o `.env` fica em `public_html/.env` e o `php artisan` roda dentro de `public_html/`.

**Modo separado:** o arquivo `deploy/shared-hosting/public_html/index.php` usa:

```php
define('LARAVEL_CORE', dirname(__DIR__).'/bpo-site-update');
require LARAVEL_CORE.'/vendor/autoload.php';
$app = require_once LARAVEL_CORE.'/bootstrap/app.php';
$app->usePublicPath(__DIR__);   // public_html é a pasta pública (manifest do Vite, assets)
```

Se o núcleo ficar em outra pasta, ajuste só a constante `LARAVEL_CORE`.
O arquivo de manutenção (`storage/framework/maintenance.php`) também é lido a partir de `LARAVEL_CORE`.

## 7. Permissões e cache

```bash
cd ~/public_html          # modo raiz   (modo separado: cd ~/bpo-site-update)
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;
chmod 640 .env

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

- Pastas: 755 (ou 775 se o PHP rodar com outro usuário). Arquivos: 644. `.env`: 640 ou 600.
- **Sem SSH:** o site funciona sem cache de configuração. Se precisar limpar, apague os arquivos `*.php` de `bootstrap/cache/` (exceto `.gitignore`) e o conteúdo de `storage/framework/views/`.
- **Sempre que alterar o `.env` ou o `config/site.php`**, rode `php artisan config:cache` de novo (ou apague `bootstrap/cache/config.php`).

## 8. Apache e segurança

O `public_html/.htaccess` já inclui:

- `Options -Indexes` (sem listagem de diretórios);
- bloqueio de arquivos ocultos (`.env`, `.git`…) e de `composer.json`, `*.log`, `*.sql`, `*.md`, `*.yml`;
- regras de rewrite do Laravel;
- cache longo para assets com hash (`build/`) e compressão, quando os módulos existirem.

Cabeçalhos de segurança (`X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy` e HSTS em produção) são enviados pelo middleware `App\Http\Middleware\SecurityHeaders`, sem depender do `mod_headers`.

**Redirecionamento HTTPS + www:** depois de confirmar que o SSL está ativo, descomente o bloco "Produção: forçar HTTPS e www" no `.htaccess`.

Se o provedor exigir `RewriteBase /` (alguns exigem), adicione a linha logo após `RewriteEngine On`.

## 9. Testes pós-publicação

- [ ] `https://www.solutionbpo.com.br/` abre sem erro e com o cadeado de HTTPS.
- [ ] O banner exibe os 4 slides, faz o autoplay e responde às setas e ao swipe.
- [ ] Abas de serviços, FAQ e menu mobile funcionam.
- [ ] Botões de WhatsApp abrem a conversa com (13) 99633-8514.
- [ ] Links de e-mail, telefone, Instagram e mapa funcionam.
- [ ] `https://www.solutionbpo.com.br/robots.txt` mostra `Allow: /` e `Sitemap: https://www.solutionbpo.com.br/sitemap.xml`.
- [ ] `https://www.solutionbpo.com.br/sitemap.xml` abre como XML e lista só `https://www.solutionbpo.com.br/`.
- [ ] O código-fonte tem `<meta name="robots" content="index, follow…">` e a resposta não traz o cabeçalho `X-Robots-Tag`.
- [ ] Sitemap enviado no Google Search Console.
- [ ] `https://www.solutionbpo.com.br/contato` redireciona para `/#contato`.
- [ ] `https://www.solutionbpo.com.br/.env` e `/assets/` retornam **403**.
- [ ] Modo raiz: `/vendor/autoload.php`, `/config/site.php`, `/storage/logs/` e `/composer.json` retornam **403**.
- [ ] O código-fonte da página **não** contém `noindex` e o canonical é `https://www.solutionbpo.com.br/`.
- [ ] O console do navegador está sem erros; o PageSpeed Insights foi rodado em mobile e desktop.
- [ ] A pré-visualização do link no WhatsApp/Facebook mostra a imagem do banner (Open Graph).
- [ ] Os dados estruturados validam no Rich Results Test (https://search.google.com/test/rich-results).

## 10. Rollback

1. Renomeie o `public_html` novo para `public_html-novo-AAAAMMDD` (no modo raiz, o site novo inteiro está nessa pasta).
2. Restaure o backup do site antigo (passo 4.1) como `public_html`.
3. Se o site antigo dependia de outras pastas ou banco, restaure-os do mesmo backup. O novo site não altera nenhum banco.
4. A pasta `bpo-site-update/` pode continuar no servidor: fora de `public_html` ela não fica acessível.

Para voltar à versão nova, basta inverter a troca de pastas.

## 11. Atualizações futuras

1. Altere os textos e contatos em `config/site.php` (ou os componentes em `resources/views/components/`).
2. `lando npm run build && lando artisan test && lando package`.
3. Envie apenas o que mudou: `public_html/build/` (apague o `build/` antigo antes, porque os nomes têm hash), `public_html/assets/` e/ou `bpo-site-update/config|resources|app`.
4. Rode `php artisan config:cache && php artisan view:cache` (ou limpe o cache manualmente, conforme a seção 7).
