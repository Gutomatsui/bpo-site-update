<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// URLs do site antigo: preserva links e indexação existentes.
Route::permanentRedirect('/contato', '/#contato');
Route::permanentRedirect('/contato.html', '/#contato');

Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
