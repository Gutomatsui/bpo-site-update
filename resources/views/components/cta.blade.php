@props(['cta', 'contact'])
@php($whatsappLink = $contact['whatsapp_url'].'?text='.rawurlencode($cta['whatsapp_message']))
<section aria-labelledby="comece-agora-titulo" class="relative bg-white pb-20 sm:pb-24 lg:pb-28">
    <div class="container-site">
        <div class="on-dark relative isolate overflow-hidden rounded-[2rem] bg-navy px-6 py-14 shadow-lift sm:px-12 sm:py-16 lg:px-16 lg:py-20" data-reveal>
            <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
                <div class="absolute -right-24 -top-24 size-96 rounded-full bg-brand/50 blur-[100px]"></div>
                <div class="absolute -bottom-32 left-1/4 size-80 rounded-full bg-accent/20 blur-[100px]"></div>
                <div class="absolute right-10 top-1/2 hidden size-72 -translate-y-1/2 rounded-full border border-white/10 lg:block"></div>
                <div class="absolute right-24 top-1/2 hidden size-44 -translate-y-1/2 rounded-full border border-accent/30 lg:block"></div>
            </div>

            <div class="grid items-center gap-10 lg:grid-cols-[1.4fr_1fr]">
                <div>
                    <h2 id="comece-agora-titulo" class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                        {{ str($cta['title'])->beforeLast(' ') }} <span class="text-accent">{{ str($cta['title'])->afterLast(' ') }}</span>
                    </h2>
                    <div class="mt-6 space-y-3 text-lg leading-relaxed text-white/75">
                        @foreach ($cta['paragraphs'] as $paragraph)
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                    <p class="mt-6 text-xl font-bold text-white">{{ $cta['highlight'] }}</p>
                </div>
                <div class="flex flex-col gap-4 lg:items-end">
                    <a href="{{ $whatsappLink }}" target="_blank" rel="noopener" class="btn btn-accent px-8 py-4 text-base">
                        <x-icon name="whatsapp" class="size-5" />
                        {{ $cta['button'] }}
                    </a>
                    <a href="tel:{{ $contact['phone_e164'] }}" class="inline-flex min-h-11 items-center gap-2 text-sm font-medium text-white/75 transition hover:text-white lg:justify-end">
                        <x-icon name="phone" class="size-4 text-accent" />
                        ou ligue {{ $contact['phone_display'] }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
