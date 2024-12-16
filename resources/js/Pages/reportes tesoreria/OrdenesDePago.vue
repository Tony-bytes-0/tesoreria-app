<template>
    <Navbar>
        <div class="mt-20 ml-5 printArea">
            <!-- <h1>Reporte ordenes de pago</h1> -->
        </div>
        <!-- <DateRange @sendDate="sendDate" /> -->
        <v-container fluid>
            <form @submit.prevent="loadItems">
                <v-row justify="center">
                    <v-col cols="4">
                        <v-text-field
                            v-model="proceso_id"
                            class="custom-dark"
                            label="Numero de proceso de pago"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="2" align-self="center"
                        ><v-btn submit @click="loadItems">Buscar</v-btn>
                    </v-col>
                    <!-- <v-col cols="2"><v-btn submit @click="loadItems(false)">ultimos registros</v-btn></v-col> -->
                </v-row>
            </form>
        </v-container>
        <!-- aqui va la modal -->
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
                                    class="text-center mt-10 rounded-md"
                                    :class="{
                                        'bg-red-400':
                                            modalResponseMessage.error,
                                        'bg-green-700':
                                            !modalResponseMessage.error,
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
        <!-- aqui va la modal -->
        <v-row class="mt-10 mb-10">
            <v-col cols="3" class="border text-">logo</v-col>
            <v-col cols="6" class="border text-xl text-center"
                >ORDEN DE PAGO ELECTRÓNICO DE PROVEEDORES</v-col
            >
            <v-col cols="3" class="border">
                <v-col cols="12" class="border"
                    >Fecha: {{ reportData.fecha_creacion }}</v-col
                >
                <v-col cols="12" class="border"
                    >Referencia: {{ reportData.referencia }}</v-col
                >
                <v-col cols="12" class="border"
                    >Tasa: {{ reportData.tasa }}</v-col
                >
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="3" class="border">Empresa: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>

            <v-col cols="3" class="border">Banco Emisor: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>

            <v-col cols="3" class="border">Tipo de cuenta: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>

            <v-col cols="3" class="border">Nº de cuenta: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>

            <v-col cols="3" class="border">Fecha valor: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>

            <v-col cols="3" class="border">Nº de registro: </v-col>
            <v-col cols="4" class="border">asdasd</v-col>
            <v-col cols="5"></v-col>
        </v-row>

        <v-data-table
            class="pagination mt-10"
            v-model="selectedItems"
            :headers="headers"
            :items="serverItems"
            item-value="id"
            :items-per-page="itemsPerPage"
            return-object
            hover
            hide-default-footer
        >
            <template v-slot:item="{ item }">
                <tr>
                    <td class="text-center border">{{ item.id }}</td>
                    <td class="text-center border">
                        <!-- {{ item.beneficiario.descripcion }} -->
                    </td>
                    <td class="text-center border">{{ item.factura }}</td>
                    <td class="text-center border">
                        {{ formatedNumber(item.monto_total) }}
                    </td>
                    <td class="text-center border">
                        {{ item.retencion_islr }}
                    </td>
                    <td class="text-center border">
                        {{ formatedNumber(item.transferencia) }}
                    </td>
                    <td class="text-center border">
                        {{ formatedNumber(item.comision_bancaria) }}
                    </td>
                    <td class="text-center border">{{ item.autorizacion }}</td>
                    <!-- <td class="text-center border">{{ item.concepto }}</td> -->
                    <td class="text-center border"></td>
                </tr>
            </template>
        </v-data-table>
        <p class="mt-10 ml-5 bold">Concepto: {{ reportData.concepto }}</p>
        <v-row class="mt-15" justify="center">
            <v-col cols="2">Monto total: {{ formatedNumber(reportData.total) }}</v-col>
            <v-col cols="2">Monto total Retencion:</v-col>
            <v-col cols="2">Monto transferencia:</v-col>
            <v-col cols="2">Comisión bancaria:</v-col>
            <v-col cols="2"
                >Equivalente en divisas:
                {{
                    formatedNumber(
                        parseFloat(reportData.total) /
                            parseFloat(reportData.tasa)
                    )
                }} $</v-col
            >
        </v-row>
        <v-row class="mt-10" justify="center">
            <v-col cols="2">Revisado por tesoreria: </v-col>
            <v-col cols="2">Firmas autorizadas:</v-col>
            <v-col cols="2">REG. Final cuentas por pagar:</v-col>
        </v-row>
        <!-- <v-pagination
            class="mt-10"
            :length="visiblePagination"
            v-model="itemsPerPage"
            :total-visible="10"
            >asdasd</v-pagination
        > -->
        <!-- <h1>{{ selectedItems }}</h1> -->
    </Navbar>
