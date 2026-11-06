@props(['testimonials', 'clients'])
<section id="depoimentos" aria-labelledby="depoimentos-titulo" class="section relative overflow-hidden bg-white">
    <div class="container-site">
        <div class="grid gap-12 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16">
            <div data-reveal>
                <span class="eyebrow">Depoimentos</span>
                <h2 id="depoimentos-titulo" class="heading-section">O que dizem nossos clientes</h2>
                <p class="lead">Parcerias de longo prazo, construídas com transparência e proximidade.</p>
            </div>

            <div x-data="testimonialsSlider" class="testimonials-swiper min-w-0" data-reveal>
                <section class="swiper" x-ref="swiper" aria-roledescription="carrossel" aria-label="Depoimentos de clientes">
                    <div class="swiper-wrapper">
                        @foreach ($testimonials as $t)
                            <div class="swiper-slide h-auto!" role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} de {{ count($testimonials) }}">
                                <figure class="relative flex h-full flex-col overflow-hidden rounded-[2rem] bg-gradient-to-br from-navy to-navy-600 p-8 text-white shadow-lift sm:p-12">
                                    <x-icon name="quote" class="absolute right-8 top-8 size-20 text-white/5 sm:size-28" />
                                    <x-icon name="quote" class="size-9 text-accent" />
                                    <blockquote class="mt-6 flex-1 text-lg font-medium leading-relaxed text-white/90 sm:text-xl">
                                        <p>“{{ $t['quote'] }}”</p>
                                    </blockquote>
                                    <figcaption class="mt-8 flex items-center gap-4 border-t border-white/10 pt-6">
                                        <span class="grid h-14 w-20 shrink-0 place-items-center overflow-hidden rounded-xl bg-white p-1.5">
                                            <x-picture :src="$t['logo']" ext="jpg" alt="" width="148" height="100" img-class="max-h-11 w-auto object-contain" />
                                        </span>
                                        <span>
                                            <span class="block text-xs font-bold uppercase tracking-[0.16em] text-accent">{{ $t['company'] }}</span>
                                            <span class="mt-1 block font-bold text-white">{{ $t['author'] }}</span>
                                            <span class="block text-sm text-white/60">{{ $t['role'] }}</span>
                                        </span>
                                    </figcaption>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </section>
                <div class="mt-6 flex items-center justify-between">
                    <div class="swiper-pagination !static !w-auto flex items-center" x-ref="pagination"></div>
                    <div class="flex gap-2">
                        <button type="button" x-on:click="toggleAutoplay()" x-show="autoplayAvailable"
                                class="inline-flex size-11 items-center justify-center rounded-full text-navy ring-1 ring-slate-200 transition hover:bg-surface"
                                :aria-label="playing ? 'Pausar troca automática de depoimentos' : 'Retomar troca automática de depoimentos'" aria-label="Pausar troca automática de depoimentos">
                            <x-icon name="pause" class="size-4" x-show="playing" />
                            <x-icon name="play" class="size-4" x-show="!playing" x-cloak />
                        </button>
                        <button type="button" x-ref="prev" aria-label="Depoimento anterior" class="inline-flex size-11 items-center justify-center rounded-full text-navy ring-1 ring-slate-200 transition hover:bg-navy hover:text-white disabled:opacity-40">
                            <x-icon name="chevron-left" />
                        </button>
                        <button type="button" x-ref="next" aria-label="Próximo depoimento" class="inline-flex size-11 items-center justify-center rounded-full bg-navy text-white transition hover:bg-brand disabled:opacity-40">
                            <x-icon name="chevron-right" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Clientes --}}
        <div class="mt-20 lg:mt-24" data-reveal>
            <div x-data="clientsSlider">
            <div class="flex items-center gap-4 sm:gap-6">
                <h3 class="text-xs font-bold uppercase tracking-[0.18em] text-muted">Clientes que confiam na Solution</h3>
                <span class="h-px flex-1 bg-slate-200" aria-hidden="true"></span>
                <button type="button" x-on:click="toggleAutoplay()" x-show="autoplayAvailable" x-cloak
                        class="inline-flex size-11 shrink-0 items-center justify-center rounded-full text-navy ring-1 ring-slate-200 transition hover:bg-surface"
                        :aria-label="playing ? 'Pausar rolagem automática dos logotipos' : 'Retomar rolagem automática dos logotipos'" aria-label="Pausar rolagem automática dos logotipos">
                    <x-icon name="pause" class="size-4" x-show="playing" />
                    <x-icon name="play" class="size-4" x-show="!playing" x-cloak />
                </button>
            </div>
            <div class="mt-8">
                <section class="swiper" x-ref="swiper" aria-label="Logotipos de clientes">
                    <ul class="swiper-wrapper">
                        @foreach ($clients as $client)
                            <li class="swiper-slide h-auto!">
                                <div class="flex h-28 items-center justify-center rounded-2xl border border-slate-200/80 bg-white px-6 shadow-soft transition duration-500 hover:-translate-y-1 hover:shadow-lift">
                                    <x-picture :src="$client['logo']" :ext="$client['ext']" :alt="$client['name']"
                                               :width="$client['size'][0]" :height="$client['size'][1]"
                                               img-class="max-h-16 w-auto object-contain" />
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            </div>
            </div>
        </div>
    </div>
</section>
