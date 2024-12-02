<template>
    <Navbar>
        <div class="mt-20 ml-5">
            <h1>Reporte ordenes de pago</h1>
        </div>
        <DateRange @sendDate="sendDate" />
        <v-data-table-server
            class="pagination"
            v-model:items-per-page="itemsPerPage"
            :headers="headers"
            :items="serverItems"
            :items-length="itemsPerPage"
            :loading="loading"
            :search="search"
            :page="page"
            item-value="name"
            @update:options="loadItems"
        ></v-data-table-server>
    </Navbar>
</template>

<script setup>
import DateRange from "@/Components/DateRange.vue";
import Navbar from "@/Layouts/Navbar.vue";
import axios from "axios";
import "vuetify/styles";
import "vuetify";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps(["ordenesDePago"]);
var date = ref({
    initialDate: "",
    finalDate: "",
});

const sendDate = (targetValue) => {
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
    { title: "Concepto", key: "concepto", align: "end" },
];

const search = ref("");
const serverItems = ref([]);
const loading = ref(true);
//const totalItems = ref(3);
const page = ref(1);
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
            example: "",
        },
    }).then((response) => {
        serverItems.value = response.data.items.data;
    });

    //serverItems.value = items
    //totalItems.value = total
    loading.value = false;
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
    //serverItems.value = props.ordenesDePago;
    const buttonContainer = document.getElementsByClassName('v-pagination__list');
    console.log(buttonContainer);
    buttonContainer.class = 'paginationButton'
});
</script>

<style scoped>
.paginationButton {
    background-color: #f1f1f1;
    /*
    border-color: #ff0000;
    margin: 50px;
    */
}   
</style>
