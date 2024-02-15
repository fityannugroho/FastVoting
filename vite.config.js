import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    plugins: [laravel(["resources/js/app.js"])],
    resolve: {
        alias: {
            "@": "/resources/js",
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
        },
    },
});
