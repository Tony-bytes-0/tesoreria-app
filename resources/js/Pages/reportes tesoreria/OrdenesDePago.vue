<template>
    <Navbar>
        <div class="mt-20 ml-5">
            <h1>Reporte ordenes de pago</h1>
        </div>
        <DateRange @sendDate="sendDate" />
        <!--         <v-data-table-server
            v-model:items-per-page="itemsPerPage"
            :headers="headers"
            :items="serverItems"
            :items-length="itemsPerPage"
            :loading="loading"
            :search="search"
            item-value="name"
            @update:options="loadItems"
        ></v-data-table-server> -->
        <v-table height="100%" fixed-header class="mt-20">
            <thead>
                <tr>
                    <th class="text-center">Referencia</th>
                    <th class="text-center">RIF</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Número de cuenta</th>
                    <th class="text-center">Nº factura</th>
                    <th class="text-center">Monto total</th>
                    <th class="text-center">ISLR</th>
                    <th class="text-center">Nº Autorización</th>
                    <th class="text-center">Transferencia</th>
                    <th class="text-center">Comisión bancaria</th>
                    <th class="text-center">Concepto</th>
                    <th class="text-center">Numero de orden</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in props.ordenesDePago" :key="item.id">
                    <td class="text-center">{{ item.id }}</td>
                    <td class="text-center">{{ item.rif }}</td>
                    <td class="text-center">
                        {{ item.beneficiario }}
                    </td>
                    <td class="text-center">
                        {{ item.codigo_cuenta }}
                    </td>
                    <td class="text-center">{{ item.factura }}</td>
                    <td class="text-center">{{ item.monto_total }}</td>
                    <td class="text-center">{{ item.retencion_islr }}</td>
                    <td class="text-center">{{ item.autorizacion }}</td>
                    <td class="text-center">
                        {{ item.transferencia.toLocaleString("es-CO") }}
                    </td>
                    <td class="text-center">{{ item.comision_bancaria }}</td>
                    <td class="text-center">{{ item.concepto }}</td>
                    <td class="text-center">{{ item.id_proceso }}</td>
                </tr>
            </tbody>
        </v-table>
    </Navbar>
</template>

<script setup>
import DateRange from "@/Components/DateRange.vue";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps(["ordenesDePago"]);
var date = ref({
    initialDate: "",
    finalDate: "",
});

const sendDate = (targetValue) => {
    date.value = targetValue;
};

//table
const desserts = [
    {
        name: "Frozen Yogurt",
        calories: 159,
        fat: 6.0,
        carbs: 24,
        protein: 4.0,
        iron: "1",
    },
    // ... other desserts ...
];

const FakeAPI = {
    async fetch({ page, itemsPerPage, sortBy }) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const items = desserts.slice();

                if (sortBy.length) {
                    const sortKey = sortBy[0].key;
                    const sortOrder = sortBy[0].order;
                    items.sort((a, b) => {
                        const aValue = a[sortKey];
                        const bValue = b[sortKey];
                        return sortOrder === "desc"
                            ? bValue - aValue
                            : aValue - bValue;
                    });
                }

                const paginated = items.slice(start, end);

                resolve({ items: paginated, total: items.length });
            }, 500);
        });
    },
};

const headers = [
    { title: "RIF", align: "start", sortable: false, key: "name" },
    { title: "Nombre", key: "calories", align: "end" },
    { title: "Número de cuenta", key: "fat", align: "end" },
    { title: "Nº factura", key: "carbs", align: "end" },
    { title: "Monto total", key: "protein", align: "end" },
    { title: "Nº autorización", key: "iron", align: "end" },
    { title: "TRansferencia", key: "iron", align: "end" },
    { title: "Comisión bancaria", key: "iron", align: "end" },
    { title: "Concepto", key: "iron", align: "end" },
    { title: "Numero de referencia", key: "iron", align: "end" },
    { title: "Orden de pago", key: "Orden de pago", align: "end" },
];

const search = ref("");
const serverItems = ref([]);
const loading = ref(true);
const totalItems = ref(3);
const page = ref(1);
const itemsPerPage = ref(5);
const sortBy = ref([{ key: "name", order: "asc" }]);
const sortByDesc = computed(() => sortBy.value[0]?.order === "desc");

function loadItems({ page, itemsPerPage, sortBy }) {
    loading.value = true;
    //FakeAPI.fetch({ page, itemsPerPage, sortBy }).then(({ items, total }) => {
    axios({
        method: "post",
        url: "/user/12345",
        data: {
            firstName: "Fred",
            lastName: "Flintstone",
        },
    });
    //serverItems.value = items
    //totalItems.value = total
    ///loading.value = false
}

// Watch for changes in search and update the data accordingly
watch(search, () => {
    loadItems({
        page: page.value,
        itemsPerPage: itemsPerPage.value,
        sortBy: sortBy.value,
    });
});

// Watch for changes in pagination and sort options
watch([page, itemsPerPage, sortBy], () => {
    loadItems({
        page: page.value,
        itemsPerPage: itemsPerPage.value,
        sortBy: sortBy.value,
    });
});
onMounted(() => {
    console.log("props: ", props.ordenesDePago);
    serverItems.value = props.ordenesDePago;
});
</script>
