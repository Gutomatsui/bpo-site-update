<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $site = config('site');

        return view('home', [
            'site' => $site,
            'structuredData' => $this->structuredData($site),
        ]);
    }

    /**
     * Dados estruturados (schema.org) da empresa e das perguntas frequentes.
     */
    private function structuredData(array $site): array
    {
        $url = rtrim(config('app.url'), '/').'/';
        $contact = $site['contact'];
        $address = $contact['address'];

        $business = [
            '@type' => 'ProfessionalService',
            '@id' => $url.'#empresa',
            'name' => $site['name'],
            'alternateName' => $site['short_name'],
            'description' => $site['seo']['description'],
            'url' => $url,
            'logo' => asset('assets/images/logo/logo-solution.png'),
            'image' => asset($site['seo']['og_image']),
            'telephone' => $contact['phone_e164'],
            'email' => $contact['email'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address['street'],
                'addressLocality' => $address['city'],
                'addressRegion' => $address['state'],
                'addressCountry' => $address['country'],
            ],
            'areaServed' => 'BR',
            'sameAs' => [$contact['instagram_url']],
            'employee' => [
                '@type' => 'Person',
                'name' => $site['director']['name'],
                'jobTitle' => $site['director']['role'],
            ],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name' => 'Serviços de BPO Financeiro',
                'itemListElement' => array_map(fn (array $service) => [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => $service['tab'],
                        'description' => implode(' ', $service['highlights']),
                    ],
                ], $site['services']['items']),
            ],
        ];

        $faq = [
            '@type' => 'FAQPage',
            '@id' => $url.'#faq',
            'mainEntity' => array_map(fn (array $item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($item['answer'], '<ul><li><strong><p>')],
            ], $site['faq']),
        ];

        $website = [
            '@type' => 'WebSite',
            '@id' => $url.'#site',
            'url' => $url,
            'name' => $site['name'],
            'inLanguage' => 'pt-BR',
            'publisher' => ['@id' => $url.'#empresa'],
        ];

        return ['@context' => 'https://schema.org', '@graph' => [$business, $website, $faq]];
    }
}
