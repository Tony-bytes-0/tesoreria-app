<script setup>
import Formulario from '@/Components/ordenes de pago/Formulario.vue';
import Navbar from '@/Layouts/Navbar.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-gray-100 w-100 h-screen">
        componente welcome!!!
    </div>

</template>
