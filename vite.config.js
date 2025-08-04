import { defineConfig } from 'vite'

export default defineConfig({
    root: '.', // корень проекта
    server: {
        host: 'pronajemonline.local',
        strictPort: true,
        cors: true,
        port: 5174,
        hmr: {
            host: 'pronajemonline.local',

        },
    },
    build: {
        outDir: 'public/assets',
        emptyOutDir: true,
        rollupOptions: {
            input: 'src/js/app.js',
        },
    },
})
