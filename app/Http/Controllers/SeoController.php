<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Fora de produção, bloqueia a indexação para evitar conteúdo duplicado.
     */
    public function robots(): Response
    {
        $lines = app()->isProduction()
            ? ['User-agent: *', 'Allow: /', '', 'Sitemap: '.rtrim(config('app.url'), '/').'/sitemap.xml']
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n", 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function sitemap(): Response
    {
        $urls = [
            ['loc' => rtrim(config('app.url'), '/').'/', 'changefreq' => 'monthly', 'priority' => '1.0'],
        ];

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
