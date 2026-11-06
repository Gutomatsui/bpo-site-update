@props(['services'])
@php($items = $services['items'])
<section id="servicos" aria-labelledby="servicos-titulo" class="section relative overflow-hidden bg-surface">
    <div class="pointer-events-none absolute -right-40 top-20 size-[30rem] rounded-full bg-brand-light/10 blur-3xl" aria-hidden="true"></div>

    <div class="container-site relative">
        <div class="max-w-3xl" data-reveal>
            <span class="eyebrow">{{ $services['eyebrow'] }}</span>
            <h2 id="servicos-titulo" class="heading-section">{{ $services['title'] }}</h2>
            <p class="lead">{{ $services['intro'] }}</p>
        </div>

        <div x-data="serviceTabs(@js(array_column($items, 'id')))" x-on:select-service.window="select($event.detail)" class="mt-12 lg:mt-14" data-reveal>
            {{-- Abas: coluna única no celular (até 767px), 2 colunas no tablet e 4 lado a lado no desktop. --}}
            <div role="tablist" aria-label="Serviços" x-on:keydown="onKeydown($event)"
                 class="grid grid-cols-1 gap-2.5 md:grid-cols-2 md:gap-3 lg:grid-cols-4">
                @foreach ($items as $item)
                    <button type="button" role="tab" id="tab-{{ $item['id'] }}" aria-controls="painel-{{ $item['id'] }}"
                            x-on:click="select('{{ $item['id'] }}')"
                            :aria-selected="(active === '{{ $item['id'] }}').toString()" aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            :tabindex="active === '{{ $item['id'] }}' ? 0 : -1" tabindex="{{ $loop->first ? 0 : -1 }}"
                            class="group relative flex w-full items-center gap-3 rounded-2xl border px-4 py-3.5 text-left text-sm font-bold transition duration-300 ease-out-soft sm:px-5 sm:py-4"
                            :class="active === '{{ $item['id'] }}'
                                ? 'border-transparent bg-navy text-white shadow-lift'
                                : 'border-slate-300/80 bg-white text-navy hover:border-brand/40 hover:shadow-soft'">
                        {{-- Os PNGs originais são brancos: usados como máscara, a cor do ícone vem
                             do CSS (azul Solution no inativo, azul-marinho sobre o laranja no ativo). --}}
                        <span class="grid size-10 shrink-0 place-items-center rounded-xl transition"
                              :class="active === '{{ $item['id'] }}' ? 'bg-accent text-navy' : 'bg-brand/10 text-brand group-hover:bg-brand/15'">
                            <span class="service-tab-icon" style="--icon: url('{{ asset($item['icon']) }}')" aria-hidden="true"></span>
                        </span>
                        <span>{{ $item['tab'] }}</span>
                    </button>
                @endforeach
            </div>

            {{-- Painéis --}}
            <div class="mt-6 grid">
                @foreach ($items as $item)
                    <div role="tabpanel" id="painel-{{ $item['id'] }}" aria-labelledby="tab-{{ $item['id'] }}" tabindex="0"
                         x-show="active === '{{ $item['id'] }}'" @unless ($loop->first) x-cloak @endunless
                         x-transition:enter="transition duration-500 ease-out-soft" x-transition:enter-start="opacity-0 translate-y-3"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="[grid-area:1/1] overflow-hidden rounded-3xl bg-white shadow-soft ring-1 ring-slate-200/70">
                        <div class="grid lg:grid-cols-[1.25fr_1fr]">
                            <div class="p-6 sm:p-10 lg:p-12">
                                <h3 class="text-2xl font-extrabold tracking-tight text-navy sm:text-3xl">{{ $item['title'] }}</h3>
                                <div class="mt-5 space-y-3">
                                    @foreach ($item['highlights'] as $highlight)
                                        <p class="border-l-[3px] border-accent pl-4 text-base font-medium leading-relaxed text-ink sm:text-lg">{{ $highlight }}</p>
                                    @endforeach
                                </div>

                                <div class="mt-8">
                                    <h4 class="text-xs font-bold uppercase tracking-[0.16em] text-brand">O que nós fazemos:</h4>
                                    <ul class="mt-4 grid gap-x-6 gap-y-3 sm:grid-cols-2">
                                        @foreach ($item['we_do'] as $task)
                                            <li class="flex items-start gap-3 text-base leading-snug text-ink">
                                                <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-brand/10 text-brand">
                                                    <x-icon name="check" class="size-3.5" />
                                                </span>
                                                {{ $task }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                @if (! empty($item['client']))
                                    <div class="mt-8 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-50 p-5 ring-1 ring-accent/30">
                                        <h4 class="text-xs font-bold uppercase tracking-[0.16em] text-accent-ink">{{ $item['client_label'] }}</h4>
                                        @foreach ($item['client'] as $clientTask)
                                            <p class="mt-2 font-medium leading-relaxed text-ink">{{ $clientTask }}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="relative flex items-center justify-center overflow-hidden bg-gradient-to-br from-navy via-navy-600 to-brand p-8 sm:p-10">
                                <div class="pointer-events-none absolute -bottom-20 -right-20 size-64 rounded-full border-[28px] border-white/5" aria-hidden="true"></div>
                                <div class="pointer-events-none absolute -left-10 -top-10 size-40 rounded-full bg-accent/20 blur-2xl" aria-hidden="true"></div>
                                <figure class="relative">
                                    <div class="absolute -inset-3 rounded-[1.75rem] bg-white/10 ring-1 ring-white/15" aria-hidden="true"></div>
                                    <x-picture :src="$item['image']" :ext="$item['image_ext']" :alt="$item['image_alt']"
                                               :width="$item['image_size'][0]" :height="$item['image_size'][1]"
                                               class="relative block overflow-hidden rounded-2xl shadow-2xl"
                                               img-class="block h-auto w-auto max-w-full" />
                                </figure>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
