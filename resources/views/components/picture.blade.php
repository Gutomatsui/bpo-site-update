@props([
    'src',              // caminho sem extensão, relativo a /public
    'ext' => 'jpg',     // extensão do arquivo original (fallback)
    'alt' => '',
    'width',
    'height',
    'loading' => 'lazy',
    'imgClass' => '',
])
<picture {{ $attributes }}>
    <source srcset="{{ asset($src.'.webp') }}" type="image/webp">
    <img src="{{ asset($src.'.'.$ext) }}" alt="{{ $alt }}" width="{{ $width }}" height="{{ $height }}"
         loading="{{ $loading }}" decoding="async" class="{{ $imgClass }}">
</picture>
