@props(['workflow'])
@php
    $steps = $workflow['steps'];
    $total = count($steps);
    $pad = fn (int $n) => str_pad($n, 2, '0', STR_PAD_LEFT);
@endphp
{{-- "Como funciona" — jornada vertical com scrollytelling.
     Desktop: painel azul-marinho fixo (sticky) à esquerda + etapas à direita.
     Celular/tablet: coluna única com linha de progresso à esquerda.
     Todo o conteúdo está no HTML; o JS só realça a etapa ativa e preenche a linha. --}}
<section id="como-funciona" aria-labelledby="como-funciona-titulo"
         x-data="workflowJourney(@js(array_column($steps, 'title')))"
         class="journey section relative bg-white">
    <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent" aria-hidden="true"></div>

    <div class="container-site grid gap-12 lg:grid-cols-[minmax(0,0.92fr)_minmax(0,1.08fr)] lg:gap-14 xl:gap-20">
        {{-- Painel visual: sticky apenas no desktop --}}
        <div class="lg:sticky lg:top-24 lg:self-start">
            <div class="on-dark relative isolate overflow-hidden rounded-[2rem] bg-navy p-7 text-white shadow-lift sm:p-10" data-reveal>
                <div class="pointer-events-none absolute -right-24 -top-24 -z-10 size-72 rounded-full bg-brand-light/25 blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute -bottom-28 -left-16 -z-10 size-64 rounded-full bg-accent/15 blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(rgb(255_255_255/0.07)_1px,transparent_1px)] [background-size:22px_22px] [mask-image:linear-gradient(to_bottom,black,transparent_75%)]" aria-hidden="true"></div>

                <span class="eyebrow text-accent!">{{ $workflow['eyebrow'] }}</span>
                <h2 id="como-funciona-titulo" class="mt-4 text-3xl font-extrabold tracking-tight text-balance text-white sm:text-4xl lg:text-[2.05rem] lg:leading-[1.18] xl:text-[2.4rem]">{{ $workflow['title'] }}</h2>
                <p class="mt-4 text-base leading-relaxed text-pretty text-white/75 sm:text-lg">{{ $workflow['intro'] }}</p>

                {{-- Ilustração + progresso: decorativos (o conteúdo está na lista ao lado) --}}
                <div class="hidden lg:block" aria-hidden="true">
                    <div class="journey-stage relative mt-8 overflow-hidden rounded-3xl bg-white/[0.04] ring-1 ring-white/10">
                        @include('components.workflow-scenes')
                    </div>

                    <div class="mt-6 flex items-end justify-between gap-6">
                        <p class="flex items-baseline gap-2 font-extrabold tabular-nums leading-none">
                            <span class="text-5xl text-white" x-text="counter">01</span>
                            <span class="text-lg text-white/45">/ {{ $pad($total) }}</span>
                        </p>
                        <p class="max-w-[62%] text-right text-sm font-semibold leading-snug text-white/80 line-clamp-2" x-text="titles[active]">{{ $steps[0]['title'] }}</p>
                    </div>
                    <div class="relative mt-4 h-1.5 overflow-hidden rounded-full bg-white/10">
                        <div class="journey-bar absolute inset-0 rounded-full bg-gradient-to-r from-brand-light via-brand-light to-accent"></div>
                    </div>
                    <div class="mt-3 grid grid-cols-5 gap-2">
                        @foreach ($steps as $step)
                            <span class="h-1 rounded-full transition-colors duration-500"
                                  :class="{ 'bg-accent': active >= {{ $loop->index }}, 'bg-white/15': active < {{ $loop->index }} }"
                                  @class(['bg-accent' => $loop->first, 'bg-white/15' => ! $loop->first])></span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Jornada vertical --}}
        {{-- lg:mb: mantém o painel fixo até o ícone de conclusão chegar à região principal da tela --}}
        <div class="relative lg:mb-[clamp(0px,calc(54.5rem-55vh),26rem)] [--node:3.5rem] [--pad:1rem] sm:[--pad:1.5rem] lg:[--node:4rem] lg:[--pad:2rem]">
            {{-- Linha: do centro do primeiro ícone até o ícone de conclusão --}}
            <div class="absolute left-[calc(var(--node)/2-1px)] top-[calc(var(--pad)+var(--node)/2)] bottom-[calc(var(--node)/2)] w-0.5 rounded-full bg-slate-200"
                 x-ref="rail" aria-hidden="true">
                <div class="journey-rail-fill absolute inset-0 rounded-full bg-gradient-to-b from-brand via-brand-light to-accent"></div>
                <div class="journey-rail-head absolute inset-0">
                    <span class="absolute left-1/2 top-0 size-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-accent shadow-[0_0_0_4px_rgb(255_162_53/0.2),0_0_14px_rgb(255_162_53/0.55)]"></span>
                </div>
            </div>

            <ol class="relative space-y-3 sm:space-y-4 lg:space-y-8">
                @foreach ($steps as $step)
                    <li class="grid grid-cols-[var(--node)_minmax(0,1fr)] gap-4 sm:gap-6 lg:gap-8" data-journey-step
                        :aria-current="active === {{ $loop->index }} ? 'step' : null"
                        @if ($loop->first) aria-current="step" @endif>
                        <div class="relative z-10 pt-[var(--pad)]">
                            <div class="journey-node grid size-[var(--node)] place-items-center rounded-2xl bg-navy"
                                 :class="{ 'is-active': active === {{ $loop->index }}, 'is-done': active > {{ $loop->index }} }"
                                 @class(['is-active' => $loop->first])>
                                <x-picture :src="str_replace('.png', '', $step['icon'])" ext="png" alt="" width="60" height="60" img-class="size-7 object-contain lg:size-8" />
                            </div>
                        </div>

                        <div data-reveal class="journey-card relative rounded-3xl p-[var(--pad)] ring-1 transition duration-500 ease-out-soft"
                             :class="{ 'is-active bg-white shadow-lift ring-slate-200/80': active === {{ $loop->index }}, 'ring-transparent': active !== {{ $loop->index }} }"
                             @class(['is-active bg-white shadow-lift ring-slate-200/80' => $loop->first, 'ring-transparent' => ! $loop->first])>
                            <span class="journey-num block text-5xl font-extrabold leading-none tracking-tighter tabular-nums lg:text-7xl" aria-hidden="true">{{ $pad($loop->iteration) }}</span>
                            <h3 class="mt-4 text-lg font-bold leading-snug text-navy sm:text-xl lg:mt-5 lg:text-2xl">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-base leading-relaxed text-muted lg:text-lg">{{ $step['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>

            {{-- Fim da linha: ícone de conclusão --}}
            <div class="relative z-10 mt-3 grid grid-cols-[var(--node)_minmax(0,1fr)] sm:mt-4 lg:mt-8" aria-hidden="true">
                <div class="journey-end grid size-[var(--node)] place-items-center rounded-full" :class="done && 'is-done'">
                    <x-icon name="check" class="size-6 lg:size-7" />
                </div>
            </div>
        </div>
    </div>
</section>
