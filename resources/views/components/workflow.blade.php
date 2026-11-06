@props(['workflow'])
<section id="como-funciona" aria-labelledby="como-funciona-titulo" class="section relative bg-white">
    <div class="container-site">
        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <span class="eyebrow justify-center">{{ $workflow['eyebrow'] }}</span>
            <h2 id="como-funciona-titulo" class="heading-section">{{ $workflow['title'] }}</h2>
            <p class="lead">{{ $workflow['intro'] }}</p>
        </div>

        <div class="relative mt-14 lg:mt-20" data-timeline>
            {{-- Trilho da timeline: vertical no mobile, horizontal no desktop --}}
            <div class="absolute bottom-10 left-7 top-7 w-0.5 rounded-full bg-slate-200 lg:bottom-auto lg:left-[10%] lg:right-[10%] lg:top-8 lg:h-0.5 lg:w-auto" aria-hidden="true">
                <div class="timeline-progress h-full w-full rounded-full bg-gradient-to-b from-brand via-brand-light to-accent lg:bg-gradient-to-r" data-timeline-progress></div>
            </div>

            <ol class="relative grid gap-10 lg:grid-cols-5 lg:gap-6">
                @foreach ($workflow['steps'] as $step)
                    <li class="group relative flex gap-6 lg:flex-col lg:items-center lg:gap-0 lg:text-center" data-timeline-step>
                        <div class="relative z-10 shrink-0">
                            <div class="grid size-14 place-items-center rounded-2xl bg-navy shadow-lift ring-4 ring-white transition duration-500 ease-out-soft group-hover:-translate-y-1 group-hover:bg-navy-600 lg:size-16">
                                <img src="{{ asset($step['icon']) }}" alt="" width="60" height="60" loading="lazy" class="size-8 object-contain lg:size-9">
                            </div>
                            <span class="absolute -right-2.5 -top-2.5 grid size-7 place-items-center rounded-full bg-accent text-xs font-extrabold text-navy ring-4 ring-white">
                                {{ $loop->iteration }}
                            </span>
                        </div>
                        <div class="pt-1 lg:mt-7 lg:px-1 lg:pt-0">
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand">Etapa {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                            <h3 class="mt-2 text-lg font-bold leading-snug text-navy">{{ $step['title'] }}</h3>
                            <p class="mt-2.5 text-[0.95rem] leading-relaxed text-muted">{{ $step['text'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
