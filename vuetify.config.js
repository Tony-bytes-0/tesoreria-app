import { createVuetify } from "vuetify";

export default defineConfig({
    plugins: [
        {
            ...createVuetify({
                ssr: true,
                components: ["VApp", "VAppBar" /* other components */],
                directives: ["v-tooltip"],
                theme: {
                    defaultTheme: "dark",
                },
            }),
            enforce: "pre",
        },
    ],
});
