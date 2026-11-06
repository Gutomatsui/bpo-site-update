@props(['site'])
@php($nav = $site['navigation'])
<header x-data="siteHeader" x-on:keydown.escape.window="close()"
        class="on-dark fixed inset-x-0 top-0 z-50 overflow-x-clip transition-all duration-500 ease-out-soft"
        :class="scrolled ? 'bg-navy/90 shadow-[0_10px_30px_-12px_rgb(0_0_0/0.5)] backdrop-blur-xl' : 'bg-navy'">
    <div class="h-1 bg-gradient-to-r from-brand via-brand-light to-accent" aria-hidden="true"></div>
    <div class="container-site flex items-center justify-between gap-6 transition-[height] duration-500 ease-out-soft"
         :class="scrolled ? 'h-16 lg:h-[4.5rem]' : 'h-[4.5rem] lg:h-20'">
        {{-- Logo + recorte em V (assinatura do site original). O wrapper ocupa a altura
             da barra, então "top: 100%" é exatamente a borda inferior do header, e
             "left: 50%" é o centro real do logo em qualquer resolução. --}}
        <div class="relative flex shrink-0 items-center self-stretch">
            <a href="#inicio" class="relative z-10" aria-label="{{ $site['name'] }} — voltar ao início">
                <picture class="block"><source srcset="{{ asset('assets/images/logo/logo-solution.webp') }}" type="image/webp"><img src="{{ asset('assets/images/logo/logo-solution.png') }}" alt="{{ $site['name'] }}"
                     width="199" height="100" class="h-11 w-auto transition-all duration-500 lg:h-12" :class="scrolled && 'lg:h-11'"></picture>
            </a>

            {{-- Decorativo: 8000px de largura centrados no logo, recortados pelo header
                 (overflow-x: clip). Um único path desenha a borda inteira, incluindo o V. --}}
            <svg class="header-notch" x-ref="notch" :data-hidden="showNotch ? null : ''"
                 width="8000" height="44" viewBox="0 0 8000 44" aria-hidden="true" focusable="false">
                <defs>
                    <linearGradient id="header-edge-gradient" gradientUnits="userSpaceOnUse"
                                    x1="0" y1="0" x2="1200" y2="0" spreadMethod="repeat">
                        <stop offset="0" stop-color="#ffffff" />
                        <stop offset="0.33" stop-color="#1783cc" />
                        <stop offset="0.66" stop-color="#ffa235" />
                        <stop offset="1" stop-color="#ffffff" />
                        <animateTransform attributeName="gradientTransform" type="translate"
                                          from="0 0" to="1200 0" dur="5s" repeatCount="indefinite" />
                    </linearGradient>
                </defs>
                {{-- Preenchimento do V: mesmo azul-marinho do header --}}
                <path class="header-notch-fill" d="M3932 0 L4000 40 L4068 0 Z" />
                {{-- Linha luminosa: borda horizontal + diagonais do V em um só traçado --}}
                <path class="header-notch-line" d="M0 1 H3932 L4000 40 L4068 1 H8000"
                      stroke="url(#header-edge-gradient)" vector-effect="non-scaling-stroke" />
            </svg>
        </div>

        <nav aria-label="Navegação principal" class="hidden lg:block">
            <ul class="flex items-center gap-1">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}"
                           class="relative inline-flex min-h-11 items-center rounded-full px-3.5 text-sm font-medium text-white/80 transition hover:text-white xl:px-4"
                           :class="active === '{{ ltrim($item['href'], '#') }}' && 'text-white!'"
                           :aria-current="active === '{{ ltrim($item['href'], '#') }}' ? 'location' : null">
                            {{ $item['label'] }}
                            <span class="absolute inset-x-3.5 bottom-1 h-0.5 origin-left scale-x-0 rounded-full bg-accent transition-transform duration-300 xl:inset-x-4"
                                  :class="active === '{{ ltrim($item['href'], '#') }}' && 'scale-x-100'" aria-hidden="true"></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-3">
            <a href="#contato" class="btn btn-accent hidden min-h-11 px-5 py-2.5 sm:inline-flex">
                Contato
                <x-icon name="arrow-right" class="size-4" />
            </a>
            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full text-white ring-1 ring-white/20 transition hover:bg-white/10 lg:hidden"
                    x-on:click="toggle()" :aria-expanded="open.toString()" aria-controls="menu-mobile"
                    :aria-label="open ? 'Fechar menu' : 'Abrir menu'" aria-label="Abrir menu" aria-expanded="false">
                <x-icon name="menu" class="size-6" x-show="!open" />
                <x-icon name="close" class="size-6" x-show="open" x-cloak />
            </button>
        </div>
    </div>

    {{-- Menu mobile --}}
    <div id="menu-mobile" x-show="open" x-cloak
         x-transition:enter="transition duration-300 ease-out-soft" x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition duration-200 ease-in"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         x-trap.noscroll="open"
         class="border-t border-white/10 bg-navy lg:hidden">
        <nav aria-label="Navegação principal (celular)" class="container-site max-h-[calc(100dvh-5rem)] overflow-y-auto py-6">
            <ul class="space-y-1">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}" x-on:click="close()"
                           class="flex items-center justify-between rounded-xl px-4 py-3.5 text-base font-semibold text-white/85 transition hover:bg-white/5 hover:text-white"
                           :class="active === '{{ ltrim($item['href'], '#') }}' && 'bg-white/5 text-white!'">
                            {{ $item['label'] }}
                            <x-icon name="chevron-right" class="size-4 text-accent" />
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-6 grid gap-3 border-t border-white/10 pt-6 sm:grid-cols-2">
                <a href="#contato" x-on:click="close()" class="btn btn-accent w-full">Contato</a>
                <a href="{{ $site['contact']['whatsapp_url'] }}" target="_blank" rel="noopener" class="btn btn-ghost-light w-full">
                    <x-icon name="whatsapp" class="size-5" /> {{ $site['contact']['phone_display'] }}
                </a>
            </div>
        </nav>
    </div>
</header>
<div class="h-[calc(4.5rem+4px)] lg:h-[calc(5rem+4px)]" aria-hidden="true"></div>
