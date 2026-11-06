<?php

namespace Tests\Feature;

use Tests\TestCase;

class SiteTest extends TestCase
{
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

    public function test_referenced_images_exist(): void
    {
        $html = $this->get('/')->getContent();
        preg_match_all('#/(assets/[^"\s,]+\.(?:png|jpg|webp))#', $html, $m);

        $this->assertNotEmpty($m[1]);
        foreach (array_unique($m[1]) as $path) {
            $this->assertFileExists(public_path($path));
        }
    }

    public function test_structured_data_is_valid_json(): void
    {
        $html = $this->get('/')->getContent();
        preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $m);

        $data = json_decode($m[1] ?? '', true);
        $this->assertSame('https://schema.org', $data['@context'] ?? null);
        $this->assertCount(3, $data['@graph']);
    }

    public function test_seo_routes(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
        $this->get('/sitemap.xml')->assertOk()->assertSee('<urlset', false);
    }

    public function test_robots_allows_indexing_in_production(): void
    {
        $this->app['env'] = 'production';
        $this->get('/robots.txt')->assertOk()->assertSee('Allow: /')->assertSee('sitemap.xml');
    }

    public function test_legacy_contact_url_redirects(): void
    {
        $this->get('/contato')->assertStatus(301)->assertRedirect('/#contato');
    }
}
