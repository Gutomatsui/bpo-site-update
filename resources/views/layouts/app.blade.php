@php
    $meta ??= \App\Support\Seo::page();
    $firstSlide = $site['slides'][0]['image'] ?? null;
@endphp
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="robots" content="{{ $meta['robots'] }}">
    <link rel="canonical" href="{{ $meta['canonical'] }}">
    <meta name="theme-color" content="#091124">
    <meta name="format-detection" content="telephone=no">

    {{-- Open Graph --}}
    <meta property="og:type" content="{{ $meta['type'] }}">
    <meta property="og:locale" content="{{ $meta['locale'] }}">
    <meta property="og:site_name" content="{{ $meta['site_name'] }}">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:url" content="{{ $meta['canonical'] }}">
    <meta property="og:image" content="{{ $meta['image'] }}">
    @if ($meta['image_width'])
        <meta property="og:image:width" content="{{ $meta['image_width'] }}">
        <meta property="og:image:height" content="{{ $meta['image_height'] }}">
    @endif
    <meta property="og:image:alt" content="{{ $meta['image_alt'] }}">

    {{-- Twitter / X --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:image" content="{{ $meta['image'] }}">
    <meta name="twitter:image:alt" content="{{ $meta['image_alt'] }}">

    {{-- Ícones (derivados do logotipo oficial) --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    @if ($firstSlide)
        {{-- LCP: primeiro slide do banner (mesmos srcset/sizes do <img>) --}}
        <link rel="preload" as="image" type="image/webp" fetchpriority="high"
              href="{{ asset($firstSlide.'-1366.webp') }}"
              imagesrcset="{{ asset($firstSlide.'-480.webp') }} 480w, {{ asset($firstSlide.'-768.webp') }} 768w, {{ asset($firstSlide.'-1366.webp') }} 1366w"
              imagesizes="(min-width: 1280px) 1216px, calc(100vw - 32px)">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Sem JavaScript: exibe o conteúdo de todas as abas e respostas do FAQ --}}
    <noscript>
        <style>
            [role="tabpanel"][x-cloak], [data-faq-answer][x-cloak] { display: block !important; }
            [role="tabpanel"] { grid-area: auto !important; margin-bottom: 1.5rem; }
            [data-reveal], [data-reveal-item] { opacity: 1 !important; }
        </style>
    </noscript>

    @isset($structuredData)
        <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endisset
</head>
<body class="bg-white font-sans text-ink antialiased">
    <a href="#conteudo" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:font-semibold focus:text-navy focus:shadow-lg">
        Pular para o conteúdo
    </a>

    <x-header :site="$site" />

    <main id="conteudo">
        @yield('content')
    </main>

    <x-footer :site="$site" />
    <x-floating-actions :contact="$site['contact']" />
</body>
</html>
