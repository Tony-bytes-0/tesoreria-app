<template>
        <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden </v-divider>
    <v-form class="p-2">
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
                    :counter="10"
                    label="Numero de referencia"
                ></v-text-field>
            </v-col>

            <v-col cols="4">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.nombreDelBeneficiario"
                    :counter="10"
                    label="Nombre del beneficiario"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.numeroDeFacturas"
                    :counter="10"
                    label="Numero de facturas"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoTotal"
                    :counter="10"
                    label="Monto total"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.retencionISLR"
                    :counter="10"
                    label="Monto retención ISLR"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoTransferencia"
                    :counter="10"
                    label="Monto transferencia"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.montoDivisas"
                    :counter="10"
                    label="Monto en divisas"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.comisionBancaria"
                    :counter="10"
                    label="Comision bancaria"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.registroContable"
                    :counter="10"
                    label="Nº Registro contable"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.autorizacion"
                    :counter="10"
                    label="Nº Autorización"
                ></v-text-field>
            </v-col>

            <v-col cols="12" class="justify-center items-center p-6 mx-auto flex">
                <!-- <v-btn @click="() => console.log(ordenDePagoElectronico)"> -->
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="primary"
                    @click="handleAddToList"
                >
                    +
                </v-btn>
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="success"
                >
                    Procesar
                </v-btn>
            </v-col>

            <v-col cols="3"></v-col>
        </v-row>
    </v-form>
</template>
<script setup>
import { reactive } from "vue";
import "vuetify/styles";
import "vuetify";

const emit = defineEmits(["addToList"]);

const ordenDePagoElectronico = reactive({
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

const handleAddToList = () => {
    emit("addToList", ordenDePagoElectronico);
    //reiniciar lista
};
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
