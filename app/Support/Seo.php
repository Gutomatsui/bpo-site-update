<?php

namespace App\Support;

/**
 * Metadados de SEO por página.
 *
 * Uso em um controller de página futura:
 *   'meta' => Seo::page(title: 'Serviços', description: '...', path: '/servicos')
 *
 * Todas as URLs absolutas usam config('site.url') (domínio oficial), nunca o
 * host da requisição, para que ambientes locais/homologação não gerem URLs próprias.
 */
class Seo
{
    public static function page(
        ?string $title = null,
        ?string $description = null,
        string $path = '/',
        ?string $image = null,
        ?string $imageAlt = null,
        string $type = 'website',
        bool $indexable = true,
    ): array {
        $seo = config('site.seo');

        return [
            'title' => $title === null ? $seo['title'] : $title.$seo['title_suffix'],
            'description' => $description ?? $seo['description'],
            'canonical' => self::url($path),
            'robots' => self::robots($indexable),
            'type' => $type,
            'locale' => $seo['locale'],
            'site_name' => config('site.name'),
            'image' => self::url($image ?? $seo['og_image']),
            'image_width' => $image ? null : $seo['og_image_width'],
            'image_height' => $image ? null : $seo['og_image_height'],
            'image_alt' => $imageAlt ?? $seo['og_image_alt'],
        ];
    }

    /** URL absoluta no domínio oficial. */
    public static function url(string $path = '/'): string
    {
        return config('site.url').'/'.ltrim($path, '/');
    }

    /** Fora de produção nada é indexável. */
    public static function robots(bool $indexable = true): string
    {
        if (! app()->isProduction() || ! $indexable) {
            return 'noindex, nofollow';
        }

        return 'index, follow, max-image-preview:large, max-snippet:-1';
    }

    /**
     * JSON-LD da organização, somente com dados oficiais publicados no site.
     */
    public static function organization(): array
    {
        $site = config('site');
        $contact = $site['contact'];
        $address = $contact['address'];

        return [
            '@type' => 'Organization',
            '@id' => self::url('/').'#organizacao',
            'name' => $site['name'],
            'alternateName' => $site['short_name'],
            'url' => self::url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => self::url('assets/images/logo/logo-solution.png'),
                'width' => 199,
                'height' => 100,
            ],
            'email' => $contact['email'],
            'telephone' => $contact['phone_e164'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address['street'],
                'addressLocality' => $address['city'],
                'addressRegion' => $address['state'],
                'addressCountry' => $address['country'],
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $contact['phone_e164'],
                'email' => $contact['email'],
                'availableLanguage' => 'Portuguese',
            ],
            'sameAs' => [$contact['instagram_url']],
        ];
    }

    public static function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => self::url('/').'#site',
            'url' => self::url('/'),
            'name' => config('site.name'),
            'inLanguage' => 'pt-BR',
            'publisher' => ['@id' => self::url('/').'#organizacao'],
        ];
    }

    public static function graph(array ...$nodes): array
    {
        return ['@context' => 'https://schema.org', '@graph' => $nodes];
    }
}
