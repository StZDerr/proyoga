import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/app.css",
                "resources/css/base.css",
                "resources/css/performance.css",
                "resources/css/hatha-uoga.css",
                "resources/css/tea.css",
                "resources/css/about.css",
                "resources/css/contacts.css",
                "resources/css/price-list.css",
                "resources/css/direction.css",
                "resources/css/instruction.css",
                "resources/css/arrow.css",
                "resources/css/cookies.css",
                "resources/css/photoGalleries.css",
                "resources/css/404.css",
                "resources/css/welcome.css",
                "resources/css/navbar.css",
                "resources/css/footer.css",
                "resources/css/contacts-block.css",
                "resources/css/recording.css",
                "resources/css/modal-test.css",
                "resources/css/admin/app.css",
                "resources/css/admin/admin-gallery.css",
                "resources/js/app.js",
                "resources/js/base.js",
                "resources/js/admin/mask.js",
                "resources/js/arrow.js",
                "resources/js/cookies.js",
                "resources/js/hatha-uoga.js",
                "resources/js/lazy-iframe.js",
                "resources/js/welcome_new.js",
                "resources/js/navbar.js",
                "resources/js/about.js",
                "resources/js/recording-form.js",
                "resources/js/yoga-test.js",
                "resources/js/photoGalleries.js",
                "resources/js/price-list.js",
                "resources/js/admin/app.js",
                "resources/js/admin/gallery-order.js",
                "resources/js/promotion-modal.js",
            ],
            refresh: true,
        }),
    ],
    build: {
        // Code splitting для уменьшения размера бандлов
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunk для библиотек
                    vendor: ["bootstrap", "sweetalert2"],
                },
            },
        },
        // Увеличиваем лимит для предупреждений о размере чанков
        chunkSizeWarningLimit: 1000,
        // Минификация CSS
        cssMinify: true,
        // Минификация JS с сохранением производительности
        minify: "terser",
        terserOptions: {
            compress: {
                drop_console: true, // Удаляем console.log в продакшене
                drop_debugger: true,
                pure_funcs: ["console.log", "console.info"], // Удаляем эти функции
            },
        },
    },
});
