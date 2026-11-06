/**
 * Header fixo: estado de scroll, menu mobile e destaque da seção visível (scroll spy).
 */
export default () => ({
    open: false,
    scrolled: false,
    active: 'inicio',

    init() {
        const onScroll = () => {
            this.scrolled = window.scrollY > 12;
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

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

    toggle() {
        this.open = !this.open;
    },

    close() {
        this.open = false;
    },
});
