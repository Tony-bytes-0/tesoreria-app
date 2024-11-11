import "../css/app.css";
import "./bootstrap";

import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { createApp, h } from "vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
//import { VDateInput } from 'vue3-datepicker'; // Add this line

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// Import Tailwind CSS
import "tailwindcss/tailwind.css";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob(["./Pages/**/*.vue", "../Components/**/*.vue"], {
                eager: true,
            })
        ),
    setup({ el, App, props, plugin }) {
        const vuetify = createVuetify({
            theme: {
                defaultTheme: 'dark'
            },
            components,
            directives,
        });
        //app.component("Datepicker", Datepicker);

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(vuetify)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});

