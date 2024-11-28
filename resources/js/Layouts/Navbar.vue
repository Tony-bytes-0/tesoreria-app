<template>
    <!-- <div class="min-h-10 bg-gray-100">
        <nav class="border-b border-gray-100 bg-gray-100">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex pr-6"
                    >
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </NavLink>
                    </div>
                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex pr-6"
                    >
                        <NavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Usuario
                        </NavLink>
                    </div>
                    
                </div>
            </div>
        </nav>
    </div> -->
    <v-card>
        <v-layout>
            <v-app-bar color="#E8E8E8" prominent>
                <div
                    class="p-4 inline-flex items-center hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-500 transition duration-150 ease-in-out"
                >
                    <svg-icon
                        type="mdi"
                        :path="menuIconPath"
                        variant="text"
                        @click.stop="drawer = !drawer"
                    ></svg-icon>
                </div>

                <v-toolbar-title>Menu</v-toolbar-title>

                <v-spacer></v-spacer>
            </v-app-bar>
            <!-- :location="$vuetify.display.mobile ? 'bottom' : undefined" -->
            <v-navigation-drawer
                theme="dark"
                v-model="drawer"
                location="left"
                temporary
            >
                <v-list v-for="item in items">
                    <NavLink :href="item.href">{{ item.title }}</NavLink>
                </v-list>
            </v-navigation-drawer>
        </v-layout>
        <main class="h-screen w-screen overflow-y-auto">
            <slot  />
        </main>
    </v-card>
</template>

<script setup>
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiMenu } from "@mdi/js";
import NavLink from "@/Components/NavLink.vue";
import { ref, watch } from "vue";

const theme = ref("light");

function alterTheme() {
    theme.value = theme.value === "light" ? "dark" : "light";
}
const drawer = ref(false);
const menuIconPath = ref(mdiMenu);
const items = [
    { title: "Ordenes de pago", value: "foo", href: "/OrdenesDePago" },
    {
        title: "Registrar orden de pago",
        value: "bar",
        href: "/RegistrarOrdenDePago",
    },
];
const group = ref(false);

watch(
    () => group,
    (newValue) => {
        drawer.value = false;
    }
);
</script>
