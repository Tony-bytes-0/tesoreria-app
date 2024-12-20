<template>
    <Navbar>
        <div class="mt-20 ml-5 printArea"></div>
        <v-container fluid>
            <form @submit.prevent="loadItems">
                <v-row>
                    <v-col cols="2" align-self="center">
                        <v-col align-self="center">
                            <v-btn
                                @click="selectAccGroup('j080056043')"
                                class="flex w-100 text-center justify-center p-8"
                            >
                                Naviarca
                            </v-btn></v-col
                        >
                        <v-col>
                            <v-btn
                                @click="selectAccGroup('j303876056')"
                                class="flex w-100 text-center justify-center p-8"
                                >Gran cacique</v-btn
                            ></v-col
                        >
                        <v-col>
                            <v-btn
                                @click="selectAccGroup('serviencomiendas')"
                                block
                                outline
                                class="flex w-100 text-center justify-center p-8"
                            >
                                serviencomiendas</v-btn
                            ></v-col
                        >
                    </v-col>
                    <v-col cols="5">
                        <h1 class="p-2">Cuenta bancaria</h1>
                        <v-select
                            v-model="formData.cuenta_bancaria"
                            :items="cuentasDisponibles"
                            :item-props="accProps"
                        ></v-select>
                        <h1 class="p-2">Tipo de orden</h1>
                        <v-select
                            v-model="formData.tipo"
                            :items="['Proveedores', 'Electronico']"
                        >
                        </v-select>
                    </v-col>
                    <v-col cols="5">
                        <h1 class="p-2">Nº Orden orden de pago</h1>
                        <v-text-field
                            v-model="formData.secuencia"
                            class="custom-dark"
                        ></v-text-field>

                        <v-btn
                            submit
                            @click="loadItems"
                            class="p-6 mt-11 text-center justify-center"
                            >Buscar</v-btn
                        >

                        <v-dialog max-width="500" class="z-10">
                            <template v-slot:activator="{ props: modal }">
                                <v-btn
                                v-if="selectedItems.length > 1"
                                    class="bg-blue-600 ml-10 p-6 mt-11"
                                    v-bind="modal"
                                    text="Editar seleccionados"
                                    variant="flat"
                                ></v-btn>
                            </template>

                            <template v-slot:default="{ isActive }">
                                <v-card title="Editar">
                                    <v-divider
                                        >Asignar cuenta contable</v-divider
                                    >
                                    <p
                                        v-if="modalResponseMessage.initialValue"
                                    ></p>
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
                                            >{{
                                                modalResponseMessage.message
                                            }}</v-col
                                        >
                                        <v-col cols="3"></v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="1"></v-col>
                                        <v-col cols="10">
                                            <h2 class="mb-5 mt-5">
                                                ( {{ selectedItems.length }} )
                                                registros seleccionados
                                            </h2>
                                            <v-autocomplete
                                                v-model="selectedAccount"
                                                label="Cuenta contable"
                                                :items="props.cuentasContables"
                                                item-title="descripcion"
                                                item-value="descripcion"
                                                return-object
                                            >
                                                <template
                                                    v-slot:item="{
                                                        props,
                                                        item,
                                                    }"
                                                >
                                                    <v-list-item
                                                        v-bind="props"
                                                        :subtitle="
                                                            ' cuenta: ' +
                                                            item.raw
                                                                .codigo_cuenta
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
            </form>
        </v-container>
        <!-- aqui va la modal -->

        <!-- aqui va la modal -->
        <div id="reporteHeader" v-if="showReport">
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
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>

                <v-col cols="3" class="border">Banco Emisor: </v-col>
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>

                <v-col cols="3" class="border">Tipo de cuenta: </v-col>
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>

                <v-col cols="3" class="border">Nº de cuenta: </v-col>
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>

                <v-col cols="3" class="border">Fecha valor: </v-col>
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>

                <v-col cols="3" class="border">Nº de registro: </v-col>
                <v-col cols="4" class="border"></v-col>
                <v-col cols="5"></v-col>
            </v-row>
        </div>
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
                <tr @click="console.log('modal!')">
                    <td class="text-center border">{{ item.secuencia }}</td>
                    <td class="text-center border">
                        {{ item.beneficiario.descripcion }}
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
                    <td class="text-center border"></td>
                </tr>
            </template>
        </v-data-table>
        <p class="mt-10 ml-5 bold" v-if="showReport">
            Concepto: {{ reportData.concepto }}
        </p>
        <div id="reporteFooter" v-if="showReport">
            <v-row class="mt-15" justify="center">
                <v-col cols="2"
                    >Monto total: {{ formatedNumber(reportData.total) }}</v-col
                >
                <v-col cols="2"
                    >Rentención ISLR:
                    {{ formatedNumber(reportData.total) }}</v-col
                >
                <v-col cols="2"
                    >Transferencia:
                    {{ formatedNumber(reportData.total) }}</v-col
                >
                <v-col cols="2"
                    >Comisión bancaria:
                    {{ formatedNumber(reportData.total) }}</v-col
                >
                <v-col cols="2"
                    >Equivalente en divisas:
                    {{
                        formatedNumber(
                            parseFloat(reportData.total) /
                                parseFloat(reportData.tasa)
                        )
                    }}
                    $</v-col
                >
            </v-row>
            <v-row class="mt-10" justify="center">
                <v-col cols="2">Revisado por tesoreria: </v-col>
                <v-col cols="2">Firmas autorizadas:</v-col>
                <v-col cols="2">REG. Final cuentas por pagar:</v-col>
            </v-row>
        </div>
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
import { formatedDate, formatedNumber, totalize } from "@/helpers/numbers";

