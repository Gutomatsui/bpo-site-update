import Swiper from 'swiper';
import { A11y, Autoplay, EffectFade, Keyboard, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';

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
 * Banner principal: slides originais com autoplay, loop, setas, paginação,
 * swipe, teclado, pausa ao interagir e botão de pausar/retomar.
 */
export const heroSlider = () => ({
    swiper: null,
    current: 1,
    progress: 0,
    playing: true,

    init() {
        const reduced = prefersReducedMotion();
        this.playing = !reduced;

        this.swiper = new Swiper(this.$refs.swiper, {
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
            autoplay: reduced
                ? false
                : { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
            on: {
                slideChange: (s) => {
                    this.current = s.realIndex + 1;
                },
                autoplayTimeLeft: (s, time, ratio) => {
                    this.progress = 1 - ratio;
                },
            },
        });

        // Pausa quando o banner sai da tela (economia de CPU/bateria no celular).
        const observer = new IntersectionObserver(([entry]) => {
            if (!this.playing || !this.swiper.autoplay) return;
            entry.isIntersecting ? this.swiper.autoplay.resume() : this.swiper.autoplay.pause();
        });
        observer.observe(this.$el);
    },

    toggleAutoplay() {
        if (!this.swiper) return;
        if (this.playing) {
            this.swiper.autoplay.stop();
            this.progress = 0;
        } else {
            this.swiper.params.autoplay = { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true };
            this.swiper.autoplay.start();
        }
        this.playing = !this.playing;
    },
});

export const testimonialsSlider = () => ({
    init() {
        const reduced = prefersReducedMotion();
        new Swiper(this.$refs.swiper, {
            modules: [Navigation, Pagination, Autoplay, Keyboard, A11y],
            slidesPerView: 1,
            spaceBetween: 24,
            rewind: true,
            speed: reduced ? 0 : 700,
            grabCursor: true,
            autoHeight: false,
            keyboard: { enabled: true, onlyInViewport: true },
            a11y: { ...a11yPtBr, prevSlideMessage: 'Depoimento anterior', nextSlideMessage: 'Próximo depoimento' },
            navigation: { prevEl: this.$refs.prev, nextEl: this.$refs.next },
            pagination: { el: this.$refs.pagination, clickable: true },
            autoplay: reduced ? false : { delay: 8000, disableOnInteraction: true, pauseOnMouseEnter: true },
        });
    },
});

export const clientsSlider = () => ({
    init() {
        const reduced = prefersReducedMotion();
        new Swiper(this.$refs.swiper, {
            modules: [Autoplay, A11y],
            slidesPerView: 2,
            spaceBetween: 16,
            rewind: true,
            speed: reduced ? 0 : 700,
            grabCursor: true,
            watchOverflow: true,
            a11y: { enabled: true, slideRole: 'listitem' },
            autoplay: reduced ? false : { delay: 3500, disableOnInteraction: false, pauseOnMouseEnter: true },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 },
            },
        });
    },
});
