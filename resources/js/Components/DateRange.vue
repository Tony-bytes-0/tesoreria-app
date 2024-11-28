<template>
    <v-row>
        <v-col cols="3"></v-col>
        <v-col cols="3" class="items-center justify-center mb-4">
            <v-label>Fecha de inicio</v-label>
            <input
                type="date"
                class="custom-datepicker m-2 w-full"
                v-model="initialDate"
            />
        </v-col>
        <v-col cols="3" class="items-center justify-center mb-4">
            <v-label>Fecha final</v-label>
            <input
                type="date"
                class="custom-datepicker m-2 w-full"
                v-model="finalDate"
            />
        </v-col>
        <v-col cols="2" align-self="center">
            <v-btn variant="tonal" @click="submitDate">Buscar</v-btn>
        </v-col>
    </v-row>
</template>

<script setup>
import { ref } from "vue";

const emit = defineEmits(["sendDate"]);
var initialDate = ref("");
var finalDate = ref("");

const submitDate = () => {
    console.log('submit date: ', initialDate.value, finalDate.value)
    emit('sendDate', {
        initialDate: initialDate.value,
        finalDate: finalDate.value,
    })
}
</script>

<style scooped>
button.v-btn.selected {
    opacity: 1;
    border: 2px solid #add8e6; /* Light blue color */
    transition: all 0.3s ease;
}
.custom-datepicker input {
    background-color: #3d3d3d;
}
</style>
