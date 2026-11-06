@props(['benefits'])
<section aria-labelledby="beneficios-titulo" class="section relative bg-white">
    <div class="container-site">
        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <span class="eyebrow justify-center">BPO Financeiro</span>
            <h1 id="beneficios-titulo" class="heading-section">{{ $benefits['title'] }}</h1>
            <p class="lead">{{ $benefits['intro'] }}</p>
        </div>

        <div class="relative mt-14 lg:mt-16">
        {{-- conector entre os cards (desktop) --}}
        <div class="absolute left-[16%] right-[16%] top-[3.25rem] hidden h-px bg-gradient-to-r from-transparent via-brand/25 to-transparent md:block" aria-hidden="true"></div>
        <ol class="relative grid gap-6 md:grid-cols-3 lg:gap-8" data-reveal-group>
            @foreach ($benefits['items'] as $item)
                <li class="group relative flex flex-col items-center rounded-3xl border border-slate-200/80 bg-white p-8 text-center shadow-soft transition-[translate,box-shadow,border-color] duration-500 ease-out-soft hover:-translate-y-1.5 hover:border-brand/20 hover:shadow-lift lg:p-10" data-reveal-item>
                    <div class="relative grid size-[4.5rem] place-items-center rounded-2xl bg-gradient-to-br from-sky-50 to-blue-100 ring-1 ring-brand/10 transition duration-500 group-hover:scale-105 group-hover:rotate-[-3deg]">
                        <x-picture :src="str_replace('.png', '', $item['icon'])" ext="png" alt="" width="75" height="75" img-class="size-11 object-contain" />
                        <span class="absolute -right-2 -top-2 grid size-7 place-items-center rounded-full bg-accent text-xs font-extrabold text-navy shadow-md">{{ $loop->iteration }}</span>
                    </div>
                    <h2 class="mt-7 text-xl font-bold text-navy">{{ $item['title'] }}</h2>
                    <p class="mt-3 leading-relaxed text-muted">{{ $item['text'] }}</p>
                </li>
            @endforeach
        </ol>
        </div>
    </div>
</section>
