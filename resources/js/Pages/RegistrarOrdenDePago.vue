<script setup>
import AccountSelect from "@/Components/ordenes de pago/AccountSelect.vue";
import Formulario from "@/Components/ordenes de pago/Formulario.vue";
import ItemOnList from "@/Components/ordenes de pago/ItemOnList.vue";
import TableheadThs from "@/Components/ordenes de pago/TableheadThs.vue";
import Navbar from "@/Layouts/Navbar.vue";
import { ref, defineProps } from "vue";

const props = defineProps(['cuentasBancarias'])
var items = ref([]);
var idCounter = ref(0);

const addToList = (newItem) => {
    newItem = {...newItem, id: idCounter.value++ }
    items.value.push(newItem);
    console.log(idCounter.value)
    console.log("añadido a la lista: ", newItem);
};
const deleteItem = (targetId) => {
    items.value = items.value.filter((x) => x.id !== targetId)
}
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

        <AccountSelect :cuentasBancarias="props.cuentasBancarias" />
        <Formulario @addToList="addToList"  />
<!--         <h1>props!!!!!!!!!!!!: {{ props.cuentasBancarias }}</h1> -->
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
