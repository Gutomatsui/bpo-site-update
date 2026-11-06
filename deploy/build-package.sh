#!/usr/bin/env bash
#
# Gera o pacote para hospedagem compartilhada em dist/.
#
# Uso (na raiz do projeto):
#   lando npm run build        # compila os assets (public/build)
#   lando package              # modo "raiz" (padrão): tudo na pasta pública, index.php na raiz
#   lando package separado     # modo "separado": núcleo fora do public_html
#
# Modo "raiz"     -> dist/solutionbpo-raiz-DATA.tar.gz
#   public_html/{index.php, .htaccess, build/, assets/, app/, vendor/, ...}
#
# Modo "separado" -> dist/solutionbpo-separado-DATA.tar.gz
#   bpo-site-update/{app/, vendor/, ...}  +  public_html/{index.php, .htaccess, build/, assets/}
#
set -euo pipefail

MODE="${1:-raiz}"
case "$MODE" in
    raiz|separado) ;;
    *) echo "Modo inválido: '$MODE'. Use 'raiz' ou 'separado'." >&2; exit 1 ;;
esac

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
STAMP="$(date +%Y%m%d-%H%M)"
WORK="$(mktemp -d)"
OUT="$ROOT/dist"
trap 'rm -rf "$WORK"' EXIT

if [ ! -f "$ROOT/public/build/manifest.json" ]; then
    echo "ERRO: public/build/manifest.json não encontrado. Rode 'lando npm run build' antes." >&2
    exit 1
fi

if [ "$MODE" = "raiz" ]; then
    CORE="$WORK/public_html"
    WEB="$WORK/public_html"
else
    CORE="$WORK/bpo-site-update"
    WEB="$WORK/public_html"
fi

echo "> Modo: $MODE"
echo "> Copiando núcleo Laravel..."
mkdir -p "$CORE" "$WEB"
tar -C "$ROOT" -cf - \
    --exclude='./.git' --exclude='./node_modules' --exclude='./vendor' --exclude='./dist' \
    --exclude='./public' --exclude='./tests' --exclude='./docs' --exclude='./deploy' \
    --exclude='./.env' --exclude='./.env.*' --exclude='./.lando*' --exclude='./.editorconfig' \
    --exclude='./.gitattributes' --exclude='./.gitignore' --exclude='./phpunit.xml' --exclude='./.phpunit.result.cache' \
    --exclude='./storage/logs/*.log' --exclude='./storage/framework/views/*.php' \
    --exclude='./storage/framework/sessions/*' --exclude='./storage/framework/cache/data/*' \
    . | tar -C "$CORE" -xf -

echo "> Instalando dependências PHP de produção (sem dev)..."
composer install --working-dir="$CORE" --no-dev --optimize-autoloader --no-interaction --no-progress --quiet
rm -f "$CORE/bootstrap/cache/"*.php

echo "> Copiando arquivos públicos (public/ -> $(basename "$WEB")/)..."
tar -C "$ROOT/public" -cf - --exclude='./hot' --exclude='./index.php' --exclude='./.htaccess' . | tar -C "$WEB" -xf -

if [ "$MODE" = "raiz" ]; then
    cp "$ROOT/deploy/shared-hosting/raiz/index.php" "$WEB/index.php"
    cp "$ROOT/deploy/shared-hosting/raiz/.htaccess" "$WEB/.htaccess"
    # Segunda camada de proteção: cada pasta interna nega acesso direto.
    for dir in app bootstrap config database resources routes storage vendor lang; do
        [ -d "$CORE/$dir" ] && cp "$ROOT/deploy/shared-hosting/raiz/deny.htaccess" "$CORE/$dir/.htaccess"
    done
else
    cp "$ROOT/deploy/shared-hosting/public_html/index.php" "$WEB/index.php"
    cp "$ROOT/public/.htaccess" "$WEB/.htaccess"
fi
cp "$ROOT/deploy/shared-hosting/.env.production.example" "$CORE/.env.production.example"

echo "> Compactando..."
mkdir -p "$OUT"
FILE="$OUT/solutionbpo-$MODE-$STAMP.tar.gz"
if [ "$MODE" = "raiz" ]; then
    tar -C "$WORK" -czf "$FILE" public_html
else
    tar -C "$WORK" -czf "$FILE" bpo-site-update public_html
fi

echo "Pacote gerado: dist/$(basename "$FILE")"
