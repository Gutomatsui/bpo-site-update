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
 *  - botão de pausar/retomar: "playing" é a escolha do visitante e só muda por ele
 *    (ou por interação que o próprio Swiper trate como parada definitiva);
 *  - suspende enquanto o foco do TECLADO estiver dentro do carrossel (clique de mouse não);
 *  - suspende quando o carrossel sai da tela;
 *  - nunca inicia para quem prefere movimento reduzido.
 *
 * As suspensões usam stop()/start() do Swiper, não pause()/resume(): estes são feitos
 * para pausas internas (transições) e podiam ser desfeitos sozinhos ou travar no
 * último slide de carrosséis com "rewind".
 */
function withAutoplayControl(options) {
    return {
        swiper: null,
        playing: false,
        autoplayAvailable: false,
        autoplayOptions: options,
        syncAutoplay: () => {},

        setupAutoplay(swiper) {
            this.swiper = swiper;
            const reduced = prefersReducedMotion();
            this.autoplayAvailable = !reduced && !swiper.isLocked;
            this.playing = this.autoplayAvailable;

            if (!this.autoplayAvailable) {
                swiper.autoplay?.stop();
            }

            let internal = false; // start/stop disparados pela suspensão (não pelo visitante)
            let focused = false;
            let visible = true;

            swiper.on('autoplayStop', () => {
                if (!internal) this.playing = false;
            });
            swiper.on('autoplayStart', () => {
                if (!internal) this.playing = true;
            });
            swiper.on('lock unlock', () => {
                this.autoplayAvailable = !reduced && !swiper.isLocked;
            });

            this.syncAutoplay = () => {
                if (!this.autoplayAvailable) return;
                const shouldRun = this.playing && !focused && visible;
                if (shouldRun === swiper.autoplay.running) return;
                internal = true;
                if (shouldRun) {
                    const current = typeof swiper.params.autoplay === 'object' ? swiper.params.autoplay : {};
                    swiper.params.autoplay = { ...current, ...this.autoplayOptions };
                    swiper.autoplay.start();
                } else {
                    swiper.autoplay.stop();
                }
                internal = false;
            };

            this.$el.addEventListener('focusin', (e) => {
                if (!e.target.matches(':focus-visible')) return;
                focused = true;
                this.syncAutoplay();
            });
            this.$el.addEventListener('focusout', (e) => {
                if (!this.$el.contains(e.relatedTarget)) {
                    focused = false;
                    this.syncAutoplay();
                }
            });
            new IntersectionObserver(([entry]) => {
                visible = entry.isIntersecting;
                this.syncAutoplay();
            }).observe(this.$el);
        },

        toggleAutoplay() {
            if (!this.swiper) return;
            this.playing = !this.playing;
            this.syncAutoplay();
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
    // Sem pausa por mouse: o card ocupa boa parte da tela e o cursor costuma repousar
    // sobre ele, o que dava a impressão de carrossel travado. Após navegação manual, o
    // autoplay continua. Pausar continua disponível pelo botão (e pelo foco do teclado).
    const autoplay = { delay: 8000, disableOnInteraction: false, pauseOnMouseEnter: false };

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
