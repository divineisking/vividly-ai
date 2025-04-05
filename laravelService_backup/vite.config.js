import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Make sure it listens on all network interfaces
        port: 5173,
        hmr: {
            host: 'localhost', // This can be adjusted if needed
        },
        watch: {
            usePolling: true, // Useful for Docker/WSL environments
        },
    },
});
