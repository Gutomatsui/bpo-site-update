@props(['about', 'director'])
<section id="sobre-nos" aria-labelledby="sobre-titulo" class="section relative overflow-hidden bg-surface">
    <div class="container-site">
        {{-- Institucional --}}
        <div class="grid items-center gap-10 lg:grid-cols-[1fr_1.15fr] lg:gap-16">
            <div class="relative order-2 lg:order-1" data-reveal>
                <div class="relative isolate overflow-hidden rounded-[2rem] bg-navy p-10 shadow-lift sm:p-14">
                    <div class="pointer-events-none absolute -right-16 -top-16 -z-10 size-72 rounded-full bg-brand/50 blur-3xl" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -bottom-20 -left-10 -z-10 size-56 rounded-full bg-accent/15 blur-3xl" aria-hidden="true"></div>
                    <picture class="block"><source srcset="{{ asset('assets/images/logo/logo-solution.webp') }}" type="image/webp"><img src="{{ asset('assets/images/logo/logo-solution.png') }}" alt="Solution Business BPO" width="199" height="100" loading="lazy" class="h-20 w-auto sm:h-24"></picture>
                    <x-icon name="quote" class="mt-12 size-10 text-accent" />
                    <p class="mt-4 text-2xl font-bold leading-snug text-white sm:text-3xl">{{ $about['closing'] }}</p>
                </div>
            </div>

            <div class="order-1 lg:order-2" data-reveal>
                <span class="eyebrow">{{ $about['eyebrow'] }}</span>
                <h2 id="sobre-titulo" class="heading-section">{{ $about['title'] }}</h2>
                <div class="mt-6 space-y-5 text-lg leading-relaxed text-muted">
                    @foreach ($about['paragraphs'] as $paragraph)
                        <p @class(['text-xl font-medium text-ink' => $loop->first])>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Diretora --}}
        <article aria-labelledby="diretora-nome" class="mt-20 overflow-hidden rounded-[2rem] bg-white shadow-soft ring-1 ring-slate-200/70 lg:mt-28" data-reveal>
            <div class="grid md:grid-cols-[minmax(0,320px)_1fr] lg:grid-cols-[minmax(0,380px)_1fr]">
                <div class="relative isolate flex items-end justify-center overflow-hidden bg-gradient-to-br from-brand via-royal to-navy px-8 pt-10">
                    <div class="pointer-events-none absolute left-1/2 top-1/2 -z-10 size-72 -translate-x-1/2 -translate-y-1/2 rounded-full border-[30px] border-white/10" aria-hidden="true"></div>
                    <div class="pointer-events-none absolute -bottom-10 left-1/2 -z-10 h-32 w-64 -translate-x-1/2 rounded-full bg-accent/30 blur-3xl" aria-hidden="true"></div>
                    <x-picture :src="$director['photo']" ext="png" :alt="'Foto de '.$director['name'].', '.$director['role'].' da Solution BPO'"
                               :width="$director['photo_size'][0]" :height="$director['photo_size'][1]"
                               img-class="block h-auto w-[220px] drop-shadow-[0_20px_30px_rgb(0_0_0/0.35)] lg:w-[240px]" />
                </div>
                <div class="p-8 sm:p-10 lg:p-14">
                    <span class="eyebrow">Liderança</span>
                    <h3 id="diretora-nome" class="mt-3 text-3xl font-extrabold tracking-tight text-navy sm:text-4xl">{{ $director['name'] }}</h3>
                    <p class="mt-1 text-lg font-semibold text-brand">{{ $director['role'] }}</p>

                    <dl class="mt-8 grid gap-3 sm:grid-cols-3">
                        @foreach ($director['facts'] as $fact)
                            <div class="rounded-2xl bg-surface p-4 ring-1 ring-slate-200/70">
                                <dt class="text-xs font-bold uppercase tracking-[0.14em] text-accent-ink">{{ $fact['label'] }}</dt>
                                <dd class="mt-1.5 text-base font-semibold leading-snug text-navy lg:text-sm">{{ $fact['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>

                    <div class="mt-8 space-y-4 leading-relaxed text-muted">
                        @foreach ($director['bio'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
