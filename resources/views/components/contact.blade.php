@props(['contact'])
@php
    $channels = [
        ['icon' => 'whatsapp', 'label' => 'WhatsApp', 'value' => $contact['phone_display'], 'href' => $contact['whatsapp_url'], 'external' => true, 'cta' => 'Iniciar conversa'],
        ['icon' => 'phone', 'label' => 'Telefone', 'value' => $contact['phone_display'], 'href' => 'tel:'.$contact['phone_e164'], 'external' => false, 'cta' => 'Ligar agora'],
        ['icon' => 'mail', 'label' => 'E-mail', 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email'], 'external' => false, 'cta' => 'Enviar e-mail'],
        ['icon' => 'instagram', 'label' => 'Instagram', 'value' => $contact['instagram_handle'], 'href' => $contact['instagram_url'], 'external' => true, 'cta' => 'Seguir'],
    ];
@endphp
<section id="contato" aria-labelledby="contato-titulo" class="section relative isolate overflow-hidden bg-navy">
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -left-32 top-10 size-[30rem] rounded-full bg-brand/40 blur-[120px]"></div>
        <div class="absolute -right-20 bottom-0 size-96 rounded-full bg-royal/40 blur-[120px]"></div>
    </div>
    <div class="container-site">
        <div class="max-w-3xl" data-reveal>
            <span class="eyebrow text-accent!">Contato</span>
            <h2 id="contato-titulo" class="heading-section text-white!">Vamos conversar sobre o financeiro da sua empresa</h2>
            <p class="lead text-white/70!">Escolha o canal que preferir para falar com a nossa equipe.</p>
        </div>

        <div class="mt-12 grid gap-6 lg:grid-cols-[1fr_1.1fr] lg:gap-8">
            <ul class="grid gap-4 sm:grid-cols-2" data-reveal-group>
                @foreach ($channels as $channel)
                    <li data-reveal-item>
                        <a href="{{ $channel['href'] }}" @if ($channel['external']) target="_blank" rel="noopener" @endif
                           class="group flex h-full flex-col rounded-2xl bg-white/[0.04] p-6 ring-1 ring-white/10 backdrop-blur transition duration-300 hover:-translate-y-1 hover:bg-white/[0.08] hover:ring-accent/40">
                            <span class="grid size-12 place-items-center rounded-xl bg-accent/15 text-accent transition group-hover:bg-accent group-hover:text-navy">
                                <x-icon :name="$channel['icon']" class="size-6" />
                            </span>
                            <span class="mt-5 text-xs font-bold uppercase tracking-[0.16em] text-white/50">{{ $channel['label'] }}</span>
                            <span class="mt-1 break-all font-semibold text-white">{{ $channel['value'] }}</span>
                            <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-accent">
                                {{ $channel['cta'] }} <x-icon name="arrow-up-right" class="size-4 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                            </span>
                        </a>
                    </li>
                @endforeach
                <li class="sm:col-span-2" data-reveal-item>
                    <a href="{{ $contact['maps_url'] }}" target="_blank" rel="noopener"
                       class="group flex items-center gap-5 rounded-2xl bg-white/[0.04] p-6 ring-1 ring-white/10 transition duration-300 hover:bg-white/[0.08] hover:ring-accent/40">
                        <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-accent/15 text-accent transition group-hover:bg-accent group-hover:text-navy">
                            <x-icon name="pin" class="size-6" />
                        </span>
                        <span>
                            <span class="block text-xs font-bold uppercase tracking-[0.16em] text-white/50">Endereço</span>
                            <span class="mt-1 block font-semibold text-white">{{ $contact['address']['display'] }}</span>
                            <span class="mt-1 inline-flex items-center gap-1.5 text-sm font-semibold text-accent">Como chegar <x-icon name="arrow-up-right" class="size-4" /></span>
                        </span>
                    </a>
                </li>
            </ul>

            <div class="min-h-80 overflow-hidden rounded-2xl ring-1 ring-white/10" data-reveal>
                <iframe src="{{ $contact['maps_embed_url'] }}" title="Mapa: {{ $contact['address']['display'] }}"
                        class="h-full min-h-80 w-full grayscale-[30%]" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
