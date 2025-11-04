// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                // CAMINHOS DO ADMINLTE:
                'node_modules/admin-lte/dist/css/adminlte.min.css',
                'node_modules/admin-lte/dist/js/adminlte.min.js', // <--- Verifique esta linha
                // Outros caminhos, como FontAwesome, se necessário
            ],
            refresh: true,
        }),
    ],
});