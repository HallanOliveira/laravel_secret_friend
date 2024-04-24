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
                'resources/js/secretFriendGroup/script.js',
            ],
            refresh: true,
        }),
        {
            name: 'jquery',
            resolveId(id) {
                if (id === '$' || id === 'jquery') {
                    return id;
                }
            },
            load(id) {
                if (id === '$' || id === 'jquery') {
                    return 'export default window.jQuery;';
                }
            }
        }
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap-icons'),
        }
    },
});
