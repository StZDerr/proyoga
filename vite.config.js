import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/css/app.css",
                "resources/css/performance.css",
                "resources/css/hatha-uoga.css",
                "resources/css/tea.css",
                "resources/css/about.css",
                "resources/css/contacts.css",
                "resources/css/price-list.css",
                "resources/css/direction.css",
                "resources/css/arrow.css",
                "resources/css/cookies.css",
                "resources/css/404.css",
                "resources/js/app.js",
                "resources/js/arrow.js",
                "resources/js/cookies.js",
                "resources/js/lazy-iframe.js",
                "resources/css/welcome.css",
                "resources/css/navbar.css",
                "resources/css/footer.css",
                "resources/css/contacts-block.css",
                "resources/css/recording.css",
                "resources/css/modal-test.css",
                "resources/js/welcome_new.js",
                "resources/js/navbar.js",
                "resources/js/about.js",
                "resources/js/recording-form.js",
                "resources/js/yoga-test.js",
                "resources/js/price-list.js",
                "resources/css/admin/app.css",
                "resources/js/admin/app.js",
                "resources/js/promotion-modal.js",
            ],
            refresh: true,
        }),
    ],
});
