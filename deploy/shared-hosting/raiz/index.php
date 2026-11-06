<?php

/*
|--------------------------------------------------------------------------
| index.php de PRODUÇÃO — modo "raiz" (hospedagem compartilhada)
|--------------------------------------------------------------------------
|
| Todo o projeto fica dentro da raiz pública do domínio (ex.: public_html/),
| com este index.php na raiz, ao lado de app/, vendor/, bootstrap/...
| O conteúdo de public/ (build/, assets/, favicon...) também fica na raiz.
|
| As pastas internas são bloqueadas pelo .htaccess da raiz e por um
| .htaccess "Require all denied" dentro de cada uma delas.
|
| Este arquivo NÃO substitui o public/index.php usado no Lando.
|
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Modo de manutenção (php artisan down)...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader do Composer...
require __DIR__.'/vendor/autoload.php';

// Inicializa o Laravel...
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

// A pasta pública passa a ser a própria raiz (manifesto do Vite, assets e favicon).
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
