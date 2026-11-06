import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

/**
 * Animações discretas de entrada durante o scroll.
 * Elementos já visíveis no carregamento não são animados (evita "piscar").
 */
export function initAnimations() {
    const inView = (el) => el.getBoundingClientRect().top < window.innerHeight * 0.9;

    gsap.utils.toArray('[data-reveal]').forEach((el) => {
        if (inView(el)) return;
        gsap.from(el, {
            y: el.dataset.reveal === 'fade' ? 0 : 32,
            opacity: 0,
            duration: 0.9,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 88%', once: true },
        });
    });

    gsap.utils.toArray('[data-reveal-group]').forEach((group) => {
        const items = group.querySelectorAll('[data-reveal-item]');
        if (!items.length || inView(group)) return;
        gsap.from(items, {
            y: 36,
            opacity: 0,
            duration: 0.8,
            ease: 'power3.out',
            stagger: 0.12,
            scrollTrigger: { trigger: group, start: 'top 85%', once: true },
        });
    });

    // Recalcula posições após o carregamento de imagens/fontes.
    window.addEventListener('load', () => ScrollTrigger.refresh());
}
