<template>
    <td class="text-center">{{ item.tipo }}</td>
    <!-- <td class="text-center">{{ item.referencia }}</td> -->
    <td class="text-center">{{ item.beneficiario }}</td>
    <td class="text-center">{{ item.factura }}</td>
    <td class="text-center">{{ item.monto_total }}</td>
    <td class="text-center">{{ item.retencion_islr }}</td>
    <td class="text-center">{{ item.autorizacion }}</td>
    <td class="text-center">{{ item.transferencia }}</td>
    <td class="text-center">{{ item.comision_bancaria }}</td>
    <td class="text-center">{{ item.concepto }}</td>
    <td class="text-center">{{ item.fecha }}</td>
    <!-- Debug -->
    <td class="text-center">
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
