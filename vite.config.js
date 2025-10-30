import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/css/welcome.css",
                "resources/css/navbar.css",
                "resources/css/footer.css",
                "resources/css/contacts-block.css",
                "resources/css/recording.css",
                "resources/css/modal-test.css",
                "resources/js/welcome_new.js",
                "resources/js/navbar.js",
                "resources/js/recording-form.js",
                "resources/js/yoga-test.js",
                "resources/css/admin/app.css",
                "resources/js/admin/app.js",
            ],
            refresh: true,
        }),
    ],
});
