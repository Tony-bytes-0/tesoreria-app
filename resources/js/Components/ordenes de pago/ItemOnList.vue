<template>
    <td>{{ item.tipo }}</td>
    <td>{{ item.orden }}</td>
    <td>{{ item.beneficiario }}</td>
    <td>{{ item.factura }}</td>
    <td>{{ item.monto_total }}</td>
    <td>{{ item.retencion_islr }}</td>
    <td>{{ item.transferencia }}</td>
    <td>{{ item.divisas }}</td>
    <td>{{ item.comision_bancaria }}</td>
    <td>{{ item.registro_contable }}</td>
    <td>{{ item.autorizacion }}</td>
    <td>{{ item.fecha }}</td>
    <!-- <td>{{  item.id }}</td> -->
    <!-- Debug -->
    <td>
        <v-btn
            variant="text"
            color="primary"
            density="comfortable"
            @click="handleDeleteItem(item.id)"
        >
            <svg-icon type="mdi" :path="deleteIconPath" ></svg-icon>
        </v-btn>
    </td>
</template>

<script setup>
import SvgIcon from "@jamescoyle/vue-icon";
import { mdiDelete } from "@mdi/js";
const deleteIconPath = mdiDelete;
defineProps(["item"]);
const emit = defineEmits(['deleteItem'])

const handleDeleteItem = (targetId) => {
    emit('deleteItem', targetId)
}
</script>

<style>
i.v-icon.v-icon {
  color: red;
} 
</style>
