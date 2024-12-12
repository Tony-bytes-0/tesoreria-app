<template>
    <td class="text-center"><b>totales:</b></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center">
        {{ formatedNumber( props.monto_total) }}
    </td>
    <td class="text-center">
        {{ formatedNumber(props.comisionISLR) }}
    </td>
    <td class="text-center">
        {{ formatedNumber(props.transferencia) }}
    </td>
    <td class="text-center">
        {{ formatedNumber(props.comisionBancaria) }}
    </td>
</template>

<script setup>
import { formatedNumber } from "@/helpers/numbers";
import { ref, defineProps, computed } from "vue";

const props = defineProps([
    "monto_total",
    "comisionISLR",
    "transferencia",
    "comisionBancaria",
]);
</script>
