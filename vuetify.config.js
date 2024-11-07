import { createVuetify } from "vuetify";

export default defineConfig({
    plugins: [
        {
            ...createVuetify({
                components: ["VApp", "VAppBar" /* other components */],
                directives: ["v-tooltip"],
                theme: {
                    defaultTheme: "light",
                },
            }),
            enforce: "pre",
        },
    ],
});