const props = defineProps([
    "ordenesDePago",
    "cuentasContables",
    "cuentasNaviarca",
    "cuentasGc",
]);
const cuentasBancarias = ref({
    j080056043: props.cuentasNaviarca,
    j303876056: props.cuentasGc,
    //añadir cuentas serviencomiendas!!!
});
//control
var cuentasDisponibles = ref([]);
const showReport = ref(false);
//formData
const formData = ref({
    rif: "",
    tipo: "",
    cuenta_bancaria: {
        id: "",
        banco_id: "",
        codigo_cuenta: "",
        moneda_id: "",
        tipo_cuenta: "",
        banco_nombre: "",
    },
    secuencia: "",
});

const reportData = ref({
    referencia: "",
    fecha_creacion: "",
    tasa: "",
    total: "",
    equivalente_divisas: "",
    concepto: "",
});
const accProps = (item) => {
    return {
        title:
            item.banco_nombre +
            "  -  " +
            item.codigo_cuenta +
            "  " +
            item.moneda_id, // + " - " + item.codigo_cuenta,
        subtitle:
            item.moneda_id == "VED"
                ? "Bs. " + item.codigo_cuenta
                : "$" + " - " + item.codigo_cuenta,
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
var selectedAccount = ref({
    id: "",
    banco_id: "",
    codigo_cuenta: "",
    moneda_id: "",
    tipo_cuenta: "",
    banco_nombre: "",
});
const selectAccGroup = (key) => {
    resetAccount();
    formData.value.rif = key;
    if (key == "serviencomiendas") {
        cuentasDisponibles.value = [];
    } else {
        cuentasDisponibles.value = cuentasBancarias.value[key];
    }
};
const resetAccount = () => {
    selectedAccount.value = {
        id: "",
        banco_id: "",
        codigo_cuenta: "",
        moneda_id: "",
        tipo_cuenta: "",
        banco_nombre: "",
    };
};

const modalResponseMessage = ref({
    message: "",
    error: false,
    initialValue: true,
});

const headers = [
    { title: "Nº de referencia", key: "secuencia", align: "center" },
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

async function loadItems() {
    loading.value = true;
    axios
        .post("/api/consultar_ordenes_de_pago", {
            rif: formData.value.rif,
            cuenta_bancaria_id: formData.value.cuenta_bancaria.id,
            tipo: formData.value.tipo,
            secuencia: formData.value.secuencia,
        })
        .then((response) => {
            if (response.status == 204) {
                fastMsg(
                    "No existen registros con el numero: " + proceso_id.value
                );
            } else {
                console.log(response.data);
                const proceso = response.data.proceso_orden_de_pago;
                serverItems.value = response.data.items.data;
                totalItems.value = response.data.items;
                reportData.value = {
                    referencia: proceso ? proceso.id : "",
                    fecha_creacion: proceso
                        ? formatedDate(proceso.created_at)
                        : "",
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

async function staticLoad() {
    loading.value = true;
    axios({
        method: "GET",
        url: "/api/consultar_ordenes_de_pago_ultimas",
    }).then((response) => {
        if (response.status == 204) {
            fastMsg("No existen registros con el numero: " + proceso_id.value);
        } else {
            serverItems.value = response.data.items.data;
            totalItems.value = response.data.items;
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
    staticLoad();
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
