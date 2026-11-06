#!/usr/bin/env bash
#
# Gera o pacote para hospedagem compartilhada em dist/.
# Uso (na raiz do projeto):
#   lando npm run build     # compila os assets (public/build)
#   lando package           # executa este script no container PHP
#
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
STAMP="$(date +%Y%m%d-%H%M)"
WORK="$(mktemp -d)"
CORE="$WORK/bpo-site-update"
WEB="$WORK/public_html"
OUT="$ROOT/dist"

if [ ! -f "$ROOT/public/build/manifest.json" ]; then
    echo "ERRO: public/build/manifest.json não encontrado. Rode 'lando npm run build' antes." >&2
    exit 1
fi

echo "> Copiando núcleo Laravel..."
mkdir -p "$CORE" "$WEB"
tar -C "$ROOT" -cf - \
    --exclude='./.git' --exclude='./node_modules' --exclude='./vendor' --exclude='./dist' \
    --exclude='./public' --exclude='./tests' --exclude='./docs' --exclude='./deploy' \
    --exclude='./.env' --exclude='./.env.*' --exclude='./.lando*' --exclude='./.editorconfig' \
    --exclude='./.gitattributes' --exclude='./.gitignore' --exclude='./phpunit.xml' \
    --exclude='./storage/logs/*.log' --exclude='./storage/framework/views/*.php' \
    --exclude='./storage/framework/sessions/*' --exclude='./storage/framework/cache/data/*' \
    --exclude='./public/hot' \
    . | tar -C "$CORE" -xf -

echo "> Instalando dependências PHP de produção (sem dev)..."
composer install --working-dir="$CORE" --no-dev --optimize-autoloader --no-interaction --no-progress --quiet
rm -f "$CORE/bootstrap/cache/"*.php

echo "> Montando public_html..."
tar -C "$ROOT/public" -cf - --exclude='./hot' --exclude='./index.php' . | tar -C "$WEB" -xf -
cp "$ROOT/deploy/shared-hosting/public_html/index.php" "$WEB/index.php"
cp "$ROOT/deploy/shared-hosting/.env.production.example" "$CORE/.env.production.example"

echo "> Compactando..."
mkdir -p "$OUT"
tar -C "$WORK" -czf "$OUT/solutionbpo-$STAMP.tar.gz" bpo-site-update public_html
rm -rf "$WORK"

echo "Pacote gerado: dist/solutionbpo-$STAMP.tar.gz"
echo "Conteúdo: bpo-site-update/ (núcleo, fora da web) + public_html/ (raiz pública)"
