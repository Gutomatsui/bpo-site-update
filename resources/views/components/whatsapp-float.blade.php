@props(['contact'])
{{-- Mesmo comportamento do site original: a mensagem inclui a URL da página atual --}}
<a href="{{ $contact['whatsapp_url'] }}?text={{ rawurlencode($contact['whatsapp_float_message'].' '.url()->current()) }}"
   target="_blank" rel="noopener" aria-label="Fale conosco pelo WhatsApp"
   class="group fixed bottom-5 right-5 z-40 flex items-center gap-3 rounded-full bg-[#25d366] p-3.5 text-white shadow-[0_12px_30px_-8px_rgb(37_211_102/0.7)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_18px_36px_-8px_rgb(37_211_102/0.8)] sm:bottom-6 sm:right-6">
    <span class="absolute inset-0 -z-10 animate-ping rounded-full bg-[#25d366]/40 motion-reduce:hidden [animation-duration:2.5s]" aria-hidden="true"></span>
    <x-icon name="whatsapp" class="size-7" />
    <span class="hidden max-w-0 overflow-hidden whitespace-nowrap text-sm font-bold transition-all duration-500 group-hover:max-w-40 group-hover:pr-1 sm:inline">Fale conosco</span>
</a>
