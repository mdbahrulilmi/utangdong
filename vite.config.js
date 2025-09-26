import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    base: '/build/',  // penting untuk deploy ke Vercel
    server: {
        cors: true,
    },
    build: {
        outDir: 'public/build',  // output ke folder public/build
        emptyOutDir: true,
    },
});
