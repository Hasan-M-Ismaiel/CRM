import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/profile.css',
                'resources/css/createProject.css',
                'resources/css/editProject.css',
                'resources/css/radioButton.styl',
            ],
            refresh: true,
        }),
    ],
});
