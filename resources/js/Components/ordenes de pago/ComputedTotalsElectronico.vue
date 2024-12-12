<template>
    <td class="text-center"><b>totales:</b></td>
    <td class="text-center"><b></b></td>

    <td class="text-center">
        {{ props.concepto }}
    </td>
    <td class="text-center">
        {{ props.numero_personas }}
    </td>
    <td class="text-center">
        {{ formatedNumber(props.monto_total) }}
    </td>
</template>

<script setup>
import { formatedNumber } from "@/helpers/numbers";
import { ref, defineProps, computed } from "vue";

const props = defineProps([
    "numero_personas",
    "monto_total",
    "concepto",
    
]);
</script>