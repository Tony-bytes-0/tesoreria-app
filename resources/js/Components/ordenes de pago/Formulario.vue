<template>
    <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden </v-divider>
    <v-form class="p-2" @submit.prevent>
        <v-row>
            <v-col cols="2">
                <v-select
                    v-model="ordenDePagoElectronico.tipoDeOrden"
                    :items="['Proveedores', 'Electronico']"
                    label="Tipo de orden"
                >
                </v-select>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.referencia"
                    label="Numero de referencia"
                ></v-text-field>
            </v-col>

            <v-col cols="4">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.nombreDelBeneficiario"
                    label="Nombre del beneficiario"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.numeroDeFacturas"
                    label="Numero de facturas"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoTotal"
                    label="Monto total"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.retencionISLR"
                    label="Monto retención ISLR"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoTransferencia"
                    label="Monto transferencia"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoDivisas"
                    label="Monto en divisas"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.comisionBancaria"
                    label="Comision bancaria"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.registroContable"
                    label="Nº Registro contable"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.autorizacion"
                    label="Nº Autorización"
                ></v-text-field>
            </v-col>

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

            <v-col cols="3"></v-col>
        </v-row>
    </v-form>
</template>
<script setup>
import { reactive, ref, watch } from "vue";
import "vuetify/styles";
import "vuetify";
import { staticError } from "../alerts/staticMessages";

const emit = defineEmits(["addToList", "submit"]);
const props = defineProps(["form"]);

var ordenDePagoElectronico = ref({
    tipoDeOrden: "",
    referencia: "",
    nombreDelBeneficiario: "",
    numeroDeFacturas: "",
    montoTotal: "",
    montoTransferencia: "",
    montoDivisas: "",
    retencionISLR: "",
    comisionBancaria: "",
    autorizacion: "",
    registroContable: "",
});

const validateForm = (item) => {
    //valida que no hallan propiedades vacias
    const notEmpty = (x) => {
        return x.length == 0;
    };
    console.log(Object.values(item), Object.values(item).some(notEmpty)); //#debug
    return Object.values(item), Object.values(item).some(notEmpty);
};

const resetForm = () => {
    ordenDePagoElectronico.value = {
        tipoDeOrden: "",
        referencia: "",
        nombreDelBeneficiario: "",
        numeroDeFacturas: "",
        montoTotal: "",
        montoTransferencia: "",
        montoDivisas: "",
        retencionISLR: "",
        comisionBancaria: "",
        autorizacion: "",
        registroContable: "",
    };
};
const handleAddToList = () => {
    if (validateForm(ordenDePagoElectronico.value)) {
        staticError("Complete el formulario");
    } else {
        emit("addToList", ordenDePagoElectronico.value);
        resetForm();
    }
};

const submit = () => {
    emit('submit')
}
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
</style>
