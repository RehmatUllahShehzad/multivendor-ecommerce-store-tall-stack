import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
            /**
             * Editor Resources
             */
            'Editor/resources/js/index.js',
            'Editor/resources/css/gjs.css',
        ]),
    ],
    refresh: true,
    build: {
        chunkSizeWarningLimit: 2000,
        outDir: 'public/tallAdmin'
    },
});
