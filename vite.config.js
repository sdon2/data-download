import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject";

export default defineConfig({
    plugins: [
        inject({
            $: 'jquery',
            jQuery: 'jquery',
            include: "*.js",
        }),
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/fonts/fonts.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
