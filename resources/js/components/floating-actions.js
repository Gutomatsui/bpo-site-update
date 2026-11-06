import { prefersReducedMotion } from '../utils/motion';

const SHOW_AFTER = 300; // px de rolagem para exibir o "Voltar ao topo"

/**
 * Botões flutuantes: visibilidade do "Voltar ao topo" e anel de progresso da página.
 *
 * - Um único listener de scroll (passivo) agenda no máximo uma atualização por frame.
 * - A altura rolável é guardada em cache e recalculada só quando o documento ou a
 *   janela mudam de tamanho (ResizeObserver), evitando reflow a cada scroll.
 * - O anel é atualizado direto no SVG (stroke-dashoffset), sem passar pelo Alpine.
 * - Oculta os botões enquanto o menu mobile está aberto.
 */
export default () => ({
    visible: false,
    complete: false,
    menuOpen: false,

    init() {
        const ring = this.$refs.ring;
        let maxScroll = 0;
        let frame = 0;

        const measure = () => {
            maxScroll = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
        };

        const update = () => {
            frame = 0;
            const y = window.scrollY;
            const progress = maxScroll > 0 ? Math.min(100, Math.max(0, (y / maxScroll) * 100)) : 0;

            ring.style.strokeDashoffset = String(100 - progress);
            this.visible = y > SHOW_AFTER;
            this.complete = progress >= 99.5;
        };

        const schedule = () => {
            if (!frame) frame = requestAnimationFrame(update);
        };

        measure();
        update();
        window.addEventListener('scroll', schedule, { passive: true });

        new ResizeObserver(() => {
            measure();
            schedule();
        }).observe(document.body);
        window.addEventListener('resize', () => {
            measure();
            schedule();
        }, { passive: true });

        const menu = document.getElementById('menu-mobile');
        if (menu) {
            const sync = () => {
                this.menuOpen = menu.style.display !== 'none' && menu.offsetParent !== null;
            };
            new MutationObserver(sync).observe(menu, { attributes: true, attributeFilter: ['style'] });
            sync();
        }
    },

    toTop(event) {
        window.scrollTo({ top: 0, behavior: prefersReducedMotion() ? 'auto' : 'smooth' });

        // Teclado: o botão some no topo; leva o foco para o início da página.
        if (event.detail === 0) {
            const target = document.querySelector('header a[href="#inicio"]');
            target?.focus({ preventScroll: true });
        }
    },
});
