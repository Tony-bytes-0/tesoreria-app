<template>
    <!-- <td class="text-center">{{ item.referencia }}</td> -->
    <td class="text-center">{{ item.beneficiario.descripcion + ' - ' + item.beneficiario.codigo_cuenta }}</td>
    <td class="text-center">{{ item.factura }}</td>
    <td class="text-center">{{ computedMontoTotal }}</td>
    <td class="text-center">{{ computedRetencion }}</td>
    <td class="text-center">{{ item.autorizacion }}</td>
    <td class="text-center">{{ item.transferencia.toLocaleString('es-MX') }}</td>
    <td class="text-center">{{ computedComision }}</td>
    <td class="text-center">{{ item.concepto }}</td>
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
import { computed } from "vue";
const deleteIconPath = mdiDelete;
const props = defineProps(["item"]);
const emit = defineEmits(['deleteItem'])

const computedMontoTotal = computed(() => {
    return parseFloat(props.item.monto_total).toFixed(2)
})

const computedRetencion = computed(() => {
    if(props.item.retencion_islr){
        return parseFloat(props.item.retencion_islr).toFixed(2)
    }else return 0;
})

const computedComision = computed(() => {
    if(props.item.comision_bancaria){
        return parseFloat(props.item.comision_bancaria).toFixed(2)
    }else return 0;
})

const handleDeleteItem = (targetId) => {
    emit('deleteItem', targetId)
}
</script>

<style>
i.v-icon.v-icon {
  color: red;
} 
</style>
