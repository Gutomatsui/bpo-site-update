<?php

/*
|--------------------------------------------------------------------------
| index.php de PRODUÇÃO — hospedagem compartilhada
|--------------------------------------------------------------------------
|
| Estrutura esperada no servidor:
|
|   /home/USUARIO/bpo-site-update/   <- núcleo Laravel (fora da web)
|   /home/USUARIO/public_html/       <- este arquivo + build/, assets/, .htaccess
|
| Se o nome da pasta do núcleo for diferente, ajuste LARAVEL_CORE abaixo.
| Este arquivo NÃO substitui o public/index.php usado no Lando.
|
*/

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

define('LARAVEL_CORE', dirname(__DIR__).'/bpo-site-update');

// Modo de manutenção (php artisan down)...
if (file_exists($maintenance = LARAVEL_CORE.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader do Composer...
require LARAVEL_CORE.'/vendor/autoload.php';

// Inicializa o Laravel...
/** @var Application $app */
$app = require_once LARAVEL_CORE.'/bootstrap/app.php';

// A pasta pública é public_html (manifesto do Vite, assets e favicon ficam aqui).
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
