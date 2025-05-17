import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        base: process.env.APP_ENV === 'production' 
        ? 'https://ta-galeri-sintang-production.up.railway.app/' 
        : '/',
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        https: true,
    },
    plugins: [
        laravel({
              input: [
                'resources/js/app.js',
                'resources/css/app.css',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        
    ],
});