<script setup>
import { staticError, staticSucces } from "@/Components/alerts/staticMessages";
import Formulario from "@/Components/ordenes de pago/Formulario.vue";
import ItemOnList from "@/Components/ordenes de pago/ItemOnList.vue";
import TableheadThs from "@/Components/ordenes de pago/TableheadThs.vue";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import { ref, defineProps, computed } from "vue";

const validateForm = ref(true);
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
    console.log("agregando nuevo item:", newItem, selectedAccount.value);
    if (selectedAccount.value.codigo_cuenta.length < 1 && validateForm.value) {
        staticError("Seleccione una cuenta bancaria");
    } else {
        newItem = {
            ...newItem,
            id: idCounter.value++,
            banco_nombre: selectedAccount.value.banco_nombre,
            codigo_cuenta: selectedAccount.value.codigo_cuenta,
            tipo_cuenta: selectedAccount.value.tipo_cuenta,
            numero_orden_de_pago: "0", //estatico
            rif: "08005604-3", //estatico!
            tipo: tipo.value,
            fecha: fecha.value,
        };
        items.value.push(newItem);
    }
};
const deleteItem = (targetId) => {
    items.value = items.value.filter((x) => x.id !== targetId);
};
//elementos que se repiten en cada registro
//cuenta bancaria
var company = ref("Naviarca");
var selectedAccount = ref({
    banco_id: "",
    codigo_cuenta: "",
    moneda_id: "",
    tipo_cuenta: "",
    banco_nombre: "",
});
const tipo = ref("");
const fecha = ref("");

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

const selectAccGroup = (key) => {
    selectedAccount.value = {
        banco_id: "",
        codigo_cuenta: "",
        moneda_id: "",
        tipo_cuenta: "",
        banco_nombre: "",
    };
    company.value = key;
    if (key == "serviencomiendas") {
        cuentasDisponibles.value = [];
    } else {
        cuentasDisponibles.value = cuentasBancarias.value[key].original;
    }
};

const sumMontoTotal = computed(() => {
    let total = 0;
    if (items.value.length > 0) {
        items.value.forEach((x) => {
            total += +x.monto_total;
        });
    }
    return total;
});

const submit = async () => {
    console.log("datos a enviar: ", items.value);
    try {
        const response = await axios
            .post("/api/registrar_orden_de_pago", { items: items.value })
            .then((response) => {
                staticSucces("Guardado con éxito");
                items.value = [];
            });
    } catch (error) {
        staticError("Codigo de error: " + error.status);
        console.log("ocurrio un error desconocido: ", error);
    }
};
</script>

<template>
    <!-- <Navbar /> -->
    <Navbar>
        <v-row dense class="mt-20 ml-20 mr-20">
            <v-col md="12">
                <v-card
                    class="mx-auto p-6 justify-center text-center mb-4"
                    title="Registrar orden de pago"
                    variant="outlined"
                >
                </v-card>
            </v-col>
        </v-row>
        <v-row dense class="ml-20 mr-20">
            <v-col md="3" align-self="center"
                >Monto total a cancelar: {{ sumMontoTotal }}</v-col
            >
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

            <v-col md="3" align-self="center" v-else>
                Tasa de cambio $: {{ tasaUsd }}
                <v-btn
                    class="p-2 ml-2"
                    @click="editandoTasa = !editandoTasa"
                    :disabled="items.length > 0"
                >
                    cambiar</v-btn
                ></v-col
            >

            <v-col md="2" align-self="center">
                <v-container>
                    <v-switch
                        v-model="validateForm"
                        label="Validar formulario"
                    ></v-switch
                ></v-container>
            </v-col>
            <v-col md="1" align-self="center">{{
                validateForm ? "validar" : "NO validar"
            }}</v-col>
        </v-row>

        <v-divider :thickness="7">Datos de la cuenta</v-divider>

        <v-row class="m-2">
            <v-row align-content="center">
                <v-container fluid>
                    <v-img
                        :width="300"
                        aspect-ratio="16/9"
                        cover
                        :src="'/img/logo_' + company + '.png'"
                    ></v-img>
                </v-container>
            </v-row>
            <v-col cols="2">
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('naviarca')"
                        :class="{ selected: company == 'naviarca' }"
                        :disabled="items.length > 0"
                    >
                        Naviarca
                    </v-btn>
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('granCacique')"
                        :class="{ selected: company == 'granCacique' }"
                        :disabled="items.length > 0"
                        >Gran cacique</v-btn
                    >
                </v-col>
                <v-col cols="12" class="text-center p-2">
                    <v-btn
                        @click="selectAccGroup('serviencomiendas')"
                        :class="{ selected: company == 'serviencomiendas' }"
                        :disabled="items.length > 0"
                        >Serviencomiendas</v-btn
                    >
                </v-col>
            </v-col>
            <v-row>
                <v-col cols="12" align-self="end">
                    <v-select
                        v-model="selectedAccount"
                        :items="cuentasDisponibles"
                        :item-props="accProps"
                        label="Cuenta bancaria"
                        :disabled="items.length > 0"
                    ></v-select>
                </v-col>
                <v-col cols="6">
                    <v-select
                        v-model="tipo"
                        :items="['Proveedores', 'Electronico']"
                        label="Tipo de orden"
                        :disabled="items.length > 0"
                    >
                    </v-select>
                </v-col>
                <v-col cols="6" class="items-centrer justify-center mb-4">
                    <input
                        id
                        type="date"
                        class="custom-datepicker m-2 w-full"
                        v-model="fecha"
                        :disabled="items.length > 0"
                    />
                </v-col>
            </v-row>

            <!-- <v-col cols="2"></v-col> -->
        </v-row>
        <v-row>
            <v-col cols="3"></v-col>

            <v-col cols="3"></v-col>
        </v-row>
        <Formulario
            @addToList="addToList"
            @submit="submit"
            :validateForm="validateForm"
        />

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
<style scooped>
button.v-btn.selected {
    opacity: 1;
    border: 2px solid #add8e6; /* Light blue color */
    transition: all 0.3s ease;
}
</style>
