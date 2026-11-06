@props(['faq'])
<section id="faq" aria-labelledby="faq-titulo" class="section bg-surface">
    <div class="container-site grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
        <div data-reveal>
            <span class="eyebrow">FAQ</span>
            <h2 id="faq-titulo" class="heading-section">Perguntas Frequentes</h2>
            <p class="lead">Ainda com dúvidas? Fale diretamente com a nossa equipe.</p>
            <a href="#contato" class="btn mt-8 bg-navy text-white hover:bg-brand">
                Falar com a Solution <x-icon name="arrow-right" class="size-4" />
            </a>
        </div>

        <div x-data="{ open: 0 }" class="space-y-4" data-reveal-group>
            @foreach ($faq as $i => $item)
                <div class="overflow-hidden rounded-2xl bg-white ring-1 transition-[box-shadow] duration-300"
                     :class="open === {{ $i }} ? 'shadow-lift ring-brand/20' : 'shadow-soft ring-slate-200/80'" data-reveal-item>
                    <h3>
                        <button type="button" id="faq-pergunta-{{ $i }}" aria-controls="faq-resposta-{{ $i }}"
                                x-on:click="open = open === {{ $i }} ? null : {{ $i }}"
                                :aria-expanded="(open === {{ $i }}).toString()" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                                class="flex w-full items-center justify-between gap-6 px-6 py-5 text-left text-base font-bold text-navy sm:px-8 sm:py-6 sm:text-lg">
                            {{ $item['question'] }}
                            <span class="grid size-9 shrink-0 place-items-center rounded-full transition duration-300"
                                  :class="open === {{ $i }} ? 'rotate-45 bg-accent text-navy' : 'bg-surface text-brand'">
                                <x-icon name="plus" class="size-4" />
                            </span>
                        </button>
                    </h3>
                    <section id="faq-resposta-{{ $i }}" data-faq-answer aria-labelledby="faq-pergunta-{{ $i }}"
                         x-show="open === {{ $i }}" x-collapse @unless ($i === 0) x-cloak @endunless>
                        <div class="prose-answer px-6 pb-6 leading-relaxed text-muted sm:px-8 sm:pb-7">
                            {!! $item['answer'] !!}
                        </div>
                    </section>
                </div>
            @endforeach
        </div>
    </div>
</section>
