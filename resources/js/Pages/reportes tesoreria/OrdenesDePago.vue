<template>
    <Navbar>
        <div class="mt-20 ml-5">
            <h1>Reporte ordenes de pago</h1>
        </div>
        <DateRange @sendDate="sendDate" />
        <v-data-table-server
            v-model:items-per-page="itemsPerPage"
            :headers="headers"
            :items="serverItems"
            :items-length="itemsPerPage"
            :loading="loading"
            :search="search"
            item-value="name"
            @update:options="loadItems"
        ></v-data-table-server> 
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
    { title: "Nº", key: "id", align: "end" },
    { title: "Orden de pago", key: "id_proceso", align: "end" },
    { title: "RIF Empresa", align: "start", sortable: false, key: "rif" },
    { title: "Nombre", key: "beneficiario[0].descripcion", align: "end" },
    { title: "Número de cuenta", key: "beneficiario[0].codigo_cuenta", align: "end" },
    { title: "Monto total", key: "monto_total", align: "end" },
    { title: "Transferencia", key: "transferencia", align: "end" },
    { title: "Comisión bancaria", key: "comision_bancaria", align: "end" },
    { title: "Nº factura", key: "factura", align: "end" },
    { title: "Nº autorización", key: "autorizacion", align: "end" },
    { title: "Concepto", key: "concepto", align: "end" },
];

const search = ref("");
const serverItems = ref([]);
const loading = ref(true);
//const totalItems = ref(3);
const page = ref(2);
const itemsPerPage = ref(5);
const sortBy = ref([{ key: "name", order: "asc" }]);
const sortByDesc = computed(() => sortBy.value[0]?.order === "desc");

function loadItems({ page, itemsPerPage, sortBy }) {
    loading.value = true;
    //FakeAPI.fetch({ page, itemsPerPage, sortBy }).then(({ items, total }) => {
    axios({
        method: "GET",
        url: "/api/consultar_ordenes_de_pago",
        params: {
            page: page,
            perPage: itemsPerPage,
        },
        data: {
            example: ''
        }
    }).then((response) => {
        console.log('respuesta del loadItems ', typeof(response.data), response.data.items.data)
        serverItems.value = response.data.items.data;
    })

    //serverItems.value = items
    //totalItems.value = total
    loading.value = false
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
/* watch([page, itemsPerPage, sortBy], () => {
    loadItems({
        page: page.value,
        itemsPerPage: itemsPerPage.value,
        sortBy: sortBy.value,
    });
}); */
onMounted(() => {
    console.log("props: ", props.ordenesDePago);
    serverItems.value = props.ordenesDePago;
});
</script>
