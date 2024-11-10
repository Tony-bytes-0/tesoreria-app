<template>
    <td>{{ item.tipoDeOrden }}</td>
    <td>{{ item.referencia }}</td>
    <td>{{ item.nombreDelBeneficiario }}</td>
    <td>{{ item.numeroDeFacturas }}</td>
    <td>{{ item.montoTotal }}</td>
    <td>{{ item.retencionISLR }}</td>
    <td>{{ item.montoTransferencia }}</td>
    <td>{{ item.montoDivisas }}</td>
    <td>{{ item.comisionBancaria }}</td>
    <td>{{ item.registroContable }}</td>
    <td>{{ item.autorizacion }}</td>
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
