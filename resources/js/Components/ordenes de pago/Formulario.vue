<template>
    <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden </v-divider>
    <v-form class="p-2" @submit.prevent>
        <v-row align="center">
            <v-col cols="1"></v-col>
            <v-col cols="2" class="items-centrer justify-center mb-4">
                <input
                    id
                    type="date"
                    class="custom-datepicker m-2 w-full"
                    v-model="ordenDePagoElectronico.fecha"
                />
            </v-col>

            <v-col cols="2">
                <v-select
                    v-model="ordenDePagoElectronico.tipo"
                    :items="['Proveedores', 'Electronico']"
                    label="Tipo de orden"
                >
                </v-select>
            </v-col>
            <!--             <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.referencia"
                    label="Numero de referencia"
                ></v-text-field>
            </v-col> -->

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.beneficiario"
                    label="Nombre del beneficiario"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.factura"
                    label="Numero de factura"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    type="number"
                    v-model="ordenDePagoElectronico.monto_total"
                    label="Monto total"
                ></v-text-field>
            </v-col>
            <v-col cols="1"></v-col>
        </v-row>
        <v-row>
            <v-col cols="2"></v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.retencion_islr"
                    label="Monto retención ISLR"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.autorizacion"
                    label="Nº Autorización"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark custom-input"
                    v-model="transferencia"
                    label="Monto transferencia"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="comision_bancaria"
                    label="Comision bancaria"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2"></v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.concepto"
                    label="Concepto ( opcional )"
                ></v-text-field>
            </v-col>
        </v-row>

        <v-row>
            <v-col
                cols="12"
                class="justify-center items-center p-6 mx-auto flex"
            >
                <!-- <v-btn @click="() => console.log(ordenDePagoElectronico)"> -->
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="primary"
                    type="submit"
                    @click="handleAddToList"
                >
                    +
                </v-btn>
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="success"
                    @click="submit"
                >
                    Procesar
                </v-btn>
            </v-col>
        </v-row>

        <v-row> </v-row>
    </v-form>
</template>
<script setup>
import { computed, onMounted, ref } from "vue";
import "vuetify/styles";
import "vuetify";
import { staticError } from "../alerts/staticMessages";

const emit = defineEmits(["addToList", "submit"]);
const props = defineProps(["form"]);

var ordenDePagoElectronico = ref({
    fecha: "",
    tipo: "",
    //referencia: "",
    beneficiario: "",
    factura: "",
    monto_total: "",
    //
    retencion_islr: "",
    autorizacion: "",
    concepto: "",
});

const transferencia = computed(() => {
    return (
        ordenDePagoElectronico.value.monto_total -
        ordenDePagoElectronico.value.retencion_islr
    );
});

const comision_bancaria = computed(() => {
    return 0.0025 * ordenDePagoElectronico.value.monto_total;
});

const validateForm = (item) => {
    console.log("keys del bojeto", Object.keys(ordenDePagoElectronico.value));
    //valida que no hallan propiedades vacias
    const notEmpty = (x) => {
        return x.length == 0;
    };
    console.log(Object.values(item), Object.values(item).some(notEmpty)); //#debug
    return Object.values(item), Object.values(item).some(notEmpty);
};

const resetForm = () => {
    ordenDePagoElectronico.value = {
        fecha: "",
        tipo: "",
        //referencia: "",
        beneficiario: "",
        factura: "",
        monto_total: "",
        //
        retencion_islr: "",
        autorizacion: "",
        concepto: "",
    };
};
const handleAddToList = () => {
    if (validateForm(ordenDePagoElectronico.value)) {
        staticError("Complete el formulario");
    } else {
        emit("addToList", {
            ...ordenDePagoElectronico.value,
            transferencia: transferencia,
            comision_bancaria: comision_bancaria,
        });
        resetForm();
    }
};

const submit = () => {
    console.log("formualario: ", ordenDePagoElectronico.value);
    emit("submit", { ...ordenDePagoElectronico.value });
};
onMounted(() => {
    //const actualDate = new Date().toJSON().slice(0, 10);
    //ordenDePagoElectronico.value.fecha = actualDate;
});
</script>

<style scooped>
.custom-option:hover {
    transition: 1s;
    background-color: black;
    opacity: 50;
}
.custom-input:focus {
    background-color: black !important;
}
.custom-dark input {
    color: black !important;
}
.custom-dark {
    color: gray !important;
}
.custom-datepicker {
    color: black;
}
</style>
