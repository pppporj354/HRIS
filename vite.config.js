import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

// export untuk npm run build dibundle didalam manifest.json dan folder assets dan didalamnya dilakukan abstraksi
export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/jquery.js",
                "resources/js/app.js",
                "resources/sass/app.scss",
                "resources/css/app.css",
                "resources/js/sidebar.js",
                "resources/js/app.js",
                "resources/js/jquery.js",
                "resources/css/dashboard.css",
            ],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ["bootstrap"],
    },
});
