<template>
    <!-- <v-chip class="ma-2" label> Datos de la cuenta </v-chip> -->
    <v-divider :thickness="7">Datos de la cuenta</v-divider>
    <v-row class="m-2">
        <v-col cols="3">
            <v-select
                v-model="accountDetails.empresa"
                :items="['Naviarca', 'Gran Cacique']"
                label="Empresa"
            >
            </v-select>
        </v-col>
        <v-col cols="3">
            <v-text-field
                class="custom-dark"
                v-model="accountDetails.numeroDeCuenta"
                :counter="10"
                label="Numero de cuenta"
            ></v-text-field>
        </v-col>
        <v-col cols="3">
            <v-select
                v-model="accountDetails.empresa"
                :items="['Naviarca', 'Gran Cacique']"
                label="Tipo de cuenta"
            >
            </v-select>
        </v-col>
        <v-col cols="3">
            <v-text-field
                class="custom-dark"
                v-model="accountDetails.numeroDeCuenta"
                :counter="10"
                label="Numero de cuenta"
            ></v-text-field>
        </v-col>
    </v-row>
    <h1> PROPS: {{ props.cuentasBancarias }} </h1>
</template>

<script setup>

import { ref } from "vue";

const props = defineProps(['cuentasBancarias'])

var accountDetails = ref({
    empresa: "",
    numeroDeCuenta: "",
    tipoDeCuenta: "",
    numeroDeRegistro: "",
});

</script>

<style scooped>
.custom-option:hover {
    transition: 1s;
    background-color: black;
    opacity: 50;
}
.custom-input:focus {
    background-color: black !important;
}
.custom-dark input {
    color: black !important;
}
.custom-dark {
    color: gray !important;
}
</style>
