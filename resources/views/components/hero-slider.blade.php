@props(['slides', 'width', 'height'])
<section id="inicio" aria-roledescription="carrossel" aria-label="Destaques da Solution BPO"
         class="on-dark relative isolate overflow-hidden bg-navy pb-10 pt-11 sm:pb-14 sm:pt-12 lg:pt-14">
    {{-- Fundo decorativo --}}
    <div class="pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        <div class="absolute -left-40 top-0 size-[36rem] rounded-full bg-brand/40 blur-[120px]"></div>
        <div class="absolute -right-32 bottom-0 size-[28rem] rounded-full bg-royal/50 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,rgb(255_255_255/0.04)_1px,transparent_1px),linear-gradient(to_bottom,rgb(255_255_255/0.04)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_at_center,black_30%,transparent_75%)]"></div>
    </div>

    <div class="container-site">
        <div x-data="heroSlider" class="hero-swiper" data-reveal="fade">
            <div class="relative overflow-hidden rounded-2xl bg-navy-700 shadow-[0_30px_80px_-30px_rgb(0_0_0/0.8)] ring-1 ring-white/10 sm:rounded-3xl">
                <div class="swiper aspect-[1366/525] w-full" x-ref="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($slides as $i => $slide)
                            <div class="swiper-slide" role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} de {{ count($slides) }}">
                                <picture>
                                    <source type="image/webp"
                                            srcset="{{ asset($slide['image'].'-480.webp') }} 480w, {{ asset($slide['image'].'-768.webp') }} 768w, {{ asset($slide['image'].'-1366.webp') }} 1366w"
                                            sizes="(min-width: 1280px) 1216px, calc(100vw - 32px)">
                                    <img src="{{ asset($slide['image'].'.png') }}" alt="{{ $slide['alt'] }}"
                                         width="{{ $width }}" height="{{ $height }}"
                                         class="block h-full w-full object-contain"
                                         @if ($i === 0) fetchpriority="high" loading="eager" @else fetchpriority="low" loading="lazy" @endif
                                         decoding="async">
                                </picture>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Controles abaixo da imagem para não cobrir o texto dos banners --}}
            <div class="mt-5 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <span class="hidden whitespace-nowrap font-mono text-sm sm:inline tabular-nums text-white/60" aria-hidden="true">
                        <span class="font-semibold text-white" x-text="String(current).padStart(2, '0')">01</span>
                        / {{ str_pad(count($slides), 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <div class="swiper-pagination !static flex items-center gap-2" x-ref="pagination"></div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" x-on:click="toggleAutoplay()"
                            class="inline-flex size-11 items-center justify-center rounded-full text-white/80 ring-1 ring-white/15 transition hover:bg-white/10 hover:text-white"
                            :aria-label="playing ? 'Pausar rotação automática' : 'Retomar rotação automática'" aria-label="Pausar rotação automática">
                        <x-icon name="pause" class="size-4" x-show="playing" />
                        <x-icon name="play" class="size-4" x-show="!playing" x-cloak />
                    </button>
                    <button type="button" x-ref="prev" aria-label="Slide anterior"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-white/10 text-white ring-1 ring-white/15 backdrop-blur transition hover:-translate-x-0.5 hover:bg-white hover:text-navy">
                        <x-icon name="chevron-left" class="size-5" />
                    </button>
                    <button type="button" x-ref="next" aria-label="Próximo slide"
                            class="inline-flex size-11 items-center justify-center rounded-full bg-accent text-navy shadow-[0_10px_30px_-10px_rgb(255_162_53/0.8)] transition hover:translate-x-0.5 hover:bg-[#ffb35c]">
                        <x-icon name="chevron-right" class="size-5" />
                    </button>
                </div>
            </div>
            <div class="mt-4 h-0.5 overflow-hidden rounded-full bg-white/10" aria-hidden="true">
                <div class="h-full origin-left bg-gradient-to-r from-brand-light to-accent" :style="`transform: scaleX(${progress})`" style="transform: scaleX(0)"></div>
            </div>
        </div>
    </div>
</section>
