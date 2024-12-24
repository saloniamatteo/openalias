import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    // Disable polyfill
    build: {
        modulePreload: {
            polyfill: false,
        },
        rollupOptions: {
            // Tree-shaking
            treeshake: {
                preset: "smallest",
                propertyReadSideEffects: false,
            }
        }
    },
    // Disable comments in JS
    esbuild: { legalComments: 'none' },
    plugins: [
        laravel({
            input: [
                'resources/css/cirrus.min.css',
                'resources/css/fonts/fonts.css',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
        // PurgeCSS
        purge({
            paths: [
                'resources/views/**',
            ],
            output: 'resources/css/cirrus.min.css',
            fontFace: false,
            keyframes: true,
            safelist: ["active"],
        }),
    ],
});
