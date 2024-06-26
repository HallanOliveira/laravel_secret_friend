import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss',
                'resources/js/secretFriendGroup/index.js',
                'resources/js/participant/form.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {}
    },
});
