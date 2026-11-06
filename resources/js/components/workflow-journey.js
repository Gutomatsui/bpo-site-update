import { prefersReducedMotion } from '../utils/motion';

/**
 * "Como funciona" — scrollytelling sem dependências.
 *
 * Uma marca imaginária a 55% da altura da tela define:
 *  - a etapa ativa (a última cujo topo já passou da marca), em ambos os sentidos de rolagem;
 *  - o preenchimento da linha (--journey-progress, 0 → 1), compartilhado pela linha
 *    vertical e pela barra do painel.
 * O listener de scroll só existe enquanto a seção está perto da tela.
 * Movimento reduzido: a linha avança em saltos (até a etapa ativa), sem acompanhar o scroll.
 */
export default (titles) => ({
    titles,
    active: 0,
    done: false,

    get counter() {
        return String(this.active + 1).padStart(2, '0');
    },

    init() {
        const root = this.$el;
        const rail = this.$refs.rail;
        const steps = [...root.querySelectorAll('[data-journey-step]')];
        const nodes = steps.map((step) => step.querySelector('.journey-node'));
        const reduced = prefersReducedMotion();
        let frame = 0;

        const update = () => {
            frame = 0;
            const mark = window.innerHeight * 0.55;

            let index = 0;
            steps.forEach((step, i) => {
                if (step.getBoundingClientRect().top < mark) index = i;
            });
            this.active = index;

            const r = rail.getBoundingClientRect();
            let progress;
            if (reduced) {
                const node = nodes[index].getBoundingClientRect();
                progress = r.bottom < mark ? 1 : (node.top + node.height / 2 - r.top) / r.height;
            } else {
                progress = (mark - r.top) / r.height;
            }
            progress = Math.min(1, Math.max(0, progress));

            root.style.setProperty('--journey-progress', progress.toFixed(4));
            this.done = progress >= 0.999;
        };

        const onScroll = () => {
            if (!frame) frame = requestAnimationFrame(update);
        };

        new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    window.addEventListener('scroll', onScroll, { passive: true });
                    window.addEventListener('resize', onScroll, { passive: true });
                    onScroll();
                } else {
                    window.removeEventListener('scroll', onScroll);
                    window.removeEventListener('resize', onScroll);
                    update(); // estado final correto ao sair (acima ou abaixo da seção)
                }
            },
            { rootMargin: '200px 0px' },
        ).observe(root);

        update();
    },
});
