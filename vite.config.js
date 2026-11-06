import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

// No Lando o Vite roda no serviço "node" e é exposto via proxy HTTPS
// em https://vite.bpo-site-update.lndo.site (ver .lando.yml).
const landoHost = process.env.LANDO_VITE_HOST;

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: landoHost
        ? {
              host: '0.0.0.0',
              port: 5173,
              strictPort: true,
              origin: `https://${landoHost}`,
              cors: true,
              hmr: { host: landoHost, protocol: 'wss', clientPort: 443 },
              watch: { ignored: ['**/storage/framework/views/**', '**/vendor/**'] },
          }
        : {
              watch: { ignored: ['**/storage/framework/views/**'] },
          },
    build: {
        assetsInlineLimit: 0,
    },
});
