import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import focus from '@alpinejs/focus';

import siteHeader from './components/site-header';
import serviceTabs from './components/service-tabs';
import workflowJourney from './components/workflow-journey';
import floatingActions from './components/floating-actions';
import { heroSlider, testimonialsSlider, clientsSlider } from './components/sliders';
import { prefersReducedMotion } from './utils/motion';

Alpine.plugin(collapse);
Alpine.plugin(focus);

Alpine.data('siteHeader', siteHeader);
Alpine.data('serviceTabs', serviceTabs);
Alpine.data('workflowJourney', workflowJourney);
Alpine.data('floatingActions', floatingActions);
Alpine.data('heroSlider', heroSlider);
Alpine.data('testimonialsSlider', testimonialsSlider);
Alpine.data('clientsSlider', clientsSlider);

window.Alpine = Alpine;
Alpine.start();

// Animações de scroll: GSAP é carregado sob demanda e nunca para quem prefere movimento reduzido.
if (!prefersReducedMotion()) {
    const loadAnimations = () => import('./animations').then(({ initAnimations }) => initAnimations());
    if ('requestIdleCallback' in window) {
        window.requestIdleCallback(loadAnimations, { timeout: 1500 });
    } else {
        window.setTimeout(loadAnimations, 300);
    }
}
