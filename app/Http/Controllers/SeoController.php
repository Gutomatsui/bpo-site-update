<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Produção: libera o rastreamento e informa o sitemap oficial.
     * Demais ambientes: bloqueia tudo (local, teste, homologação).
     */
    public function robots(): Response
    {
        $lines = app()->isProduction()
            ? ['User-agent: *', 'Allow: /', '', 'Sitemap: '.Seo::url('sitemap.xml')]
            : ['User-agent: *', 'Disallow: /'];

        return response(implode("\n", $lines)."\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * Sitemap (protocolo sitemaps.org 0.9) com as páginas públicas e canônicas
     * de config('site.sitemap'). Sem changefreq/priority (ignorados pelo Google)
     * e com lastmod apenas quando houver data real.
     *
     * Gerado sem Blade: com short_open_tag ativo (comum em hospedagem
     * compartilhada) o "<?xml" dentro de uma view quebra a compilação.
     */
    public function sitemap(): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        $seen = [];
        foreach (config('site.sitemap') as $page) {
            $loc = Seo::url($page['path']);
            if (isset($seen[$loc])) {
                continue;
            }
            $seen[$loc] = true;

            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8')."</loc>\n";
            if (! empty($page['lastmod'])) {
                $xml .= '    <lastmod>'.htmlspecialchars($page['lastmod'], ENT_XML1)."</lastmod>\n";
            }
            $xml .= "  </url>\n";
        }

        $xml .= "</urlset>\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
