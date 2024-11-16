<script setup>
import { staticError } from "@/Components/alerts/staticMessages";
import AccountSelect from "@/Components/ordenes de pago/AccountSelect.vue";
import Formulario from "@/Components/ordenes de pago/Formulario.vue";
import ItemOnList from "@/Components/ordenes de pago/ItemOnList.vue";
import TableheadThs from "@/Components/ordenes de pago/TableheadThs.vue";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import { ref, defineProps, reactive } from "vue";

const props = defineProps(["cuentasNaviarca", "cuentasGc", "tasas"]);
const cuentasBancarias = ref({
    naviarca: props.cuentasNaviarca,
    granCacique: props.cuentasGc,
    //añadir cuentas serviencomiendas!!!
});
var cuentasDisponibles = ref([]);
var items = ref([]); //items del formulario
var idCounter = ref(0);
var tasaUsd = ref(props.tasas.original.usd);
var editandoTasa = ref(false);

const addToList = (newItem) => {
    console.log("agregando nuevo item:", newItem);
    newItem = {
        ...newItem,
        id: idCounter.value++
    };
    items.value.push(newItem);
};
const deleteItem = (targetId) => {
    items.value = items.value.filter((x) => x.id !== targetId);
};

//cuenta bancaria
var company = ref("Naviarca");
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
    selectedAccount.value = "";
};

const selectAccGroup = (key) => {
    company.value = key;
    if (key == "serviencomiendas") {
        cuentasDisponibles.value = [];
    } else {
        cuentasDisponibles.value = cuentasBancarias.value[key].original;
    }
    //console.log(cuentasBancarias.value[key].original) //[key].original, 'key: ', value)
};

const submit = () => {
    try {
        axios
            .post("/api/registrar_orden_de_pago", items.value)
            .then((response) => {
                console.log("resultado de la respuesta: ", response);
            });
    } catch (error) {
        console.log("ocurrio un error desconocido: ", error);
    }
};
</script>

<template>
    <!-- <Navbar /> -->
    <Navbar>
        <v-row dense class="mt-20 ml-20 mr-20">
            <v-row v-if="editandoTasa">
                <v-col md="3">
                    <v-text-field
                        class="custom-dark"
                        v-model="tasaUsd"
                    ></v-text-field>
                </v-col>
                <v-col md="3"
                    ><v-btn @click="editandoTasa = !editandoTasa"
                        >guardar</v-btn
                    ></v-col
                >
            </v-row>

            <v-col md="12" v-else>
                Tasa de cambio $: {{ tasaUsd }}
                <v-btn class="p-2 ml-2" @click="editandoTasa = !editandoTasa">
                    cambiar</v-btn
                ></v-col
            >
        </v-row>

        <v-divider :thickness="7">Datos de la cuenta</v-divider>
        <v-row class="m-2">
            <v-col md="12">
                <v-card
                    class="mx-auto p-6 justify-center text-center mb-4"
                    title="Registrar orden de pago"
                    variant="outlined"
                >
                </v-card>
            </v-col>
        </v-row>
        <v-row class="m-2">
            <!-- <v-col cols="2"></v-col> -->

            <v-row align-content="center">
                <v-container fluid>
                    <v-img
                        :width="300"
                        aspect-ratio="16/9"
                        cover
                        src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"
                    ></v-img>
                </v-container>
            </v-row>
            <v-col cols="2">
                <v-col cols="12" class="text-center p-2">
                    <v-btn color="primary" @click="selectAccGroup('naviarca')"
                        >Naviarca</v-btn
                    >
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        color="primary"
                        @click="selectAccGroup('granCacique')"
                        >Gran cacique</v-btn
                    >
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        color="primary"
                        @click="selectAccGroup('serviencomiendas')"
                        >Serviencomiendas</v-btn
                    >
                </v-col>
            </v-col>
            <v-col cols="7" align-self="end">
                <v-select
                    v-model="selectedAccount"
                    :items="cuentasDisponibles"
                    :item-props="accProps"
                    label="Cuenta bancaria"
                ></v-select>
            </v-col>

            <!-- <v-col cols="2"></v-col> -->
        </v-row>
        <Formulario @addToList="addToList" @submit="submit" />

        <v-table height="300px" fixed-header>
            <thead>
                <tr>
                    <TableheadThs />
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <ItemOnList :item="item" @deleteItem="deleteItem" />
                </tr>
            </tbody>
        </v-table>
    </Navbar>
</template>
