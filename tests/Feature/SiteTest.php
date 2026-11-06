<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Tests\TestCase;

class SiteTest extends TestCase
{
    private function dom(string $html): DOMXPath
    {
        $doc = new DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="UTF-8">'.$html);
        libxml_clear_errors();

        return new DOMXPath($doc);
    }

    public function test_home_renders_all_original_content(): void
    {
        $site = config('site');
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee($site['benefits']['title'])
            ->assertSee('Flávia Jacob')
            ->assertSee('Jorge Eduardo da Silva')
            ->assertSee('Fábio Jacob')
            ->assertSee('wa.me/5513996338514', false)
            ->assertSee('Copyright © '.now()->year, false);

        // Banner: os 4 slides originais, na ordem.
        $html = $response->getContent();
        $positions = array_map(fn ($n) => strpos($html, "banners/banner{$n}-1366.webp 1366w"), [3, 4, 5, 6]);
        $this->assertNotContains(false, $positions);
        $sorted = $positions;
        sort($sorted);
        $this->assertSame($sorted, $positions, 'Slides fora da ordem original');

        // Conteúdo de TODAS as abas presente no HTML inicial (indexável).
        foreach ($site['services']['items'] as $service) {
            $response->assertSee($service['title']);
            foreach ($service['we_do'] as $task) {
                $response->assertSee($task);
            }
        }
        foreach ($site['workflow']['steps'] as $step) {
            $response->assertSee($step['text']);
        }
        foreach ($site['faq'] as $item) {
            $response->assertSee($item['question']);
        }
        foreach ($site['clients'] as $client) {
            $response->assertSee($client['logo'].'.webp', false);
        }
    }

    public function test_seo_metadata(): void
    {
        $xpath = $this->dom($this->get('/')->getContent());
        $meta = fn (string $q) => $xpath->query($q)->item(0)?->nodeValue;

        $this->assertSame('pt-BR', $meta('//html/@lang'));
        $this->assertSame('BPO Financeiro e Terceirização Financeira | Solution BPO', $meta('//title'));
        $this->assertLessThanOrEqual(60, mb_strlen($meta('//title')));

        $description = $meta('//meta[@name="description"]/@content');
        $this->assertNotEmpty($description);
        $this->assertLessThanOrEqual(160, mb_strlen($description));

        // Canonical e Open Graph sempre no domínio oficial.
        $this->assertSame('https://www.solutionbpo.com.br/', $meta('//link[@rel="canonical"]/@href'));
        $this->assertSame('https://www.solutionbpo.com.br/', $meta('//meta[@property="og:url"]/@content'));
        $this->assertStringStartsWith('https://www.solutionbpo.com.br/', $meta('//meta[@property="og:image"]/@content'));
        $this->assertSame('summary_large_image', $meta('//meta[@name="twitter:card"]/@content'));

        // Fora de produção: noindex.
        $this->assertSame('noindex, nofollow', $meta('//meta[@name="robots"]/@content'));

        // Sem metadados duplicados.
        foreach (['//title', '//meta[@name="description"]', '//link[@rel="canonical"]', '//meta[@name="robots"]', '//meta[@property="og:title"]'] as $q) {
            $this->assertSame(1, $xpath->query($q)->length, "Duplicado: $q");
        }

        // Um único H1.
        $this->assertSame(1, $xpath->query('//h1')->length);
    }

    public function test_production_metadata_allows_indexing(): void
    {
        $this->app['env'] = 'production';
        $xpath = $this->dom($this->get('/')->getContent());

        $this->assertStringStartsWith('index, follow', $xpath->query('//meta[@name="robots"]/@content')->item(0)->nodeValue);
    }

