<template>
    <!-- <v-chip class="ma-2" label> Datos de la cuenta </v-chip> -->
    <v-divider :thickness="7">Datos de la cuenta</v-divider>
    <v-row class="m-2">
        <v-col cols="6">
            <!--             <v-select
                v-model="selectedAccount"
                :items="props.cuentasNaviarca.original"
                label="Seleccione una cuenta"
                item-title="222"
            >
            </v-select> -->
            <v-select
                v-model="selectedAccount"
                :items="props.cuentasNaviarca.original"
                item-title="banco_nombre"
                item-value="codigo_cuenta"
                label="cuentas bancarias"
                return-object
                single-line
            ></v-select>
        </v-col>
    </v-row>
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
    <h1>
        PROPS:
        {{
            (props.cuentasNaviarca.original,
            "tipo: ",
            typeof props.cuentasNaviarca)
        }}
    </h1>
    {{ props.cuentasNaviarca }}
</template>

<script setup>
import { ref } from "vue";
import ItemOnList from "./ItemOnList.vue";
import "vuetify/styles";
import "vuetify";

const props = defineProps(["cuentasNaviarca", "cuentasGc"]);

var accountDetails = ref({
    empresa: "",
    numeroDeCuenta: "",
    tipoDeCuenta: "",
    numeroDeRegistro: "",
});

var selectedAccount = ref({
    banco_id: "",
    codigo_cuenta: "",
    moneda_id: "",
    tipo_cuenta: "",
    banco_nombre: "",
});

const formatItemText = (item) => {
    return "example";
};

const formatItemValue = (item) => {
    return item.codigo_cuenta.toString();
};

const makeNewIterableList = (arrayWithObjects) => {};
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
