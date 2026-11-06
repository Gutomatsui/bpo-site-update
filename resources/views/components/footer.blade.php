@props(['site'])
@php($contact = $site['contact'])
<footer class="relative bg-[#060c1a] text-white/70">
    <div class="container-site grid gap-12 py-16 sm:grid-cols-2 lg:grid-cols-[1.3fr_1fr_1fr_1.3fr] lg:py-20">
        <div>
            <a href="#inicio" aria-label="{{ $site['name'] }} — voltar ao início">
                <img src="{{ asset('assets/images/logo/logo-solution.png') }}" alt="{{ $site['name'] }}" width="199" height="100" loading="lazy" class="h-14 w-auto">
            </a>
            <p class="mt-6 max-w-xs text-sm leading-relaxed">{{ $site['about']['closing'] }}</p>
            <div class="mt-6 flex gap-3">
                <a href="{{ $contact['instagram_url'] }}" target="_blank" rel="noopener" aria-label="Instagram da Solution BPO"
                   class="grid size-10 place-items-center rounded-full ring-1 ring-white/15 transition hover:bg-accent hover:text-navy hover:ring-accent">
                    <x-icon name="instagram" class="size-5" />
                </a>
                <a href="{{ $contact['whatsapp_url'] }}" target="_blank" rel="noopener" aria-label="WhatsApp da Solution BPO"
                   class="grid size-10 place-items-center rounded-full ring-1 ring-white/15 transition hover:bg-accent hover:text-navy hover:ring-accent">
                    <x-icon name="whatsapp" class="size-5" />
                </a>
                <a href="mailto:{{ $contact['email'] }}" aria-label="Enviar e-mail para a Solution BPO"
                   class="grid size-10 place-items-center rounded-full ring-1 ring-white/15 transition hover:bg-accent hover:text-navy hover:ring-accent">
                    <x-icon name="mail" class="size-5" />
                </a>
            </div>
        </div>

        <nav aria-label="Navegação do rodapé">
            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Navegação</h2>
            <ul class="mt-5 space-y-3 text-sm">
                @foreach ($site['navigation'] as $item)
                    <li><a href="{{ $item['href'] }}" class="transition hover:text-accent">{{ $item['label'] }}</a></li>
                @endforeach
                <li><a href="#contato" class="transition hover:text-accent">Contato</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Serviços</h2>
            <ul class="mt-5 space-y-3 text-sm">
                @foreach ($site['services']['items'] as $service)
                    <li>
                        <a href="#servicos" x-data x-on:click="$dispatch('select-service', '{{ $service['id'] }}')" class="transition hover:text-accent">{{ $service['tab'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-xs font-bold uppercase tracking-[0.18em] text-white">Contato</h2>
            <ul class="mt-5 space-y-4 text-sm">
                <li>
                    <a href="{{ $contact['whatsapp_url'] }}" target="_blank" rel="noopener" class="flex items-center gap-3 transition hover:text-accent">
                        <x-icon name="whatsapp" class="size-4 shrink-0 text-accent" /> {{ $contact['phone_display'] }}
                    </a>
                </li>
                <li>
                    <a href="mailto:{{ $contact['email'] }}" class="flex items-center gap-3 transition hover:text-accent">
                        <x-icon name="mail" class="size-4 shrink-0 text-accent" /> {{ $contact['email'] }}
                    </a>
                </li>
                <li>
                    <a href="{{ $contact['website_url'] }}" class="flex items-center gap-3 transition hover:text-accent">
                        <x-icon name="globe" class="size-4 shrink-0 text-accent" /> {{ $contact['website_display'] }}
                    </a>
                </li>
                <li>
                    <a href="{{ $contact['maps_url'] }}" target="_blank" rel="noopener" class="flex items-start gap-3 transition hover:text-accent">
                        <x-icon name="pin" class="mt-0.5 size-4 shrink-0 text-accent" />
                        <address class="not-italic">{{ $contact['address']['display'] }}</address>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-site flex flex-col items-center justify-between gap-2 py-6 text-xs text-white/50 sm:flex-row">
            <p>Copyright © {{ now()->year }} • {{ $site['name'] }}</p>
            <a href="#inicio" class="inline-flex items-center gap-1.5 transition hover:text-white">Voltar ao topo <x-icon name="chevron-down" class="size-3.5 rotate-180" /></a>
        </div>
    </div>
    <div class="h-1 bg-gradient-to-r from-brand via-brand-light to-accent" aria-hidden="true"></div>
</footer>
