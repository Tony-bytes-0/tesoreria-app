<template>
    <!-- <v-chip class="ma-2" label> Datos de la orden </v-chip> -->
    <v-divider :thickness="7">Datos de la orden de pago</v-divider>
    <v-form class="p-2" @submit.prevent>
        <v-row align="center">
            <v-col cols="2"><SvgIcon type="mdi" :path="successIconPath" size="50" v-if="!validateForm(ordenDePagoElectronico)"></SvgIcon></v-col>
            <v-col cols="4">
                <v-autocomplete
                    label="Beneficiario"
                    v-model="ordenDePagoElectronico.beneficiario"
                    item-title="descripcion"
                    item-value="descripcion"
                    :items="props.beneficiarios"
                    return-object
                    :disabled="!props.showForm && props.validateForm"
                >
                    <template v-slot:item="{ props, item }">
                        <v-list-item
                            v-bind="props"
                            :title="item.raw.descripcion"
                            :text="item.raw.descripcion"
                            :subtitle="
                                item.raw.rif +
                                ' cuenta: ' +
                                item.raw.codigo_cuenta
                            "
                        ></v-list-item>
                    </template>
                </v-autocomplete>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.factura"
                    :label="!props.pagoElectronico ? 'Número de factura' : 'Numero de personas'"
                    :disabled="!props.showForm && props.validateForm"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.monto_total"
                    :label="props.pagoElectronico ? 'Total a pagar' : 'Monto total'"
                    :disabled="!props.showForm && props.validateForm"
                ></v-text-field>
            </v-col>
            <v-col cols="1"></v-col>
        </v-row>
        <v-row>
            <v-col cols="2"></v-col>
            <v-col cols="2">
                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.retencion_islr"
                    label="Monto retención ISLR"
                    :disabled="!props.showForm && props.validateForm"
                ></v-text-field>
            </v-col>

            <v-col cols="2">
                <v-text-field
                v-if="!props.pagoElectronico"
                    class="custom-dark"
                    v-model="ordenDePagoElectronico.autorizacion"
                    label="Nº Autorización"
                    :disabled="!props.showForm && props.validateForm"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    v-if="!props.pagoElectronico"
                    class="custom-dark custom-input"
                    v-model="transferencia"
                    label="Monto transferencia"
                    disabled
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-text-field
                    v-if="!props.pagoElectronico"
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
                    añadir a la lista
                </v-btn>
                <v-btn
                    class="w-2/5 justify-center items-center m-2"
                    color="success"
                    :disabled="!canSubmit"
                    @click="submit"
                >
                    Procesar ordenes
                </v-btn>
            </v-col>
        </v-row>

        
    </v-form>
</template>
<script setup>
import { computed, onMounted, ref } from "vue";
import { staticError } from "../alerts/staticMessages";
import SvgIcon from '@jamescoyle/vue-icon';
import { mdiCheckBold } from '@mdi/js';
import "vuetify/styles";
import "vuetify";

const successIconPath = mdiCheckBold
const emit = defineEmits(["addToList", "submit"]);
const props = defineProps(["validateForm", "beneficiarios", "showForm", "pagoElectronico", "canSubmit"]);
var ordenDePagoElectronico = ref({
    //fecha: "", datos ahora fuera del formulario
    //tipo: "",
    //referencia: "",
    beneficiario: "",
    factura: "",
    monto_total: "",
    //
    retencion_islr: "",
    autorizacion: "",
    concepto: "",
});

const id_beneficiario = computed(() => {
    return ordenDePagoElectronico.value.beneficiario.id
})

const transferencia = computed(() => {
    const newValue = parseFloat(
        ordenDePagoElectronico.value.monto_total - ordenDePagoElectronico.value.retencion_islr
    );
    return Number(newValue.toFixed(2));
});

const comision_bancaria = computed(() => {
        const newValue = parseFloat(
        0.0025 * transferencia.value.toString()
    );    
    return Number(newValue.toFixed(2));
});

const canAddToList = computed(() => {

})

const validateForm = (item) => {
    var validationObject = Object.assign({}, item);
    delete validationObject.concepto; //propiedad no validable
    delete validationObject.retencion_islr; //propiedad no validable
    delete validationObject.transferencia;
    delete validationObject.autorizacion;
    delete validationObject.comision_bancaria;
    delete validationObject.transferencia;

    const notEmpty = (x) => {
        return x.length == 0;
    };
    console.log('frenar el paso: ', Object.values(validationObject).some(notEmpty))
    return Object.values(validationObject).some(notEmpty);
};

const resetForm = () => {
    ordenDePagoElectronico.value = {
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
    if (validateForm(ordenDePagoElectronico.value) && props.validateForm) {
        staticError("Complete el formulario");
    } else {
        emit("addToList", {
            ...ordenDePagoElectronico.value,
            monto_total: Number(ordenDePagoElectronico.value.monto_total).toFixed(2),
            transferencia: transferencia.value,
            comision_bancaria: comision_bancaria.value,
            id_beneficiario: id_beneficiario.value,
            numero_personas: ordenDePagoElectronico.value.factura
        });
        resetForm();
    }
};

const submit = () => {
    console.log("formualario: ", ordenDePagoElectronico.value);
    emit("submit", { ...ordenDePagoElectronico.value });
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
    color: white !important;
    background-color: #7a7a7a;
}
.custom-dark {
    color: gray !important;
}
.custom-datepicker {
    color: black;
    margin: 20px;
}
.v-autocomplete input {
    --v-input-font-color: rgba(0, 0, 0, 0.87);
    /*--v-input-group-adaptive-elevation: 2px;*/
    background-color: #3d3d3d;
    border-color: inherit;
    border: 0cm;
    margin: 0;
    padding: 0;
    size: 1;
    height: 100%;
    width: 100%;
}
.v-autocomplete div {
    /*background-color:#3CBC8D;*/
    padding: 0px;
}
</style>
