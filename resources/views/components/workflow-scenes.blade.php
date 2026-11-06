{{-- Ilustrações vetoriais das 5 etapas (decorativas, sem dados reais).
     Uma cena por etapa; só a ativa fica visível. As animações rodam uma vez ao
     ativar a cena e terminam na composição final (sem loops infinitos). --}}
@php
    $doc = '#e8eef7'; $line = '#a9bad0'; $panel = '#0f1d3a'; $edge = 'rgb(255 255 255 / 0.16)';
    $blue = '#1783cc'; $orange = '#ffa235'; $navy = '#091124';
@endphp
<svg class="block h-full w-full" viewBox="0 0 480 290" preserveAspectRatio="xMidYMid meet" focusable="false">
    {{-- 01 — Documentos e contas sendo enviados --}}
    <g class="journey-scene" :class="{ 'is-active': active === 0 }" @class(['is-active' => true])>
        {{-- Destino: caixa de entrada --}}
        <rect x="300" y="146" width="132" height="98" rx="18" fill="{{ $panel }}" stroke="{{ $edge }}" />
        <path d="M300 194 H338 l10 16 h36 l10 -16 H432" fill="none" stroke="{{ $blue }}" stroke-width="3" stroke-linejoin="round" />
        <g class="jr-pop" style="--d: 1.1s">
            <circle cx="366" cy="108" r="22" fill="{{ $orange }}" />
            <path d="M366 119 V98 M357 106 l9 -9 9 9" fill="none" stroke="{{ $navy }}" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
        </g>
        {{-- Trajeto --}}
        <path class="jr-flow" d="M168 136 C 220 70, 286 76, 334 164" fill="none" stroke="{{ $orange }}" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="5 9" opacity="0.85" />
        {{-- Contas: a pagar e a receber --}}
        @foreach ([[48, 104, $orange], [96, 80, $blue]] as [$x, $y, $tone])
            <g>
                <path d="M{{ $x }} {{ $y + 10 }} a10 10 0 0 1 10 -10 h52 l20 20 v86 a10 10 0 0 1 -10 10 h-62 a10 10 0 0 1 -10 -10 z" fill="{{ $doc }}" />
                <path d="M{{ $x + 62 }} {{ $y }} v14 a6 6 0 0 0 6 6 h14" fill="#cfdbea" />
                <rect x="{{ $x + 14 }}" y="{{ $y + 30 }}" width="40" height="6" rx="3" fill="{{ $line }}" />
                <rect x="{{ $x + 14 }}" y="{{ $y + 46 }}" width="54" height="6" rx="3" fill="{{ $line }}" />
                <rect x="{{ $x + 14 }}" y="{{ $y + 62 }}" width="30" height="6" rx="3" fill="{{ $line }}" />
                <circle cx="{{ $x + 66 }}" cy="{{ $y + 96 }}" r="9" fill="{{ $tone }}" />
            </g>
        @endforeach
        {{-- Documento em trânsito --}}
        @foreach ([0, 0.7] as $delay)
            <g class="jr-fly" style="--d: {{ $delay }}s">
                <rect x="150" y="124" width="34" height="42" rx="6" fill="{{ $doc }}" />
                <rect x="157" y="136" width="20" height="4" rx="2" fill="{{ $line }}" />
                <rect x="157" y="146" width="14" height="4" rx="2" fill="{{ $line }}" />
            </g>
        @endforeach
    </g>

    {{-- 02 — Documentos organizados, notas fiscais e boletos --}}
    <g class="journey-scene" :class="{ 'is-active': active === 1 }">
        {{-- Nota fiscal --}}
        <g class="jr-rise" style="--d: 0s">
            <rect x="70" y="40" width="140" height="196" rx="14" fill="{{ $doc }}" />
            <path d="M70 54 a14 14 0 0 1 14 -14 h112 a14 14 0 0 1 14 14 v20 h-140 z" fill="{{ $blue }}" />
            <rect x="86" y="52" width="58" height="10" rx="5" fill="rgb(255 255 255 / 0.85)" />
            @foreach ([94, 112, 130, 148] as $i => $y)
                <rect x="86" y="{{ $y }}" width="{{ [96, 70, 108, 60][$i] }}" height="6" rx="3" fill="{{ $line }}" />
            @endforeach
            <rect x="86" y="176" width="108" height="1.5" fill="#c3d0e0" />
            <rect x="86" y="190" width="44" height="8" rx="4" fill="{{ $line }}" />
        </g>
        <g class="jr-pop" style="--d: 0.9s">
            <circle cx="190" cy="214" r="24" fill="{{ $orange }}" />
            <circle cx="190" cy="214" r="17" fill="none" stroke="{{ $navy }}" stroke-width="2" stroke-dasharray="3 4" opacity="0.5" />
            <path d="M180 214 l7 7 13 -14" fill="none" stroke="{{ $navy }}" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
        </g>
        {{-- Boleto --}}
        <g class="jr-rise" style="--d: 0.25s">
            <rect x="236" y="112" width="182" height="120" rx="14" fill="{{ $doc }}" />
            <rect x="252" y="128" width="70" height="8" rx="4" fill="{{ $line }}" />
            <rect x="252" y="144" width="110" height="6" rx="3" fill="#c3d0e0" />
            @php($bx = 252)
            @foreach ([3, 1.5, 4, 1.5, 2, 5, 1.5, 3, 2, 1.5, 4, 2, 1.5, 3, 5, 1.5, 2, 4, 1.5, 3, 2, 1.5, 4, 2, 3, 1.5, 5, 2, 1.5, 3, 2, 4] as $w)
                <rect x="{{ $bx }}" y="166" width="{{ $w }}" height="48" fill="{{ $navy }}" opacity="0.85" />
                @php($bx += $w + 3)
            @endforeach
            <rect class="jr-scan" x="248" y="160" width="3" height="60" rx="1.5" fill="{{ $orange }}" />
        </g>
        {{-- Envio por e-mail --}}
        <g class="jr-pop" style="--d: 1.3s">
            <rect x="346" y="42" width="72" height="50" rx="10" fill="{{ $panel }}" stroke="{{ $blue }}" stroke-width="2" />
            <path d="M352 50 l30 22 30 -22" fill="none" stroke="{{ $blue }}" stroke-width="2.5" stroke-linejoin="round" />
            <path d="M300 74 h30 m-8 -7 l8 7 -8 7" fill="none" stroke="{{ $orange }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </g>

    {{-- 03 — Monitor com indicadores (sem valores) --}}
    <g class="journey-scene" :class="{ 'is-active': active === 2 }">
        <rect x="70" y="30" width="340" height="206" rx="18" fill="{{ $panel }}" stroke="{{ $edge }}" />
        <rect x="86" y="46" width="308" height="158" rx="10" fill="{{ $navy }}" />
        <path d="M222 236 l-8 24 h52 l-8 -24 z" fill="{{ $panel }}" />
        <rect x="190" y="258" width="100" height="8" rx="4" fill="{{ $panel }}" stroke="{{ $edge }}" />
        {{-- Indicadores: a pagar (laranja) e a receber (azul) --}}
        @foreach ([[100, $orange], [180, $blue]] as [$x, $tone])
            <g class="jr-rise" style="--d: {{ $x === 100 ? 0 : 0.15 }}s">
                <rect x="{{ $x }}" y="60" width="68" height="40" rx="8" fill="{{ $panel }}" stroke="{{ $edge }}" />
                <circle cx="{{ $x + 14 }}" cy="74" r="5" fill="{{ $tone }}" />
                <rect x="{{ $x + 24 }}" y="71" width="32" height="6" rx="3" fill="rgb(255 255 255 / 0.35)" />
                <rect x="{{ $x + 10 }}" y="86" width="46" height="6" rx="3" fill="{{ $tone }}" opacity="0.7" />
            </g>
        @endforeach
        {{-- Linha de tendência --}}
        <polyline class="jr-draw" style="--len: 200" points="100,186 128,170 150,176 176,150 204,156 232,128" fill="none" stroke="{{ $blue }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        <circle class="jr-pop" style="--d: 1.1s" cx="232" cy="128" r="5" fill="{{ $blue }}" />
        {{-- Barras --}}
        @foreach ([44, 70, 56, 92, 78, 110] as $i => $h)
            <rect class="jr-bar" style="--d: {{ 0.2 + $i * 0.1 }}s" x="{{ 262 + $i * 20 }}" y="{{ 192 - $h }}" width="12" height="{{ $h }}" rx="4"
                  fill="{{ $i === 5 ? $orange : $blue }}" opacity="{{ $i === 5 ? 1 : 0.85 }}" />
        @endforeach
        <rect x="256" y="192" width="126" height="1.5" fill="{{ $edge }}" />
    </g>

    {{-- 04 — Calendário e pagamentos agendados --}}
    <g class="journey-scene" :class="{ 'is-active': active === 3 }">
        <rect x="56" y="44" width="230" height="214" rx="18" fill="{{ $doc }}" />
        <path d="M56 62 a18 18 0 0 1 18 -18 h194 a18 18 0 0 1 18 18 v28 h-230 z" fill="{{ $blue }}" />
        <rect x="100" y="32" width="10" height="26" rx="5" fill="{{ $navy }}" />
        <rect x="232" y="32" width="10" height="26" rx="5" fill="{{ $navy }}" />
        @php($scheduled = [2, 6, 9, 13, 17])
        @for ($i = 0; $i < 20; $i++)
            @php($cx = 72 + ($i % 5) * 42)
            @php($cy = 104 + intdiv($i, 5) * 36)
            <rect x="{{ $cx }}" y="{{ $cy }}" width="34" height="28" rx="7" fill="#cfdbea" />
            @if (in_array($i, $scheduled))
                @php($order = array_search($i, $scheduled))
                <g class="jr-pop" style="--d: {{ 0.2 + $order * 0.22 }}s">
                    <rect x="{{ $cx }}" y="{{ $cy }}" width="34" height="28" rx="7" fill="{{ $orange }}" />
                    <path d="M{{ $cx + 11 }} {{ $cy + 14 }} l5 5 9 -10" fill="none" stroke="{{ $navy }}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                </g>
            @endif
        @endfor
        {{-- Banco --}}
        <g class="jr-rise" style="--d: 0.1s">
            <path d="M318 112 l56 -30 56 30 z" fill="none" stroke="{{ $blue }}" stroke-width="3" stroke-linejoin="round" />
            @foreach ([330, 356, 382, 408] as $x)
                <rect x="{{ $x }}" y="122" width="10" height="58" rx="3" fill="rgb(255 255 255 / 0.22)" />
            @endforeach
            <rect x="316" y="186" width="116" height="8" rx="4" fill="{{ $blue }}" />
        </g>
        {{-- Relógio do agendamento --}}
        <circle cx="374" cy="232" r="24" fill="{{ $panel }}" stroke="{{ $orange }}" stroke-width="3" />
        <path d="M374 232 v-13" stroke="{{ $orange }}" stroke-width="3" stroke-linecap="round" />
        <path class="jr-spin" d="M374 232 h10" stroke="#ffffff" stroke-width="3" stroke-linecap="round" />
    </g>

    {{-- 05 — Painel de controle com confirmação --}}
    <g class="journey-scene" :class="{ 'is-active': active === 4 }">
        <rect x="50" y="44" width="236" height="206" rx="18" fill="{{ $panel }}" stroke="{{ $edge }}" />
        <rect x="70" y="64" width="80" height="8" rx="4" fill="rgb(255 255 255 / 0.4)" />
        @foreach ([96, 146, 196] as $i => $y)
            <rect x="70" y="{{ $y }}" width="196" height="38" rx="10" fill="rgb(255 255 255 / 0.04)" stroke="{{ $edge }}" />
            <rect x="84" y="{{ $y + 11 }}" width="{{ [70, 88, 58][$i] }}" height="6" rx="3" fill="rgb(255 255 255 / 0.4)" />
            <rect x="84" y="{{ $y + 23 }}" width="{{ [44, 36, 52][$i] }}" height="5" rx="2.5" fill="rgb(255 255 255 / 0.2)" />
            <rect class="jr-toggle-track" style="--d: {{ 0.2 + $i * 0.3 }}s" x="212" y="{{ $y + 9 }}" width="40" height="20" rx="10" fill="{{ $orange }}" />
            <circle class="jr-toggle-knob" style="--d: {{ 0.2 + $i * 0.3 }}s" cx="242" cy="{{ $y + 19 }}" r="7" fill="{{ $navy }}" />
        @endforeach
        {{-- Confirmação --}}
        <circle class="jr-ring" cx="378" cy="146" r="66" fill="none" stroke="{{ $blue }}" stroke-width="2" opacity="0.4" />
        <circle cx="378" cy="146" r="52" fill="{{ $panel }}" stroke="{{ $orange }}" stroke-width="5" />
        <path class="jr-draw" style="--len: 80; --d: 1s" d="M354 147 l16 16 32 -34" fill="none" stroke="#ffffff" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
    </g>
</svg>
