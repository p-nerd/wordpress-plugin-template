import { defineConfig } from "vite";
import solid from "vite-plugin-solid";
import { v4wp } from "@kucrut/vite-for-wp";
import tsconfigPaths from "vite-tsconfig-paths";

export default defineConfig({
    plugins: [
        v4wp({
            input: "src/index.tsx",
            outDir: "dist",
        }),
        solid(),
        tsconfigPaths(),
    ],
});