    public function test_referenced_images_exist_and_have_alt(): void
    {
        $html = $this->get('/')->getContent();
        preg_match_all('#/(assets/[^"\s,]+\.(?:png|jpg|webp))#', $html, $m);

        $this->assertNotEmpty($m[1]);
        foreach (array_unique($m[1]) as $path) {
            $this->assertFileExists(public_path($path));
        }

        $xpath = $this->dom($html);
        $this->assertSame(0, $xpath->query('//img[not(@alt)]')->length, 'Imagem sem alt');
        $this->assertSame(0, $xpath->query('//img[not(@width) or not(@height)]')->length, 'Imagem sem dimensões');
        // O primeiro slide (LCP) não pode ter lazy loading.
        $this->assertSame('eager', $xpath->query('//*[@id="inicio"]//img')->item(0)->getAttribute('loading'));
    }

    public function test_structured_data_uses_only_official_information(): void
    {
        $html = $this->get('/')->getContent();
        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $m);

        $data = json_decode($m[1] ?? '', true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame('https://schema.org', $data['@context']);

        $types = array_column($data['@graph'], '@type');
        $this->assertSame(['Organization', 'WebSite'], $types);

        $org = $data['@graph'][0];
        $this->assertSame('Solution Business BPO', $org['name']);
        $this->assertSame('https://www.solutionbpo.com.br/', $org['url']);
        $this->assertSame('+5513996338514', $org['telephone']);
        $this->assertSame('contato@solutionbpo.com.br', $org['email']);
        $this->assertSame(['https://www.instagram.com/solution.bpofinanceira/'], $org['sameAs']);
        $this->assertArrayNotHasKey('aggregateRating', $org);
        $this->assertArrayNotHasKey('review', $org);
    }

    public function test_sitemap_is_valid_and_uses_official_domain(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $doc = new DOMDocument;
        $this->assertTrue($doc->loadXML($response->getContent()), 'XML inválido');
        $this->assertTrue($doc->schemaValidate(base_path('tests/Fixtures/sitemap-0.9.xsd')), 'Não segue o esquema sitemaps.org 0.9');

        $locs = array_map(fn ($n) => $n->nodeValue, iterator_to_array($doc->getElementsByTagName('loc')));
        $this->assertSame(['https://www.solutionbpo.com.br/'], $locs);
        $this->assertStringNotContainsString('lndo.site', $response->getContent());
        $this->assertStringNotContainsString('#', $response->getContent());
        $this->assertStringNotContainsString('<priority>', $response->getContent());
        $this->assertStringNotContainsString('<changefreq>', $response->getContent());
    }

    public function test_sitemap_lastmod_only_when_configured(): void
    {
        config(['site.sitemap' => [
            ['path' => '/', 'lastmod' => '2026-11-06'],
            ['path' => '/', 'lastmod' => null], // duplicada: deve ser ignorada
        ]]);

        $content = $this->get('/sitemap.xml')->getContent();
        $this->assertSame(1, substr_count($content, '<loc>'));
        $this->assertStringContainsString('<lastmod>2026-11-06</lastmod>', $content);
    }

    public function test_robots_blocks_non_production(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
        $this->get('/')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_robots_allows_indexing_in_production(): void
    {
        $this->app['env'] = 'production';

        $response = $this->get('/robots.txt');
        $response->assertOk()
            ->assertSee('Allow: /')
            ->assertSee('Sitemap: https://www.solutionbpo.com.br/sitemap.xml')
            ->assertDontSee('Disallow');
        $this->get('/')->assertHeaderMissing('X-Robots-Tag');
    }

    public function test_staging_can_require_basic_auth(): void
    {
        config(['site.staging_auth' => ['user' => 'cliente', 'password' => 'segredo']]);

        $this->get('/')->assertStatus(401)->assertHeader('WWW-Authenticate');
        $this->withHeader('Authorization', 'Basic '.base64_encode('cliente:segredo'))->get('/')->assertOk();
    }

    public function test_staging_auth_is_ignored_in_production(): void
    {
        $this->app['env'] = 'production';
        config(['site.staging_auth' => ['user' => 'cliente', 'password' => 'segredo']]);

        $this->get('/')->assertOk();
    }

    public function test_legacy_contact_url_redirects(): void
    {
        $this->get('/contato')->assertStatus(301)->assertRedirect('/#contato');
    }

    public function test_internal_storage_routes_are_disabled(): void
    {
        $this->get('/storage/qualquer-arquivo')->assertNotFound();
    }
}
