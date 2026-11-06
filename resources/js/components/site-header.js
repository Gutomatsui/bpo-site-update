import { prefersReducedMotion } from '../utils/motion';

/**
 * Header fixo: estado de scroll, menu mobile, destaque da seção visível (scroll spy)
 * e recorte em V com borda animada (visível só no topo da página).
 */
export default () => ({
    open: false,
    scrolled: false,
    atTop: true,
    active: 'inicio',

    /** O V e a borda animada aparecem no topo e com o menu mobile fechado. */
    get showNotch() {
        return this.atTop && !this.open;
    },

    init() {
        // Um único listener de scroll para todos os estados do header.
        const onScroll = () => {
            this.scrolled = window.scrollY > 12;
            this.atTop = window.scrollY < 40;
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        this.setupNotchAnimation();

        const sections = [...document.querySelectorAll('main section[id]')];
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.active = entry.target.id;
                    }
                });
            },
            { rootMargin: '-45% 0px -50% 0px' },
        );
        sections.forEach((section) => observer.observe(section));

        // Fecha o menu se a tela crescer para o layout desktop.
        window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
            if (e.matches) this.close();
        });
    },

    /**
     * As duas bordas (superior e inferior com o V) usam o MESMO gradiente com uma
     * única animação SMIL, definida no SVG do recorte. Por isso ela continua rodando
     * durante a rolagem: a borda superior permanece animada no header compacto.
     * Movimento reduzido: as duas bordas ficam estáticas.
     */
    setupNotchAnimation() {
        const svg = this.$refs.notch;
        if (!svg || typeof svg.pauseAnimations !== 'function') return;

        if (prefersReducedMotion()) {
            svg.pauseAnimations();
            svg.setCurrentTime(0);
        }
    },

    toggle() {
        this.open = !this.open;
    },

    close() {
        this.open = false;
    },
});
