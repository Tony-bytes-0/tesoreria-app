<template>
    <!-- <v-chip class="ma-2" label> Datos de la cuenta </v-chip> -->
    <v-divider :thickness="7">Datos de la cuenta</v-divider>
    <v-row class="m-2">
        <!-- <v-col cols="2"></v-col> -->
        <v-col cols="3">
            <v-switch
                v-model="company"
                :label="`Empresa: ${company}`"
                false-value="Gran cacique"
                true-value="Naviarca"
                hide-details
                @click="onSwitchClick"
            ></v-switch>
        </v-col>
        <v-col cols="9">
            <v-select
                v-model="selectedAccount"
                :items="
                    company == 'Naviarca'
                        ? props.cuentasNaviarca.original
                        : props.cuentasGc.original
                "
                :item-props="accProps"
                label="Cuenta bancaria"
            ></v-select>
        </v-col>
        <!-- <v-col cols="2"></v-col> -->
    </v-row>
    <!-- {{ props.cuentasNaviarca }} -->
</template>

<script setup>
import { ref } from "vue";
import "vuetify/styles";
import "vuetify";
const props = defineProps(["cuentasNaviarca", "cuentasGc"]);

var company = ref('Naviarca');
var selectedAccount = ref({
    banco_id: "",
    codigo_cuenta: "",
    moneda_id: "",
    tipo_cuenta: "",
    banco_nombre: "",
});

const accProps = (item) => {
    return {
        title: item.banco_nombre, // + " - " + item.codigo_cuenta,
        subtitle:
            item.banco_id +
            " - " +
            item.tipo_cuenta +
            " - " +
            item.codigo_cuenta,
        value: {
            id: item.id,
            banco_id: item.banco_id,
            codigo_cuenta: item.codigo_cuenta,
            moneda_id: item.moneda_id,
            tipo_cuenta: item.tipo_cuenta,
            banco_nombre: item.banco_nombre,
        },
    };
};

const onSwitchClick = () => {
    selectedAccount.value = ''
};

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
