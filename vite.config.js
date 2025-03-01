import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import Components from 'unplugin-vue-components/vite'
import { defineConfig } from 'vite'
import eslintPlugin from 'vite-plugin-eslint'

export default defineConfig({
    plugins: [
        eslintPlugin({
            fix: true,
            failOnError: false,
        }),

        Components({
            dirs: ['resources/js/Components', 'resources/js/Layouts'],
        }),

        laravel({
            input: 'resources/js/app.js',
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
})
