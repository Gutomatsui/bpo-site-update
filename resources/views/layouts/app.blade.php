@php
    $seo = $site['seo'];
    $canonical = rtrim(config('app.url'), '/').'/';
    $ogImage = asset($seo['og_image']);
    $firstSlide = $site['slides'][0]['image'];
@endphp
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <link rel="canonical" href="{{ $canonical }}">
    <meta name="theme-color" content="#091124">
    @unless (app()->isProduction())
        <meta name="robots" content="noindex, nofollow">
    @endunless

    {{-- Open Graph / redes sociais --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{ $seo['locale'] }}">
    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="{{ $seo['og_image_width'] }}">
    <meta property="og:image:height" content="{{ $seo['og_image_height'] }}">
    <meta property="og:image:alt" content="{{ $site['slides'][0]['alt'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Ícones --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48">
    <link rel="icon" type="image/png" href="{{ asset('favicon-32.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- LCP: primeiro slide do banner --}}
    <link rel="preload" as="image" type="image/webp" fetchpriority="high"
          href="{{ asset($firstSlide.'-1366.webp') }}"
          imagesrcset="{{ asset($firstSlide.'-768.webp') }} 768w, {{ asset($firstSlide.'-1366.webp') }} 1366w"
          imagesizes="(min-width: 1280px) 1216px, calc(100vw - 32px)">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
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
    <x-whatsapp-float :contact="$site['contact']" />
</body>
</html>
