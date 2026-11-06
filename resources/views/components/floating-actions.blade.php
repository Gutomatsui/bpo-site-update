@props(['contact'])
{{-- Botões flutuantes: um único contêiner fixo no canto inferior direito.
     Ordem: Voltar ao topo (acima) e WhatsApp (abaixo). O Voltar ao topo é posicionado
     de forma absoluta acima do WhatsApp, então aparecer/sumir nunca move o WhatsApp. --}}
<aside x-data="floatingActions" aria-label="Ações rápidas"
       class="fab-stack fixed z-40 transition-[opacity,visibility] duration-300"
       :class="menuOpen && 'invisible opacity-0'">
    <button type="button" x-on:click="toTop($event)" aria-label="Voltar ao topo"
            class="fab-top group absolute bottom-[calc(100%+12px)] grid size-11 cursor-pointer place-items-center rounded-full bg-white sm:size-12"
            :class="{ 'is-visible': visible, 'is-complete': complete }">
        {{-- Anel de progresso: trilho + preenchimento a partir das 12h, sentido horário --}}
        <svg class="pointer-events-none absolute inset-0 size-full -rotate-90" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
            <circle cx="24" cy="24" r="21.5" fill="none" stroke-width="3" class="fab-ring-track" />
            <circle cx="24" cy="24" r="21.5" fill="none" stroke-width="3" pathLength="100" stroke-dasharray="100" stroke-dashoffset="100"
                    stroke-linecap="round" class="fab-ring-progress" x-ref="ring" />
        </svg>
        <span class="relative grid size-[35px] place-items-center rounded-full bg-navy text-white sm:size-[38px]" aria-hidden="true">
            <svg class="size-[18px] transition-transform duration-300 group-hover:-translate-y-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M12 19V5M5 12l7-7 7 7" /></svg>
        </span>
        <span class="fab-tooltip" aria-hidden="true">Voltar ao topo</span>
    </button>

    <x-whatsapp-float :contact="$contact" />
</aside>
