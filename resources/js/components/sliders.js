import Swiper from 'swiper';
import { A11y, Autoplay, EffectFade, Keyboard, Navigation, Pagination } from 'swiper/modules';

import { prefersReducedMotion } from '../utils/motion';

const a11yPtBr = {
    enabled: true,
    prevSlideMessage: 'Slide anterior',
    nextSlideMessage: 'Próximo slide',
    firstSlideMessage: 'Este é o primeiro slide',
    lastSlideMessage: 'Este é o último slide',
    paginationBulletMessage: 'Ir para o slide {{index}}',
    slideRole: 'group',
};

/**
 * Controle de autoplay acessível (WCAG 2.2.2 — Pausar, parar, ocultar):
 *  - botão de pausar/retomar sempre sincronizado com o estado real do Swiper;
 *  - pausa enquanto o foco do teclado estiver dentro do carrossel;
 *  - pausa quando o carrossel sai da tela;
 *  - nunca inicia para quem prefere movimento reduzido.
 */
function withAutoplayControl(options) {
    return {
        swiper: null,
        playing: false,
        autoplayAvailable: false,
        autoplayOptions: options,

        setupAutoplay(swiper) {
            this.swiper = swiper;
            const reduced = prefersReducedMotion();
            this.autoplayAvailable = !reduced && !swiper.isLocked;
            this.playing = this.autoplayAvailable;

            if (!this.autoplayAvailable) {
                swiper.autoplay?.stop();
            }

            swiper.on('autoplayStop', () => {
                this.playing = false;
            });
            swiper.on('autoplayStart', () => {
                this.playing = true;
            });
            swiper.on('lock unlock', () => {
                this.autoplayAvailable = !reduced && !swiper.isLocked;
            });

            let focused = false;
            let visible = true;
            const sync = () => {
                if (!this.playing) return;
                focused || !visible ? swiper.autoplay.pause() : swiper.autoplay.resume();
            };
            this.$el.addEventListener('focusin', () => {
                focused = true;
                sync();
            });
            this.$el.addEventListener('focusout', (e) => {
                if (!this.$el.contains(e.relatedTarget)) {
                    focused = false;
                    sync();
                }
            });
            new IntersectionObserver(([entry]) => {
                visible = entry.isIntersecting;
                sync();
            }).observe(this.$el);
        },

        toggleAutoplay() {
            if (!this.swiper) return;
            if (this.playing) {
                this.swiper.autoplay.stop();
            } else {
                this.swiper.params.autoplay = { ...this.autoplayOptions };
                this.swiper.autoplay.start();
            }
        },
    };
}

/**
 * Banner principal: slides originais com autoplay, loop, setas, paginação,
 * swipe, teclado e botão de pausar/retomar.
 */
export const heroSlider = () => {
    const autoplay = { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true };

    return {
        ...withAutoplayControl(autoplay),
        current: 1,
        progress: 0,

        init() {
            const reduced = prefersReducedMotion();
            const swiper = new Swiper(this.$refs.swiper, {
                modules: [Navigation, Pagination, Autoplay, EffectFade, Keyboard, A11y],
                loop: true,
                speed: reduced ? 0 : 900,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                grabCursor: true,
                keyboard: { enabled: true, onlyInViewport: true },
                a11y: a11yPtBr,
                navigation: { prevEl: this.$refs.prev, nextEl: this.$refs.next },
                pagination: { el: this.$refs.pagination, clickable: true },
                autoplay: reduced ? false : autoplay,
                on: {
                    slideChange: (s) => {
                        this.current = s.realIndex + 1;
                    },
                    autoplayTimeLeft: (s, time, ratio) => {
                        this.progress = 1 - ratio;
                    },
                    autoplayStop: () => {
                        this.progress = 0;
                    },
                },
            });
            this.setupAutoplay(swiper);
        },
    };
};

export const testimonialsSlider = () => {
    const autoplay = { delay: 8000, disableOnInteraction: true, pauseOnMouseEnter: true };

    return {
        ...withAutoplayControl(autoplay),

        init() {
            const reduced = prefersReducedMotion();
            const swiper = new Swiper(this.$refs.swiper, {
                modules: [Navigation, Pagination, Autoplay, Keyboard, A11y],
                slidesPerView: 1,
                spaceBetween: 24,
                rewind: true,
                speed: reduced ? 0 : 700,
                grabCursor: true,
                keyboard: { enabled: true, onlyInViewport: true },
                a11y: { ...a11yPtBr, prevSlideMessage: 'Depoimento anterior', nextSlideMessage: 'Próximo depoimento' },
                navigation: { prevEl: this.$refs.prev, nextEl: this.$refs.next },
                pagination: { el: this.$refs.pagination, clickable: true },
                autoplay: reduced ? false : autoplay,
            });
            this.setupAutoplay(swiper);
        },
    };
};

export const clientsSlider = () => {
    const autoplay = { delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true };

    return {
        ...withAutoplayControl(autoplay),

        init() {
            const reduced = prefersReducedMotion();
            const swiper = new Swiper(this.$refs.swiper, {
                modules: [Autoplay, A11y],
                slidesPerView: 2,
                spaceBetween: 16,
                rewind: true,
                speed: reduced ? 0 : 700,
                grabCursor: true,
                watchOverflow: true,
                a11y: { enabled: true, slideRole: 'listitem' },
                autoplay: reduced ? false : autoplay,
                breakpoints: {
                    640: { slidesPerView: 3, spaceBetween: 20 },
                    1024: { slidesPerView: 4, spaceBetween: 24 },
                },
            });
            this.setupAutoplay(swiper);
        },
    };
};
