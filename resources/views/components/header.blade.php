@props(['site'])
@php($nav = $site['navigation'])
<header x-data="siteHeader" x-on:keydown.escape.window="close()"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-500 ease-out-soft"
        :class="scrolled ? 'bg-navy/90 shadow-[0_10px_30px_-12px_rgb(0_0_0/0.5)] backdrop-blur-xl' : 'bg-navy'">
    <div class="h-1 bg-gradient-to-r from-brand via-brand-light to-accent" aria-hidden="true"></div>
    <div class="container-site flex items-center justify-between gap-6 transition-[height] duration-500 ease-out-soft"
         :class="scrolled ? 'h-16 lg:h-[4.5rem]' : 'h-[4.5rem] lg:h-20'">
        <a href="#inicio" class="shrink-0" aria-label="{{ $site['name'] }} — voltar ao início">
            <img src="{{ asset('assets/images/logo/logo-solution.png') }}" alt="{{ $site['name'] }}"
                 width="199" height="100" class="h-11 w-auto transition-all duration-500 lg:h-12" :class="scrolled && 'lg:h-11'">
        </a>

        <nav aria-label="Navegação principal" class="hidden lg:block">
            <ul class="flex items-center gap-1">
                @foreach ($nav as $item)
                    <li>
                        <a href="{{ $item['href'] }}"
                           class="relative rounded-full px-3.5 py-2 text-sm font-medium text-white/75 transition hover:text-white xl:px-4"
                           :class="active === '{{ ltrim($item['href'], '#') }}' && 'text-white!'"
                           :aria-current="active === '{{ ltrim($item['href'], '#') }}' ? 'location' : null">
                            {{ $item['label'] }}
                            <span class="absolute inset-x-3.5 -bottom-0.5 h-0.5 origin-left scale-x-0 rounded-full bg-accent transition-transform duration-300 xl:inset-x-4"
                                  :class="active === '{{ ltrim($item['href'], '#') }}' && 'scale-x-100'" aria-hidden="true"></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>

        <div class="flex items-center gap-3">
            <a href="#contato" class="btn btn-accent hidden px-5 py-2.5 sm:inline-flex">
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
