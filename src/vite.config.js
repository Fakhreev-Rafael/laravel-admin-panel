import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/admin/app.css',
                'resources/js/admin/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    },
    server: {
        host: '0.0.0.0',  // Важно для Docker
        port: 5173,
        hmr: {
            host: 'localhost',  // Или ваш домен
        },
    },
});