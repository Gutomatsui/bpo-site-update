@props(['contact'])
{{-- Botão do WhatsApp (posicionado pelo contêiner <x-floating-actions>).
     Mesmo comportamento do site original: a mensagem inclui a URL da página atual. --}}
<a href="{{ $contact['whatsapp_url'] }}?text={{ rawurlencode($contact['whatsapp_float_message'].' '.url()->current()) }}"
   target="_blank" rel="noopener" aria-label="Fale conosco pelo WhatsApp"
   class="fab-whatsapp group relative grid size-[54px] cursor-pointer place-items-center rounded-full bg-[#25D366] text-white sm:size-[60px]">
    <span class="fab-pulse" aria-hidden="true"></span>
    <x-icon name="whatsapp" class="relative size-7 sm:size-8" />
    <span class="fab-tooltip" aria-hidden="true">Fale conosco pelo WhatsApp</span>
</a>
