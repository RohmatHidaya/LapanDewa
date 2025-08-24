import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    build: {
        outDir: "public/build", // hasil build ke public/build
        manifest: true, // penting! Laravel butuh ini
        emptyOutDir: true,
        manifestDir: ".",
    },
});