</template>

<script setup>
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import "vuetify/styles";
import "vuetify";
import { computed, onMounted, ref, watch } from "vue";
import { fastMsg } from "@/Components/alerts/staticMessages";
import { formatedDate, formatedNumber } from "@/helpers/numbers";

const props = defineProps(["ordenesDePago", "cuentasContables"]);
const reportData = ref({
    referencia: "",
    fecha_creacion: "",
    tasa: "",
    total: "",
    equivalente_divisas: "",
    concepto: "",
});

var selectedAccount = ref({
    id: "",
    codigo_cuenta: "",
    descripcion: "",
});

const modalResponseMessage = ref({
    message: "",
    error: false,
    initialValue: true,
});

const headers = [
    { title: "Nº de referencia", key: "id", align: "center" },
    {
        title: "Nombre del beneficiario",
        key: "proceso_id",
        align: "center",
        sortable: false,
    },
    { title: "Nº de facturas", align: "center", sortable: false, key: "rif" },
    {
        title: "Monto total",
        align: "center",
        key: "monto_total",
    },
    {
        title: "Monto retencion ISLR",
        key: "retencion_islr",
        align: "center",
    },
    {
        title: "Monto transferencia",
        key: "transferencia",
        align: "center",
    },
    { title: "Comision bancaria", key: "monto_total", align: "center" },
    {
        title: "Nº autorización",
        key: "transferencia",
        align: "center",
        sortable: false,
    },
    /*
    {
        title: "Concepto",
        key: "concepto",
        align: "center",
        sortable: false,
    },
    */
    {
        title: "Nº registro contable",
        align: "center",
        sortable: false,
    },
];
//table data datos de la tabla
var proceso_id = ref("");
const selectedItems = ref([]);
const search = ref("");
const serverItems = ref([]);
const loading = ref(false);
const page = ref(1);
const itemsPerPage = ref(100);
const totalItems = ref(0);
const visiblePagination = computed(() => {
    var pageLength = page.value;
    return pageLength;
});
//const sortBy = ref([{ key: "name", order: "asc" }]);
//const sortByDesc = computed(() => sortBy.value[0]?.order === "desc");

async function loadItems(last) {
    loading.value = true;
    axios({
        method: "GET",
        url: last
            ? "/api/consultar_ordenes_de_pago"
            : "/api/consultar_ordenes_de_pago_ultimas",
        params: {
            proceso_id: Number(proceso_id.value),
            page: Number(page.value),
            per_page: Number(itemsPerPage.value),
        },
    }).then((response) => {
        if (response.status == 204) {
            fastMsg("No existen registros con el numero: " + proceso_id.value);
        } else {
            const proceso = response.data.proceso_orden_de_pago;
            serverItems.value = response.data.items.data;
            totalItems.value = response.data.items;
            reportData.value = {
                referencia: proceso ? proceso.id : "",
                fecha_creacion: proceso ? formatedDate(proceso.created_at) : "",
                tasa: response.data.items.data[0].tasa,
                concepto: response.data.proceso_orden_de_pago
                    ? response.data.proceso_orden_de_pago.concepto
                    : "",
                total: proceso ? proceso.total : "",
            };
        }
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
    //console.log("en submit, ordenes array", ordenesArray);
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
onMounted(async () => {
    //leer los ultimos 20 registros por defecto, ordenes de pago electronico order by ids
    loadItems(false);
});
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
.custom-option:hover {
    transition: 1s;
    background-color: black;
    opacity: 50;
}
.custom-input:focus {
    background-color: black !important;
}
.custom-dark input {
    color: white !important;
    background-color: #3d3d3d;
}
.custom-dark {
    color: gray !important;
}
/* thead th div span {
    text-align: center;
    text-align: justify;
} */
@media print {
    body * {
        font-size: 7px; /* Reduces all text sizes */
        line-height: 1; /* Adjusts line spacing */
        padding: 0; /* Removes default padding */
        margin: 0; /* Removes default margins */
    }
    @page {
        size: auto;
        margin: 5;
    }
}
</style>
