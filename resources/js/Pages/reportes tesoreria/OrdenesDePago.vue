<template>
    <Navbar>
        <div class="mt-20 ml-5">
            <h1>Reporte ordenes de pago</h1>
        </div>
        <DateRange @sendDate="sendDate" />

        <v-row class="mb-10">
            <v-col>
                <v-dialog max-width="500" class="z-10">
                    <template v-slot:activator="{ props: modal }">
                        <v-btn
                            class="bg-blue-600"
                            v-bind="modal"
                            text="Editar seleccionados"
                            variant="flat"
                        ></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                        <v-card title="Editar">
                            <v-divider>Asignar cuenta contable</v-divider>
                            <p v-if="modalResponseMessage.initialValue"></p>
                            <v-row v-else>
                                <v-col cols="3"></v-col>
                                <v-col
                                    cols="6"
                                    class="text-center mt-10"
                                    :class="{
                                        'bg-red-400':
                                            modalResponseMessage.error,
                                            'bg-green-400': !modalResponseMessage.error
                                    }"
                                    >{{ modalResponseMessage.message }}</v-col
                                >
                                <v-col cols="3"></v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="1"></v-col>
                                <v-col cols="10">
                                    <h2 class="mb-5 mt-5">
                                        ( {{ selectedItems.length }} ) registros
                                        seleccionados
                                    </h2>
                                    <v-autocomplete
                                        v-model="selectedAccount"
                                        label="Cuenta contable"
                                        :items="props.cuentasContables"
                                        item-title="descripcion"
                                        item-value="descripcion"
                                        return-object
                                    >
                                        <template v-slot:item="{ props, item }">
                                            <v-list-item
                                                v-bind="props"
                                                :subtitle="
                                                    ' cuenta: ' +
                                                    item.raw.codigo_cuenta
                                                "
                                            ></v-list-item> </template
                                    ></v-autocomplete>
                                    <h1>{{ selectedAccount }}</h1>
                                </v-col>
                                <v-col cols="1"></v-col>
                            </v-row>
                            <v-row class="mb-5">
                                <v-col cols="1"></v-col>
                                <v-col cols="10" align-self="center"
                                    ><v-btn
                                        class="bg-green-700"
                                        @click="submit"
                                        :loading="loading"
                                        >Procesar</v-btn
                                    ></v-col
                                >
                                <v-col cols="1"></v-col>
                            </v-row>
                        </v-card>
                    </template>
                </v-dialog>
            </v-col>
        </v-row>
        <v-data-table
            class="pagination"
            v-model="selectedItems"
            :headers="headers"
            :items="serverItems"
            item-value="id"
            items-per-page="10"
            return-object
            show-select
            hover
        ></v-data-table>
        <h1>{{ selectedItems }}</h1>
    </Navbar>
</template>

<script setup>
import DateRange from "@/Components/DateRange.vue";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import "vuetify/styles";
import "vuetify";
import { computed, onMounted, ref, watch } from "vue";
import { staticError, staticSucces } from "@/Components/alerts/staticMessages";

const props = defineProps(["ordenesDePago", "cuentasContables"]);
var date = ref({
    initialDate: "",
    finalDate: "",
});

var selectedAccount = ref({
    id: "",
    codigo_cuenta: "",
    descripcion: "",
});

const modal = ref(false);
const modalResponseMessage = ref({
    message: "",
    error: false,
    initialValue: true,
});

const sendDate = (targetValue) => {
    loadItems({ page: 1, itemsPerPage: itemsPerPage.value });
    date.value = targetValue;
    console.log(targetValue);
};

const headers = [
    { title: "Nº", key: "id", align: "end" },
    { title: "Orden de pago", key: "id_proceso", align: "end" },
    { title: "RIF Empresa", align: "start", sortable: false, key: "rif" },
    { title: "Nombre", key: "beneficiario[0].descripcion", align: "end" },
    {
        title: "Número de cuenta",
        key: "beneficiario[0].codigo_cuenta",
        align: "end",
    },
    { title: "Monto total", key: "monto_total", align: "end" },
    { title: "Transferencia", key: "transferencia", align: "end" },
    { title: "Comisión bancaria", key: "comision_bancaria", align: "end" },
    { title: "Nº factura", key: "factura", align: "end" },
    { title: "Nº autorización", key: "autorizacion", align: "end" },
    { title: "Cuenta contable", key: "cuenta_contable", align: "end" },
    { title: "Concepto", key: "concepto", align: "end" },
];
//table data datos de la tabla
const selectedItems = ref([]);
const search = ref("");
const serverItems = ref([]);
const loading = ref(false);
const page = ref(2);
const itemsPerPage = ref(15);
//const sortBy = ref([{ key: "name", order: "asc" }]);
//const sortByDesc = computed(() => sortBy.value[0]?.order === "desc");
//const totalItems = ref(3);

function loadItems({ page, itemsPerPage }) {
    loading.value = true;
    axios({
        method: "GET",
        url: "/api/consultar_ordenes_de_pago",
        params: {
            page: page,
            perPage: itemsPerPage,
        },
        data: {
            example: "",
        },
    }).then((response) => {
        serverItems.value = response.data.items.data;
    });
    loading.value = false;
}

watch(search, () => {
    loadItems({
        page: page.value,
        itemsPerPage: itemsPerPage.value,
        sortBy: sortBy.value,
    });
});

const submit = async () => {
    const ordenesArray = selectedItems.value.map((e) => e.id);
    console.log("en submit, ordenes array", ordenesArray);
    //console.log("datos a enviar: ", items.value);
    loading.value = true;
    try {
        await axios
            .post("/api/asignar_cuenta_contable_a_orden", {
                id_ordenes: ordenesArray,
                id_cuenta_contable: selectedAccount.value.id,
            })
            .then((response) => {
                selectedAccount.value = {
                    id: "",
                    descripcion: "",
                    codigo_cuenta: "",
                };
                modalResponseMessage.value = {
                    initialValue: false,
                    message: "Carga exitosa",
                    error: false,
                };
            });
    } catch (error) {
        modalResponseMessage.value = {
            initialValue: false,
            message: "Ha ocurrido un error",
            error: true,
        };
    } finally {
        loading.value = false;
    }
};
</script>

<style>
.v-selection-control__input > .v-icon {
    opacity: 50;
}
.mdi-checkbox-blank-outline {
    background-color: #f1f1f1;
    opacity: 50%;
    box-sizing: border-box;
    border-width: 0;
    border-style: solid;
    border-radius: 50%;
}
.mdi-checkbox-marked {
    background-color: rgb(145, 255, 102);
    border-radius: 50%;
}
.v-pagination__first {
    color: #f1f1f1;
}
</style>
