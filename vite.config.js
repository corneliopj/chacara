// vite.config.js (Exemplo de como deve ficar)
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // Seu CSS customizado ou Tailwind
                'resources/js/app.js',
                // Incluindo AdminLTE e suas dependências
                'node_modules/admin-lte/dist/css/adminlte.min.css',
                'node_modules/admin-lte/dist/js/adminlte.min.js',
                // E os ícones Font Awesome (geralmente usado pelo AdminLTE)
            ],
            refresh: true,
        }),
    ],
});